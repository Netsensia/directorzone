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
    
    public function indexCompanies()
    {
        $this->client->indices()->delete(array(array('index' => 'companies')));
        
        $limit = 5000;
        $lastCompanyId = -1;
        
        $count = 0;
        do {
            
            $rowset = $this->companyTableGateway->select(
                function (Select $select) use ($limit, $lastCompanyId) {
                    $select->order('companyid ASC')->limit($limit)->where->greaterThan('companyid', $lastCompanyId);
                }
            );
            
            $found = false;
                
            $body = '';
            //$body = [];
            
            foreach ($rowset as $row) {
                $count ++;
                
                $found = true;
                
                $row['_id'] = $row['companyid'];
                
                $body .= 
                    '{ "index" : { "_index" : "companies", "_type" : "company", "_id" : "' . $row['companyid'] . '" } }' . PHP_EOL .
                    json_encode($row) . PHP_EOL;
                //$body[] = (array)$row;
                
                $lastCompanyId = $row['companyid'];

            }
            
            $document = array(
                'index' => 'companies',
                'type'  => 'company',
                'body'  => $body
            );
            
            $result = $this->client->bulk($document);
            
            if (isset($result['error'])) {
                var_dump($result); die;
            }
            
            echo $count . ' | ' . $row['name'] . PHP_EOL;
            
        } while ($found);

    }
}
