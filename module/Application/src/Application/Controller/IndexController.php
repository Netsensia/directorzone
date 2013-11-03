<?php
namespace Application\Controller;

use Netsensia\Controller\NetsensiaActionController;

class IndexController extends NetsensiaActionController
{
    public function indexAction()
    {

        return [ 
            'flashMessages' => $this->getFlashMessages(),
        ];
    }
    
    public function companyAction()
    {
        $companyNumber = $this->params('companyNumber');
        
        $request = $this->getServiceLocator()->get('NetsensiaCompanies\Request\CompanyDetailsRequest');
        $companyModel = $request->loadCompanyDetails($companyNumber);

        $request = $this->getServiceLocator()->get('NetsensiaCompanies\Request\CompanyAppointmentsRequest');
        $companyAppointmentsModel = $request->loadCompanyAppointments(
            $companyNumber,
            $companyModel->getCompanyName(),
            true,
            true
        );
        
        return [
            'company' => $companyModel,
            'appointments' => $companyAppointmentsModel,
        ];
                
    }
}
