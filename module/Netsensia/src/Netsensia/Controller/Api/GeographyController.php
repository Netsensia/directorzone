<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/Help for the canonical source repository
 * @copyright Copyright (c) 2005-2012 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Netsensia\Controller\Api;

use Zend\Db\TableGateway\TableGateway;
use Zend\View\Model\JsonModel;
use Netsensia\Controller\NetsensiaActionController;

class GeographyController extends NetsensiaActionController
{
    var $geographyTable;
    
    public function __construct(
        TableGateway $geographyTable
    )
    {
        $this->geographyTable = $geographyTable;    
    }
    
    public function childrenAction()
    {
        $id = $this->params('id');
        
        $rows = $this->geographyTable->select(['parentid' => $id])->toArray();
        
        return new JsonModel($rows);
    }
}
