<?php
namespace Directorzone\Service;

use Netsensia\Service\NetsensiaService;
use Zend\Db\TableGateway\TableGateway;

class ExperienceService extends NetsensiaService
{
    private $client;
    
    private $companyDirectoryTable;
    private $companiesHouseTable;
    private $userExperienceTable;
    
    public function __construct(
        TableGateway $companyDirectoryTable,
        TableGateway $companiesHouseTable,
        TableGateway $userExperienceTable
    )
    {
        $this->companyDirectoryTable = $companyDirectoryTable;
        $this->companiesHouseTable = $companiesHouseTable;
        $this->userExperienceTable = $userExperienceTable;
        
    }
    
    public function setHistory($userId, $companies)
    {
        $this->userExperienceTable->delete([
           'userid' => $userId 
        ]);
        
        foreach ($companies as $company) {
            $this->userExperienceTable->insert([
                'userid' => $userId,
                'companydirectoryid' => $company['companyid'],
            ]);
        }
    }
 }
