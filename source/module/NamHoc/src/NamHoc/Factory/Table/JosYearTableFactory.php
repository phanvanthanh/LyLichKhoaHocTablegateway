<?php
namespace NamHoc\Factory\Table;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\TableGateway;
use NamHoc\Model\Entity\JosYear;
use NamHoc\Model\JosYearTable;

class JosYearTableFactory implements FactoryInterface
{

    public function createService(ServiceLocatorInterface $servicelocator)
    {
        $adapter = $servicelocator->get('Zend\Db\Adapter\Adapter');
        $resultSetPrototype = new ResultSet();
        $resultSetPrototype->setArrayObjectPrototype(new JosYear());
        $tableGateway = new TableGateway('jos_year', $adapter, null, $resultSetPrototype);
        return new JosYearTable($tableGateway);
    }
}