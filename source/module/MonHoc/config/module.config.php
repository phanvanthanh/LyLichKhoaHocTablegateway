<?php
return array(
    'controllers' => array(
        'invokables' => array(
            'MonHoc\Controller\MonHoc' => 'MonHoc\Controller\MonHocController',
        ),
    ),
    'view_manager' => array(
        'template_path_stack' => array(
            'MonHoc' => __DIR__ . '/../view',
        ),
    ),
);
