<?php
namespace Directorzone\Service;

use Netsensia\Service\NetsensiaService;
use Elasticsearch\Client as ElasticClient;
use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Sql\Select;

class ElasticService extends NetsensiaService
{
    private $dateKeys;
    
    private $client;
    
    private $companiesHouseTableGateway;
    private $companyOfficersTableGateway;
    private $companyDirectoryTableGateway;
    private $articleTableGateway;
    private $addressService;
    
    public function __construct(
        ElasticClient $client,
        TableGateway $companiesHouseTableGateway,
        TableGateway $companyOfficersTableGateway,
        TableGateway $companyDirectoryTableGateway,
        TableGateway $articleTableGateway,
        AddressService $addressService
    )
    {
        $this->client = $client;
        $this->companiesHouseTableGateway = $companiesHouseTableGateway;
        $this->companyOfficersTableGateway = $companyOfficersTableGateway;
        $this->companyDirectoryTableGateway = $companyDirectoryTableGateway;
        $this->articleTableGateway = $articleTableGateway;
        $this->addressService = $addressService;
    }
    
    public function searchCompanies($name, $limit = 10, $format = '')
    {
        $results = $this->search(
	       $name,
            [
                'index' => 'companies',
                'type'  => 'company',
            ],
            $limit
        );  
        
        if ($format == 'autocomplete') {
            $return = [];
            foreach ($results['hits']['hits'] as $result) {
                $source = $result['_source'];
                $return[] = [
                    'value' => $source['companyid'],
                    'label' => $source['name'],
                    'source' => $source,
               ];
            }
            
            $results = $return;
        }
        
        return $results;
    }
    
    public function searchArticles($name)
    {
        return $this->search(
            $name,
            [
                'index' => 'articles',
                'type'  => 'article',
            ]
        );
    }
    
    public function searchCompanyDirectory($name)
    {
        return $this->search(
            $name,
            [
                'index' => 'companydirectory',
                'type'  => 'companydz',
            ]
        );
    }
    
    public function searchOfficers($name)
    {
        return $this->search(
            $name,
            [
                'index' => 'officers',
                'type'  => 'officer',
            ]
        );
    }
    
    public function searchSite($name)
    {
        return $this->search(
            $name,
            [
                'index' => 'articles,companydirectory,officers',
                'type'  => 'article,companydz,officer',
            ]
        );
    }
    
    public function indexCompanies()
    {
        $this->createIndex('companies', 'name');
        
        $this->indexGeneric(
            'companies',
            'company',
            $this->companiesHouseTableGateway,
            'companyid',
            'name'
        );
    }
    
    public function indexCompanyDirectory()
    {
        $this->createIndex('companydirectory');
        
        echo 'Index Created' . PHP_EOL;
        
        $this->indexGeneric(
            'companydirectory',
            'companydz',
            $this->companyDirectoryTableGateway,
            'companydirectoryid',
            'name'
        );
    }
    
    public function indexCompanyOfficers()
    {
        $this->createIndex('officers');
        
        $this->indexGeneric(
            'officers',
            'officer',
            $this->getServiceLocator()->get('WhosWhoTableGateway'),
            'whoswhoid',
            'surname'
        );
    }
    
    public function indexArticles()
    {
        $this->createIndex('articles');
        
        $this->indexGeneric(
            'articles', 
            'article', 
            $this->articleTableGateway, 
            'articleid', 
            'title'
        );
    }
    
