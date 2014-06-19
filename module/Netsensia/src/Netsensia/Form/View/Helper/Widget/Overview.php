<?php
namespace Netsensia\Form\View\Helper\Widget;

class Overview
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
        ?>
        <div class="bs-callout bs-callout-info bs-callout-overview">
        <?php echo $this->element->getValue(); ?>
        </div>
        <?php
    }
}

