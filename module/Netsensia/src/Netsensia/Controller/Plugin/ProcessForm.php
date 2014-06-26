<?php

namespace Netsensia\Controller\Plugin;

use Zend\Mvc\Controller\Plugin\AbstractPlugin;
use Zend\Form\Element\Checkbox;
use Netsensia\Controller\Plugin\Widget\MultiTable;

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
                    if (preg_match('/^netsensiaWidget_(.*?)_/', $key, $matches) !== 0) {
                        $this->widget($matches[1], $value);
                    } elseif ($key != 'form-submit' && $key != 'widgetignore') {
                        $modelField = preg_replace('/^' . $prefix . '/', '', $key);
                        $modelData[$modelField] = $value;
                    }
                }

                foreach ($form->getAutoDateOnCreateArray() as $autoDateOnCreate) {
                    $modelData[$autoDateOnCreate] = date('Y-m-d H:i:s', time());    
                }
                
                foreach ($form->getElements() as $element) {
                    if ($element instanceof Checkbox) {
                        $name = $element->getName();
                        $modelField = preg_replace('/^' . $prefix . '/', '', $name);
                        $modelData[$modelField] = ($element->getValue() == 1 ? 'Y' : 'N');
                    }
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
    
    private function widget($widgetType, $value)
    {
        if ($widgetType == 'multiTable') {
            $widget = new MultiTable(
                $this->controller->getServiceLocator(),
                $value
            );
            $widget->process();
            return;
        }
    }
}
