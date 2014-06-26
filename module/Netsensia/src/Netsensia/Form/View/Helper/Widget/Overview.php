<?php
namespace Netsensia\Form\View\Helper\Widget;

class Overview extends Widget
{
    public function render()
    {
        ?>
        <div class="bs-callout bs-callout-info bs-callout-overview">
        <?php echo $this->element->getValue(); ?>
        </div>
        <?php
    }
}

