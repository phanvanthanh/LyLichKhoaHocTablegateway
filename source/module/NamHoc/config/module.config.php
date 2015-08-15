<?php
return array(
    'controllers' => array(
        'invokables' => array(
            'NamHoc\Controller\NamHoc' => 'NamHoc\Controller\NamHocController',
        ),
    ),
    'view_manager' => array(
        'template_path_stack' => array(
            'NamHoc' => __DIR__ . '/../view',
        ),
    ),
);
