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
    
    public function count()
    {
        $sql =
            "SELECT count(*) as c " .
            "FROM company";
    
        $query = $this->getConnection()->prepare($sql);
    
        $query->execute();
    
        if ($row = $query->fetch()) {
            return $row['c'];
        } else {
            return null;
        }   
    }    
    
    public function getMaxAlphabeticalCompanyName()
    {
        $sql =
            "SELECT name " .
            "FROM company " .
            "WHERE name NOT LIKE 'THE %' " .
            "AND name NOT LIKE 'THE-%' " .            
            "ORDER BY name DESC " .
            "LIMIT 1";

        $query = $this->getConnection()->prepare($sql);
        
        $query->execute();
        
        if ($row = $query->fetch()) {
            $name = preg_replace('/^THE[ -]/', '', $row['name']);
            return $name;
        } else {
            return null;
        }        
        
    }
}
