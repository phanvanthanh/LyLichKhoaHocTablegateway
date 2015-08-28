<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/Attribute for the canonical source repository
 * @copyright Copyright (c) 2005-2014 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Attribute\Controller;

use Zend\Mvc\Controller\AbstractActionController;

use Attribute\Form\AddAttributeForm;
use Attribute\Form\EditAttributeForm;
use Attribute\Form\EditAttributeOptionForm;
use Attribute\Model\Entity\JosAttribute;
use Application\FunctionClass\FunctionClass;
use Attribute\Model\Entity\JosAttributeOption;

class AttributeController extends AbstractActionController
{
    public function indexAction()
    {
        // mảng trả về
        $return_array =array();
        // tạo điểm truy cập csdl jos_attribute
        $jos_attribute_table=$this->getServiceLocator()->get('Attribute\Model\JosAttributeTable');
        // lấy tất cả môn học theo năm kích hoạt
        $all_attributes=$jos_attribute_table->getAttributeByYearActive();
        $return_array['all_attributes']=$all_attributes;
        // attribute_option
        $jos_attribute_option_table=$this->getServiceLocator()->get('Attribute\Model\JosAttributeOptionTable');
        $jos_attribute_options=$jos_attribute_option_table->getAttributeOptionByArrayConditionAndArrayColumn();
        $return_array['jos_attribute_option']=$jos_attribute_options;
        // add form
        $add_form=new AddAttributeForm($this->getServiceLocator());
        $return_array['add_form']=$add_form;

        // edit form
        $edit_form=new EditAttributeForm($this->getServiceLocator());
        $return_array['edit_form']=$edit_form;


        return $return_array;
    }

    public function addAction(){
        // add form
        $add_form=new AddAttributeForm($this->getServiceLocator());

        $request=$this->getRequest();
        if($request->isPost()){
            $post=$request->getPost();
            $add_form->setData($post);
            if($add_form->isValid()){
                $attribute_code = $post['attribute_code'];
                $frontend_label = $post['frontend_label'];
                $frontend_input = $post['frontend_input'];
                $value_table    = 'jos_infomation';                
                // khai báo model bảng jos_year
                $jos_year_table=$this->getServiceLocator()->get('NamHoc\Model\JosYearTable');
                // lấy year_id default
                $years=$jos_year_table->getYearByArrayConditionAndArrayColumn(array('is_active'));
                // không tồn tại year default
                if(!$years){
                    $this->flashMessenger()->addErrorMessage('Lỗi. Bạn muốn thêm "Môn Học" vào năm học nào? Vui lòng kiểm tra lại!');
                    return $this->redirect()->toRoute('thuoc_tinh/crud', array('action'=>'index'));
                }
                // tạo điểm truy cập csdl jos_subject
                $jos_attribute_table=$this->getServiceLocator()->get('Attribute\Model\JosAttributeTable');
                // kiểm tra với năm hiện tại có tồn tại có tồn tại môn học này chưa
                $jos_attribute_exist=$jos_attribute_table->getAttributeByArrayConditionAndArrayColumn(array('attribute_code'=>$attribute_code, 'year_id'=>$years[0]['year_id']));
                if($jos_attribute_exist){
                    $this->flashMessenger()->addErrorMessage('Lỗi, Thuộc tính vừa thêm đã tồn tại. Vui lòng kiểm tra lại!');
                    return $this->redirect()->toRoute('thuoc_tinh/crud', array('action'=>'index'));
                }
                // kiểm tra dữ liệu frontend_input có thuộc loại trong config hong
                $service_config = $this->getServiceLocator()->get('config');
                $function_class = new FunctionClass();
                $options=array();
                $source_model_frontend_input=array();
                $source_model_frontend_input['source_model']['attribute']='frontend_input';
                // truy cập vào config lấy ra danh sách config
                $options = $function_class->selectElementArray(array('array_element' => $source_model_frontend_input, 'array' => $service_config ));
                if(!isset($options[$frontend_input])){
                    $this->flashMessenger()->addErrorMessage('Lỗi, Loại thuộc tính không tồn tại. Vui lòng kiểm tra lại!');
                    return $this->redirect()->toRoute('thuoc_tinh/crud', array('action'=>'index'));
                }
                // thêm vào csdl
                $new_attribute=new JosAttribute();
                $new_attribute->exchangeArray($post);
                $new_attribute->setAttributeCode($attribute_code);
                $new_attribute->setFrontendLabel($frontend_label);
                $new_attribute->setValueTable($value_table);
                $new_attribute->setYearId($years[0]['year_id']);
                // lưu thuộc tính
                $jos_attribute_table->saveAttribute($new_attribute);
                // nếu frontend_input==Select thì lưu option vào bảng jos_attribute_option
                if($frontend_input=='Select'){
                    // lấy id jos_attribute
                    $attribute=$jos_attribute_table->getAttributeByArrayConditionAndArrayColumn(array('attribute_code'=>$attribute_code, 'year_id'=>$years[0]['year_id']), array('attribute_id'));
                    if(isset($attribute[0]['attribute_id'])){
                        $jos_attribute_option_table=$this->getServiceLocator()->get('Attribute\Model\JosAttributeOptionTable');
                        foreach ($post['frontend_input_value'] as $key => $value) {
                            if($value and $post['frontend_input_label'][$key]){
                                $jos_attribute_option_exist=$jos_attribute_option_table->getAttributeOptionByArrayConditionAndArrayColumn(array('attribute_id'=>$attribute[0]['attribute_id'], 'key'=>$post['frontend_input_label'][$key]), array('value_id'));
                                if($jos_attribute_option_exist){
                                    continue;
                                }
                                $new_attribute_option=new JosAttributeOption();
                                $new_attribute_option->setAttributeId($attribute[0]['attribute_id']);
                                $new_attribute_option->setKey($value);
                                $new_attribute_option->setLabel($post['frontend_input_label'][$key]);
                                $jos_attribute_option_table->saveAttributeOption($new_attribute_option);
                            }
                        }
                    }
                        
                }
                // lưu thành công
                $this->flashMessenger()->addSuccessMessage('Chúc mừng, thêm thuộc tính thành công!');
                return $this->redirect()->toRoute('thuoc_tinh/crud', array('action'=>'index'));
                
            }
        }
        $this->flashMessenger()->addErrorMessage('Lỗi, thực thi không thành công. Vui lòng kiểm tra lại!');
        return $this->redirect()->toRoute('thuoc_tinh/crud', array('action'=>'index'));
    }

