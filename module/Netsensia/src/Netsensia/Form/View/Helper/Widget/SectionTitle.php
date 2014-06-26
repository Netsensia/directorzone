<?php
namespace Netsensia\Form\View\Helper\Widget;

class SectionTitle extends Widget
{
    public function render()
    {
        $parts = explode('|', $this->element->getValue());
        
        ?>
        <div class="bs-callout bs-callout-info">
        <h4><?= $parts[0] ?></h4>
        <?php if (!empty($parts[1])) echo $parts[1]; ?>
        </div>
        <?php
    }
}

