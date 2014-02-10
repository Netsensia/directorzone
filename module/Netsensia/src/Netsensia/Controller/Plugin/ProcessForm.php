<?php

namespace Netsensia\Controller\Plugin;

use Zend\Mvc\Controller\Plugin\AbstractPlugin;

class ProcessForm extends AbstractPlugin
{
    public function __invoke(
        $formName,
        $modelName,
        $modelId
    )
    {
        $form = $this->controller->getServiceLocator()->get($formName);
        
        $form->prepare();
        
        $controller = $this->getController();
        
        $request = $controller->getRequest();
        
        $sl = $this->controller->getServiceLocator();
        $tableModel = $sl->get($modelName . 'Model');
        
        $tableModel->init($modelId);

        if ($request->isPost()) {
            $formData = $request->getPost()->toArray();
        
            $form->setData($formData);
                    
            if ($form->isValid()) {
                $prefix = $form->getFieldPrefix();
                                
                $modelData = [];
                
                foreach ($formData as $key => $value) {
                    if ($key != 'form-submit') {
                        $modelField = preg_replace('/^' . $prefix . '/', '', $key);
                        $modelData[$modelField] = $value;
                    }
                }

                foreach ($form->getAutoDateOnCreateArray() as $autoDateOnCreate) {
                    $modelData[$autoDateOnCreate] = date('Y-m-d H:i:s', time());    
                }

                $currentData = $tableModel->getData();
                
                $data = array_merge(
                    $currentData,
                    $modelData
                );
                
                $isValid = true;
                if (isset($data['password']) && isset($data['confirmpassword'])) {
                    
                    if ($data['password'] == $data['confirmpassword']) {
                        $userService =
                            $this->controller->getServiceLocator()->get('Netsensia\Service\UserService');
                        
                        $data['password'] = $userService->encryptPassword($data['password']);
                    } else {
                        unset($data['password']);
                    }
                    
                    unset($data['confirmpassword']);
                }
                                
                if ($isValid) {
                    $tableModel->setData($data);
                    
                    if (empty($modelId)) {
                        $tableModel->create();
                    } else {
                        $tableModel->save();
                    }
                    
                    $this->controller->flashMessenger()->addSuccessMessage(
                        'Your details have been saved'
                    );
                    
                    $router = $sl->get('router');
                    $request = $sl->get('request');
                    
                    $routeMatch = $router->match($request);
                    
                    $this->controller->redirect()->toRoute(
                        $routeMatch->getMatchedRouteName(),
                        $routeMatch->getParams()
                    );
                }
            }
        
        } else {
            $form->setDataFromModel($tableModel);
        }
      
        return $form;
        
    }
}
