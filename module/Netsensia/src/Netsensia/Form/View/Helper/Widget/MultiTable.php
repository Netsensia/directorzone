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
                	            'netsensia_form_widget select_parent ' .
                	            ($tier < $tierCount-1 ? ' select_child' : '')
                            );
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
            	    $select->setAttribute('class', 'netsensia_form_widget' . ($isTiered ? ' select_child select_node' : ''));
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

            	        for ($i=$tierCount; $i>=2; $i--) {
            	            $parentAppend = '';
            	            for ($tier=3; $tier<=$i; $tier++) {
            	               $parentAppend .= 'parent';
            	            }

                	        $referenceSelect = new Select('widgetignore[]');
                	        $referenceSelect->setAttribute('class', 'netsensia_form_widget' . ($isTiered ? ' select_child' : ''));
                	         
                            $optionsArray = $this->form->getOptionsArray($field->name . $parentAppend, null, null, true);
                            $optionsArray = array_merge(
                                [['value' => -1, 'label' => 'Please select...']],
                                $optionsArray
                            );
                            $referenceSelect->setValueOptions(
                                $optionsArray
                            );
                	        $referenceSelect->setAttribute('class', 'netsensia_form_widget select_reference');
    
                	        $parentValue = -1;
                	        foreach ($optionsArray as $option) {
                                $parts = explode(',', $option['value']);
                                if (count($parts) == 2 && !empty($values)) {
                                    if ($parts[0] == $values[$fieldIndex]) {
                                        $parentValue = $parts[1];
                                        $referenceSelect->setValue($option['value']);
                                    }
                                }
                            }
                	        $selectElements['parent' . $parentAppend]->setValue($parentValue);
                	        $selectElements['reference' . $parentAppend] = $referenceSelect;
            	        }
            	        
            	    }
            	    
            	    foreach ($selectElements as $key => $select) {

                       echo $this->view->formElement($select);
                    }

            	    break;
            	case 'textlink':
            	    echo '<a class="widget_multitable_edit" data-type="text" data-value="' . $textValue . '" id="' . $this->element->getAttribute('id') . '_' . $field->name . '" data-title="Enter ' . $field->label . '" href="#">Edit</a>';
            	    break;
            	case 'textarealink':
            	    echo '<a class="widget_multitable_edit" data-type="textarea" data-value="' . $textValue . '" id="' . $this->element->getAttribute('id') . '_' . $field->name . '" data-title="Enter ' . $field->label . '" href="#">Edit</a>';
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

