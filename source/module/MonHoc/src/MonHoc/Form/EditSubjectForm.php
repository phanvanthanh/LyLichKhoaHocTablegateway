<?php
namespace MonHoc\Form;

use Zend\Form\Form;
use MonHoc\Form\EditSubjectFormFilter;

class EditSubjectForm extends Form
{

    public function __construct()
    {
        parent::__construct("edit_subject_form");
        $this->setAttribute('method', 'post');        
        
        $this->add(array(
            'name' => 'name',
            'type' => 'Zend\Form\Element\Text', 
            'attributes' => array(
                'title' => 'Tên môn học',
                'class' => 'form-control',
                'id'    => 'name',
                'placeholder' => 'Nhập tên học',
            ),
        )); 

        $this->add(array(
            'name' => 'value_id',
            'type' => 'Zend\Form\Element\Hidden', 
            'attributes' => array(
                'id'    => 'id',
            ),            
        ));

        $this->setInputFilter(new EditSubjectFormFilter());
        
    }
}