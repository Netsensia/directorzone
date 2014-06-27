<?php
namespace Netsensia\Controller\Plugin\Widget;

use Zend\Db\TableGateway\TableGateway;
class MultiTable extends Widget
{
    public function process()
    {
        $model = $this->serviceLocator->get(
            $this->widget->jointablemodel . 'Model'
        );
        
        $tableGateway = $this->serviceLocator->get(
            $this->widget->jointablemodel . 'TableGateway'
        );
        
        $tableGateway instanceof TableGateway;
        $tableGateway->delete($this->parentModel->getPrimaryKey());
        
        $tableColumns = [];
        
        foreach ($this->widget->fields as $field) {
            if ($field->name == 'select') {
                $columnName = $field->name . 'id';
            } else {
                $columnName = $field->name;
            }
        }
        
        foreach ($tableColumns as $column) {
            
        }
    }
}

