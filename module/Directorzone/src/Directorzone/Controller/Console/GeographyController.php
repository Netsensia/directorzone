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
        $regionsWithNoTown = [];
        $regionsWithTooManyTowns = [];
            
        $this->geographyTable =
            $this->getServiceLocator()->get('GeographyTableGateway');
        
        $continentsTable =
            $this->getServiceLocator()->get('Gn_ContinentCodesTableGateway');
        $countriesTable =
            $this->getServiceLocator()->get('Gn_CountryInfoTableGateway');
        $geonameTable =
            $this->getServiceLocator()->get('Gn_GeonameTableGateway');
        
        $continents = $continentsTable->select()->toArray();
        
        $this->geographyTable->delete(1);
        
        foreach ($continents as $continent) {
            $this->printPlace(1, $continent['name']);
            
            $continentId = $this->insert([
	            'parentid' => -1,
                'geography' => $continent['name'],
                'level' => 1,
                'geonameid' => $continent['geonameid'],
                'haschildren' => true,
            ]);
            
            $countries = $countriesTable->select(['continent' => $continent['code']])->toArray();

            foreach ($countries as $country) {
                $this->printPlace(2, $country['name']);
                
                $countryId = $this->insert([
    	            'parentid' => $continentId,
                    'geography' => $country['name'],
                    'level' => 2,
                    'geonameid' => $country['geonameId'],
                    'haschildren' => true,
                ]);
                
                $admin1Regions = $geonameTable->select(
                        function (Select $select) use ($country) {
                                $select->where([
                                    'fcode' => 'ADM1',
                                    'country' => $country['iso_alpha2'],
                                ])
                                ->order('name ASC');
                            }
                        )->toArray();
                
                foreach ($admin1Regions as $admin1Region) {
                    $admin1Region['haschildren'] = true;
                    $admin1Id = $this->insertFromGeonameRow($countryId, $admin1Region, 3);
                    
                    $admin2Regions = $geonameTable->select(
                        function (Select $select) use ($admin1Region) {
                            $select->where([
                                'fcode' => 'ADM2',
                                'country' => $admin1Region['country'],
                                'admin1' => $admin1Region['admin1'],
                                ])
                                ->order('name ASC');
                        }
                    )->toArray();
                    
                    foreach ($admin2Regions as $admin2Region) {
                        $admin2Region['haschildren'] = false;
                        $admin2Id = $this->insertFromGeonameRow($admin1Id, $admin2Region, 4);
                    }
                    
                }
             }

        }
        
        echo PHP_EOL;
        
        $this->insertContinentalRegions();
    }
    
    private function insertContinentalRegions()
    {

    }
    
    private function printPlace($level, $name)
    {
        echo PHP_EOL . str_pad(' ', $level * 4) . $name;
    }
    
    private function insertFromGeonameRow($parentId, $geonameRow, $level)
    {
        $this->printPlace($level, $geonameRow['asciiname']);
        
        return $this->insert([
            'parentid' => $parentId,
            'geography' => $geonameRow['asciiname'],
            'level' => $level,
            'population' => $geonameRow['population'],
            'geonameid' => $geonameRow['geonameid'],
            'latitude' => $geonameRow['latitude'],
            'longitude' => $geonameRow['longitude'],
            'haschildren' => $geonameRow['haschildren'],
            ]);
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
