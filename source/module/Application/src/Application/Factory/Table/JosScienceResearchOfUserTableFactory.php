<?php
namespace Application\Factory\Table;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\TableGateway;
use Application\Model\Entity\JosScienceResearchOfUser;
use Application\Model\JosScienceResearchOfUserTable;

class JosScienceResearchOfUserTableFactory implements FactoryInterface
{

    public function createService(ServiceLocatorInterface $servicelocator)
    {
        $adapter = $servicelocator->get('Zend\Db\Adapter\Adapter');
        $resultSetPrototype = new ResultSet();
        $resultSetPrototype->setArrayObjectPrototype(new JosScienceResearchOfUser());
        $tableGateway = new TableGateway('jos_science_research_of_user', $adapter, null, $resultSetPrototype);
        return new JosScienceResearchOfUserTable($tableGateway);
    }
}