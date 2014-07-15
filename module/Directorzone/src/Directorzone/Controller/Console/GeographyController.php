<?php
namespace Directorzone\Controller\Console;

use Netsensia\Controller\NetsensiaActionController;
use Netsensia\Library\Csv\Csv;
use Netsensia\Library\Datetime\Datetime;
use Zend\Db\Sql\Select;
use Zend\Db\Sql\Where;

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
        $regionsTable =
            $this->getServiceLocator()->get('Gn_GeonameTableGateway');
        $admin1Table =
            $this->getServiceLocator()->get('Gn_Admin1CodesAsciiTableGateway');
        
        $continents = $continentsTable->select()->toArray();
        
        // 
        $this->geographyTable->delete([1 => 1]);
        
        foreach ($continents as $continent) {
            
            $continentId = $this->insert([
	            'parentid' => -1,
                'geography' => $continent['name'],
                'level' => 1,
                'geonameid' => $continent['geonameid'],
            ]);
            
            $countries = $countriesTable->select(['continent' => $continent['code']])->toArray();

            foreach ($countries as $country) {
                $countryId = $this->insert([
    	            'parentid' => $continentId,
                    'geography' => $country['name'],
                    'level' => 2,
                    'geonameid' => $country['geonameId'],
                ]);
                
                $where = new Where();
                $where->like('code', $country['iso_alpha2'] . '.%');
                $admin1s = $admin1Table->select($where);
                
                foreach ($admin1s as $admin1) {
                    $admin1Id = $this->insert([
                        'parentid' => $countryId,
                        'geography' => $admin1['nameAscii'],
                        'level' => 3,
                        'code' => $admin1['code'],
                        'geonameid' => $admin1['geonameid'],
                    ]);
                }
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
