<?php
namespace Netsensia\Form\View\Helper\Widget;

class SectionTitle
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
        $parts = explode('|', $this->element->getValue());
        
        ?>
        <div class="bs-callout bs-callout-info">
        <h4><?= $parts[0] ?></h4>
        <?php if (isset($parts[1])) echo $parts[1]; ?>
        </div>
        <?php
    }
}

