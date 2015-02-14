<?php

namespace Netsensia\Controller\Plugin;

use Zend\Mvc\Controller\Plugin\AbstractPlugin;
use Zend\Form\Element\Checkbox;
use Zend\Di\ServiceLocator;

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
                        // is a widget, ignore until we get the ID of the parent model
                    } elseif ($key != 'form-submit' && $key != 'widgetignore' && $key != '_wysihtml5_mode') {
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

                    foreach ($formData as $key => $value) {
                        if (preg_match('/^netsensiaWidget_(.*?)_/', $key, $matches) !== 0) {
                            $this->widget($matches[1], $value, $tableModel);
                        }
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
            } else {
                var_dump($form->getMessages()); die;
            }
        
        } else {
            $form->setDataFromModel(
                $tableModel,
                $this->controller->getServiceLocator()
            );
        }
      
        return $form;
        
    }
    
    private function widget($widgetType, $value, $tableModel)
    {
        $widgetClass = '\\Netsensia\\Controller\\Plugin\\Widget\\' . ucfirst($widgetType);
    
        $serviceLocator = $this->controller->getServiceLocator();
        
        if (class_exists($widgetClass)) {

            $widget = new $widgetClass(
                $serviceLocator,
                $value,
                $tableModel
            );
            $widget->process();
        }
        
        $config = $serviceLocator->get('config');

        if (array_key_exists('netsensia_form_widget_extension_namespace', $config)) {
            $extensionNamespace = $config['netsensia_form_widget_extension_namespace'];
            $extensionClass = $extensionNamespace . '\\' . ucfirst($widgetType);
            if (class_exists($extensionClass)) {
                $widget = new $extensionClass(
                    $serviceLocator,
                    $value,
                    $tableModel
                );
                $widget->process();
            }
        }
    }
}
