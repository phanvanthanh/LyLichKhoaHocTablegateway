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
       
    }

    public function editAllProfileAction(){
    	
    }
}
