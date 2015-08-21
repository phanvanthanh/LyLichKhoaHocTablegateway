<?php
namespace CongTacNghienCuu\Form;

use Zend\Form\Form;
use CongTacNghienCuu\Form\EditScienceActivityFormFilter;

class EditScienceActivityForm extends Form
{

    public function __construct()
    {
        parent::__construct("edit_science_activity_form");
        $this->setAttribute('method', 'post');        
        
        $this->add(array(
            'name' => 'name',
            'type' => 'Zend\Form\Element\Text', 
            'attributes' => array(
                'title' => 'Tên hoạt động nghiên cứu khoa học',
                'class' => 'form-control',
                'id'    => 'name',
                'placeholder' => 'Nhập tên hoạt động nghiên cứu khoa học',
            ),
        )); 

        $this->add(array(
            'name' => 'id',
            'type' => 'Zend\Form\Element\Hidden', 
            'attributes' => array(
                'id'    => 'id',
            ),            
        ));

        $this->setInputFilter(new EditScienceActivityFormFilter());
        
    }
}