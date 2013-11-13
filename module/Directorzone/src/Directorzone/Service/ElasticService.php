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
        
        $offset = 0;
        $limit = 1000;
        
        do {
            $rowset = $this->companyTableGateway->select(
                function (Select $select) use ($offset, $limit) {
                    $select->order('name ASC')->offset($offset)->limit($limit);
                }
            );
            
            $found = false;
                
            foreach ($rowset as $row) {
                $found = true;
                
                $document = array(
                    'index' => 'companies',
                    'type'  => 'company',
                    'id'    => $row['companyid'],
                    'body'  => (array)$row
                );
                
                $this->client->index($document);
            }
            echo $row['name'] . PHP_EOL;
            
            $offset += $limit;
        } while ($found);

    }
}
