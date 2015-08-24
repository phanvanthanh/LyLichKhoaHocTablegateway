<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2014 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\View\Model\JsonModel;

use Application\Form\EditInforForm;
use Application\Model\Entity\JosInfomation;

class IndexController extends AbstractActionController
{
    public function indexAction()
    {
    	//danh sách trả về
    	$return_array=array();

     	// lấy id giảng viên
     	$id=$this->params('id');
     	$return_array['id']=$id;
      // nếu chưa đăng nhập
      $user_id=0;
      $return_array['edit_all_profile']=0;
      // nếu đã đăng nhập
      $read=$this->getServiceLocator()->get('AuthService')->getStorage()->read();
      if(isset($read['username']) and $read['username']){
        // tạo điểm truy cập jos_users table
        $jos_users_table=$this->getServiceLocator()->get('Permission\Model\JosUsersTable');
        // lấy id user theo username
        $user=$jos_users_table->getGiangVienByArrayConditionAndArrayColumns(array('username'=>$read['username']), array('id'));
        // nếu username tồn tại trong csdl
        if($user){
          // đặt lại user_id
          $user_id=$user[0]['id'];
        }       
        // Kiểm tra nếu có quyền editAllProfile        
        foreach ($read['white_list'] as $key => $white_list) {
            if($white_list['action']=='editAllProfile'){
                $return_array['edit_all_profile']=1;
                break;
            }
        }
      }
      $return_array['user_id']=$user_id;      
      

     	// trả dữ liệu ra view
     	return $return_array;


    }

    public function editAction()
    {
      $id=$this->params('id');
      $return_array['id']=$id;
      // nếu đã đăng nhập
      $read=$this->getServiceLocator()->get('AuthService')->getStorage()->read();
      if(isset($read['username']) and $read['username']){
        // tạo điểm truy cập jos_users table
        $jos_users_table=$this->getServiceLocator()->get('Permission\Model\JosUsersTable');
        // kiểm tra user đang đăng nhập
        $user=$jos_users_table->getGiangVienByArrayConditionAndArrayColumns(array('username'=>$read['username']));
        // kiểm tra user có quyền editAllProfile không
        $white_lists=$read['white_list'];
        $edit_all_profile=0;
        foreach ($white_lists as $key => $white_list) {
          if($white_list['action']=='editAllProfile'){
            $edit_all_profile=1;
          }
        }
        // nếu id cần sửa bằng với user_id đang đăng nhập hoặc có quyền editAllProfile
        if($user and $user[0]['id']==$id or $edit_all_profile==1){
          // THÔNG TIN CÁ NHÂN 
            // lấy tất cả attribute ở năm đang active
            $jos_attribute_table=$this->getServiceLocator()->get('Attribute\Model\JosAttributeTable');
            $all_attributes=$jos_attribute_table->getAttributeByYearActive();
            $return_array['all_attributes']=$all_attributes;
            // cập nhật thông tin cá nhân      
            $edit_infor_form=new EditInforForm($this->getServiceLocator(), $all_attributes);
            $return_array['edit_infor_form']=$edit_infor_form;

          // PHẦN KHÁC

          return $return_array;
        }         
      }
      $this->flashMessenger()->addErrorMessage('Lỗi, bạn không có quyền truy cập. Vui lòng kiểm tra lại!');
      return $this->redirect()->toRoute('application/crud', array('action'=>'index', 'id'=>$id));

    }

