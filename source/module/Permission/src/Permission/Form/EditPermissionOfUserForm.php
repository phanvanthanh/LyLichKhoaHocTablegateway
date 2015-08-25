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
            $attributes=array();
            $attributes['class']='checkbox';
            $attributes['title']=$resource['resource_name'];
            $attributes['checked']=false;
            if($resource['rule_id']){
                $attributes['checked']=true;
            }            

            $options=array();
            $options['checked_value']       = $resource['resource_id'];
            $options['unchecked_value']     = 0;

            $this->add(array(
                'name' => $resource['parent_id'].'_'.$resource['resource'],
                'type' => 'Zend\Form\Element\Checkbox',
                'options' => $options,
                'attributes' => $attributes,
            ));
        }
        $this->setInputFilter(new EditPermissionOfUserFormFilter($resources));
        
    }
}