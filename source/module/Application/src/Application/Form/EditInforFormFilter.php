<?php
namespace Application\Form;

use Zend\InputFilter\InputFilter;

class EditInforFormFilter extends InputFilter
{

    public function __construct()
    {
        /*$this->add(array(
            'name' => 'attribute_code',
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
                    'options' => array(
                        'message' => array(
                            'isEmpty' => 'Vui lòng nhập mã thuộc tính'
                        )
                    )
                )
            )
        ));*/
    }
}
