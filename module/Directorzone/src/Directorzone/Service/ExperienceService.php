<?php
namespace Directorzone\Service;

use Netsensia\Service\NetsensiaService;
use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Sql\Select;

class ExperienceService extends NetsensiaService
{
    private $companyService;
    private $userExperienceTable;
    
    public function __construct(
        CompanyService $companyService,
        TableGateway $userExperienceTable
    )
    {
        $this->companyService = $companyService;
        $this->userExperienceTable = $userExperienceTable;
        
    }
    
    public function setHistory($userId, $companies)
    {
        $this->userExperienceTable->delete([
           'userid' => $userId 
        ]);
        
        foreach ($companies as $company) {
            
            if (empty($company['companydirectoryid'])) {
                $reference = $this->companyService->getCompanyReference($company['companyid']);
                $companyDirectoryId = $this->companyService->getCompanyDirectoryId($reference);
                
                if ($companyDirectoryId === false) {
                    $companyDirectoryId = $this->companyService->addCompanyToDirectory([
                        'reference' => $reference,
                        'name' => $company['name'],
                        'directorzonecommunity' => 'N'
                    ]);
                }
            } else {
                $companyDirectoryId = $company['companydirectoryid'];
            }
            
            $this->userExperienceTable->insert([
                'userid' => $userId,
                'companydirectoryid' => $companyDirectoryId,
                'fromdate' => $company['fromdate'],
                'todate' => $company['todate'],
                'title' => $company['title'],
                'jobstatusid' => $company['jobstatusid'],
                'jobareaid' => $company['jobareaid'],
                'committeeroleid' => $company['committeeroleid'],
            ]);
        }
    }
    
    public function getHistory($userId)
    {
        $resultSet = $this->userExperienceTable->select(
            function (Select $select) use ($userId) {
                $select->columns(['companydirectoryid', 'jobstatusid', 'jobareaid', 'committeeroleid', 'title', 'fromdate', 'todate'])
                    ->join(
                        'companydirectory', 
                        'companydirectory.companydirectoryid = userexperience.companydirectoryid',
                        ['name'],
                        Select::JOIN_RIGHT
                    )
                    ->where(['userid' => $userId]);
            }
        )->toArray();
        
        foreach ($resultSet as &$result) {
            if ($result['fromdate'] == '0000-00-00') {
                $result['fromdate'] = '';
            }
            if ($result['todate'] == '0000-00-00') {
                $result['todate'] = '';
            }
        }
        return $resultSet;
    }
 }
