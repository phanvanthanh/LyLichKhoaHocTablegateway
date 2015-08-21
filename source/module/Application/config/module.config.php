<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2014 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

return array(    
    'service_manager' => array(
        'abstract_factories' => array(
            'Zend\Cache\Service\StorageCacheAbstractServiceFactory',
            'Zend\Log\LoggerAbstractServiceFactory',
        ),
        'aliases' => array(
            'translator' => 'MvcTranslator',
        ),
    ),
    'translator' => array(
        'locale' => 'en_US',
        'translation_file_patterns' => array(
            array(
                'type'     => 'gettext',
                'base_dir' => __DIR__ . '/../language',
                'pattern'  => '%s.mo',
            ),
        ),
    ),
    'controllers' => array(
        'invokables' => array(
            'Application\Controller\Index' => 'Application\Controller\IndexController'
        ),
    ),
    'view_manager' => array(
        'display_not_found_reason' => true,
        'display_exceptions'       => true,
        'doctype'                  => 'HTML5',
        'not_found_template'       => 'error/404',
        'exception_template'       => 'error/index',
        'template_map' => array(
            'layout/layout'           => __DIR__ . '/../view/layout/layout.phtml',
            'layout/ajax_layout'           => __DIR__ . '/../view/layout/ajax-layout.phtml',
            'application/index/index' => __DIR__ . '/../view/application/index/index.phtml',
            'application/partial/menu' => __DIR__ . '/../view/application/partial/menu.phtml',
            'error/404'               => __DIR__ . '/../view/error/404.phtml',
            'error/index'             => __DIR__ . '/../view/error/index.phtml',


        ),
        'template_path_stack' => array(
            __DIR__ . '/../view',
        ),
    ),
    // Placeholder for console routes
    'console' => array(
        'router' => array(
            'routes' => array(
            ),
        ),
    ),

    'view_helpers' => array(
        'invokables' => array(
            'layout' => 'Application\View\Helper\Layout',
            'Zend\Authentication\AuthenticationService' => 'Zend\Authentication\AuthenticationService',
        ),
    ),

    'navigation' => array(
        'default' => array(
            array(
                'label' => 'Phân quyền', 
                'title' => 'Phân quyền', 
                'route' => 'permission/permission',
                'order' => 0
            ),              
            array(
                'label' => 'Nghiên cứu', 
                'title' => 'Nghiên cứu', 
                'route' => 'cong_tac_nghien_cuu/crud',
                'order' => 1
            ),
            array(
                'label' => 'Môn học', 
                'title' => 'Môn học', 
                'route' => 'mon_hoc/crud',
                'order' => 2
            ),  
            array(
                'label' => 'Chứng chỉ', 
                'title' => 'Chứng chỉ', 
                'route' => 'chung_chi_khac/crud',
                'order' => 3
            ), 
            array(
                'label' => 'Năm học', 
                'title' => 'Năm học', 
                'route' => 'nam_hoc/crud',
                'order' => 4
            ),  
            array(
                'label' => 'Thuộc tính', 
                'title' => 'Thuộc tính', 
                'route' => 'thuoc_tinh/crud',
                'order' => 5
            ),      
        ),
    ),
);
