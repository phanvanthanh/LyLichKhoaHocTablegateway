<?php
namespace MonHoc\Form;

use Zend\Form\Form;
use MonHoc\Form\AddSubjectFormFilter;

class AddSubjectForm extends Form
{

    public function __construct()
    {
        parent::__construct("add_subject_form");
        $this->setAttribute('method', 'post');        
        
        $this->add(array(
            'name' => 'name',
            'type' => 'Zend\Form\Element\Text', 
            'attributes' => array(
                'title' => 'Tên môn học',
                'class' => 'form-control',
                'id'    => 'name',
                'placeholder' => 'Nhập tên môn học',
            ),
        )); 

        $this->setInputFilter(new AddSubjectFormFilter());
        
    }
}