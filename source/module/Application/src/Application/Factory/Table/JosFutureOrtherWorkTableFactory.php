<?php
namespace Application\Factory\Table;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\TableGateway;
use Application\Model\Entity\JosFutureOrtherWork;
use Application\Model\JosFutureOrtherWorkTable;

class JosFutureOrtherWorkTableFactory implements FactoryInterface
{

    public function createService(ServiceLocatorInterface $servicelocator)
    {
        $adapter = $servicelocator->get('Zend\Db\Adapter\Adapter');
        $resultSetPrototype = new ResultSet();
        $resultSetPrototype->setArrayObjectPrototype(new JosFutureOrtherWork());
        $tableGateway = new TableGateway('jos_future_orther_work', $adapter, null, $resultSetPrototype);
        return new JosFutureOrtherWorkTable($tableGateway);
    }
}