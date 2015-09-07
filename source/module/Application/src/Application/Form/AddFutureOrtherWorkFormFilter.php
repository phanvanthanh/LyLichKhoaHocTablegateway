<?php
namespace Application\Form;

use Zend\InputFilter\InputFilter;

class AddFutureOrtherWorkFormFilter extends InputFilter
{

    public function __construct()
    { 
        $this->add(array(
            'name' => 'content',
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
                            'isEmpty' => 'Vui lòng nhập nội dung công tác',
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
            'name' => 'time_to',
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
