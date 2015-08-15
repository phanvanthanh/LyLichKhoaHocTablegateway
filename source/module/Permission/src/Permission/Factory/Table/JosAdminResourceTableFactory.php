<?php
namespace Permission\Factory\Table;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\TableGateway;
use Permission\Model\Entity\JosAdminResource;
use Permission\Model\JosAdminResourceTable;

class JosAdminResourceTableFactory implements FactoryInterface
{

    public function createService(ServiceLocatorInterface $servicelocator)
    {
        $adapter = $servicelocator->get('Zend\Db\Adapter\Adapter');
        $resultSetPrototype = new ResultSet();
        $resultSetPrototype->setArrayObjectPrototype(new JosAdminResource());
        $tableGateway = new TableGateway('jos_admin_resource', $adapter, null, $resultSetPrototype);
        return new JosAdminResourceTable($tableGateway);
    }
}