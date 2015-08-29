<?php
namespace Application\Form;

use Zend\InputFilter\InputFilter;

class EditCongTacGiangDayFormFilter extends InputFilter
{

    public function __construct($array)
    {  
        $he_dao_tao     = $array['he_dao_tao'];
        $bac_hoc        = $array['bac_hoc'];
        $this->add(array(
            'name' => 'id_cong_tac',
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
                            'isEmpty' => 'Vui lòng nhập id công tác giảng dạy',
                        )
                    )
                )
            )
        ));

        $this->add(array(
            'name' => 'ten_mon',
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
            'name' => 'so_tiet',
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

        foreach ($bac_hoc as $key => $bh) {
            $this->add(array(
                'name' => 'bac_hoc_'.$key,
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

        // hệ đào tạo
        foreach ($he_dao_tao as $key => $hdt) {
            $this->add(array(
                'name' => 'he_dao_tao_'.$key,
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

        $this->add(array(
            'name' => 'ghi_chu',
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
