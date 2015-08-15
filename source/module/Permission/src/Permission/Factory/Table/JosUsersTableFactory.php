<?php
namespace Permission\Factory\Table;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\TableGateway;
use Permission\Model\Entity\JosUsers;
use Permission\Model\JosUsersTable;

class JosUsersTableFactory implements FactoryInterface
{

    public function createService(ServiceLocatorInterface $servicelocator)
    {
        $adapter = $servicelocator->get('Zend\Db\Adapter\Adapter');
        $resultSetPrototype = new ResultSet();
        $resultSetPrototype->setArrayObjectPrototype(new JosUsers());
        $tableGateway = new TableGateway('jos_users', $adapter, null, $resultSetPrototype);
        return new JosUsersTable($tableGateway);
    }
}