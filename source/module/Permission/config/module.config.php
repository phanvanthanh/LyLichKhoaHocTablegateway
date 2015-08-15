<?php
return array(
    'controllers' => array(
        'invokables' => array(
            'Permission\Controller\User' => 'Permission\Controller\UserController',
            'Permission\Controller\Permission' => 'Permission\Controller\PermissionController'
        ),
    ),
    
    'view_manager' => array(
        'template_path_stack' => array(
            __DIR__ . '/../view'
        )
    ),

    'controller_plugins' => array(
        'invokables' => array(
            'tree_plugin' => 'Permission\Controller\Plugin\TreePlugin', 
        ),
    ),
  
);