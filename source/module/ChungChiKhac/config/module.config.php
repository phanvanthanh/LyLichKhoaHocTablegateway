<?php
return array(
    'controllers' => array(
        'invokables' => array(
            'ChungChiKhac\Controller\ChungChiKhac' => 'ChungChiKhac\Controller\ChungChiKhacController',
        ),
    ),
    'view_manager' => array(
        'template_path_stack' => array(
            'ChungChiKhac' => __DIR__ . '/../view',
        ),
    ),
);
