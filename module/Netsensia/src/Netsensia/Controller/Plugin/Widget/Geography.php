<?php
namespace Netsensia\Controller\Plugin\Widget;

use Zend\Db\TableGateway\TableGateway;

class Geography extends Widget
{
    public function process()
    {
        $tableGateway = $this->serviceLocator->get(
            $this->widget->jointablemodel . 'TableGateway'
        );
        
        $tableGateway instanceof TableGateway;
        $parentKey = $this->parentModel->getPrimaryKey();
        
        /* Will throw exception if model is not populated */
        $parentId = $this->parentModel->getId();

        $tableGateway->delete($parentKey);
                
        foreach ($this->widget->rowValues as $value) {
            
            $updateArray = array_merge(
                $this->parentModel->getPrimaryKey(),
                ['geographyid' => $value]
            );
            
            $model = $this->serviceLocator->get(
                $this->widget->jointablemodel . 'Model'
            );
            
            $model->init();
            
            $model->setData($updateArray);
            
            $model->create();

        }
        
    }
}

