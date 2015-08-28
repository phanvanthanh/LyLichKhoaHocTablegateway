<?php
namespace Application\Form;

use Zend\Form\Form;
use Application\Form\EditCertificateFormFilter;
use Application\FunctionClass\FunctionClass;

class EditCertificateForm extends Form
{

    public function __construct($serviceLocator, $certificates)
    {
        parent::__construct("edit_certificate_form");
        $this->setAttribute('method', 'post');
        //die(var_dump($certificates));
        foreach ($certificates as $key => $certificate) {
            $certificate_id='certificate_id_'.$certificate['value_id'];
            $this->add(array(
                'name'          => $certificate_id,
                'type'          => 'Zend\Form\Element\Hidden', 
                'attributes'    => array(
                    'title'     => 'Id chứng chỉ',
                    'class'     => 'form-control',
                ),
            ));  

            $certificate_name='certificate_name_'.$certificate['value_id'];
            $this->add(array(
                'name'          => $certificate_name,
                'type'          => 'Zend\Form\Element\Text', 
                'attributes'    => array(
                    'title'     => 'Tên chứng chỉ',
                    'class'     => 'form-control',
                    'value'     => $certificate['name'],
                    'disabled'  => true,
                ),
            ));

                
            if($certificate['name']=='Ngoại ngữ'){
                // nếu là ngoại ngữ thì cột chú thích (certificate_note) sẽ lưu lại loại ngoại ngữ: có thể là tieng_anh, tieng_nhat, tieng_phap...
                $certificate_note='certificate_loai_ngoai_ngu_'.$certificate['value_id'];
                $this->add(array(
                    'name'          => $certificate_note,
                    'type'          => 'Zend\Form\Element\Select', 
                    'attributes'    => array(
                        'title'     => 'Loại ngoại ngữ',
                        'class'     => 'form-control',
                    ),
                    'options'       => array(
                        'empty_option'  =>'Chọn',                        
                        'value_options' =>array(
                            'tieng_anh' =>'Tiếng anh',
                            'tieng_nhat'=>'Tiếng nhật'
                        ),
                    ),
                )); 

                // cột level sẽ lưu lại trình độ ngoại ngữ đó
                $certificate_level='certificate_level_'.$certificate['value_id'];
                $this->add(array(
                    'name'          => $certificate_level,
                    'type'          => 'Zend\Form\Element\Text', 
                    'attributes'    => array(
                        'title'     => 'Trình độ',
                        'class'     => 'form-control',
                    ),
                ));               
            } 
            else{
                // ngược lại thì sẽ lưu ghi chú
                $certificate_note='certificate_note_'.$certificate['value_id'];
                $this->add(array(
                    'name'          => $certificate_note,
                    'type'          => 'Zend\Form\Element\Text', 
                    'attributes'    => array(
                        'title'     => 'Ghi chú',
                        'class'     => 'form-control',
                    ),
                ));

                $certificate_check='certificate_check_'.$certificate['value_id'];
                $this->add(array(
                    'name'          => $certificate_check,
                    'type'          => 'Zend\Form\Element\Checkbox', 
                    'attributes'    => array(
                        'title'     => 'Ghi chú',
                        'class'     => 'checkbox',                        
                    ),
                    'options' => array(
                        'use_hidden_element' => true,
                        'checked_value' => 1,
                        'unchecked_value' => 0
                    )
                ));
            }
        }    

        

        $this->setInputFilter(new EditCertificateFormFilter());
        
    }
}