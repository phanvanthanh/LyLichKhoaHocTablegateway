<?php
namespace Application\Form;

use Zend\Form\Form;
use Application\Form\EditCTNCFormFilter;
use Application\FunctionClass\FunctionClass;

class EditCTNCForm extends Form
{

    public function __construct()
    {
        parent::__construct("edit_ctnc_form");
        $this->setAttribute('method', 'post');
        
        $this->add(array(
            'name'          => 'id_hoat_dong',
            'type'          => 'Zend\Form\Element\Hidden', 
            'attributes'    => array(
                'title'     => 'Id hoạt động',
                'class'     => 'form-control',
            )
        ));

        $this->add(array(
            'name'          => 'ten_hoat_dong',
            'type'          => 'Zend\Form\Element\Text', 
            'attributes'    => array(
                'title'     => 'Tên hoạt động',
                'class'     => 'form-control',
                'disabled'  => true,
            ),
            'options'       => array(
                'Label'     => 'Tên hoạt động',
            ),
        ));    

        $this->add(array(
            'name'          => 'trang_thai',
            'type'          => 'Zend\Form\Element\Checkbox', 
            'attributes'    => array(
                'title'     => 'Trạng thái',
                'class'     => 'checkbox',
            ),
            'options'       => array(
                'Label'     => 'Trạng thái',
                'use_hidden_element' => true,
                'checked_value' => 1,
                'unchecked_value' => 0
            ),
        ));     

        $this->add(array(
            'name'          => 'time_from',
            'type'          => 'Zend\Form\Element\Text', 
            'attributes'    => array(
                'title'     => 'Từ ngày',
                'class'     => 'form-control date-time',
            ),
            'options'       => array(
                'Label'     => 'Từ ngày'
            ),
        )); 

        $this->add(array(
            'name'          => 'time_to',
            'type'          => 'Zend\Form\Element\Text', 
            'attributes'    => array(
                'title'     => 'Đến ngày',
                'class'     => 'form-control date-time',
            ),
            'options'       => array(
                'Label'     => 'Đến ngày'
            ),
        )); 

        $this->add(array(
            'name'          => 'ghi_chu',
            'type'          => 'Zend\Form\Element\Text', 
            'attributes'    => array(
                'title'     => 'Ghi chú',
                'class'     => 'form-control',
            ),
            'options'       => array(
                'Label'     => 'Ghi chú',
            ),
        )); 


        $this->setInputFilter(new EditCTNCFormFilter());
        
    }
}