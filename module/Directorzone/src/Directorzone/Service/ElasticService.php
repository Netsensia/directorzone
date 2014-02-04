<?php
namespace Directorzone\Service;

use Netsensia\Service\NetsensiaService;
use Elasticsearch\Client as ElasticClient;
use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Sql\Select;

class ElasticService extends NetsensiaService
{
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
    
    public function search($name, $params = [])
    {
        
        $params['body']['query']['query_string']['query'] = $name;
        $params['body']['query']['query_string']['default_field'] = 'name';
        $params['body']['query']['query_string']['default_operator'] = 'OR';
        $params['body']['query']['query_string']['analyzer'] = 'standard';
        
        $result = $this->client->search($params);
        
        return $result;
    }
    
    private function createIndex($name)
    {
        $indexParams['index']  = $name;
    
        // Index Settings
        $indexParams['body']['settings']['number_of_shards']   = 3;
        $indexParams['body']['settings']['number_of_replicas'] = 2;
    
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
        $this->createIndex('companies');
        
        $this->client->indices()->delete(array('index' => 'companies'));
        
        $limit = 10000;
        $lastCompanyId = -1;
        
        $count = 0;
        do {
            
            $rowset = $this->companiesHouseTableGateway->select(
                function (Select $select) use ($limit, $lastCompanyId) {
                    $select->order('companyid ASC')
                           ->limit($limit)
                           ->where->greaterThan('companyid', $lastCompanyId);
                }
            );
            
            $found = false;
                
            $body = '';
            
            foreach ($rowset as $row) {
                
                if (isset($row['incorporationdate'])) {
                    if (empty($row['incorporationdate']) ||
                        $row['incorporationdate'] == 'Unknown') {
                        unset($row['incorporationdate']);
                    }
                }
                
                $count ++;
                
                $found = true;
                
                $row['_id'] = $row['companyid'];
                
                $body .=
                    '{ "index" : { "_index" : "companies", "_type" : "company", "_id" : "' . $row['companyid'] . '" } }' . PHP_EOL .
                    json_encode($row) . PHP_EOL;
                
                $lastCompanyId = $row['companyid'];
            }
            
            if ($body != '') {
                $document = array(
                    'index' => 'companies',
                    'type'  => 'company',
                    'body'  => $body
                );
                
                $result = $this->client->bulk($document);
                
                for ($i=0; $i<5000; $i++) {
                    if (isset($result['items'][$i]['index']['error'])) {
                        var_dump($result['items'][$i]['index']);
                        die;
                    }
                }
                
                echo $count . ' | ' . $row['name'] . PHP_EOL;
            }
            
        } while ($found);

    }
    
    public function indexArticles()
    {
        $this->createIndex('articles');
        
        $this->client->indices()->delete(array('index' => 'articles'));
        
        $limit = 10000;
        $lastArticleId = -1;
    
        $count = 0;
        do {
    
            $rowset = $this->articleTableGateway->select(
                function (Select $select) use ($limit, $lastArticleId) {
                    $select->order('companyid ASC')
                    ->limit($limit)
                    ->where->greaterThan('articleid', $lastArticleId);
                }
            );
    
            $found = false;
    
            $body = '';
    
            foreach ($rowset as $row) {

                $count ++;
    
                $found = true;
    
                $row['_id'] = $row['companyid'];
                
                $row = $this->unsetDateFieldsIfEmpty($row, ['startdate', 'enddate', 'publishdate']);
                
                $body .=
                '{ "index" : { "_index" : "articles", "_type" : "article", "_id" : "' . $row['articleid'] . '" } }' . PHP_EOL .
                json_encode($row) . PHP_EOL;
    
                $lastArticleId = $row['articleid'];
            }
    
            if ($body != '') {
                $document = array(
                    'index' => 'articles',
                    'type'  => 'article',
                    'body'  => $body
                );
    
                $result = $this->client->bulk($document);
    
                for ($i=0; $i<5000; $i++) {
                    if (isset($result['items'][$i]['index']['error'])) {
                        var_dump($result['items'][$i]['index']);
                        die;
                    }
                }
    
                echo $count . ' | ' . $row['title'] . PHP_EOL;
            }
    
        } while ($found);
    
    }
    
    private function unsetDateFieldsIfEmpty($row, $fields)
    {
        foreach ($fields as $field) {
            if (empty($row[$field]) || $row[$field] == '0000-00-00') {
                unset($row[$field]);
            }
        }
        
        return $row;
    }
}
