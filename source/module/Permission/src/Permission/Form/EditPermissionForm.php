<?php
namespace Permission\Form;

use Zend\Form\Form;
use Permission\Form\EditPermissionFormFilter;

class EditPermissionForm extends Form
{

    public function __construct($danh_sach_giang_viens, $resources, $serviceLocator)
    {
        parent::__construct("edit_permission_form");
        $this->setAttribute('method', 'post');        
        // danh sách giảng viên option
        $danh_giang_vien_option=array();
        foreach ($danh_sach_giang_viens as $danh_sach_giang_vien) {
            $danh_giang_vien_option[$danh_sach_giang_vien['id']]=$danh_sach_giang_vien['name'];
        }

        $this->add(array(
            'name' => 'id_giang_vien',
            'type' => 'Zend\Form\Element\Select',            
            'options'=>array(
                'empty_option' => 'Chọn',
                 'value_options' => $danh_giang_vien_option,
            ),
            'attributes' => array(
                'title' => 'Danh sách giảng viên',
                'class' => 'form-control',
                'id'    => 'id-giang-vien',
            ),
        ));
        foreach ($resources as $resource) {
            $this->add(array(
                'name' => $resource['resource'],
                'type' => 'Zend\Form\Element\Checkbox',
                'options' => array(
                    'value'     => $resource['resource_id']
                ),
                'attributes' => array(
                    'title' => $resource['resource_name'],
                    'class' => 'checkbox'
                )
            ));
        }

        $this->setInputFilter(new EditPermissionFormFilter($resources));
        
    }
}