    // lưu lại thông tin cá nhân
    public function editInforAction(){
      $this->layout('layout/ajax_layout');
      $response=array();
        
      $request=$this->getRequest();
      if($request->isXmlHttpRequest()) // kiểm tra nếu post dữ liệu
      {
        $post=$request->getPost();
        $id=$post['id']; unset($post['id']);
        // nếu đã đăng nhập
        $read=$this->getServiceLocator()->get('AuthService')->getStorage()->read();
        if(isset($read['username']) and $read['username']){
          // tạo điểm truy cập jos_users table
          $jos_users_table=$this->getServiceLocator()->get('Permission\Model\JosUsersTable');
          // kiểm tra user đang đăng nhập
          $user=$jos_users_table->getGiangVienByArrayConditionAndArrayColumns(array('username'=>$read['username']));
          // kiểm tra user có quyền editAllProfile không
          $white_lists=$read['white_list'];
          $edit_all_profile=0;
          foreach ($white_lists as $key => $white_list) {
            if($white_list['action']=='editAllProfile'){
              $edit_all_profile=1;
            }
          }
          // nếu id cần sửa bằng với user_id đang đăng nhập hoặc có quyền editAllProfile
          if($user and $user[0]['id']==$id or $edit_all_profile==1){
            // có quyền sửa
              // lấy year_id default
              $jos_year_table=$this->getServiceLocator()->get('NamHoc\Model\JosYearTable');
              $year=$jos_year_table->getYearByArrayConditionAndArrayColumn(array('is_active'=>1));
              if(!$year or !isset($year[0]['year_id'])){
                $response[]=array('error'=>1, 'error_name'=>'Lỗi, Không xác định được năm cần sửa.');
                $json = new JsonModel($response);
                return $json;
              }
              $year_id=$year[0]['year_id'];
              // khai báo truy cập csdl bảng jos_information
              $jos_infor_table=$this->getServiceLocator()->get('Application\Model\JosInfomationTable');
              $jos_attribute_table=$this->getServiceLocator()->get('Attribute\Model\JosAttributeTable');
              $jos_attribute_option_table=$this->getServiceLocator()->get('Attribute\Model\JosAttributeOptionTable');
              $error='';
              foreach ($post as $key => $p) {
                // kiểm tra attribute_code post qua có tồn tại không
                $attribute_exist=$jos_attribute_table->getAttributeByArrayConditionAndArrayColumn(array('year_id'=>$year_id, 'attribute_code'=>$key));
                //nếu không tồn tại thì bỏ qua
                if(!$attribute_exist){
                  $error.=' không tìm thấy '.$key.' đã nhập |';
                  continue;
                }
                else{
                  if($attribute_exist[0]['frontend_input']=='Select'){
                    // kiểm tra dữ liệu select post qua có tồn tại không
                    $option_exist=$jos_attribute_option_table->getAttributeOptionByArrayConditionAndArrayColumn(array('attribute_id'=>$attribute_exist[0]['attribute_id'], 'key'=>$p));
                    if(!$option_exist){
                      $error.=' dữ liệu dòng '.$key.' đã nhập không đúng |';
                      continue;
                    }
                  }
                }
                // kiểm tra bang infor đã có dòng thông tin theo attribute code chưa
                $infor_exist=$jos_infor_table->getInfomationAttributeByArrayConditionAndArrayColumns(array('t1.user_id'=>$id, 't2.attribute_code'=>$key, 't2.year_id'=>$year_id), array(), array());
                $new_infor=new JosInfomation();
                // nếu tồn tại thì sửa
                if(isset($infor_exist[0])){                  
                  $new_infor->exchangeArray($infor_exist[0]);
                  $new_infor->setValue($p);
                }
                // ngược lại thì add
                else{
                  $new_infor->setValue($p);
                  $new_infor->setUserId($id);
                  $new_infor->setAttributeId($attribute_exist[0]['attribute_id']);
                }
                // lưu lại
                $jos_infor_table->saveJosInfor($new_infor);
              }
              // cập nhật thành công
              if(!$error){
                $response[]=array('error'=>0);
              }
              // có một số lỗi trong quá trình cập nhật
              else{
                $response[]=array('error'=>1, 'error_name'=>$error);
              }
              
              $json = new JsonModel($response);
              return $json;
          }
        }        
      }        
      // không có quyền sửa
      $response[]=array('error'=>1, 'error_name'=>'Lỗi, Bạn không có quyền truy cập.');
      $json = new JsonModel($response);
      return $json;
      
    }

    public function editAllProfileAction(){
    	
    }
}
