<?php
namespace Permission\Form;

use Zend\Form\Form;

class EditPermissionForm extends Form
{

    public function __construct($giang_viens, $resources, $serviceLocator)
    {
        parent::__construct("edit_permission_form");
        $this->setAttribute('method', 'post');
        
        foreach ($resources as $resource) {
            $this->add(array(
                'name' => $resource['resource'],
                'type' => 'Zend\Form\Element\Checkbox',
                'options' => array(
                    //'label'   => $resource['resource_name']
                    'value'     => $resource['resource_id']
                ),
                'attributes' => array(
                    'title' => $resource['resource_name'],
                    'class' => 'checkbox'
                )
            ));
        }
        
    }
}