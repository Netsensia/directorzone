<?php
namespace Directorzone\Controller\Console;

use Netsensia\Controller\NetsensiaActionController;
use Netsensia\Library\Csv\Csv;
use Netsensia\Library\Datetime\Datetime;

class GeographyController extends NetsensiaActionController
{

    var $geographyTable;
    
    public function populateGeographyAction()
    {
        $this->geographyTable =
            $this->getServiceLocator()->get('GeographyTableGateway');
        
        $continentsTable =
            $this->getServiceLocator()->get('Gn_ContinentCodesTableGateway');
        $countriesTable =
            $this->getServiceLocator()->get('Gn_CountryInfoTableGateway');
        
        $continents = $continentsTable->select()->toArray();
        
        $this->geographyTable->delete([1 => 1]);
        
        foreach ($continents as $continent) {
            
            $continentId = $this->insert([
	            'parentid' => -1,
                'geography' => $continent['name'],
                'level' => 1,
            ]);
            
            $countries = $countriesTable->select(['continent' => $continent['code']])->toArray();
            

            foreach ($countries as $country) {
                $countryId = $this->insert([
    	            'parentid' => $continentId,
                    'geography' => $country['name'],
                    'level' => 2,
                ]);
            }
        }
        
    }
    
    private function insert($row) {
        $this->geographyTable->insert($row);
        
        return $this->geographyTable
            ->getAdapter()
            ->getDriver()
            ->getConnection()
            ->getLastGeneratedValue();
    }
    
}
