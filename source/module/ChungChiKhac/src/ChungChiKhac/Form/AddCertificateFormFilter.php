<?php
namespace ChungChiKhac\Form;

use Zend\InputFilter\InputFilter;

class AddCertificateFormFilter extends InputFilter
{

    public function __construct()
    {
        $this->add(array(
            'name' => 'name',
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
                            'isEmpty' => 'Vui lòng nhập tên chứng chỉ'
                        )
                    )
                )
            )
        ));
    }
}
