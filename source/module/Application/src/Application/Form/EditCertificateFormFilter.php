<?php
namespace Application\Form;

use Zend\InputFilter\InputFilter;

class EditCertificateFormFilter extends InputFilter
{

    public function __construct($certificates)
    {       
        foreach ($certificates as $key => $certificate) {
            $certificate_id='certificate_id_'.$certificate['value_id'];
            $certificate_name='certificate_name_'.$certificate['value_id'];
            
            $this->add(array(
                'name' => $certificate_id,
                'required' => true,
                'filters' => array(
                    array(
                        'name' => 'StringTrim'
                    ),
                    array(
                        'name' => 'StripTags'
                    )
                ),
                'validators' => array(
                    array(
                        'name' => 'NotEmpty',
                        'options' => array(
                            'message' => array(
                                'isEmpty' => 'Vui lòng nhập id chứng chỉ',
                            )
                        )
                    )
                )
            ));

            $this->add(array(
                'name' => $certificate_name,
                'required' => false,
                'filters' => array(
                    array(
                        'name' => 'StringTrim'
                    ),
                    array(
                        'name' => 'StripTags'
                    )
                )
            ));

            if($certificate['name']=='Ngoại ngữ'){
                $certificate_note='certificate_loai_ngoai_ngu_'.$certificate['value_id'];
                $certificate_level='certificate_level_'.$certificate['value_id'];
                
                $this->add(array(
                    'name' => $certificate_note,
                    'required' => false,
                    'filters' => array(
                        array(
                            'name' => 'StringTrim'
                        ),
                        array(
                            'name' => 'StripTags'
                        )
                    )
                ));

                $this->add(array(
                    'name' => $certificate_level,
                    'required' => false,
                    'filters' => array(
                        array(
                            'name' => 'StringTrim'
                        ),
                        array(
                            'name' => 'StripTags'
                        )
                    )
                ));

            }
            else{    
                $certificate_note='certificate_note_'.$certificate['value_id'];
                $certificate_check='certificate_check_'.$certificate['value_id'];
                
                $this->add(array(
                    'name' => $certificate_note,
                    'required' => false,
                    'filters' => array(
                        array(
                            'name' => 'StringTrim'
                        ),
                        array(
                            'name' => 'StripTags'
                        )
                    )
                ));

                $this->add(array(
                    'name' => $certificate_check,
                    'required' => false,
                    'filters' => array(
                        array(
                            'name' => 'StringTrim'
                        ),
                        array(
                            'name' => 'StripTags'
                        )
                    )
                ));

            }

            


        } 
    }
}
