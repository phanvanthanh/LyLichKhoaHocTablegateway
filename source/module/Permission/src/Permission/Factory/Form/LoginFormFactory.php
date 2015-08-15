<?php
namespace Permission\Factory\Form;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Permission\Form\LoginForm;
use Permission\Form\LoginFormFilter;

class LoginFormFactory implements FactoryInterface
{

    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $form = new LoginForm();
        
        $form->setInputFilter(new LoginFormFilter());
        
        return $form;
    }
}