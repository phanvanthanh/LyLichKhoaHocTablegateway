<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/MonHoc for the canonical source repository
 * @copyright Copyright (c) 2005-2014 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace MonHoc\Controller;

use Zend\Mvc\Controller\AbstractActionController;

use MonHoc\Form\AddSubjectForm;
use MonHoc\Form\EditSubjectForm;
use MonHoc\Model\Entity\JosSubject;

class MonHocController extends AbstractActionController
{
    public function indexAction()
    {
    	// mảng trả về
    	$return_array =array();
    	// tạo điểm truy cập csdl jos_subject
    	$jos_subject_table=$this->getServiceLocator()->get('MonHoc\Model\JosSubjectTable');
    	// lấy tất cả môn học theo năm kích hoạt
    	$all_subjects=$jos_subject_table->getSubjectByYearActive();
    	$return_array['all_subjects']=$all_subjects;

    	// add form
    	$add_form=new AddSubjectForm();
    	$return_array['add_form']=$add_form;

    	// edit form
    	$edit_form=new EditSubjectForm();
    	$return_array['edit_form']=$edit_form;


    	return $return_array;
    }

    public function addAction(){
        // add form
        $add_form=new AddSubjectForm();

        $request=$this->getRequest();
        if($request->isPost()){
            $post=$request->getPost();
            $add_form->setData($post);
            if($add_form->isValid()){
                $name=$post['name'];
                // khai báo model bảng jos_year
                $jos_year_table=$this->getServiceLocator()->get('NamHoc\Model\JosYearTable');
                // lấy year_id default
                $years=$jos_year_table->getYearByArrayConditionAndArrayColumn(array('is_active'));
                // không tồn tại year default
                if(!$years){
                    $this->flashMessenger()->addErrorMessage('Lỗi. Bạn muốn thêm "Môn Học" vào năm học nào? Vui lòng kiểm tra lại!');
                    return $this->redirect()->toRoute('mon_hoc/crud', array('action'=>'index'));
                }
                // tạo điểm truy cập csdl jos_subject
                $jos_subject_table=$this->getServiceLocator()->get('MonHoc\Model\JosSubjectTable');
                // kiểm tra với năm hiện tại có tồn tại có tồn tại môn học này chưa
                $jos_subject_exist=$jos_subject_table->getSubjectByArrayConditionAndArrayColumn(array('name'=>$name, 'year_id'=>$years[0]['year_id']));
                if($jos_subject_exist){
                    $this->flashMessenger()->addErrorMessage('Lỗi. Môn học vừa thêm đã tồn tại. Vui lòng kiểm tra lại!');
                    return $this->redirect()->toRoute('mon_hoc/crud', array('action'=>'index'));
                }
                // thêm vào csdl
                $new_subject=new JosSubject();
                $new_subject->setName($name);
                $new_subject->setYearId($years[0]['year_id']);
                // lưu môn học
                $jos_subject_table->saveSubject($new_subject);
                // lưu thành công
                $this->flashMessenger()->addSuccessMessage('Chúc mừng, thêm môn học thành công!');
                return $this->redirect()->toRoute('mon_hoc/crud', array('action'=>'index'));
                
            }
        }
        $this->flashMessenger()->addErrorMessage('Lỗi, thực thi không thành công. Vui lòng kiểm tra lại!');
        return $this->redirect()->toRoute('mon_hoc/crud', array('action'=>'index'));
                
                
    }

    public function editAction(){
        // edit form
        $edit_form=new EditSubjectForm();

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
                    $this->flashMessenger()->addErrorMessage('Lỗi. Bạn muốn thêm "Môn Học" vào năm học nào? Vui lòng kiểm tra lại!');
                    return $this->redirect()->toRoute('mon_hoc/crud', array('action'=>'index'));
                }
                // tạo điểm truy cập csdl jos_subject
                $jos_subject_table=$this->getServiceLocator()->get('MonHoc\Model\JosSubjectTable');
                // kiểm tra id vừa post có tồn tại không
                $subject=$jos_subject_table->getSubjectByArrayConditionAndArrayColumn(array('value_id'=>$post['value_id']), array('year_id'));
                if(!$subject){
                    $this->flashMessenger()->addErrorMessage('Lỗi. Môn học cần sửa không tồn tại. Vui lòng kiểm tra lại!');
                    return $this->redirect()->toRoute('mon_hoc/crud', array('action'=>'index'));
                }
                // kiểm tra với năm hiện tại có tồn tại dòng nào có tên như trên chưa
                // nếu có kiểm tra có khác id không
                $jos_subject_exist=$jos_subject_table->getSubjectByArrayConditionAndArrayColumn(array('name'=>$post['name'], 'year_id'=>$years[0]['year_id']), array('value_id'));
                if($jos_subject_exist and $post['value_id']!=$jos_subject_exist[0]['value_id']){
                    $this->flashMessenger()->addErrorMessage('Lỗi. Tên Môn học đã tồn tại. Vui lòng kiểm tra lại!');
                    return $this->redirect()->toRoute('mon_hoc/crud', array('action'=>'index'));
                }
                // luu lại
                $new_subject=new JosSubject();
                $new_subject->exchangeArray($post);
                $new_subject->setYearId($subject[0]['year_id']);
                $jos_subject_table->saveSubject($new_subject);
                // thông báo thành công
                $this->flashMessenger()->addSuccessMessage('Chúc mừng, cập nhật môn học thành công!');
                return $this->redirect()->toRoute('mon_hoc/crud', array('action'=>'index'));
            }
        }
        $this->flashMessenger()->addErrorMessage('Lỗi, thực thi không thành công. Vui lòng kiểm tra lại!');
        return $this->redirect()->toRoute('mon_hoc/crud', array('action'=>'index'));
         


    }

    public function deleteAction(){
    	// lấy id subjec
    	$value_id=$this->params('id');
    	// tạo điểm kết nối csdl bảng jos_subject_table
    	$jos_subject_table=$this->getServiceLocator()->get('MonHoc\Model\JosSubjectTable');
    	$subject_exist=$jos_subject_table->getSubjectByArrayConditionAndArrayColumn(array('value_id'=>$value_id), array('name'));
    	if(!$subject_exist){
    		$this->flashMessenger()->addErrorMessage('Lỗi, Môn học cần xóa không tồn tại. Vui lòng kiểm tra lại!');
    		return $this->redirect()->toRoute('mon_hoc/crud', array('action'=>'index'));
    	}
    	// xóa subject theo value_id
    	$jos_subject_table->deleteSubjectById($value_id);
    	$this->flashMessenger()->addSuccessMessage('Chúc mừng, xóa "Môn Học" thành công!');
    	return $this->redirect()->toRoute('mon_hoc/crud', array('action'=>'index'));
    }

   
}
