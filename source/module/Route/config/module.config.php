<?php
return array(
    'controllers' => array(
        'invokables' => array(
            'Route\Controller\Route' => 'Route\Controller\RouteController',
        ),
    ),
    
    'view_manager' => array(
        'template_path_stack' => array(
            'Route' => __DIR__ . '/../view',
        ),
    ),
    'router' => array(
        'routes' => array(
            'home' => array(
                'type' => 'Zend\Mvc\Router\Http\Literal',
                'options' => array(
                    'route'    => '/',
                    'defaults' => array(
                        'controller' => 'Application\Controller\Index',
                        'action'     => 'index',
                    ),
                ),
            ),
            'application' => array(
                'type'    => 'Literal',
                'options' => array(
                    'route'    => '/application',
                    'defaults' => array(
                        '__NAMESPACE__' => 'Application\Controller',
                        'controller'    => 'Index',
                        'action'        => 'index',
                    ),
                ),
                'may_terminate' => true,
                'child_routes' => array(
                    'crud' => array(
                        'type' => 'Segment',
                        'options' => array(
                            'route' => '/crud[/:action][/:id]',
                            'constraints' => array(
                                'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'id' => '[0-9]+'
                            ),
                            'defaults' => array(
                                'controller' => 'Application\Controller\Index',
                                'action' => 'index',
                            )
                        )
                    ),
                ),
            ),

            'mon_hoc' => array(
                'type'    => 'Literal',
                'options' => array(
                    'route'    => '/mon-hoc',
                    'defaults' => array(
                        '__NAMESPACE__' => 'MonHoc\Controller',
                        'controller'    => 'MonHoc',
                        'action'        => 'index',
                    ),
                ),
                'may_terminate' => true,
                'child_routes' => array(
                    'crud' => array(
                        'type' => 'Segment',
                        'options' => array(
                            'route' => '/crud[/:action][/:id]',
                            'constraints' => array(
                                'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'id' => '[0-9]+'
                            ),
                            'defaults' => array(
                                'controller' => 'MonHoc\Controller\MonHoc',
                                'action' => 'index'
                            )
                        )
                    ),
                ),
            ),

            'cong_tac_nghien_cuu' => array(
                'type'    => 'Literal',
                'options' => array(
                    'route'    => '/cong-tac-nghien-cuu',
                    'defaults' => array(
                        '__NAMESPACE__' => 'CongTacNghienCuu\Controller',
                        'controller'    => 'CongTacNghienCuu',
                        'action'        => 'index',
                    ),
                ),
                'may_terminate' => true,
                'child_routes' => array(
                    'crud' => array(
                        'type' => 'Segment',
                        'options' => array(
                            'route' => '/crud[/:action][/:id]',
                            'constraints' => array(
                                'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'id' => '[0-9]+'
                            ),
                            'defaults' => array(
                                'controller' => 'CongTacNghienCuu\Controller\CongTacNghienCuu',
                                'action' => 'index'
                            )
                        )
                    ),
                ),
            ),

            'ngoai_ngu' => array(
                'type'    => 'Literal',
                'options' => array(
                    'route'    => '/ngoai-ngu',
                    'defaults' => array(
                        '__NAMESPACE__' => 'NgoaiNgu\Controller',
                        'controller'    => 'NgoaiNgu',
                        'action'        => 'index',
                    ),
                ),
                'may_terminate' => true,
                'child_routes' => array(
                    'crud' => array(
                        'type' => 'Segment',
                        'options' => array(
                            'route' => '/crud[/:action][/:id]',
                            'constraints' => array(
                                'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'id' => '[0-9]+'
                            ),
                            'defaults' => array(
                                'controller' => 'NgoaiNgu\Controller\NgoaiNgu',
                                'action' => 'index'
                            )
                        )
                    ),
                ),
            ),
            

            'nam_hoc' => array(
                'type'    => 'Literal',
                'options' => array(
                    'route'    => '/name-hoc',
                    'defaults' => array(
                        '__NAMESPACE__' => 'NamHoc\Controller',
                        'controller'    => 'NamHoc',
                        'action'        => 'index',
                    ),
                ),
                'may_terminate' => true,
                'child_routes' => array(
                    'crud' => array(
                        'type' => 'Segment',
                        'options' => array(
                            'route' => '/crud[/:action][/:id]',
                            'constraints' => array(
                                'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'id' => '[0-9]+'
                            ),
                            'defaults' => array(
                                'controller' => 'NamHoc\Controller\NamHoc',
                                'action' => 'index'
                            )
                        )
                    ),
                ),
            ),
            
            'permission' => array(
                'type'    => 'Literal',
                'options' => array(
                    'route'    => '/permission',
                    'defaults' => array(
                        '__NAMESPACE__' => 'Permission\Controller',
                        'controller'    => 'User',
                        'action'        => 'login',
                    ),
                ),
                'may_terminate' => true,
                'child_routes' => array(
                    'permission' => array(
                        'type' => 'Segment',
                        'options' => array(
                            'route' => '/permission[/:action][/:id]',
                            'constraints' => array(
                                'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'id' => '[0-9]+'
                            ),
                            'defaults' => array(
                                'controller' => 'Permission\Controller\Permission',
                                'action' => 'index'
                            )
                        )
                    ),
                    'user' => array(
                        'type' => 'Segment',
                        'options' => array(
                            'route' => '/user[/:action][/:id]',
                            'constraints' => array(
                                'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'id' => '[0-9]+'
                            ),
                            'defaults' => array(
                                'controller' => 'Permission\Controller\User',
                                'action' => 'login'
                            )
                        )
                    ),
                ),
            ),
        ),
    ),
);
