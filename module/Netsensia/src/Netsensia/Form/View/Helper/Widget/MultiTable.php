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
            	    $isTiered = (isset($field->subtype) && $field->subtype == 'tiered');
            	    if ($isTiered) {
            	        $parentSelect = new Select('widgetignore[]');
            	        $parentSelect->setAttribute('class', 'netsensia_form_widget select_parent');
            	        $parentOptionsArray = $this->form->getOptionsArray($field->name . 'parent');
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
            	        echo $this->view->formElement($parentSelect);
            	    }
            	    $select = new Select('widgetignore[]');
            	    $select->setAttribute('class', 'netsensia_form_widget' . ($isTiered ? ' select_child' : ''));
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
            	    echo $this->view->formElement($select);
            	    if ($isTiered) {
                        $optionsArray = $this->form->getOptionsArray($field->name, null, null, true);
                        $optionsArray = array_merge(
                            [['value' => -1, 'label' => 'Please select...']],
                            $optionsArray
                        );
                        $select->setValueOptions(
                            $optionsArray
                        );
            	        $select->setAttribute('class', 'netsensia_form_widget select_reference');
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

