<?php
namespace Netsensia\Controller\Plugin\Widget;

use Zend\Db\TableGateway\TableGateway;

class MultiTable extends Widget
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
        
        $tableColumns = [];
        
        foreach ($this->widget->fields as $field) {
            if ($field->type == 'select') {
                $columnName = $field->name . 'id';
            } else {
                $columnName = $field->name;
            }
            $tableColumns[] = $columnName;
        }

        foreach ($this->widget->rowValues as $row) {
            
            $count = 0;
            foreach ($tableColumns as $column) {
                $updateArray[$column] = $row[$count];
                $count++;
            }
            
            $updateArray = array_merge(
                $this->parentModel->getPrimaryKey(),
                $updateArray
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

