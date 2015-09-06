<?php
namespace Application\Factory\Table;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\TableGateway;
use Application\Model\Entity\JosFutureScienceResearchOfUser;
use Application\Model\JosFutureScienceResearchOfUserTable;

class JosFutureScienceResearchOfUserTableFactory implements FactoryInterface
{

    public function createService(ServiceLocatorInterface $servicelocator)
    {
        $adapter = $servicelocator->get('Zend\Db\Adapter\Adapter');
        $resultSetPrototype = new ResultSet();
        $resultSetPrototype->setArrayObjectPrototype(new JosFutureScienceResearchOfUser());
        $tableGateway = new TableGateway('jos_future_science_research_of_user', $adapter, null, $resultSetPrototype);
        return new JosFutureScienceResearchOfUserTable($tableGateway);
    }
}