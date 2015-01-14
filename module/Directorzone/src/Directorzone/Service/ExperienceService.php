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
            
            $companyDirectoryId = $this->companyService->getCompanyDirectoryId($company['companyid']);
            
            if ($companyDirectoryId === false) {
                $companyDirectoryId = $this->companyService->addCompanyToDirectory([
                    'reference' => $company['companyid'],
                    'name' => $company['name'],
                    'directorzonecommunity' => 'N'
                ]);
            }
            
            $this->userExperienceTable->insert([
                'userid' => $userId,
                'companydirectoryid' => $companyDirectoryId,
            ]);
        }
    }
    
    public function getHistory($userId)
    {
        $resultSet = $this->userExperienceTable->select(
            function (Select $select) use ($userId) {
                $select->columns(['companydirectoryid'])
                    ->join(
                        'companydirectory', 
                        'companydirectory.companydirectoryid = userexperience.companydirectoryid',
                        Select::SQL_STAR,
                        Select::JOIN_RIGHT
                    )
                    ->where(['userid' => $userId]);
            }
        )->toArray();
        
        return $resultSet;
    }
 }
