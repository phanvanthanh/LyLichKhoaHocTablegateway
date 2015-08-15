<?php
namespace Permission\Form;

use Zend\Form\Form;
use Permission\Form\EditPermissionOfUserFormFilter;

class EditPermissionOfUserForm extends Form
{

    public function __construct($resources, $serviceLocator)
    {
        parent::__construct("edit_permission_of_user_form");
        $this->setAttribute('method', 'post');       
        
        foreach ($resources as $resource) {
            $this->add(array(
                'name' => $resource['resource'],
                'type' => 'Zend\Form\Element\Checkbox',
                'options' => array(
                    'value'     => $resource['resource_id']
                ),
                'attributes' => array(
                    'title' => $resource['resource_name'],
                    'class' => 'checkbox'
                )
            ));
        }
        $this->setInputFilter(new EditPermissionOfUserFormFilter($resources));
        
    }
}