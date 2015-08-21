<?php
namespace CongTacNghienCuu\Form;

use Zend\Form\Form;
use CongTacNghienCuu\Form\AddScienceActivityFormFilter;

class AddScienceActivityForm extends Form
{

    public function __construct()
    {
        parent::__construct("add_science_activity_form");
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

        $this->setInputFilter(new AddScienceActivityFormFilter());
        
    }
}