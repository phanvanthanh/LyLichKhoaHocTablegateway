<?php
namespace Attribute\Form;

use Zend\InputFilter\InputFilter;

class AddAttributeFormFilter extends InputFilter
{

    public function __construct()
    {
        $this->add(array(
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
        ));

        $this->add(array(
            'name' => 'frontend_input',
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
                            'isEmpty' => 'Vui lòng chọn loại thuộc tính'
                        )
                    )
                )
            )
        ));

        $this->add(array(
            'name' => 'frontend_label',
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
                            'isEmpty' => 'Vui lòng nhập tên thuộc tính'
                        )
                    )
                )
            )
        ));
    }
}
