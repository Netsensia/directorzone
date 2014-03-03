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
    
    public function __construct(
        ElasticClient $client,
        TableGateway $companiesHouseTableGateway,
        TableGateway $companyOfficersTableGateway,
        TableGateway $companyDirectoryTableGateway,
        TableGateway $articleTableGateway
    )
    {
        $this->client = $client;
        $this->companiesHouseTableGateway = $companiesHouseTableGateway;
        $this->companyOfficersTableGateway = $companyOfficersTableGateway;
        $this->companyDirectoryTableGateway = $companyDirectoryTableGateway;
        $this->articleTableGateway = $articleTableGateway;
    }
    
    public function searchCompanies($name)
    {
        return $this->search(
	       $name,
            [
                'index' => 'companies',
                'type'  => 'company',
            ]
        );  
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
                'type'  => 'article,company,officer',
            ]
        );
    }
    
    public function search($name, $params = [])
    {
        $params['body']['query']['query_string']['query'] = $name;
        $params['body']['query']['query_string']['default_operator'] = 'OR';
        $params['body']['query']['query_string']['analyzer'] = 'standard';
        
        $result = $this->client->search($params);
        
        return $result;
    }
    
    private function createIndex($name, $defaultField = null)
    {
        $indexParams['index']  = $name;
    
        // Index Settings
        $indexParams['body']['settings']['number_of_shards']   = 3;
        $indexParams['body']['settings']['number_of_replicas'] = 2;
        
        if ($defaultField) {
            $indexParams['body']['settings']['query']['default_field'] = $defaultField;
        }
        
        $indexParams['body']['settings']['analysis']['char_filter']['nopunc_mapping'] = [
            "type" => "mapping",
            "mappings" => [".=>"]
        ];
    
        $indexParams['body']['settings']['analysis']['analyzer']['custom_with_char_filter'] = [
            "tokenizer" => "standard",
            "char_filter" => ["nopunc_mapping"]
        ];
         
        // Create the index
        $this->client->indices()->create($indexParams);
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
        
        $this->indexGeneric(
            'companydirectory',
            'company',
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
            $this->companyOfficersTableGateway,
            'officernumber',
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
        $this->client->indices()->delete(array('index' => $index));
    
        $limit = 5000;
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
    
                for ($i=0; $i<5000; $i++) {
                    if (isset($result['items'][$i]['index']['error'])) {
                        var_dump($result['items'][$i]['index']);
                        die;
                    }
                }
    
                echo $count . ' | ' . $row[$nameKey] . PHP_EOL;
            }
    
        } while ($found);
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

}
