<?php
namespace Permission;

use Zend\EventManager\EventInterface;

class Module
{

    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }

    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__
                )
            )
        );
    }

    public function getServiceConfig()
    {
        return array(
            'factories' => array(
                'AuthService' => 'Permission\Factory\MyAuthStorageFactory',
                // Table
                'Permission\Model\JosAdminResourceTable' => 'Permission\Factory\Table\JosAdminResourceTableFactory',
                'Permission\Model\JosAdminRoleTable' => 'Permission\Factory\Table\JosAdminRoleTableFactory',
                'Permission\Model\JosAdminRuleTable' => 'Permission\Factory\Table\JosAdminRuleTableFactory',
                'Permission\Model\JosUsersTable' => 'Permission\Factory\Table\JosUsersTableFactory',
                'Permission\Model\JosUserLasttimeLoginTable' => 'Permission\Factory\Table\JosUserLasttimeLoginTableFactory',
                // Form
                'Permission\Form\LoginForm' => 'Permission\Factory\Form\LoginFormFactory',

            )
            
        );
    }
}
?>