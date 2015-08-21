<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/NamHoc for the canonical source repository
 * @copyright Copyright (c) 2005-2014 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace NamHoc\Controller;

use Zend\Mvc\Controller\AbstractActionController;

use NamHoc\Model\Entity\JosYear;
use NamHoc\Form\AddYearForm;

class NamHocController extends AbstractActionController
{
    public function indexAction()
    {
       // tạo mảng return
       $return_array=array();
       // tạo điểm truy cập csdl bảng jos_year
       $jos_year_table=$this->getServiceLocator()->get('NamHoc\Model\jos_year_table');
       // lấy tất cả dữ liệu bảng jos_year
       $jos_years=$jos_year_table->getYearByArrayConditionAndArrayColumn();
       $return_array['jos_years']=$jos_years;
       // tạo form add
       $add_form=new AddYearForm();
       $return_array['add_form']=$add_form;

       return $return_array;

    }

    public function kichHoatAction(){
    	// lấy year_id cần kích hoạt
    	$year_id=$this->params('id');
    	// tạo điểm truy cập csdl bảng jos_year
        $jos_year_table=$this->getServiceLocator()->get('NamHoc\Model\jos_year_table');
        // kiểm tra year_id có tồn tại không
        $year_exist=$jos_year_table->getYearByArrayConditionAndArrayColumn(array('year_id'=>$year_id));
        if(!$year_id){
        	$this->flashMessenger()->addErrorMessage('Lỗi, không tìm thấy năm cần kích hoạt. Vui lòng kiểm tra lại!');
        	return $this->redirect()->toRoute('nam_hoc/crud', array('action'=>'index'));
        }
        // cập nhật is_active=0 cho tất cả các năm 
        $all_years=$jos_year_table->getYearByArrayConditionAndArrayColumn(array('is_active'=>1));
        foreach ($all_years as $key => $year) {
        	$new_year=new JosYear();
	        $new_year->exchangeArray($year);
	        $new_year->setIsActive(0);
	        $jos_year_table->saveYear($new_year);
        }
        // cập nhật lại cột is_active=1 cho năm có year_id=$year_id
        $new_year=new JosYear();
        $new_year->exchangeArray($year_exist[0]);
        $new_year->setIsActive(1);
        $jos_year_table->saveYear($new_year);
        //cập nhật thành công
        $this->flashMessenger()->addSuccessMessage('Chúc mừng, Kích hoạt thành công. Bạn đang quản lý thông tin năm: '.$year_id.'!');
        return $this->redirect()->toRoute('nam_hoc/crud', array('action'=>'index'));
    }

    public function addAction(){
    	// tạo form add
        $add_form=new AddYearForm();
        $return_array['add_form']=$add_form;
        // kiểm tra post dữ liệu
    	$request=$this->getRequest();
    	if($request->isPost()){
    		$post=$request->getPost();
    		$add_form->setData($post);
    		if($add_form->isValid()){
    			// tạo điểm truy cập csdl bảng jos_year
        		$jos_year_table=$this->getServiceLocator()->get('NamHoc\Model\jos_year_table');
        		$check_year=$jos_year_table->getYearByArrayConditionAndArrayColumn(array('year_id'=>$post['year_id']), array('is_active'));
    			if($check_year){
    				$this->flashMessenger()->addErrorMessage('Lỗi, Năm học đã tồn tại. Vui lòng kiểm tra lại!');
        			return $this->redirect()->toRoute('nam_hoc/crud', array('action'=>'index'));
    			}
    			// tạo năm học mới
    			$new_year=new JosYear();
    			$new_year->setYearId($post['year_id']);
    			$new_year->setIsActive(0);
    			// lưu lại
    			$jos_year_table->saveYear($new_year);
    			//cập nhật thành công
		        $this->flashMessenger()->addSuccessMessage('Chúc mừng, tạo năm học mới thành công!');
		        return $this->redirect()->toRoute('nam_hoc/crud', array('action'=>'index'));
    		}
    	}
    	// lỗi thực thi không thành công
    	$this->flashMessenger()->addErrorMessage('Lỗi, Thực thi không thành công. Vui lòng kiểm tra lại!');
        return $this->redirect()->toRoute('nam_hoc/crud', array('action'=>'index'));
    }

    public function deleteAction(){
        // lấy id năm học cần xóa
        $year_id=$this->params('id');
        // tạo điểm kết nối csdl bảng jos_year
        $jos_year_table=$this->getServiceLocator()->get('NamHoc\Model\jos_year_table');
        // kiểm tra tồn tại
        $check_year=$jos_year_table->getYearByArrayConditionAndArrayColumn(array('year_id'=>$year_id), array('is_active'));
        if(!$check_year or $check_year[0]['is_active']==1){
            $this->flashMessenger()->addErrorMessage('Lỗi, Không tìm thấy "Năm học" cần xóa hoặc "Năm học" cần xóa đang hoạt động. Vui lòng kiểm tra lại!');
            return $this->redirect()->toRoute('nam_hoc/crud', array('action'=>'index'));
        }  
        // xóa năm học
        $jos_year_table->deleteYearByYearId($year_id);
        //cập nhật thành công
        $this->flashMessenger()->addSuccessMessage('Chúc mừng, Xóa năm học mới thành công!');
        return $this->redirect()->toRoute('nam_hoc/crud', array('action'=>'index'));
    

    }
}
