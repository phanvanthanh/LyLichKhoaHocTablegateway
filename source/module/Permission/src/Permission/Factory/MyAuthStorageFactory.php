<?php
namespace Permission\Factory;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\Authentication\Adapter\DbTable;
use Zend\Authentication\AuthenticationService;
use Permission\Model\MyAuthStorage;

class MyAuthStorageFactory implements FactoryInterface
{

    public function createService(ServiceLocatorInterface $servicelocator)
    {
        $dbAdapter = $servicelocator->get('Zend\Db\Adapter\Adapter');
        $dbTableAuthAdapter = new DbTable($dbAdapter, 'jos_users', 'username', 'password', '');
        //$dbTableAuthAdapter = new DbTable($dbAdapter, 'jos_users', 'username', 'password', 'MD5(?)');
        $authService = new AuthenticationService();
        $authService->setAdapter($dbTableAuthAdapter);
        $authService->setStorage(new MyAuthStorage());
        return $authService;
    }
}