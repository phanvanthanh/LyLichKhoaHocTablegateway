<?php
namespace Application\Form;

use Zend\InputFilter\InputFilter;

class EditCertificateFormFilter extends InputFilter
{

    public function __construct()
    {        
        /*$this->add(array(
            'name' => 'certificate_id',
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
                            'isEmpty' => 'Vui lòng nhập id chứng chỉ',
                        )
                    )
                )
            )
        ));*/
    }
}
