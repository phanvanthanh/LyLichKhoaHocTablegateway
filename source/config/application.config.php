<?php
return array(
    'modules' => array(
        'Route',
        'ACL',
        'Permission',        
        'Application',
        'CongTacNghienCuu',
        'ChungChiKhac',
        'MonHoc',
        'NamHoc','Attribute',
    ),
    'module_listener_options' => array(        
        'module_paths' => array(
            './module',
            './vendor','./module',            
        ),
        'config_glob_paths' => array(
            'config/autoload/{,*.}{global,local}.php',
        ),
    ),
);
