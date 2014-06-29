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
            echo '<td>';
            switch ($field->type) {
            	case 'select' :
            	    $select = new Select('widgetignore[]');
            	    $select->setAttribute('class', 'netsensia_form_widget');
            	    $optionsArray = $this->form->getOptionsArray($field->name);
            	    $select->setValueOptions(
            	        array_merge(
                            [-1 => 'Please select...'],
                            $optionsArray
                        )
            	    );
                    if (!empty($values)) {
                        $select->setValue($values[$fieldIndex]);
                    }
            	    echo $this->view->formElement($select);
            	    break;
            	case 'textlink':
            	    echo '<a class="widget_multitable_edit" data-type="text" data-value="" id="' . $this->element->getAttribute('id') . '_' . $field->name . '" data-title="Enter ' . $field->label . '" href="#">Edit</a>';
            	    break;
            	case 'textarealink':
            	    echo '<a class="widget_multitable_edit" data-type="textarea" data-value="" id="' . $this->element->getAttribute('id') . '_' . $field->name . '" data-title="Enter ' . $field->label . '" href="#">Edit</a>';
            	    break;
            	case 'text':
            	    $text = new Text('widgetignore[]');
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

