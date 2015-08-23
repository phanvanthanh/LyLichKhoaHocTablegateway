<?php
namespace Attribute\Factory\Table;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\TableGateway;
use Attribute\Model\Entity\JosAttributeOption;
use Attribute\Model\JosAttributeOptionTable;

class JosAttributeOptionTableFactory implements FactoryInterface
{

    public function createService(ServiceLocatorInterface $servicelocator)
    {
        $adapter = $servicelocator->get('Zend\Db\Adapter\Adapter');
        $resultSetPrototype = new ResultSet();
        $resultSetPrototype->setArrayObjectPrototype(new JosAttributeOption());
        $tableGateway = new TableGateway('jos_attribute_option', $adapter, null, $resultSetPrototype);
        return new JosAttributeOptionTable($tableGateway);
    }
}