<?php
namespace Attribute\Form;

use Zend\Form\Form;
use Attribute\Form\EditAttributeFormFilter;

class EditAttributeForm extends Form
{

    public function __construct()
    {
        parent::__construct("edit_attribute_form");
        $this->setAttribute('method', 'post');  

        $this->add(array(
            'name' => 'attribute_id',
            'type' => 'Zend\Form\Element\Hidden', 
            'attributes' => array(
                'id'    => 'attribute-id',
            ),            
        ));

        $this->add(array(
            'name' => 'attribute_code',
            'type' => 'Zend\Form\Element\Text', 
            'attributes' => array(
                'title' => 'Mã thuộc tính',
                'class' => 'form-control',
                'id'    => 'attribute-code',
                'placeholder' => 'Nhập mã thuộc tính',
            ),
        )); 

        $this->add(array(
            'name' => 'frontend_label',
            'type' => 'Zend\Form\Element\Text', 
            'attributes' => array(
                'title' => 'Tên thuộc tính',
                'class' => 'form-control',
                'id'    => 'frontend-label',
                'placeholder' => 'Nhập tên thuộc tính',
            ),
        ));

        

        $this->setInputFilter(new EditAttributeFormFilter());
        
    }
}