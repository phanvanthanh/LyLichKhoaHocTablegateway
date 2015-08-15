<?php
namespace Permission\Factory\Table;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\TableGateway;
use Permission\Model\Entity\JosAdminRule;
use Permission\Model\JosAdminRuleTable;

class JosAdminRuleTableFactory implements FactoryInterface
{

    public function createService(ServiceLocatorInterface $servicelocator)
    {
        $adapter = $servicelocator->get('Zend\Db\Adapter\Adapter');
        $resultSetPrototype = new ResultSet();
        $resultSetPrototype->setArrayObjectPrototype(new JosAdminRule());
        $tableGateway = new TableGateway('jos_admin_rule', $adapter, null, $resultSetPrototype);
        return new JosAdminRuleTable($tableGateway);
    }
}