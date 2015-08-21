<?php
namespace CongTacNghienCuu\Factory\Table;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\TableGateway;
use CongTacNghienCuu\Model\Entity\JosScienceActivity;
use CongTacNghienCuu\Model\JosScienceActivityTable;

class JosScienceActivityTableFactory implements FactoryInterface
{

    public function createService(ServiceLocatorInterface $servicelocator)
    {
        $adapter = $servicelocator->get('Zend\Db\Adapter\Adapter');
        $resultSetPrototype = new ResultSet();
        $resultSetPrototype->setArrayObjectPrototype(new JosScienceActivity());
        $tableGateway = new TableGateway('jos_science_activity', $adapter, null, $resultSetPrototype);
        return new JosScienceActivityTable($tableGateway);
    }
}