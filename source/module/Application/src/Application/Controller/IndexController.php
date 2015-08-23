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
        $id=$post['id'];
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
            $response[]=array('error'=>0);
            $json = new JsonModel($response);
            return $json;
          }
        }        
      }        
      // không có quyền sửa
      $response[]=array('error'=>1);
      $json = new JsonModel($response);
      return $json;
      
    }

    public function editAllProfileAction(){
    	
    }
}
