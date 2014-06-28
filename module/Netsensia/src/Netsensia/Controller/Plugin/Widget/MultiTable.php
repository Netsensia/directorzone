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
        
        $model->init();
        
        $tableGateway = $this->serviceLocator->get(
            $this->widget->jointablemodel . 'TableGateway'
        );
        
        $tableGateway instanceof TableGateway;
        $tableGateway->delete($this->parentModel->getPrimaryKey());
        
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
            
            $model->setData($updateArray);
            $model->create();
        }

    }
}

