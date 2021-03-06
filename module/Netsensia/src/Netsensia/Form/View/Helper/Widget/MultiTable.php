<?php
namespace Netsensia\Form\View\Helper\Widget;

use Zend\Form\Element\Select;
use Zend\Form\Element\Text;

class MultiTable extends Widget
{
    public function render()
    {
        $options = json_decode($this->element->getValue());
        
        ?>
        <table class="table widget_multitable" style="margin-bottom:5px" data-widgetid="<?= $this->element->getAttribute('id'); ?>" style="margin-top:1em">
        <?php if (isset($options->groupname)) echo '<caption>' . $options->groupname . '</caption>'; ?>
        <tr>
        <?php foreach ($options->fields as $field): ?>
        <th><?= $field->label; ?></th>
        <?php endforeach; ?>
        <th>&nbsp;</th>
        </tr>
        
        <?php
            if (count($options->rowValues) == 0) {
                $this->renderTableRow($options->fields);
            } else {
                foreach ($options->rowValues as $row) {
                    $this->renderTableRow($options->fields, $row);
                }
            } 
        ?>
        
        </table>
        <a class="widget_multitable_addrow" data-widgetid="<?= $this->element->getAttribute('id'); ?>">
        <span class="glyphicon glyphicon-plus"></span>
        </a>
        &nbsp;
        <a class="widget_multitable_addrow" data-widgetid="<?= $this->element->getAttribute('id'); ?>">Add row</a>
        
        <?php
    }
    
    private function renderTableRow($fields, $values = [])
    {
        ?>
        <tr>
        <?php
        $fieldIndex = 0;
        foreach ($fields as $field) {
            $textValue = empty($values) ? '' : $values[$fieldIndex];
            echo '<td>';
            $fieldId = $this->element->getAttribute('id') . '_' . $field->name;
            switch ($field->type) {
            	case 'select' :
            	    $selectElements = [];
            	    
            	    $isTiered = (isset($field->subtype) && $field->subtype == 'tiered');
            	    $tierCount = null;
            	    
            	    if ($isTiered) {
            	        $tierCount = (isset($field->tiers) ? $field->tiers : 2);
            	         
            	        for ($tier=$tierCount-1; $tier>0; $tier--) {
            	            $parentText = '';
            	            for ($i=0; $i<$tier; $i++) {
            	                $parentText .= 'parent';
            	            }
            	            
                	        $parentSelect = new Select('widgetignore[]');
                	        $parentSelect->setAttribute(
                	           'class',
                	            'netsensia_form_widget select_parent' .
                	            ($tier < $tierCount-1 ? ' select_child' : '')
                            );
                	        $parentSelect->setAttribute('data-tier', $tier+1);

                	        $parentOptionsArray = $this->form->getOptionsArray($field->name . $parentText);
                	        $parentOptionsArray = array_merge(
                	           [['value' => -1, 'label' => 'Please select parent...']],
                	           $parentOptionsArray
                	        );
                	        $parentSelect->setValueOptions(
                	            $parentOptionsArray
                	        );
                	        if (!empty($values)) {
                	            // @todo get parent from child value
                	        }
                	        $selectElements[$parentText] = $parentSelect;
            	        }
            	    }
            	    
            	    $select = new Select('widgetignore[]');
            	    $select->setAttribute('class', 'netsensia_form_widget select_node' . ($isTiered ? ' select_child' : ''));
            	    $select->setAttribute('data-tier', 1);
            	    $optionsArray = $this->form->getOptionsArray($field->name);
            	    $optionsArray = array_merge(
                        [['value' => -1, 'label' => 'Please select...']],
            	        $optionsArray
            	    );
            	    $select->setValueOptions(
            	        $optionsArray
            	    );
                    if (!empty($values)) {
                        $select->setValue($values[$fieldIndex]);
                    }
                    $selectElements['child'] = $select;
            	    
            	    if ($isTiered) {

            	        if (!empty($values)) {
            	            $childValue = $values[$fieldIndex];
            	        } else {
            	            $childValue = -1;
            	        }
            	         
            	        for ($i=1; $i<=$tierCount-1; $i++) {
            	            // process each select element except the ultimate parent
            	            $parentAppend = '';
            	            for ($tier=2; $tier<=$i; $tier++) {
            	               $parentAppend .= 'parent';
            	            }

                	        $referenceSelect = new Select('widgetignore[]');
                	         
                            $optionsArray = $this->form->getOptionsArray($field->name . $parentAppend, null, null, true);
                            $optionsArray = array_merge(
                                [['value' => -1, 'label' => 'Please select...']],
                                $optionsArray
                            );
                            $referenceSelect->setValueOptions(
                                $optionsArray
                            );
                            $referenceSelect->setAttribute('data-tier', $i);
                	        $referenceSelect->setAttribute('class', 'netsensia_form_widget select_reference');
    
                	        $parentValue = -1;
                	        
                	        foreach ($optionsArray as $option) {
                                $parts = explode(',', $option['value']);
                                if (count($parts) == 2 && !empty($values)) {
                                    if ($parts[0] == $childValue) {
                                        $parentValue = $parts[1];
                                        $referenceSelect->setValue($option['value']);
                                    }
                                }
                            }
                            
                            $childValue = $parentValue;

                	        $selectElements['parent' . $parentAppend]->setValue($parentValue);
                	        $selectElements['reference' . $parentAppend] = $referenceSelect;
                	    }
            	    }

            	    foreach ($selectElements as $key => $select) {
                       echo $this->view->formElement($select);
                    }

            	    break;
            	case 'textlink':
            	    echo '<span></span><a class="widget_multitable_edit" data-type="text" data-value="' . $textValue . '" id="' . $fieldId . '" data-title="Enter ' . $field->label . '" href="#">Edit</a>';
            	    break;
            	case 'textarealink':
            	    echo '<span></span><a class="widget_multitable_edit" data-type="textarea" data-value="' . $textValue . '" id="' . $fieldId . '" data-title="Enter ' . $field->label . '" href="#">Edit</a>';
            	    break;
            	case 'text':
            	    $text = new Text('widgetignore[]');
            	    $text->setValue($textValue);
            	    $text->setAttribute('class', 'netsensia_form_widget');
            	    echo $this->view->formElement($text);
            	    break;
            }
            echo '</td>';
            
            $fieldIndex ++;
        }
        ?>
        <td style="text-align:right"><a href="#" class="widget_multitable_deleterow" data-widgetid="<?= $this->element->getAttribute('id'); ?>"><span class="glyphicon glyphicon-trash"></span></a></td>
        </tr>
        <?php
    }
}

