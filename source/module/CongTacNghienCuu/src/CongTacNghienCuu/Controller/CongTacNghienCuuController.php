<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/CongTacNghienCuu for the canonical source repository
 * @copyright Copyright (c) 2005-2014 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace CongTacNghienCuu\Controller;

use Zend\Mvc\Controller\AbstractActionController;

use CongTacNghienCuu\Form\AddScienceActivityForm;
use CongTacNghienCuu\Form\EditScienceActivityForm;
use CongTacNghienCuu\Model\Entity\JosScienceActivity;

class CongTacNghienCuuController extends AbstractActionController
{
    public function indexAction()
    {
    	// return array
    	$return_array=array();

        // lấy danh sách tất cả các hoạt động nghiên cứu khoa học, theo year_id đac được active
   		$jos_science_activity_table=$this->getServiceLocator()->get('CongTacNghienCuu\Model\JosScienceActivityTable');
   		$science_activitys=$jos_science_activity_table->getScienceActivityByYearActive(array('name', 'value_id'));
    	$return_array['science_activitys']=$science_activitys;

    	// edit form
    	$edit_form= new EditScienceActivityForm();
    	$return_array['edit_form']=$edit_form;

    	// add form
    	$add_form= new AddScienceActivityForm();
    	$return_array['add_form']=$add_form;
    	
    	return $return_array;
    }

    public function addAction(){
    	// khai báo model bảng jos_year
    	$jos_year_table=$this->getServiceLocator()->get('NamHoc\Model\JosYearTable');
        // lấy year_id default
    	$years=$jos_year_table->getYearByArrayConditionAndArrayColumn(array('is_active'));
        // không tồn tại year default
    	if(!$years){
    		$this->flashMessenger()->addErrorMessage('Lỗi. Bạn muốn thêm "Hoạt Động Nghiên Cứu" vào năm học nào? Vui lòng kiểm tra lại!');
    		return $this->redirect()->toRoute('cong_tac_nghien_cuu/crud', array('action'=>'index'));
    	}
    	// add form
    	$add_form= new AddScienceActivityForm();
    	$return_array['add_form']=$add_form;
    	// kiểm tra post dữ liệu
    	$request=$this->getRequest();
    	if($request->isPost()){
    		$post=$request->getPost();
    		$add_form->setData($post);
    		if($add_form->isValid()){
                // khai báo model bảng jos_science_activity
                $jos_science_activity_table=$this->getServiceLocator()->get('CongTacNghienCuu\Model\JosScienceActivityTable');
    			// kiểm tra tên hoạt động nghiên cứu vừa post có tồn tại chưa.
                $jos_science_activity_exist=$jos_science_activity_table->getScienceActivityByArrayConditionAndArrayColumn(array('name'=>$post['name'], 'year_id'=>$years[0]['year_id']), array('value_id'));
                // nếu dữ liệu post đã tồn tại
                if($jos_science_activity_exist){
                    $this->flashMessenger()->addErrorMessage('Lỗi. "Hoạt Động Nghiên Cứu" Đã tồn tài. Vui lòng kiểm tra lại!');
                    return $this->redirect()->toRoute('cong_tac_nghien_cuu/crud', array('action'=>'index'));
                }
                // tạo jos_science_activity mới
                $jos_science_activity=new JosScienceActivity();
    			$jos_science_activity->setName($post['name']);
    			$jos_science_activity->setYearId($years[0]['year_id']);
                // lưu jos_science_activity mới vào csdl
    			$jos_science_activity_table->saveScienceActivity($jos_science_activity);
                // thông báo lưu thành công
    			$this->flashMessenger()->addSuccessMessage('Chúc mừng, thêm công tác nghiên cứu thành công.');
    			return $this->redirect()->toRoute('cong_tac_nghien_cuu/crud', array('action'=>'index'));
    		}
    	}    	
        // thông báo lưu thất bại
		$this->flashMessenger()->addErrorMessage('Thông báo, lỗi thực thi. Vui lòng kiểm tra lại!');
		return $this->redirect()->toRoute('cong_tac_nghien_cuu/crud', array('action'=>'index'));

    }

