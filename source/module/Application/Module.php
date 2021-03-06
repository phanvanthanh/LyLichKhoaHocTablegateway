<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2014 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Application;

use Zend\Mvc\ModuleRouteListener;
use Zend\Mvc\MvcEvent;

class Module
{
    public function onBootstrap(MvcEvent $e)
    {
        $eventManager        = $e->getApplication()->getEventManager();
        $moduleRouteListener = new ModuleRouteListener();
        $moduleRouteListener->attach($eventManager);
    }

    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }

    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ),
            ),
        );
    }

    public function getServiceConfig()
    {
        return array(
            'factories' => array(
                'Navigation' => 'Application\Navigation\MyNavigationFactory',
                'Application\Model\JosInfomationTable' => 'Application\Factory\Table\JosInfomationTableFactory',
                'Application\Model\JosTeachingTable' => 'Application\Factory\Table\JosTeachingTableFactory',
                'Application\Model\JosFutureTeachingTable' => 'Application\Factory\Table\JosFutureTeachingTableFactory',
                'Application\Model\JosScienceResearchOfUserTable' => 'Application\Factory\Table\JosScienceResearchOfUserTableFactory',
                'Application\Model\JosFutureScienceResearchOfUserTable' => 'Application\Factory\Table\JosFutureScienceResearchOfUserTableFactory',
                'Application\Model\JosOrtherWorkTable' => 'Application\Factory\Table\JosOrtherWorkTableFactory',
                'Application\Model\JosFutureOrtherWorkTable' => 'Application\Factory\Table\JosFutureOrtherWorkTableFactory',
                'Application\Model\JosFutureStudyTable' => 'Application\Factory\Table\JosFutureStudyTableFactory',
                'Application\Model\JosScientificReportTable' => 'Application\Factory\Table\JosScientificReportTableFactory',
            
            )
        );
    }
}
