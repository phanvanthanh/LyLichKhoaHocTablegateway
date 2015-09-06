<?php
namespace Application\Factory\Table;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\TableGateway;
use Application\Model\Entity\JosOrtherWork;
use Application\Model\JosOrtherWorkTable;

class JosOrtherWorkTableFactory implements FactoryInterface
{

    public function createService(ServiceLocatorInterface $servicelocator)
    {
        $adapter = $servicelocator->get('Zend\Db\Adapter\Adapter');
        $resultSetPrototype = new ResultSet();
        $resultSetPrototype->setArrayObjectPrototype(new JosOrtherWork());
        $tableGateway = new TableGateway('jos_orther_work', $adapter, null, $resultSetPrototype);
        return new JosOrtherWorkTable($tableGateway);
    }
}