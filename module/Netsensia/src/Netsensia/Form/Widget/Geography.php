<?php
namespace Netsensia\Form\Widget;

use Zend\Db\Sql\Select;

class Geography extends Widget
{
    const STATE_ALL = 0;
    const STATE_SOME = 1;
    const STATE_NONE = 2;
    const STATE_DISABLED = 3;
    
    private $rowValues;
    
    public function getPopulatedElement()
    {
        $elementValue = $this->element->getValue();
        
        $options = json_decode($elementValue);
        
        $gatewayName = $options->jointablemodel . 'TableGateway';
        
        $gateway = $this->serviceLocator->get($gatewayName);
        
        $rowset = $gateway->select(
            function (Select $select) {
                $select->where(
                    $this->parentModel->getPrimaryKey()
                );
            }
        );
        
        $results = $rowset->toArray();
        
        $allRowValues = [];
        
        foreach ($results as $row) {
            $allRowValues[] = [
                'value' => $row['geographyid'],
                'parents' => $this->getParents($row['geographyid'])
            ];
        }
        
        $this->rowValues = $allRowValues;
        
        $options->rowValues = $allRowValues;
        
        $numSelected = count($allRowValues);
        if ($numSelected == 0) {
            $globalState = self::STATE_ALL;
        } else {
            $globalState = self::STATE_SOME;
        }
        
        $parentId = -1;
        
        $options->tree = [
            'items' =>
                [
                    [
                       'geographyid' => $parentId,
                       'name' => 'Global',
                       'state' => $globalState,
                       'expanded' => true,
                       'haschildren' => true,
                       'loaded' => true,
                       'items' => $this->populateTree(1, $parentId),
                    ],
                ],
        ];
        
        $elementValue = json_encode($options);
        
        $this->element->setValue($elementValue);
                
        return $this->element;
    }
    
    private function populateTree($level, $parentId)
    {
        $return = [];
        
        $geographyTable = $this->serviceLocator->get('GeographyTableGateway');
        
        $rows = $geographyTable->select(
            ['level' => $level, 'parentid' => $parentId]
        )->toArray();
        
        foreach ($rows as $row) {
            $node = [
                'geographyid' => $row['geographyid'],
                'name' => $row['geography'],
                'state' => self::STATE_ALL,
                'loaded' => false,
                'haschildren' => true,
                'expanded' => false, // will force a plus icon even though no children yet
            ];
            // if anyone has this as a parent, then add items to the node, set expanded as false,
            // loaded as true, haschildren as true and state as STATE_SOME
            // otherwise...
            // find out if there are any children and set haschildren accordingly
        
            $return[] = $node;
        }
        
        return $return;
    }
    
    private function getParents($geographyId)
    {
        $parents = [];
        $gateway = $this->serviceLocator->get('GeographyTableGateway');
        
        $rows = $gateway->select(['geographyid' => $geographyId])->toArray();
        $row = $rows[0];
        $level = $row['level'];
        
        while ($level > 0) {
            $level --;
            $parents[$level] = $row['parentid'];
            
            if ($level > 0) {
                $rows = $gateway->select(['geographyid' => $row['parentid']])->toArray();
                $row = $rows[0];
            }

        }
        
        return $parents;
    }
}

