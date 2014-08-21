<?php
namespace Directorzone\Service;

use Netsensia\Service\NetsensiaService;
use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Sql\Select;
use Netsensia\Exception\NotFoundResourceException;
use Zend\Db\Sql\Expression;

class CompanyOwnersService extends NetsensiaService
{
    /**
     * @var TableGateway
     */
    private $userCompanyDirectoryTable;
    
    public function __construct(
        TableGateway $userCompany
    )
    {
        $this->userCompanyDirectoryTable = $userCompany;
    }

    public function getCompanyOwners()
    {
        return ['results' => [['internalId' => 1, 'company' => 'This', 'owner' => 'Is', 'requestdate' => '2014-07-01', 'status' => 'Temporary Data']]];
    }
}
