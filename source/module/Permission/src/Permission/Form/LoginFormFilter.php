<?php
namespace Permission\Form;

use Zend\InputFilter\InputFilter;

class LoginFormFilter extends InputFilter
{

    public function __construct()
    {
        $this->add(array(
            'name' => 'username',
            'filters' => array(
                array(
                    'name' => 'StringTrim'
                ),
                array(
                    'name' => 'StripTags'
                )
            ),
            'validators' => array(                
                array(
                    'name' => 'NotEmpty',
                    'options' => array(
                        'message' => array(
                            'isEmpty' => 'Tên đăng nhập không được rỗng'
                        )
                    )
                )
            )
        ));
        
        $this->add(array(
            'name' => 'password',
            'filters' => array(
                array(
                    'name' => 'StringTrim'
                ),
                array(
                    'name' => 'StripTags'
                )
            ),
            'validators' => array(
                array(
                    'name' => 'NotEmpty',
                    'options' => array(
                        'message' => array(
                            'isEmpty' => 'Mật khẩu không được rỗng'
                        )
                    )
                )
            )
        ));
    }
}
