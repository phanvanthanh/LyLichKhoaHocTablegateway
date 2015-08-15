<?php
namespace Permission\Form;

use Zend\InputFilter\InputFilter;

class EditPermissionFormFilter extends InputFilter
{

    public function __construct($resources)
    {
        $this->add(array(
            'name' => 'id_giang_vien',
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
                            'isEmpty' => 'Vui lòng chọn giảng viên'
                        )
                    )
                )
            )
        ));
        foreach ($resources as $resource) {
            $this->add(array(
                'name' => $resource['resource'],
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
}