    public function editAction(){
        // edit form
        $edit_form=new EditAttributeForm($this->getServiceLocator());

        $request=$this->getRequest();
        if($request->isPost()){
            $post=$request->getPost();
            $edit_form->setData($post);
            if($edit_form->isValid()){
                // khai báo model bảng jos_year
                $jos_year_table=$this->getServiceLocator()->get('NamHoc\Model\JosYearTable');
                // lấy year_id default
                $years=$jos_year_table->getYearByArrayConditionAndArrayColumn(array('is_active'));
                // không tồn tại year default
                if(!$years){
                    $this->flashMessenger()->addErrorMessage('Lỗi. Bạn muốn thêm attribute vào năm học nào? Vui lòng kiểm tra lại!');
                    return $this->redirect()->toRoute('thuoc_tinh/crud', array('action'=>'index'));
                }
                // tạo điểm truy cập csdl jos_attribute
                $jos_attribute_table=$this->getServiceLocator()->get('Attribute\Model\JosAttributeTable');
                // kiểm tra id vừa post có tồn tại không
                $attribute=$jos_attribute_table->getAttributeByArrayConditionAndArrayColumn(array('attribute_id'=>$post['attribute_id']), array('value_table'));
                if(!$attribute){
                    $this->flashMessenger()->addErrorMessage('Lỗi, thuộc tính cần sửa không tồn tại. Vui lòng kiểm tra lại!');
                    return $this->redirect()->toRoute('thuoc_tinh/crud', array('action'=>'index'));
                }
                // kiểm tra với năm hiện tại có tồn tại dòng nào có tên như trên chưa
                // nếu có kiểm tra có khác id không
                $jos_attribute_exist=$jos_attribute_table->getAttributeByArrayConditionAndArrayColumn(array('attribute_code'=>$post['attribute_code'], 'year_id'=>$years[0]['year_id']), array('attribute_id'));
                if($jos_attribute_exist and $post['attribute_id']!=$jos_attribute_exist[0]['attribute_id']){
                    $this->flashMessenger()->addErrorMessage('Lỗi. Tên thuộc tính đã tồn tại. Vui lòng kiểm tra lại!');
                    return $this->redirect()->toRoute('thuoc_tinh/crud', array('action'=>'index'));
                }
                // luu lại
                $new_attribute=new JosAttribute();
                $new_attribute->exchangeArray($post);
                $new_attribute->setYearId($years[0]['year_id']);
                $new_attribute->setValueTable($attribute[0]['value_table']);
                $jos_attribute_table->saveAttribute($new_attribute);
                if($post['frontend_input']!='Select'){
                    // tạo điểm truy cập csdl bảng attribute_option
                    $jos_attribute_option_table=$this->getServiceLocator()->get('Attribute\Model\JosAttributeOptionTable');
                    // xóa option cũ
                    $jos_attribute_option_table->deleteAttributeOptionByAttributeId($post['attribute_id']);
                }
                // thông báo thành công
                $this->flashMessenger()->addSuccessMessage('Chúc mừng, cập nhật thuộc tính thành công!');
                return $this->redirect()->toRoute('thuoc_tinh/crud', array('action'=>'index'));
            }
        }
        $this->flashMessenger()->addErrorMessage('Lỗi, thực thi không thành công. Vui lòng kiểm tra lại!');
        return $this->redirect()->toRoute('thuoc_tinh/crud', array('action'=>'index'));
    }


