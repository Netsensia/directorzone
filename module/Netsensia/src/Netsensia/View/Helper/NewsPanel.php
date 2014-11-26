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
<div class="panel news-panel <?php echo $panelClass; ?>">
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
                            
        <div class="panel-body" style="overflow:hidden">
    		<div class="media">
    			<div style="margin-bottom:0.5em;background: #fff url(<?php echo $item['image']; ?>) center center no-repeat;width: 100%;height:100px;border: 1px solid #fff;text-indent: -9999px;">
    			</div>
    			<div class="media-body">
    				<h4 class="media-heading" style="font-size: 1.15em">
    					<a href="/article/<?php echo $item['articleid']; ?>"><?php echo $item['title']; ?></a>
    				</h4>
                        <?php $fontSize=0.86; ?>
                        <div style="max-height:4em;font-size:<?php echo $fontSize; ?>em"><?php echo $content; ?></div>
    			</div>
    		</div>
	    </div>
                                    
                <?php else: ?>
                <div class="mini-list-item" style="max-height: 1.5em;overflow:hidden">
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