    public function indexGeneric(
        $index,
        $type,
        $gateway,
        $primaryKey,
        $nameKey
    )
    {
        $limit = 1000;
        $lastId = -1;
    
        $count = 0;
        
        $this->dateKeys = [];
                
        do {
    
            $rowset = $gateway->select(
                function (Select $select) use ($limit, $lastId, $primaryKey) {
                    $select->order($primaryKey . ' ASC')
                    ->limit($limit)
                    ->where->greaterThan($primaryKey, $lastId);
                }
            );
    
            $found = false;
    
            $body = '';
    
            foreach ($rowset as $row) {
    
                $count ++;
    
                $found = true;
    
                $row['_id'] = $row[$primaryKey];
    
                if ($count == 1) {
                    $dateKeys = $this->setDateKeys($row);
                }
                
                foreach ($this->dateKeys as $key) {
                    if (isset($row[$key])) {
                        if (!$this->validateDate($row[$key])) {
                            unset($row[$key]);
                        }
                    }        
                }
                
                $unsets = ['nationality', 'country'];
                foreach ($unsets as $unset) {
                    if (isset($row[$unset])) {
                        unset($row[$unset]);
                    }
                }
                
                $addresses = [];
                foreach ($row as $key => $value) {
                    if (strpos($key, 'addressid') !== false) {
                        $address = $this->addressService->getAddressDetails($value);
                        if (is_array($address)) {
                            $newKey = str_replace('addressid', 'address', $key);
                            
                            foreach ($address as $subKey => $subValue) {
                                $addresses[$newKey . '_' . $subKey] = $subValue;
                            }
                        }
                    }
                }
                

                $row = array_merge($row->getArrayCopy(), $addresses);
                
                $body .=
                    '{ "index" : { "_index" : "' . $index .
                    '", "_type" : "' . $type . '", "_id" : "' .
                    $row[$primaryKey] . '" } }' . PHP_EOL .
                    json_encode($row) . PHP_EOL;
                
                $lastId = $row[$primaryKey];
            }
    
            if ($body != '') {
                $document = array(
                    'index' => $index,
                    'type'  => $type,
                    'body'  => $body
                );
    
                $result = $this->client->bulk($document);
    
                for ($i=0; $i<$limit; $i++) {
                    if (isset($result['items'][$i]['index']['error'])) {
                        var_dump($result['items'][$i]['index']);
                        die;
                    }
                }
    
                echo $count . ' | ' . $row[$nameKey] . PHP_EOL;
            }
    
        } while ($found);
        
        print "Data indexed" . PHP_EOL;
    }
    
    private function validateDate($date, $format = 'Y-m-d H:i:s')
    {
        $d = \DateTime::createFromFormat($format, $date);
        return $d && $d->format($format) == $date;
    }
    
    private function setDateKeys($row)
    {
        $dateKeys = [];
        
        foreach ($row as $key => $value) {
            $keys[] = $key;
        }
        
        foreach ($keys as $key) {
            if (preg_match('/date$/', $key) || $key == 'dob') {
                $dateKeys[] = $key;
            }
        }
        
        $this->dateKeys = $dateKeys;
    }
    
    private function getIndexSettings()
    {
        $json = '{
                      "settings" : {
                        "number_of_shards" : 3,
                        "number_of_replicas" : 0,
                        "index" : {
                          "analysis": {
                            "analyzer": {
                              "en": {
                                "tokenizer": "letter",
                                "filter": [
                                 "asciifolding",
                                 "lowercase",
                                 "ourEnglishFilter"
                                ]
                              },
                              "trigrams": {
                                  "type":      "custom",
                                  "tokenizer": "letter",
                                  "filter":   [
                                     "my_stop",
                                     "lowercase",
                                     "trigrams_filter"
                                  ]
                                }
            
                            },
                            "filter": {
    
                              "ourEnglishFilter": {
                                "type": "kstem"
                              },
                              "trigrams_filter": {
                                 "type":     "ngram",
                                 "min_gram": 3,
                                 "max_gram": 20
                              },
                              "my_stop": {
                                "type":       "stop",
                                "stopwords": ["and", "is", "the", "but"]
                              }
                            }
                          }
                        }
                      },
                      "mappings" : {
                        "companydz" : {
                          "properties" : {
                            "name": { "type" : "string", "store" : "yes", "index" : "analyzed", "analyzer": "trigrams", "boost": 2 }
                          }
                        }
                      }
                    }';
    
        $ret = json_decode($json, true);
        return $ret;
    }
    
    private function createIndex($name, $defaultField = null)
    {
        $indexParams['index']  = $name;
        try {
            $this->client->indices()->delete($indexParams);
        } catch (\Exception $e) {
            echo "No index to delete" . PHP_EOL;
        }
    
        $indexParams['body'] = $this->getIndexSettings();
    
        if ($defaultField) {
            $indexParams['body']['settings']['query']['default_field'] = $defaultField;
        }
    
        // Create the index
        $this->client->indices()->create($indexParams);
    
        $settings = $this->client->indices()->getSettings(['index' => 'companydirectory']);
    }

    public function search($name, $params = [], $limit = 20)
    {
        $params['body']['query']['query_string']['query'] = 'name:' . $name . ' ' . $name;
        $params['body']['query']['query_string']['default_operator'] = 'OR';
        $params['body']['query']['query_string']['analyzer'] = 'standard';
        $params['body']['from'] = 0;
        $params['body']['size'] = $limit;
    
        $result = $this->client->search($params);
    
        return $result;
    }
}
