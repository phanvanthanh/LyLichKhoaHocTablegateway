<?php
return array(
    'controllers' => array(
        'invokables' => array(
            'Attribute\Controller\Attribute' => 'Attribute\Controller\AttributeController',
        ),
    ),    
    'view_manager' => array(
        'template_path_stack' => array(
            'Attribute' => __DIR__ . '/../view',
        ),
    ),
);
