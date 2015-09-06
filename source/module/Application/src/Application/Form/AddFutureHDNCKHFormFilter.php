<?php
namespace Application\Form;

use Zend\InputFilter\InputFilter;

class AddFutureHDNCKHFormFilter extends InputFilter
{

    public function __construct()
    { 
        $this->add(array(
            'name' => 'science_activity_name',
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
                            'isEmpty' => 'Vui lòng nhập tên hoạt động nghiên cứu khoa học',
                        )
                    )
                )
            )
        ));  

        $this->add(array(
            'name' => 'time_from',
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
                            'isEmpty' => 'Vui lòng nhập thời gian bắt đầu',
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
