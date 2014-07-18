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
                       'items' => $this->populateTree(1, $parentId, $globalState),
                    ],
                ],
        ];
        
        $elementValue = json_encode($options);
        
        $this->element->setValue($elementValue);
                
        return $this->element;
    }
    
    private function populateTree($level, $parentId, $parentState)
    {
        $return = [];
        
        $geographyTable = $this->serviceLocator->get('GeographyTableGateway');
        
        $rows = $geographyTable->select(
            ['level' => $level, 'parentid' => $parentId]
        )->toArray();
        
        foreach ($rows as $row) {
            if ($this->isParentOfUserSelection($row['geographyid'], $level)) {
                $items = $this->populateTree($level + 1, $row['geographyid'], self::STATE_SOME);
                
                $node = [
                    'geographyid' => $row['geographyid'],
                    'name' => $row['geography'],
                    'state' => self::STATE_SOME,
                    'loaded' => true,
                    'haschildren' => $this->hasChildren($row['geographyid']),
                    'expanded' => false,
                    'items' => $items
                ];
            } else {
                $node = [
                    'geographyid' => $row['geographyid'],
                    'name' => $row['geography'],
                    'state' => 
                        // no children selected so can't be STATE_SOME - it's all or nothing
                        $parentState == self::STATE_NONE || $parentState == self::STATE_DISABLED 
                            ? $parentState 
                            : self::STATE_ALL,
                    'loaded' => false,
                    'haschildren' => $this->hasChildren($row['geographyid']),
                    'expanded' => false,
                ];
            }
        
            $return[] = $node;
        }
        
        return $return;
    }
    
    private function hasChildren($geographyId)
    {
        $geographyTable = $this->serviceLocator->get('GeographyTableGateway');
        $rows = $geographyTable->select(['parentid' => $geographyId])->toArray();
       
        return count($rows) > 0;
    }
    
    private function isParentOfUserSelection($geographyId, $level)
    {
        foreach ($this->rowValues as $rowValue) {
            if (isset($rowValue['parents'][$level]) && $rowValue['parents'][$level] == $geographyId) {
                return true;
            }
        }
        return false;
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

