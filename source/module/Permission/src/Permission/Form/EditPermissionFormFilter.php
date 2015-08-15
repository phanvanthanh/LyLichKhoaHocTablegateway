<?php
namespace Permission\Form;

use Zend\InputFilter\InputFilter;

class EditPermissionFormFilter extends InputFilter
{

    public function __construct()
    {
        $this->add(array(
            'name' => 'username',
            'required' => true,
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
                    'break_chain_on_failure' => true,
                    'options' => array(
                        'message' => array(
                            'isEmpty' => 'Hãy nhập giá trị vào ô "TÊN ĐĂNG NHẬP"!'
                        )
                    )
                )
            )
        ));
        $this->add(array(
            'name' => 'password',
            'required' => false,
            'filters' => array(
                array(
                    'name' => 'StringTrim'
                ),
                array(
                    'name' => 'StripTags'
                )
            ),            
        ));
        $this->add(array(
            'name' => 'firstname',
            'required' => true,
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
                    'break_chain_on_failure' => true,
                    'options' => array(
                        'message' => array(
                            'isEmpty' => 'Hãy nhập giá trị vào ô "TÊN"!'
                        )
                    )
                )
            )
        ));
        
        $this->add(array(
            'name' => 'lastname',
            'required' => true,
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
                    'break_chain_on_failure' => true,
                    'options' => array(
                        'message' => array(
                            'isEmpty' => 'Hãy nhập giá trị vào ô "HỌ"!'
                        )
                    )
                )
            )
        ));
        
        $email = $this->factory->createInput(array(
            'name' => 'email',
            'required' => true,
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
                    'name' => 'Regex',
                    'options' => array(
                        'pattern' => '/^[a-zA-Z0-9.!#$%&\'*+\/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/',
                        'messages' => array(
                            "regexNotMatch" => 'Email không hợp lệ!'
                        )
                    )
                )
            )
        ));
        $email->setAllowEmpty(TRUE);
        
        $this->add($email);
    }
}
