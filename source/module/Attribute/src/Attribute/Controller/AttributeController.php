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
use Attribute\Model\Entity\JosAttribute;

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
                // thêm vào csdl
                $new_attribute=new JosAttribute();
                $new_attribute->setAttributeCode($attribute_code);
                $new_attribute->setFrontendLabel($frontend_label);
                $new_attribute->setValueTable($value_table);
                $new_attribute->setYearId($years[0]['year_id']);
                // lưu thuộc tính
                $jos_attribute_table->saveAttribute($new_attribute);
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
}
