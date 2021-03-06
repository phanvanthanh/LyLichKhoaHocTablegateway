<?php
namespace Application\Form;

use Zend\InputFilter\InputFilter;

class EditInforFormFilter extends InputFilter
{

    public function __construct($all_attributes)
    {
        foreach ($all_attributes as $key => $all_attribute) {
            $this->add(array(
                'name' => $all_attribute['attribute_code'],
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
                                'isEmpty' => 'Vui lòng nhập '.$all_attribute['frontend_label'],
                            )
                        )
                    )
                )
            ));
        }
    }
}
