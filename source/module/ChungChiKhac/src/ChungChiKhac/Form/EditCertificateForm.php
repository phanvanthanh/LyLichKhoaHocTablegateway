<?php
namespace ChungChiKhac\Form;

use Zend\Form\Form;
use ChungChiKhac\Form\EditCertificateFormFilter;

class EditCertificateForm extends Form
{

    public function __construct()
    {
        parent::__construct("edit_certificate_form");
        $this->setAttribute('method', 'post');        
        
        $this->add(array(
            'name' => 'name',
            'type' => 'Zend\Form\Element\Text', 
            'attributes' => array(
                'title' => 'Tên chứng chỉ',
                'class' => 'form-control',
                'id'    => 'name',
                'placeholder' => 'Nhập tên chứng chỉ',
            ),
        )); 

        $this->add(array(
            'name' => 'value_id',
            'type' => 'Zend\Form\Element\Hidden', 
            'attributes' => array(
                'id'    => 'id',
            ),            
        ));

        $this->setInputFilter(new EditCertificateFormFilter());
        
    }
}