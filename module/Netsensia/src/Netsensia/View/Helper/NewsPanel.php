<?php
namespace Netsensia\View\Helper;

use Zend\View\Helper\AbstractHelper;
use Zend\View\HelperPluginManager as ServiceManager;

class NewsPanel extends AbstractHelper 
{
    public function __invoke($panelTitle, array $items)
    {
        ?>
            <div class="panel panel-default">
            <div class="panel-heading">
            <h3 class="panel-title">
            <?php echo $panelTitle; ?>
            </h3>
            </div>
        <?php
        foreach ($items as $item) {
        ?>

            <div class="panel-body">
                <div class="media">
                <a class="pull-left" href="#">
                <img class="media-object" src="<?php echo $item['image']; ?>" alt="<?php echo $item['title']; ?>">
                </a>
                    <div class="media-body">
                    <h4 class="media-heading"><?php echo $item['title']; ?></h4>
                    <?php echo $item['content']; ?>
                    </div>
                </div>
            </div>

        <?php
        }
        ?>
        </div>
        <?php
        
    }
}
