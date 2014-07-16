<?php
namespace Netsensia\Form\View\Helper\Widget;

use Netsensia\Form\Widget\Geography as GeographyWidget;

class Geography extends Widget
{
    const TREE_ICON_DIR = '/js/dhtmlxTree/dhtmlxTree_v403_std/codebase/imgs/dhxtree_skyblue/';
    
    public function render()
    {
        ?>
        <table><caption>Regions</caption></table>
        <div id="geographytree_<?php echo uniqid(); ?>">
        
        <?php
            $options = json_decode($this->element->getValue());
            
            $this->renderTree($options->tree);
        ?>
        
        </div>
        <?php
    }
    
    private function renderTree($tree)
    {
        if (!property_exists($tree, 'items')) {
            return;
        }
        echo '<ul class="treepicker">';
        foreach ($tree->items as $item) {
            echo '<li>';
            if (property_exists($item, 'expanded')) {
                echo $this->expandState($item->expanded);
            }
            echo $this->selectState($item->state);
            echo $item->name;
            
            $this->renderTree($item);

            echo '</li>';
        }
        echo '</ul>';
    }
    
    private function expandState($isExpanded)
    {
        if ($isExpanded) {
            return '<img src="' . self::TREE_ICON_DIR . 'plus.gif">&nbsp;';
        } else {
            return '<img src="' . self::TREE_ICON_DIR . 'minus.gif">&nbsp;';
        }
    }
    
    private function selectState($state)
    {
        switch ($state) {
            case GeographyWidget::STATE_ALL :
                return '<img src="' . self::TREE_ICON_DIR . 'iconCheckAll.gif">&nbsp;';
                break;
            case GeographyWidget::STATE_SOME :
                return '<img src="' . self::TREE_ICON_DIR . 'iconCheckGray.gif">&nbsp;';
                break;
            case GeographyWidget::STATE_NONE :
                return '<img src="' . self::TREE_ICON_DIR . 'iconUncheckAll.gif">&nbsp;';
                break;
            case GeographyWidget::STATE_DISABLED :
                return '<img src="' . self::TREE_ICON_DIR . 'iconCheckDis.gif">&nbsp;';
                break;
        }

    }
}
