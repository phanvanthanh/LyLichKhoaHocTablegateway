<?php
namespace Permission\Factory\Table;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\TableGateway;
use Permission\Model\Entity\JosAdminRole;
use Permission\Model\JosAdminRoleTable;

class JosAdminRoleTableFactory implements FactoryInterface
{

    public function createService(ServiceLocatorInterface $servicelocator)
    {
        $adapter = $servicelocator->get('Zend\Db\Adapter\Adapter');
        $resultSetPrototype = new ResultSet();
        $resultSetPrototype->setArrayObjectPrototype(new JosAdminRole());
        $tableGateway = new TableGateway('jos_admin_role', $adapter, null, $resultSetPrototype);
        return new JosAdminRoleTable($tableGateway);
    }
}