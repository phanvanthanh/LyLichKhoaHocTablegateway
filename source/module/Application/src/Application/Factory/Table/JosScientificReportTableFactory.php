<?php
namespace Application\Factory\Table;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\TableGateway;
use Application\Model\Entity\JosScientificReport;
use Application\Model\JosScientificReportTable;

class JosScientificReportTableFactory implements FactoryInterface
{

    public function createService(ServiceLocatorInterface $servicelocator)
    {
        $adapter = $servicelocator->get('Zend\Db\Adapter\Adapter');
        $resultSetPrototype = new ResultSet();
        $resultSetPrototype->setArrayObjectPrototype(new JosScientificReport());
        $tableGateway = new TableGateway('jos_scientific_report', $adapter, null, $resultSetPrototype);
        return new JosScientificReportTable($tableGateway);
    }
}