    public function editAction(){
    	// edit form
    	$edit_form= new EditScienceActivityForm();
    	$return_array['edit_form']=$edit_form;
    	// kiểm tra post dữ liệu
    	$request=$this->getRequest();
    	if($request->isPost()){    		
    		$post=$request->getPost();    		
    		$edit_form->setData($post);
    		if($edit_form->isValid()){                
                $jos_science_activity_table=$this->getServiceLocator()->get('CongTacNghienCuu\Model\JosScienceActivityTable');
                // kiểm tra id vừa post có tồn tại không
                $jos_science_activity_edit=$jos_science_activity_table->getScienceActivityByArrayConditionAndArrayColumn(array('value_id'=>$post['id']));
                if(!$jos_science_activity_edit){
                    $this->flashMessenger()->addErrorMessage('Lỗi, "Hoạt Động Nghiên Cứu" cần sửa không tồn tại. Vui lòng kiểm tra lại!');
                    return $this->redirect()->toRoute('cong_tac_nghien_cuu/crud', array('action'=>'index'));
                }
                // kiểm tra tên hoạt động mới có tồn tại chưa
                $jos_science_activity_exist=$jos_science_activity_table->getScienceActivityByArrayConditionAndArrayColumn(array('name'=>$post['name'], 'year_id'=>$jos_science_activity_edit[0]['year_id']), array('value_id'));
                if($jos_science_activity_exist and $jos_science_activity_exist[0]['value_id']!=$post['id']){
                    $this->flashMessenger()->addErrorMessage('Lỗi, "Hoạt Động Nghiên Cứu" này đã tồn tại. Vui lòng kiểm tra lại!');
                    return $this->redirect()->toRoute('cong_tac_nghien_cuu/crud', array('action'=>'index'));
                }

                // sửa lại hoạt động nghiên cứu
    			$jos_science_activity=new JosScienceActivity();
    			$jos_science_activity->exchangeArray($jos_science_activity_edit[0]);
    			$jos_science_activity->setName($post['name']);
    			$jos_science_activity_table->saveScienceActivity($jos_science_activity);
    			$this->flashMessenger()->addSuccessMessage('Chúc mừng, thêm công tác nghiên cứu thành công.');
    			return $this->redirect()->toRoute('cong_tac_nghien_cuu/crud', array('action'=>'index'));
    		}
    	}   
        // Thông báo lỗi và trả về trang index 	
		$this->flashMessenger()->addErrorMessage('Thông báo, lỗi thực thi. Vui lòng kiểm tra lại!');
		return $this->redirect()->toRoute('cong_tac_nghien_cuu/crud', array('action'=>'index'));
    }

    public function deleteAction(){
        // lấy id "cong tác nghiên cứu khoa học" cần xóa
        $id=$this->params('id');
        if(!$id){
            $this->flashMessenger()->addErrorMessage('Thông báo, không tìm thấy "Hoạt Động Nghiên Cứu" cần xóa. Vui lòng kiểm tra lại!');

            return $this->redirect()->toRoute('cong_tac_nghien_cuu/crud', array('action'=>'index'));
        }
        // tạo điểm truy cập csdl bảng jos_science_activity
        $jos_science_activity_table=$this->getServiceLocator()->get('CongTacNghienCuu\Model\JosScienceActivityTable');
        // kiểm tra hoạt động nghiên cứu khoa học vừa post qua có tồn tại không
        $jos_science_activity_exist=$jos_science_activity_table->getScienceActivityByArrayConditionAndArrayColumn(array('value_id'=>$id), array('year_id'));
        // nếu không tồn tại thì thông báo không xóa được
        if(!$jos_science_activity_exist){
            $this->flashMessenger()->addErrorMessage('Thông báo, không tìm thấy "Hoạt Động Nghiên Cứu" cần xóa. Vui lòng kiểm tra lại!');
            return $this->redirect()->toRoute('cong_tac_nghien_cuu/crud', array('action'=>'index'));
        }
        // nếu tồn tại thì tiến hành xóa
        $jos_science_activity_table->deleteScienceActivityById($id);
        // quay lại trang index khi xóa thành công
        $this->flashMessenger()->addSuccessMessage('Chúc mừng, xóa "Hoạt Động Nghiên Cứu" thành công!');
        return $this->redirect()->toRoute('cong_tac_nghien_cuu/crud', array('action'=>'index'));
    }
}
