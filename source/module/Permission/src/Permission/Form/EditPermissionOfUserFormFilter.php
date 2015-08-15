<?php
namespace Permission\Form;

use Zend\InputFilter\InputFilter;

class EditPermissionOfUserFormFilter extends InputFilter
{

    public function __construct($resources)
    {        
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
