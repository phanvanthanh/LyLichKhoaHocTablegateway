<?php
namespace Application\Factory\Table;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\TableGateway;
use Application\Model\Entity\JosFutureTeaching;
use Application\Model\JosFutureTeachingTable;

class JosFutureTeachingTableFactory implements FactoryInterface
{

    public function createService(ServiceLocatorInterface $servicelocator)
    {
        $adapter = $servicelocator->get('Zend\Db\Adapter\Adapter');
        $resultSetPrototype = new ResultSet();
        $resultSetPrototype->setArrayObjectPrototype(new JosFutureTeaching());
        $tableGateway = new TableGateway('jos_future_teaching', $adapter, null, $resultSetPrototype);
        return new JosFutureTeachingTable($tableGateway);
    }
}