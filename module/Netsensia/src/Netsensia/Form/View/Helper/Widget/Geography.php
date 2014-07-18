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
            $this->renderTree($options->tree, true);
        ?>
        
        </div>
        <?php
    }
    
    private function renderTree($tree, $isExpanded)
    {
        if (!property_exists($tree, 'items')) {
            return;
        }
        
        if ($isExpanded) {
            $visibililty = '';
        } else {
            $visibililty = 'style="display:none"';
        }
        
        echo '<ul data-widgetid="' . $this->elId . '" class="treepicker" ' . $visibililty . '">';
        foreach ($tree->items as $item) {
            echo '<li>';
            
            $isExpanded = $this->renderExpandState($item);
            $this->renderSelectState($item);
            
            echo $item->name;
            
            $this->renderTree($item, $isExpanded);

            echo '</li>';
        }
        echo '</ul>';
    }
    
    private function renderExpandState($item)
    {
        $hasChildren = $item->haschildren;
        
        if (!$hasChildren) {
            return false;
        }
        
        if (property_exists($item, 'expanded')) {
            $isExpanded = $item->expanded;
        } else {
            $isExpanded = false;
        }
        
        $attributes = 
            'data-widgetid="' . $this->elId . '" ' .
            'data-loaded="' . $item->loaded . '" ' .
            'style="cursor:pointer" ' .
            'data-geographyid="' . $item->geographyid . '"';
       
        if ($isExpanded) {
            echo '<img ' . $attributes . ' class="treecollapse" src="' . self::TREE_ICON_DIR . 'minus.gif">&nbsp;';
            return true;
        } else {
            echo '<img ' . $attributes . ' class="treeexpand" src="' . self::TREE_ICON_DIR . 'plus.gif">&nbsp;';
            return false;
        }
    }
    
    private function renderSelectState($item)
    {
        $attributes = 
            'data-haschildren="' . $item->haschildren . '" ' .
            'data-state="' . $item->state . '" ' .
            'data-widgetid="' . $this->elId . '" ' .
            'style="cursor:pointer" ' .
            'class="treeitemselect" ' .
            'data-geographyid="' . $item->geographyid . '"';
        
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
