<?php
namespace NamHoc\Form;

use Zend\Form\Form;
use NamHoc\Form\AddYearFormFilter;

class AddYearForm extends Form
{

    public function __construct()
    {
        parent::__construct("add_year_form");
        $this->setAttribute('method', 'post');        
        
        $this->add(array(
            'name' => 'year_id',
            'type' => 'Zend\Form\Element\Text', 
            'attributes' => array(
                'title' => 'Chọn năm',
                'class' => 'form-control date-time-yyyy',
                'id'    => 'year-id',
            ),
        )); 

        $this->setInputFilter(new AddYearFormFilter());
        
    }
}