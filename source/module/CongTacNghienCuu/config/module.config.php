<?php
return array(
    'controllers' => array(
        'invokables' => array(
            'CongTacNghienCuu\Controller\CongTacNghienCuu' => 'CongTacNghienCuu\Controller\CongTacNghienCuuController',
        ),
    ),
    'view_manager' => array(
        'template_path_stack' => array(
            'CongTacNghienCuu' => __DIR__ . '/../view',
        ),
    ),
);
