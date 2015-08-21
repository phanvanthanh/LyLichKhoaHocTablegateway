<?php
namespace NamHoc\Form;

use Zend\InputFilter\InputFilter;

class AddYearFormFilter extends InputFilter
{

    public function __construct()
    {
        $this->add(array(
            'name' => 'year_id',
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
                            'isEmpty' => 'Vui lòng chọn năm học'
                        )
                    )
                )
            )
        ));
    }
}
