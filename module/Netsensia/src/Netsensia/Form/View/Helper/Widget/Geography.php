<?php
namespace Netsensia\Form\View\Helper\Widget;

use Netsensia\Form\Widget\Geography as GeographyWidget;

class Geography extends Widget
{
    const TREE_ICON_DIR = '/img/tree/';
    var $elId;
    
    public function render()
    {
        ?>
        <table><caption>Regions</caption></table>
        <div id="geographytree_<?php echo uniqid(); ?>">
        
        <?php
            $options = json_decode($this->element->getValue());
            $this->elId = $this->element->getAttribute('id');
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
        echo '<ul data-widgetid="' . $this->elId . '" class="treepicker">';
        foreach ($tree->items as $item) {
            echo '<li>';
            $this->renderExpandState($item);
            $this->renderSelectState($item);
            
            echo $item->name;
            
            $this->renderTree($item);

            echo '</li>';
        }
        echo '</ul>';
    }
    
    private function renderExpandState($item)
    {
        if (property_exists($item, 'expanded')) {
            $isExpanded = $item->expanded;
        } elseif (property_exists($item, 'items')) {
            $isExpanded = ($item->state == GeographyWidget::STATE_SOME);
        } else {
            return;
        }
        
        $attributes = 'data-widgetid="' . $this->elId . '" style="cursor:pointer" data-id="' . $item->id . '"';
       
        if ($isExpanded) {
            echo '<img ' . $attributes . ' class="treecollapse" src="' . self::TREE_ICON_DIR . 'minus.gif">&nbsp;';
        } else {
            echo '<img ' . $attributes . ' class="treeexpand" src="' . self::TREE_ICON_DIR . 'plus.gif">&nbsp;';
        }
    }
    
    private function renderSelectState($item)
    {
        $attributes = 
            'data-state="' . $item->state . '" ' .
            'data-loaded="' . $item->loaded . '" ' . 
            'data-widgetid="' . $this->elId . '" ' .
            'style="cursor:pointer" ' .
            'class="treeitemselect" ' .
            'data-id="' . $item->id . '"';
        
        switch ($item->state) {
            case GeographyWidget::STATE_ALL :
                echo '<img ' . $attributes . ' src="' . self::TREE_ICON_DIR . 'iconCheckAll.gif">&nbsp;';
                break;
            case GeographyWidget::STATE_SOME :
                echo '<img ' . $attributes . ' src="' . self::TREE_ICON_DIR . 'iconCheckGray.gif">&nbsp;';
                break;
            case GeographyWidget::STATE_NONE :
                echo '<img ' . $attributes . ' src="' . self::TREE_ICON_DIR . 'iconUncheckAll.gif">&nbsp;';
                break;
            case GeographyWidget::STATE_DISABLED :
                echo '<img ' . $attributes . ' src="' . self::TREE_ICON_DIR . 'iconCheckDis.gif">&nbsp;';
                break;
        }

    }
}
