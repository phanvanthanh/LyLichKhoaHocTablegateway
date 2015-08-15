<?php
namespace Permission\Form;

use Zend\InputFilter\InputFilter;

class EditResourceFormFilter extends InputFilter
{

    public function __construct()
    {
        $this->add(array(
            'name' => 'resource_name',
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
                            'isEmpty' => 'Resource name không được trống'
                        )
                    )
                )
            )
        ));

        $this->add(array(
            'name' => 'resource_id',
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
                            'isEmpty' => 'Resource id không được trống'
                        )
                    )
                )
            )
        ));
        
    }
}
