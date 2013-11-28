<?php
namespace Directorzone\Service;

use Netsensia\Service\NetsensiaService;
use Elasticsearch\Client as ElasticClient;
use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Sql\Select;

class ElasticService extends NetsensiaService
{
    private $client;
    
    private $companyTableGateway;
    
    public function __construct(
        ElasticClient $client,
        TableGateway $companyTableGateway
    ) {
        $this->client = $client;
        $this->companyTableGateway = $companyTableGateway;
    }
    
    public function search($name)
    {        
        $params = [
            'index' => 'companies',
            'type'  => 'company',
        ];
        
        $params['body']['query']['query_string']['query'] = $name;
        $params['body']['query']['query_string']['default_field'] = 'name';
        $params['body']['query']['query_string']['default_operator'] = 'OR';
        $params['body']['query']['query_string']['analyzer'] = 'standard';
        
        $result = $this->client->search($params);
        
        return $result;
    }
    
    private function createCompaniesIndex()
    {
        $indexParams['index']  = 'companies';
        
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
        $this->createCompaniesIndex();
        
        $this->client->indices()->delete(array(array('index' => 'companies')));
        
        $limit = 10000;
        $lastCompanyId = -1;
        
        $count = 0;
        do {
            
            $rowset = $this->companyTableGateway->select(
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
                        //echo 'Unset' . PHP_EOL;
                    } else {
                        //echo 'DATE: ' . $row['incorporationdate'] . PHP_EOL;
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
}
