<?php
namespace Application\Navigation;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class MyNavigationFactory implements FactoryInterface
{

    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $navigation = new MyNavigation($serviceLocator);
        return $navigation->createService($serviceLocator);
    }
}