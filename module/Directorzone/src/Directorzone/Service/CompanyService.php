<?php
namespace Directorzone\Service;

use Netsensia\Service\NetsensiaService;

class CompanyService extends NetsensiaService
{
    public function isCompanyNumberTaken($companyNumber)
    {
        $sql =
        "SELECT companyid " .
        "FROM company " .
        "WHERE number = :number";
    
        $query = $this->getConnection()->prepare($sql);
    
        $query->execute(
            array(
                ':number' => $companyNumber,
            )
        );
    
        return ($query->rowCount() == 1);
    }
}
