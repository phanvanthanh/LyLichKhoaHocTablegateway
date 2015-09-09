<?php
namespace Application\Form;

use Zend\Form\Form;
use Application\Form\AddFutureStudyFormFilter;
use Application\FunctionClass\FunctionClass;

class AddFutureStudyForm extends Form
{

    public function __construct()
    {
        parent::__construct("add_future_study_form");
        $this->setAttribute('method', 'post');
        
        $this->add(array(
            'name'          => 'subject_name',
            'type'          => 'Zend\Form\Element\Text', 
            'attributes'    => array(
                'title'     => 'Tên môn học',
                'class'     => 'form-control',
            ),
            'options'       => array(
                'Label'     => 'Tên môn học',
            ),
        ));     

        $this->add(array(
            'name'          => 'address',
            'type'          => 'Zend\Form\Element\Text', 
            'attributes'    => array(
                'title'     => 'Nơi học',
                'class'     => 'form-control',
            ),
            'options'       => array(
                'Label'     => 'Nơi học',
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


        $this->setInputFilter(new AddFutureStudyFormFilter());
        
    }
}