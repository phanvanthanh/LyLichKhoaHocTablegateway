<?php
namespace Permission\Factory\Table;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\TableGateway;
use Permission\Model\Entity\JosUserLasttimeLogin;
use Permission\Model\JosUserLasttimeLoginTable;

class JosUserLasttimeLoginTableFactory implements FactoryInterface
{

    public function createService(ServiceLocatorInterface $servicelocator)
    {
        $adapter = $servicelocator->get('Zend\Db\Adapter\Adapter');
        $resultSetPrototype = new ResultSet();
        $resultSetPrototype->setArrayObjectPrototype(new JosUserLasttimeLogin());
        $tableGateway = new TableGateway('jos_user_lasttime_login', $adapter, null, $resultSetPrototype);
        return new JosUserLasttimeLoginTable($tableGateway);
    }
}