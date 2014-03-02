<?php
namespace Netsensia\View\Helper;

use Zend\View\Helper\AbstractHelper;
use JBBCode\Parser;
use JBBCode\DefaultCodeDefinitionSet;

class BbCode extends AbstractHelper 
{
    private function stripBBCode($text_to_search)
    {
        $pattern = '|[[\/\!]*?[^\[\]]*?]|si';
        $replace = '';
        return preg_replace($pattern, $replace, $text_to_search);
    }
    
    public function __invoke($content)
    {
        $bbCodeParser = new Parser();
        $bbCodeParser->addCodeDefinitionSet(new DefaultCodeDefinitionSet());
        $bbCodeParser->parse($content);
        $content = $bbCodeParser->getAsHtml();
        $content = $this->stripBBCode($content);
        
        $content = str_replace(PHP_EOL, '<br>', $content);
        
        return $content;
    }
}
