<?php
namespace Application\Factory\Table;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\TableGateway;
use Application\Model\Entity\JosFutureStudy;
use Application\Model\JosFutureStudyTable;

class JosFutureStudyTableFactory implements FactoryInterface
{

    public function createService(ServiceLocatorInterface $servicelocator)
    {
        $adapter = $servicelocator->get('Zend\Db\Adapter\Adapter');
        $resultSetPrototype = new ResultSet();
        $resultSetPrototype->setArrayObjectPrototype(new JosFutureStudy());
        $tableGateway = new TableGateway('jos_future_study', $adapter, null, $resultSetPrototype);
        return new JosFutureStudyTable($tableGateway);
    }
}