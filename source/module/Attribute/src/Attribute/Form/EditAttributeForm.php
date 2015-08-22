<?php
namespace Attribute\Form;

use Zend\Form\Form;
use Attribute\Form\EditAttributeFormFilter;
use Application\FunctionClass\FunctionClass;

class EditAttributeForm extends Form
{

    public function __construct($serviceLocator)
    {
        parent::__construct("edit_attribute_form");
        $this->setAttribute('method', 'post');  
        // khai báo biến cần sử dụng      
        $service_config = $serviceLocator->get('config');
        $function_class = new FunctionClass();

        $this->add(array(
            'name' => 'attribute_id',
            'type' => 'Zend\Form\Element\Hidden', 
            'attributes' => array(
                'id'    => 'attribute-id',
            ),            
        ));

        $this->add(array(
            'name' => 'attribute_code',
            'type' => 'Zend\Form\Element\Text', 
            'attributes' => array(
                'title' => 'Mã thuộc tính',
                'class' => 'form-control',
                'id'    => 'attribute-code',
                'placeholder' => 'Nhập mã thuộc tính',
            ),
        )); 

        $options=array();
        $source_model_frontend_input=array();
        $source_model_frontend_input['source_model']['attribute']='frontend_input';
        // truy cập vào config lấy ra danh sách config
        $options['value_options'] = $function_class->selectElementArray(array('array_element' => $source_model_frontend_input, 'array' => $service_config ));
        $options['empty_option']= 'Chọn';
        $this->add(array(
            'name' => 'frontend_input',
            'type' => 'Zend\Form\Element\Select', 
            'attributes' => array(
                'title' => 'Loại thuộc tính',
                'class' => 'form-control',
                'id'    => 'frontend-input',
                'placeholder' => 'Chọn loại thuộc tính',
            ),
            'options'=>$options,
        ));

        $this->add(array(
            'name' => 'frontend_label',
            'type' => 'Zend\Form\Element\Text', 
            'attributes' => array(
                'title' => 'Tên thuộc tính',
                'class' => 'form-control',
                'id'    => 'frontend-label',
                'placeholder' => 'Nhập tên thuộc tính',
            ),
        ));

        

        $this->setInputFilter(new EditAttributeFormFilter());
        
    }
}