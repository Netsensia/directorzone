<?php

namespace Directorzone\Controller\Ajax;

use Netsensia\Controller\NetsensiaActionController;
use Zend\Mvc\MvcEvent;
use Zend\View\Model\JsonModel;
use Directorzone\Service\CompanyService;
use Directorzone\Service\ElasticService;
use Directorzone\Service\Admin\CompanyUploadService;

class CompanyController extends NetsensiaActionController
{
    /**
     * @var CompanyService $companyService
     */
    private $companyService;
    
    /**
     * @var ElasticService $elasticService
     */
    private $elasticService;
    
    private $companyUploadService;
    
    public function __construct(
        CompanyService $companyService,
        ElasticService $elasticService,
        CompanyUploadService $companyUploadService
    )
    {
        $this->companyService = $companyService;
        $this->elasticService = $elasticService;
        $this->companyUploadService = $companyUploadService;
    }
    
    public function onDispatch(MvcEvent $e)
    {
        parent::onDispatch($e);
    }
    
    public function uploadCompanyAction()
    {
        $name = $this->params()->fromPost('name', null);
        
        $this->companyUploadService->addCompaniesToUploadTable([['name' => $name]]);
        
        return new JsonModel(['success' => true]);
    }
    
    public function companySearchAction()
    {
        $name = $this->params()->fromQuery('name', null);
        $limit = $this->params()->fromQuery('limit', null);
        $format = $this->params()->fromQuery('format', null);
        
        if ($limit == '') {
            $limit = 10;
        }
        
        $result = $this->elasticService->searchCompanies($name, $limit, $format);
        
        return new JsonModel(
            $result
        );
    }
    
    public function officerSearchAction()
    {
        $name = $this->params()->fromQuery('name', null);
    
        $result = $this->elasticService->searchOfficers($name);
    
        return new JsonModel(
            $result
        );
    }
    
    public function updateUploadStatusAction()
    {
        $uploadId = $this->params()->fromQuery('uploadid', null);
        $number = $this->params()->fromQuery('number', null);
        $name = $this->params()->fromQuery('name', null);
        $status = $this->params()->fromQuery('recordstatus', null);
                
        $result = $this->companyService->updateUploadStatus(
            $uploadId,
            $number,
            $name,
            $status
        );
        
        return new JsonModel(
            [$result]
        );
    }
    
    public function deleteUploadedAction()
    {
        $uploadId = $this->params()->fromQuery('uploadid', null);
        $type = $this->params()->fromQuery('type', null);
        
        if ($type != 'L' && $type != 'P' && $type != 'U') {
            throw new \Exception('Invalid type');
        }
        
        $result = $this->companyService->deleteUploaded(
            $type,
            $uploadId
        );
    
        return new JsonModel(
            [$result]
        );
    }
    
    public function makeLiveAction()
    {
        $uploadId = $this->params()->fromQuery('uploadid', null);
    
        try {
            $result = $this->companyService->makeLive(
                $uploadId
            );
        } catch (\Exception $e) {
            $result['error'] = $e->getMessage();
        }
            
        return new JsonModel(
            [$result]
        );
    }

    public function companyListAction()
    {
        $type = $this->params()->fromQuery('type', null);
        $page = $this->params()->fromQuery('page', null);
        $size = $this->params()->fromQuery('size', null);
        $order = $this->params()->fromQuery('order', 1);
        
        $start = ($page - 1) * $size + 1;
        $end = $start + $size - 1;
        
        $results = $this->companyService->getCompanies(
            $type,
            $start,
            $end,
            $order
        );
                
        $companies = [
            'results' => [],
        ];
        
        foreach ($results as $result) {
            
            $name = $result['name'];
            $createdTime = $result['createdtime'];
            $ceo = '';
            $sectors = '';
            $turnover = '';
            $exchange = @($result['exchange'] == null ? '' : $result['exchange']);
            $town = @($result['town'] == null ? '' : $result['town']);
            $primarySector = @$result['siccode1'];
                        
            if (isset($result['companynumber'])) {
                $companyNumber = $result['companynumber'];
            } elseif (isset($result['reference'])) {
                $companyNumber = $result['reference'];
            } elseif (isset($result['number'])) {
                $companyNumber = $result['number'];
            }
            
            if (isset($result['companyuploadid'])) {
                $internalId = $result['companyuploadid'];
            } elseif (isset($result['companydirectoryid'])) {
                $internalId = $result['companydirectoryid'];
                $ceo = $result['ceo'];
                $sectors = $result['sectors'];
                $turnover = $result['turnoverid'];
            } else {
                $internalId = '';
            }
            
            $companies['results'][] = [
                'internalId' => $internalId,
                'number' => $companyNumber,
                'name' => $name,
                'ceo' => $ceo,
                'town' => $town,
                'primarysector' => $primarySector,
                'exchange' => $exchange,
                'sectors' => $sectors,
                'turnover' => $turnover,
                'createdTime' => $createdTime,
                'details' => '',
            ];
        }

        return new JsonModel(
            $companies
        );
    }
}
