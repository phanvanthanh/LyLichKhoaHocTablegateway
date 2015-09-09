<?php
namespace Application\Form;

use Zend\Form\Form;
use Application\Form\EditScientificReportFormFilter;
use Application\FunctionClass\FunctionClass;

class EditScientificReportForm extends Form
{

    public function __construct()
    {
        parent::__construct("edit_scientific_report_form");
        $this->setAttribute('method', 'post');
        
        $this->add(array(
            'name'          => 'value_id',
            'type'          => 'Zend\Form\Element\Hidden', 
            'attributes'    => array(
                'title'     => 'Id',
                'class'     => 'form-control',
            )
        ));

        $this->add(array(
            'name'          => 'name',
            'type'          => 'Zend\Form\Element\Text', 
            'attributes'    => array(
                'title'     => 'Tên bài báo',
                'class'     => 'form-control',
            ),
            'options'       => array(
                'Label'     => 'Tên bài báo',
            ),
        ));       

        
        $this->add(array(
            'name'          => 'publish_date',
            'type'          => 'Zend\Form\Element\Text', 
            'attributes'    => array(
                'title'     => 'Năm xuất bản',
                'class'     => 'form-control date-time',
            ),
            'options'       => array(
                'Label'     => 'Năm xuất bản'
            ),
        ));

        $this->add(array(
            'name'          => 'publish_place',
            'type'          => 'Zend\Form\Element\Text', 
            'attributes'    => array(
                'title'     => 'Nơi xuất bản',
                'class'     => 'form-control',
            ),
            'options'       => array(
                'Label'     => 'Nơi xuất bản'
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


        $this->setInputFilter(new EditScientificReportFormFilter());
        
    }
}