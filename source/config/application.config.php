<?php
return array(
    'modules' => array(
        'Route',
        //'ACL',
        'Permission',        
        'Application',
        'CongTacNghienCuu',
        'NgoaiNgu',
        'MonHoc',
        'NamHoc',
    ),
    'module_listener_options' => array(        
        'module_paths' => array(
            './module',
            './vendor',            
        ),
        'config_glob_paths' => array(
            'config/autoload/{,*.}{global,local}.php',
        ),
    ),
);
