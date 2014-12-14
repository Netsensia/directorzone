<?php
namespace Directorzone\Controller\Plugin\Widget;

use Netsensia\Controller\Plugin\Widget\Widget;
use Zend\Db\Sql\Select;

class MultiTable extends Widget
{
    public function process()
    {
        $companyService = $this->serviceLocator->get('CompanyService');
        
        $relationshipGateway = $this->serviceLocator->get('RelationshipTableGateway');
        $companyRelationshipGateway = $this->serviceLocator->get('CompanyRelationshipTableGateway');
        
        $result = $relationshipGateway->select(
            function (Select $select) {
                
                $select->columns(
                    ['relationshipid', 'counterpartyid']
                )
                ->where->notEqualTo('counterpartyid', '');
            }
        )->toArray();
        
        $counterParties = [];
        foreach ($result as $row) {
            $counterParties[$row['relationshipid']] = $row['counterpartyid'];
        }
        
        if ($this->widget->jointablemodel == 'CompanyRelationship') {
            $sourceCompanyId = $this->parentModel->getId();
            
            $companyRelationshipGateway->delete([
                'comment' => 'Reciprocal relationship created automatically',
                'relatedcompanyid' => $sourceCompanyId,
            ]);
            
            foreach ($this->widget->rowValues as $row) {
                $relationshipId = $row[0];
                $relatedCompanyName = $row[1];
                
                $relatedCompanyId = $companyService->getCompanyDirectoryIdFromName($relatedCompanyName);
                
                $data = [
                    'companydirectoryid' => $relatedCompanyId,
                    'relationshipid' => $counterParties[$relationshipId],
                    'relatedcompanyid' => $sourceCompanyId,
                    'relatedcompany' => $companyService->getNameFromCompanyDirectoryId($relatedCompanyId),
                    'comment' => 'Reciprocal relationship created automatically'
                ];
                
                if ($relatedCompanyId !== false) {
                    $data = [
                            'companydirectoryid' => $relatedCompanyId,
                            'relationshipid' => $counterParties[$relationshipId],
                            'relatedcompanyid' => $sourceCompanyId,
                            'relatedcompany' => $companyService->getNameFromCompanyDirectoryId($sourceCompanyId),
                            'comment' => 'Reciprocal relationship created automatically'
                        ];
                    
                    $companyRelationshipGateway->insert(
                        $data
                    );
                }
            }            
        }
    }
}

