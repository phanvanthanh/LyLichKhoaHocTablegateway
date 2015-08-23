<?php
namespace Application\Form;

use Zend\Form\Form;
use Application\Form\EditInforFormFilter;
use Application\FunctionClass\FunctionClass;

class EditInforForm extends Form
{

    public function __construct($serviceLocator, $all_attributes)
    {
        parent::__construct("add_attribute_form");
        $this->setAttribute('method', 'post'); 
        // tạo điểm truy cập csdl bảng jos_attribute_option
        $jos_attribute_option_table=$serviceLocator->get('Attribute\Model\JosAttributeOptionTable');
        foreach ($all_attributes as $key => $all_attribute) {
            $name=$all_attribute['attribute_code'];            
            $attributes=array();
            $attributes['title']=$all_attribute['frontend_label'];
            $attributes['class']='form-control ajax-thong-tin-ca-nhan';
            $attributes['id']=$all_attribute['attribute_code'];
            $attributes['placeholder']=$all_attribute['frontend_input'];
            $options=array();
            $options['label']=$all_attribute['frontend_label'];
            if($all_attribute['frontend_input']=='Select'){
                $jos_options=$jos_attribute_option_table->getAttributeOptionByArrayConditionAndArrayColumn(array('attribute_id'=>$all_attribute['attribute_id']), array('key', 'label'));
                foreach ($jos_options as $key => $jos_option) {
                    $options['value_options'][$jos_option['key']]=$jos_option['label'];
                }
                $options['empty_option']= 'Chọn';
            }
            elseif($all_attribute['frontend_input']=='Date'){
                $all_attribute['frontend_input']='Text';
                $attributes['class']='form-control date-time ajax-thong-tin-ca-nhan';
            }
            $type='Zend\Form\Element\\'.$all_attribute['frontend_input'];
            $this->add(array(
                'name'          => $name,
                'type'          => $type, 
                'attributes'    => $attributes,
                'options'       => $options,
            ));
        }         

        $this->setInputFilter(new EditInforFormFilter());
        
    }
}