<?php
namespace Attribute\Factory\Table;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\TableGateway;
use Attribute\Model\Entity\JosAttribute;
use Attribute\Model\JosAttributeTable;

class JosAttributeTableFactory implements FactoryInterface
{

    public function createService(ServiceLocatorInterface $servicelocator)
    {
        $adapter = $servicelocator->get('Zend\Db\Adapter\Adapter');
        $resultSetPrototype = new ResultSet();
        $resultSetPrototype->setArrayObjectPrototype(new JosAttribute());
        $tableGateway = new TableGateway('jos_attribute', $adapter, null, $resultSetPrototype);
        return new JosAttributeTable($tableGateway);
    }
}