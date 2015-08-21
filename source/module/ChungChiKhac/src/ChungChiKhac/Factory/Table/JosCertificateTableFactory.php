<?php
namespace ChungChiKhac\Factory\Table;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\TableGateway;
use ChungChiKhac\Model\Entity\JosCertificate;
use ChungChiKhac\Model\JosCertificateTable;

class JosCertificateTableFactory implements FactoryInterface
{

    public function createService(ServiceLocatorInterface $servicelocator)
    {
        $adapter = $servicelocator->get('Zend\Db\Adapter\Adapter');
        $resultSetPrototype = new ResultSet();
        $resultSetPrototype->setArrayObjectPrototype(new JosCertificate());
        $tableGateway = new TableGateway('jos_certificate', $adapter, null, $resultSetPrototype);
        return new JosCertificateTable($tableGateway);
    }
}