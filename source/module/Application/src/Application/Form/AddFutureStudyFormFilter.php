<?php
namespace Application\Form;

use Zend\InputFilter\InputFilter;

class AddFutureStudyFormFilter extends InputFilter
{

    public function __construct()
    { 
        $this->add(array(
            'name' => 'subject_name',
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
                            'isEmpty' => 'Vui lòng nhập tên môn học',
                        )
                    )
                )
            )
        ));

        $this->add(array(
            'name' => 'address',
            'required' => false,
            'filters' => array(
                array(
                    'name' => 'StringTrim'
                ),
                array(
                    'name' => 'StripTags'
                )
            )
        ));  

        $this->add(array(
            'name' => 'time_from',
            'required' => false,
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
                            'isEmpty' => 'Vui lòng nhập thời gian bắt đầu',
                        )
                    )
                )
            )
        ));

        $this->add(array(
            'name' => 'time_to',
            'required' => false,
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
                            'isEmpty' => 'Vui lòng nhập thời gian kết thúc',
                        )
                    )
                )
            )
        ));
        

        $this->add(array(
            'name' => 'note',
            'required' => false,
            'filters' => array(
                array(
                    'name' => 'StringTrim'
                ),
                array(
                    'name' => 'StripTags'
                )
            )
        ));
    }
}
