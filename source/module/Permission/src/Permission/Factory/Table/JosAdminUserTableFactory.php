<?php
namespace Permission\Factory\Table;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\TableGateway;
use Permission\Model\Entity\JosAdminUser;
use Permission\Model\JosAdminUserTable;

class JosAdminUserTableFactory implements FactoryInterface
{

    public function createService(ServiceLocatorInterface $servicelocator)
    {
        $adapter = $servicelocator->get('Zend\Db\Adapter\Adapter');
        $resultSetPrototype = new ResultSet();
        $resultSetPrototype->setArrayObjectPrototype(new JosAdminUser());
        $tableGateway = new TableGateway('jos_admin_user', $adapter, null, $resultSetPrototype);
        return new JosAdminUserTable($tableGateway);
    }
}