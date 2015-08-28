<?php
namespace ChungChiKhac\Factory\Table;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\TableGateway;
use ChungChiKhac\Model\Entity\JosCertificateUser;
use ChungChiKhac\Model\JosCertificateUserTable;

class JosCertificateUserTableFactory implements FactoryInterface
{

    public function createService(ServiceLocatorInterface $servicelocator)
    {
        $adapter = $servicelocator->get('Zend\Db\Adapter\Adapter');
        $resultSetPrototype = new ResultSet();
        $resultSetPrototype->setArrayObjectPrototype(new JosCertificateUser());
        $tableGateway = new TableGateway('jos_certificate_user', $adapter, null, $resultSetPrototype);
        return new JosCertificateUserTable($tableGateway);
    }
}