<?php
namespace Application\Form;

use Zend\Form\Form;
use Application\Form\AddOrtherWorkFormFilter;
use Application\FunctionClass\FunctionClass;

class AddOrtherWorkForm extends Form
{

    public function __construct()
    {
        parent::__construct("add_orther_work_form");
        $this->setAttribute('method', 'post');
        
        $this->add(array(
            'name'          => 'content',
            'type'          => 'Zend\Form\Element\Text', 
            'attributes'    => array(
                'title'     => 'Nội dung',
                'class'     => 'form-control',
            ),
            'options'       => array(
                'Label'     => 'Tên công tác',
            ),
        ));       

        
        $this->add(array(
            'name'          => 'time_from',
            'type'          => 'Zend\Form\Element\Text', 
            'attributes'    => array(
                'title'     => 'Thời gian bắt đầu',
                'class'     => 'form-control date-time',
            ),
            'options'       => array(
                'Label'     => 'Thời gian bắt đầu'
            ),
        ));

        $this->add(array(
            'name'          => 'time_to',
            'type'          => 'Zend\Form\Element\Text', 
            'attributes'    => array(
                'title'     => 'Thời gian kết thúc',
                'class'     => 'form-control date-time',
            ),
            'options'       => array(
                'Label'     => 'Thời gian kết thúc'
            ),
        ));

        $this->add(array(
            'name'          => 'note',
            'type'          => 'Zend\Form\Element\Text', 
            'attributes'    => array(
                'title'     => 'Ghi chú',
                'class'     => 'form-control',
            ),
            'options'       => array(
                'Label'     => 'Ghi chú',
            ),
        )); 


        $this->setInputFilter(new AddOrtherWorkFormFilter());
        
    }
}