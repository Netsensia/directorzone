<?php
namespace Directorzone\Service;

use Netsensia\Service\NetsensiaService;
use Zend\Db\Sql\Select;

class MemberService extends NetsensiaService
{
    public function getMemberList()
    {
        $gateway = $this->getServiceLocator()->get('UserTableGateway');
        
        $results = $gateway->select(function (Select $select) {
            $select->columns(['userid', 'name', 'forenames', 'surname']);
        })->toArray();
        
        return $results;
    }
    
    public function getMemberDetails($userId)
    {
        $gateway = $this->getServiceLocator()->get('UserTableGateway');
        
        $results = $gateway->select(function (Select $select) use ($userId) {
            $select->columns(['userid', 'approvestatusid', 'name', 'forenames', 'surname', 'email'])->where(['userid' => $userId]);
        })->toArray();
        
        return $results[0];
    }
    
    public function setMemberDetails($userId, $details)
    {
        $gateway = $this->getServiceLocator()->get('UserTableGateway');
    
        $gateway->update($details, ['userid' => $userId]);
        
        return true;
    }
}
