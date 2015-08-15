<?php
return array(
    'controllers' => array(
        'invokables' => array(
            'NgoaiNgu\Controller\NgoaiNgu' => 'NgoaiNgu\Controller\NgoaiNguController',
        ),
    ),
    'view_manager' => array(
        'template_path_stack' => array(
            'NgoaiNgu' => __DIR__ . '/../view',
        ),
    ),
);
