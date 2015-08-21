<?php
namespace Permission\Form;

use Zend\Form\Form;
use Permission\Form\EditPermissionFormFilter;

class EditPermissionForm extends Form
{

    public function __construct($roles, $resources, $serviceLocator)
    {
        parent::__construct("edit_permission_form");
        $this->setAttribute('method', 'post');        
        // danh sách giảng viên option
        $role_options=array();
        foreach ($roles as $role) {
            $role_options[$role['role_id']]=$role['role_name'];
        }

        $this->add(array(
            'name' => 'role_id',
            'type' => 'Zend\Form\Element\Select',            
            'options'=>array(
                'empty_option' => 'Chọn',
                 'value_options' => $role_options,
            ),
            'attributes' => array(
                'title' => 'Danh sách quyền',
                'class' => 'form-control',
                'id'    => 'role-id',
            ),
        ));        

        foreach ($resources as $resource) {
            $attributes=array();
            $attributes['class']='checkbox';
            $attributes['title']=$resource['resource_name'];
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

        $this->setInputFilter(new EditPermissionFormFilter($resources));
        
    }
}