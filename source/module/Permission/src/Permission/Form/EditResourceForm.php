<?php
namespace Permission\Form;

use Zend\Form\Form;

use Permission\Form\EditResourceFormFilter;

class EditResourceForm extends Form
{

    public function __construct()
    {
        parent::__construct("edit_resource_form");
        $this->setAttribute('method', 'post');
        
        $this->add(array(
            'name' => 'resource_name',
            'type' => 'Zend\Form\Element\Text',            
            'attributes' => array(
                'title' => 'Resource name',
                'class' => 'form-control',
                'id'    => 'permission-name',
            )
        ));

        $this->add(array(
            'name' => 'resource_id',
            'type' => 'Zend\Form\Element\Hidden',            
            'attributes' => array(
                'title' => 'Resource id',
                'class' => 'form-control',
                'id'    => 'permission-id',
            )
        ));

        $this->setInputFilter(new EditResourceFormFilter());
        
    }
}