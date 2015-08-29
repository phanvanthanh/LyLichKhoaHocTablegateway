<?php
namespace Application\Form;

use Zend\Form\Form;
use Application\Form\EditCongTacGiangDayFormFilter;
use Application\FunctionClass\FunctionClass;

class EditCertificateForm extends Form
{

    public function __construct($serviceLocator)
    {
        parent::__construct("edit_certificate_form");
        $this->setAttribute('method', 'post');
        // khai báo biến cần sử dụng      
        $service_config = $serviceLocator->get('config');
        $function_class = new FunctionClass();
        
        // truy cập vào config lấy ra danh sách config bậc học
        $bac_hoc=array();
        $bac_hoc_source_model=array();
        $bac_hoc_source_model['source_model']['application']='bac_hoc';
        $bac_hoc = $function_class->selectElementArray(array('array_element' => $bac_hoc_source_model, 'array' => $service_config ));
        
        // truy cập vào config lấy ra danh sách config số tiết
        $so_tiet=array();
        $so_tiet_source_model=array();
        $so_tiet_source_model['source_model']['application']='so_tiet';
        $so_tiet = $function_class->selectElementArray(array('array_element' => $so_tiet_source_model, 'array' => $service_config ));
        

        // truy cập vào config lấy ra danh sách config hệ đào tạo
        $he_dao_tao=array();
        $he_dao_tao_source_model=array();
        $he_dao_tao_source_model['source_model']['application']='he_dao_tao';
        $he_dao_tao = $function_class->selectElementArray(array('array_element' => $he_dao_tao_source_model, 'array' => $service_config ));
        
        
        // id công tác giảng dạy
        $this->add(array(
            'name'          => 'id_cong_tac',
            'type'          => 'Zend\Form\Element\Hidden',
        ));

        // Tên môn
        $mon_hoc_table=$serviceLocator->get('MonHoc\Model\JosSubjectTable');
        $mon_hocs=$mon_hoc_table->getSubjectByYearActive(array('id', 'name'));
        $mon_hoc_option=array();
        $mon_hoc_option['empty_option']='Chọn';
        foreach ($mon_hocs as $key => $mon_hoc) {
            $mon_hoc_option['value_options'][$mon_hoc['id']]=$mon_hoc['name'];
        }
        $this->add(array(
            'name'          => 'ten_mon',
            'type'          => 'Zend\Form\Element\Select', 
            'attributes'    => array(
                'title'     => 'Tên môn',
                'class'     => 'form-control',
            ),
            'options'   => $mon_hoc_option,
        )); 

        // Số tiết
        $so_tiet_option=array();
        $so_tiet_option['empty_option']='Chọn';
        $so_tiet_option['value_options']=$so_tiet;
        $this->add(array(
            'name'          => 'so_tiet',
            'type'          => 'Zend\Form\Element\Select', 
            'attributes'    => array(
                'title'     => 'Số tiết',
                'class'     => 'form-control',
            ),
            'options'       => $so_tiet_option,
        ));

        // bậc học
        foreach ($bac_hoc as $key => $bh) {
            $this->add(array(
                'name'          => 'bac_hoc_'.$key,
                'type'          => 'Zend\Form\Element\Checkbox', 
                'attributes'    => array(
                    'title'     => '$bh',
                    'class'     => 'form-control',
                )
            ));
        }

        // hệ đào tạo
        foreach ($he_dao_tao as $key => $hdt) {
            $this->add(array(
                'name'          => 'he_dao_tao_'.$key,
                'type'          => 'Zend\Form\Element\Checkbox', 
                'attributes'    => array(
                    'title'     => '$hdt',
                    'class'     => 'form-control',
                )
            ));
        }

        // ghi chú
        $this->add(array(
            'name'          => 'ghi_chu',
            'type'          => 'Zend\Form\Element\Text', 
            'attributes'    => array(
                'title'     => 'Ghi chú',
                'class'     => 'form-control',
            )
        )); 

        $this->setInputFilter(new EditCongTacGiangDayFormFilter(array('he_dao_tao'=>$he_dao_tao, 'bac_hoc'=>$bac_hoc)));
        
    }
}