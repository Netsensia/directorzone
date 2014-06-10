<?php
namespace Netsensia\Form\View\Helper\Widget;

use Zend\Form\Element\Select;
use Zend\Form\Element\Text;

class MultiTable
{
    private $view;
    private $form;
    private $element;
    
    public function __construct($view, $form, $element)
    {
        $this->view = $view;
        $this->form = $form;
        $this->element = $element;
    }
    
    public function render()
    {
        $options = json_decode($this->element->getValue());
        
        ?>
        <div class="bs-callout bs-callout-info">
        <h4><?= $options->groupname ?></h4>
        <?php if (isset($options->callouttext)) echo $options->callouttext; ?>
        </div>
        <table class="table widget_multitable" style="margin-bottom:5px" data-widgetid="<?= $this->element->getAttribute('id'); ?>" style="margin-top:1em">
        <tr>
        <?php foreach ($options->fields as $field): ?>
        <th><?= $field->label; ?></th>
        <?php endforeach; ?>
        <th>&nbsp;</th>
        </tr>
        <tr>
        <?php foreach ($options->fields as $field): ?>
        <td>
        <?php
            switch ($field->type) {
                case 'select' :
                    $select = new Select($field->name);
                    $select->setAttribute('class', 'netsensia_form_widget');
                    $select->setValueOptions(
                        $this->form->getOptionsArray($field->name)
                    );
                    echo $this->view->formElement($select);
                    break;
                case 'textlink':
                    echo '<a class="widget_multitable_edit" data-type="text" data-value="" id="' . $this->element->getAttribute('id') . '_' . $field->name . '" data-title="Enter ' . $field->label . '" href="#">Edit</a>';
                    break;
                case 'textarealink':
                    echo '<a class="widget_multitable_edit" data-type="textarea" data-value="" id="' . $this->element->getAttribute('id') . '_' . $field->name . '" data-title="Enter ' . $field->label . '" href="#">Edit</a>';
                    break;
                case 'text':
                    $text = new Text($field->name);
                    $text->setAttribute('class', 'netsensia_form_widget');
                    echo $this->view->formElement($text);
                    break;
            }
        ?>
        </td>
        <?php endforeach; ?>
        <td style="text-align:right"><a href="#" class="widget_multitable_deleterow" data-widgetid="<?= $this->element->getAttribute('id'); ?>"><span class="glyphicon glyphicon-trash"></span></a></td>
        </tr>
        </table>
        <a class="widget_multitable_addrow" data-widgetid="<?= $this->element->getAttribute('id'); ?>">
        <span class="glyphicon glyphicon-plus"></span>
        </a>
        &nbsp;
        <a class="widget_multitable_addrow" data-widgetid="<?= $this->element->getAttribute('id'); ?>">Add row</a>
        
        <?php
    }
}

