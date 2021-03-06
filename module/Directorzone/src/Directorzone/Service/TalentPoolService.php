<?php
namespace Directorzone\Service;

use Netsensia\Service\NetsensiaService;
use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Sql\Select;
use Netsensia\Exception\NotFoundResourceException;
use Zend\Db\Sql\Expression;

class TalentPoolService extends NetsensiaService
{
    const PUBLISHED_YES = 1;
    const PUBLISHED_NO = 2;
    
    /**
     * @var TableGateway
     */
    private $talentPoolDirectoryTable;
    private $userTargetRoleTable;
    private $userCompanyTable;
    
    public function __construct(
        TableGateway $talentPoolDirectory,
        TableGateway $userTargetRole,
        TableGateway $userCompany
    )
    {
        $this->talentPoolDirectoryTable = $talentPoolDirectory;
        $this->userTargetRoleTable = $userTargetRole;
        $this->userCompanyTable = $userCompany;
        
        $this->setPrimaryTable($talentPoolDirectory);
    }

    public function getTalentPoolList($start, $end, $order)
    {
        $rowset = $this->talentPoolDirectoryTable->select(
            function (Select $select) use ($start, $end, $order) {
                $columns = ['userid', 'talentpoolsummary', 'createddate'];
                
                $sortColumns = ['talentpoolsummary', 'createddate'];
                
                $select->columns(
                    $columns    
                )
                ->where(['talentpoolpublishstatusid' => self::PUBLISHED_YES])
                ->offset($start - 1)
                ->limit(1 + ($end - $start))
                ->order($sortColumns[abs($order)-1] . ' ' . ($order < 0 ? 'DESC' : 'ASC'));
            }
        );
        
        $people = [
            'results' => [],
        ];
        
        $results = $rowset->toArray();
        
        foreach ($results as $result) {
        
            $userId = $result['userid'];
            
            $footprint = $this->getFootprint($userId);
            $targetRoles = $this->userTargetRoleTable->select(
                function (Select $select) use ($userId) {
                    $select->columns(['titlesummary'])
                    ->where(['userid' => $userId]);
                }
            )->toArray();            
            
            foreach ($targetRoles as $targetRole) {
                if (trim($targetRole['titlesummary']) != '') {
                    $people['results'][] = array_merge([
                            'internalId' => $result['userid'],
                            'footprint' => $footprint,
                            'targetrole' => $targetRole['titlesummary']
                        ],
                        $result
                    );
                }
            }
        }
        
        return $people;
    }
    
    public function hasCompany($talentPoolDirectoryId)
    {
        $rowset = $this->userCompanyTable->select(
            function (Select $select) use ($talentPoolDirectoryId) {
                $select->where(
                    [
                        'userid' => $talentPoolDirectoryId
                    ]
                );
            }
        )->toArray();
        
        return count($rowset) > 0;
    }
        
    public function getTalentPoolDetails($talentPoolDirectoryId)
    {
        $rowset = $this->talentPoolDirectoryTable->select(
            function (Select $select) use ($talentPoolDirectoryId) {
                $select->where(
                    [
                        'userid' => $talentPoolDirectoryId
                    ]
                );
            }
        );
    
        if ($rowset->count() == 0) {
            throw new NotFoundResourceException('Person not found in directory');
        }
    
        $peopleDetails = $rowset->current()->getArrayCopy();
        $peopleDetails['footprint'] = $this->getFootprint(
            $talentPoolDirectoryId
        );
    
        return $peopleDetails;
    
    }
    
    public function count()
    {
        $rowset = $this->talentPoolDirectoryTable->select(
            function (Select $select) {
                $select->columns(array('count' => new Expression('COUNT(*)')));
            }
        );
    
        return $rowset->current()['count'];
    }
    
    public function getFootprint($userId)
    {
        $resultSet = $this->talentPoolDirectoryTable->select(
            function (Select $select) {
                $select->columns([])
                ->join('address', 'user.addressid = address.addressid', [])
                ->join('country', 'address.countryid = country.countryid', ['name' => 'country']);
            }
        )->toArray();
        
        if (count($resultSet) == 1) {
            $country = $resultSet[0]['name'];
        } else {
            $country = 'Unknown country';
        }
        
        $jobArea = $this->getResolvedProperty($userId, 'jobarea');
        $profession = $this->getResolvedProperty($userId, 'profession');

        $resultSet = $this->getServiceLocator()->get('UserExperienceTableGateway')->select(
            function (Select $select) use ($userId) {
                $select
                    ->columns(['title'])
                    ->join('jobstatus', 'userexperience.jobstatusid = jobstatus.jobstatusid', ['jobstatus'])
                    ->where(['userid' => $userId])
                    ->order('fromdate DESC');
            }
        )->toArray();
        
        if (count($resultSet) > 0) {
            $jobTitle = $resultSet[0]['title'];
            $jobStatus = $resultSet[0]['jobstatus'];
        } else {
            $jobTitle = 'Unknown job title';
            $jobStatus = 'Unknown job status';
        }
        
        $resultSet = $this->getServiceLocator()->get('UserLanguageTableGateway')->select(
            function (Select $select) use ($userId) {
                $select
                ->columns([])
                ->join('language', 'userlanguage.languageid = language.languageid', ['language'])
                ->join('languagelevel', 'userlanguage.languagelevelid = languagelevel.languagelevelid', ['languagelevel'])
                ->where(['userid' => $userId]);
            }
        )->toArray();
        
        $languages = '';
        if (count($resultSet) > 0) {
            foreach ($resultSet as $result) {
                $languages .= ', ' . $result['language'] . ' (' . $result['languagelevel'] . ')';
            } 
        }
        
        $resultSet = $this->getServiceLocator()->get('UserQualificationTableGateway')->select(
            function (Select $select) use ($userId) {
                $select
                ->columns(['subject'])
                ->join('qualificationtype', 'qualificationtype.qualificationtypeid = userqualification.qualificationtypeid', ['qualificationtype'])
                ->where(['userid' => $userId]);
            }
        )->toArray();
        
        $qualifications = '';
        if (count($resultSet) > 0) {
            foreach ($resultSet as $result) {
                $qualifications .= ', ' . $result['subject'] . ' (' . $result['qualificationtype'] . ')';
            }
        }
        
        $resultSet = $this->getServiceLocator()->get('UserProfessionalQualificationTableGateway')->select(
            function (Select $select) use ($userId) {
                $select
                ->columns(['qualification', 'subject'])
                ->where(['userid' => $userId]);
            }
        )->toArray();
        
        $proQualifications = '';
        if (count($resultSet) > 0) {
            foreach ($resultSet as $result) {
                $proQualifications .= ', ' . $result['subject'] . ' (' . $result['qualification'] . ')';
            }
        }
        
        return $country . ', ' . $profession . ', ' . $jobArea . ', ' . $jobTitle . ', ' . $jobStatus . $languages . $qualifications . $proQualifications;
    }
}
