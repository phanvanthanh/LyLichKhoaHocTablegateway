<?php
namespace ChungChiKhac\Form;

use Zend\Form\Form;
use ChungChiKhac\Form\AddCertificateFormFilter;

class AddCertificateForm extends Form
{

    public function __construct()
    {
        parent::__construct("add_certificate_form");
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

        $this->setInputFilter(new AddCertificateFormFilter());
        
    }
}