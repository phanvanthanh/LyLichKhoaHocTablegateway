<?php
namespace Attribute\Form;

use Zend\InputFilter\InputFilter;

class EditAttributeOptionFormFilter extends InputFilter
{

    public function __construct()
    {
        $this->add(array(
            'name' => 'attribute_id',
            'required' => true,
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
