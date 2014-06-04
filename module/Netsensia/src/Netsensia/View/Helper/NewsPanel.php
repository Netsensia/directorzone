<?php
namespace Netsensia\View\Helper;

use Zend\View\Helper\AbstractHelper;
use JBBCode\Parser;
use JBBCode\DefaultCodeDefinitionSet;

class NewsPanel extends AbstractHelper 
{
    private function stripBBCode($text_to_search)
    {
        $pattern = '|[[\/\!]*?[^\[\]]*?]|si';
        $replace = '';
        return preg_replace($pattern, $replace, $text_to_search);
    }
    
    public function __invoke($panelTitle, array $items, $panelClass = 'panel-default')
    {
        ?>
            <div class="panel <?php echo $panelClass; ?>">
            <div class="panel-heading">
            <h3 class="panel-title">
            <?php echo $panelTitle; ?>
            </h3>
            </div>
        <?php
        $count = 0;
        foreach ($items as $item) {
            $bbCodeParser = new Parser();
            $bbCodeParser->addCodeDefinitionSet(new DefaultCodeDefinitionSet());
            $content = $item['content'];
            $bbCodeParser->parse($content);
            $content = $bbCodeParser->getAsHtml();
            $content = $this->stripBBCode($content);

        ?>

                <?php if (++$count == 1): ?>
                            <div class="panel-body">
                
                                <div class="media">
                
                    <a class="pull-left" href="#">
                    <img class="media-object" style="height:45px; width:45px" src="<?php echo $item['image']; ?>" alt="<?php echo $item['title']; ?>">
                    </a>
                    <div class="media-body">
                    <h4 class="media-heading"><a href="/article/<?php echo $item['articleid']; ?>"><?php echo $item['title']; ?></a></h4>
                    <div style="max-height:6em"><?php echo $content; ?></div>
                    </div>
                                    </div>
                                                </div>
                                    
                <?php else: ?>
                <div class="mini-list-item">
                    <a href="/article/<?php echo $item['articleid']; ?>"><?php echo $item['title']; ?></a>
                    </div>
                <?php endif ?>

        <?php
        }
        ?>
        </div>
        <?php
        
    }
}