    public function deleteAction(){
        // lấy id attribute
        $attribute_id=$this->params('id');
        // tạo điểm kết nối csdl bảng jos_attribute_table
        $jos_attribute_table=$this->getServiceLocator()->get('Attribute\Model\JosAttributeTable');
        $attribute_exist=$jos_attribute_table->getAttributeByArrayConditionAndArrayColumn(array('attribute_id'=>$attribute_id), array('attribute_code'));
        if(!$attribute_exist){
            $this->flashMessenger()->addErrorMessage('Lỗi, Thuộc tính cần xóa không tồn tại. Vui lòng kiểm tra lại!');
            return $this->redirect()->toRoute('thuoc_tinh/crud', array('action'=>'index'));
        }
        // xóa subject theo value_id
        $jos_attribute_table->deleteAttributeById($attribute_id);
        $this->flashMessenger()->addSuccessMessage('Chúc mừng, xóa thuộc tính thành công!');
        return $this->redirect()->toRoute('thuoc_tinh/crud', array('action'=>'index'));
    }

    public function editOptionAction(){
        $attribute_id=$this->params('id');
        $return_array=array();
        if($attribute_id){
            // kiểm tra nếu attribute id vừa đưa qua thuộc loại select
            $jos_attribute_table=$this->getServiceLocator()->get('Attribute\Model\JosAttributeTable');
            $attribute_exist=$jos_attribute_table->getAttributeByArrayConditionAndArrayColumn(array('attribute_id'=>$attribute_id), array('frontend_input'));
            // lỗi không phải select
            if(!$attribute_exist or $attribute_exist[0]['frontend_input']!='Select'){
                $this->flashMessenger()->addErrorMessage('Lỗi, thuộc tính cần sửa không có dữ liệu option. Vui lòng kiểm tra lại!');
                return $this->redirect()->toRoute('thuoc_tinh/crud', array('action'=>'index'));
            }
            // gửi attribute_id ra view
            $return_array['attribute_id']=$attribute_id;
            // attribute_option
            $jos_attribute_option_table=$this->getServiceLocator()->get('Attribute\Model\JosAttributeOptionTable');
            $options=$jos_attribute_option_table->getAttributeOptionByArrayConditionAndArrayColumn(array('attribute_id'=>$attribute_id));
            $return_array['options']=$options;

            // edit form
            $edit_form=new EditAttributeOptionForm($this->getServiceLocator());
            $edit_form->setData(array('attribute_id'=>$attribute_id));
            $return_array['edit_form']=$edit_form;

            // kiểm tra nếu post
            $request=$this->getRequest();
            if($request->isPost()){
                $post=$request->getPost();
                // kiểm tra nếu không có post option nào hết
                if(!isset($post['frontend_input_value']) or !$post['frontend_input_value'][0] or !$post['frontend_input_label'][0]){
                    $this->flashMessenger()->addErrorMessage('Lỗi, option không tồn tại. Vui lòng kiểm tra lại!');
                    return $this->redirect()->toRoute('thuoc_tinh/crud', array('action'=>'index'));
                }
                $edit_form->setData(array('attribute_id'=>$attribute_id));
                // form hợp lý
                if($edit_form->isValid()){
                    // tạo điểm truy cập csdl bảng attribute_option
                    $jos_attribute_option_table=$this->getServiceLocator()->get('Attribute\Model\JosAttributeOptionTable');
                    // xóa option cũ
                    $jos_attribute_option_table->deleteAttributeOptionByAttributeId($attribute_id);
                    // xử lý lưu
                    foreach ($post['frontend_input_value'] as $key => $value) {
                        if($value and $post['frontend_input_label'][$key]){
                            $jos_attribute_option_exist=$jos_attribute_option_table->getAttributeOptionByArrayConditionAndArrayColumn(array('attribute_id'=>$attribute_id, 'key'=>$post['frontend_input_label'][$key]), array('value_id'));
                            if($jos_attribute_option_exist){
                                continue;
                            }
                            $new_attribute_option=new JosAttributeOption();
                            $new_attribute_option->setAttributeId($attribute_id);
                            $new_attribute_option->setKey($post['frontend_input_label'][$key]);
                            $new_attribute_option->setLabel($value);
                            $jos_attribute_option_table->saveAttributeOption($new_attribute_option);
                        }
                    }
                    // lưu thành công
                    $this->flashMessenger()->addSuccessMessage('Chúc mừng, sửa thuộc tính thành công!');
                    return $this->redirect()->toRoute('thuoc_tinh/crud', array('action'=>'index'));
                }
                else{
                    $this->flashMessenger()->addErrorMessage('Lỗi, form không hợp lệ. Vui lòng kiểm tra lại!');
                    return $this->redirect()->toRoute('thuoc_tinh/crud', array('action'=>'index'));
                }

            }

            return $return_array;
        }

        $this->flashMessenger()->addErrorMessage('Lỗi, không tìm thấy id. Vui lòng kiểm tra lại!');
        return $this->redirect()->toRoute('thuoc_tinh/crud', array('action'=>'index'));
    }
}
