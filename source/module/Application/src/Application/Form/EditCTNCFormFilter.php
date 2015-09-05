<?php
namespace Application\Form;

use Zend\InputFilter\InputFilter;

class EditCTNCFormFilter extends InputFilter
{

    public function __construct()
    { 
        $this->add(array(
            'name' => 'id_hoat_dong',
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
                            'isEmpty' => 'Vui lòng nhập id công tác nghiên cứu khoa học',
                        )
                    )
                )
            )
        ));    

        $this->add(array(
            'name' => 'ten_hoat_dong',
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
                            'isEmpty' => 'Vui lòng nhập tên công tác nghiên cứu khoa học',
                        )
                    )
                )
            )
        )); 

        $this->add(array(
            'name' => 'trang_thai',
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
                            'isEmpty' => 'Vui lòng nhập thời gian hoàn thành',
                        )
                    )
                )
            )
        ));

        $this->add(array(
            'name' => 'ghi_chu',
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
