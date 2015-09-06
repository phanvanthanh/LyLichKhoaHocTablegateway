<?php
namespace Application\Form;

use Zend\Form\Form;
use Application\Form\AddFutureHDNCKHFormFilter;
use Application\FunctionClass\FunctionClass;

class AddFutureHDNCKHForm extends Form
{

    public function __construct()
    {
        parent::__construct("add_future_htnckh_form");
        $this->setAttribute('method', 'post');
        
        $this->add(array(
            'name'          => 'science_activity_name',
            'type'          => 'Zend\Form\Element\Text', 
            'attributes'    => array(
                'title'     => 'Hoạt động nghiên cứu khoa học',
                'class'     => 'form-control',
            ),
            'options'       => array(
                'Label'     => 'Tên hoạt động',
            ),
        ));       

        
        $this->add(array(
            'name'          => 'time_from',
            'type'          => 'Zend\Form\Element\Text', 
            'attributes'    => array(
                'title'     => 'Ngày bắt đầu',
                'class'     => 'form-control date-time',
            ),
            'options'       => array(
                'Label'     => 'Ngày bắt đầu'
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


        $this->setInputFilter(new AddFutureHDNCKHFormFilter());
        
    }
}