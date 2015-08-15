<?php
namespace ACL\Utility;

use Zend\Permissions\Acl\Acl as ZendAcl;
use Zend\Permissions\Acl\Role\GenericRole as Role;
use Zend\Permissions\Acl\Resource\GenericResource as Resource;
use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class Acl extends ZendAcl implements ServiceLocatorAwareInterface
{

    const DEFAULT_ROLE = 'guest';

    protected $serviceLocator;

    public function setServiceLocator(ServiceLocatorInterface $serviceLocator)
    {
        $this->serviceLocator = $serviceLocator;
        return $this;
    }

    public function getServiceLocator()
    {
        return $this->serviceLocator;
    }

    public function initAcl($session_acl)
    {
        $this->_addRoles($session_acl[0]['role_id'])
            ->_addController($session_acl)
            ->_addRule($session_acl);
    }

    public function isAccessAllowed($role, $controller, $action)
    {
        if (! $this->hasResource($controller)) {
            return false;
        }
        if ($this->isAllowed($role, $controller, $action)) {
            return true;
        }
        return false;
    }

    protected function _addRoles($role_id)
    {
        $this->addRole(new Role(self::DEFAULT_ROLE));
        $this->addRole(new Role($role_id), self::DEFAULT_ROLE);
        return $this;
    }

    protected function _addController($controller_array)
    {
        if (count($controller_array) > 0) {
            foreach ($controller_array as $ctr) {
                if (! $this->hasResource($ctr['controller'])) {
                    $this->addResource(new Resource($ctr['controller']));
                }
            }
        }
        return $this;
    }

    protected function _addRule($rule)
    {
        if (count($rule) > 0) {
            foreach ($rule as $rul) {
                $this->allow($rul['role_id'], $rul['controller'], $rul['action']);
            }
        }
        
        return $this;
    }
}
