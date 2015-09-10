<?php
namespace Application\Navigation;

use Zend\Navigation\Service\DefaultNavigationFactory;
use Zend\ServiceManager\ServiceLocatorInterface;

class MyNavigation extends DefaultNavigationFactory
{

    private $serviceLocator;

    public function __construct(ServiceLocatorInterface $serviceLocator)
    {
        $this->serviceLocator = $serviceLocator;
    }

    protected function getPages(ServiceLocatorInterface $serviceLocator)
    {
        if (null === $this->pages) {
            $configuration = $this->serviceLocator->get('config')['navigation'];
            //die(var_dump($configuration));
            if (!isset($configuration)) {
                throw new \Exception('Could not find navigation configuration key');
            }
            if (! isset($configuration[$this->getName()])) {
                throw new \Exception(sprintf('Failed to find a navigation container by the name %s', $this->getName()));
            }
            $application = $serviceLocator->get('Application');
            $routeMatch = $application->getMvcEvent()->getRouteMatch();
            $router = $application->getMvcEvent()->getRouter();
            $pages = $this->getPagesFromConfig($configuration[$this->getName()]);
            $this->pages = $this->injectComponents($pages, $routeMatch, $router);
        }
        
        //$this->pages=$this->removeRoute($serviceLocator, $this->pages);
        return $this->pages;
    }

    /*
    protected function removeRoute(ServiceLocatorInterface $serviceLocator, $pages){
        
        $read=$serviceLocator->get("AuthService")->getStorage()->read();
        if(isset($read['username'])){
            if(!isset($read['right_route'])){
                // lấy tất cả các quyền
                $resource_table=$serviceLocator->get('Permission\Model\JosAdminResourceTable');
                $resources=$resource_table->getModuleNameByUsername($read['username']);
                foreach ($pages as $key => $page) {
                    if(!isset($resources[$page['module']])){
                        unset($pages[$key]);
                    }                    
                }
                $serviceLocator->get("AuthService")->getStorage()->write(array('right_route' => $pages));
            }
            else{
                $pages=$read['right_route'];
            }
        }
        else{
            $pages=array();
        }
        return $pages;
    }
    */
    
}