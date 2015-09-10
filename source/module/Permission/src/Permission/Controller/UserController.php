<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2014 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Permission\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Permission\Model\MyAuthStorage;
use Permission\Model\Entity\JosUserLasttimeLogin;

class UserController extends AbstractActionController
{
	protected $authservice;
	public function getAuthService()
    {
        if (! $this->authservice) {
            $authService = $this->getServiceLocator()->get('AuthService');
            $this->authservice = $authService;
        }
        return $this->authservice;
    }

    public function indexAction(){
        
    }

    public function loginAction()
    {               
        // kiểm tra nếu đã đăng nhập rồi thì không cho zô
        $read=$this->getAuthService()->getStorage()->read();
        if(isset($read['username']) and $read['username']){
            return $this->redirect()->toRoute('application/crud', array('action'=>'index'));
        }
        // tạo form login
        $login_form = $this->getServiceLocator()->get('Permission\Form\LoginForm');
        $return_array=array();
        $return_array['login_form']=$login_form; 
        // tạo url mặc định     
        $url_login='/';
        $return_array['url_login']=$url_login;
        // Kiểm tra có phải request POST
        if ($this->request->isPost()) {
            $post = $this->request->getPost();

            // lấy địa chỉ mặc định để quay lại
            if(isset($post['url'])){
                $url_login=$post['url'];
                $return_array['url_login']=$post['url'];
            }
            $login_form->setData($post);

            if($login_form->isValid()){
                $username=$post['username'];
                $password=$post['password'];
                // lấy dữ liệu theo user name
                $jos_users_table=$this->getServiceLocator()->get('Permission\Model\JosUsersTable');
                $user_exist=$jos_users_table->getGiangVienByArrayConditionAndArrayColumns(array('username'=>$username), array('password', 'id'));
                if($user_exist and isset($user_exist[0]['password'])){
                    $array_password=explode(':' , $user_exist[0]['password']);
                    //$password=$array_password[0].':'.md5($password);
                    $password=md5($password);
                    // Xác định lớp chứng thực authentication
                    $this->getAuthService()->getAdapter()->setIdentity($username)->setCredential($password);
                    $result = $this->getAuthService()->authenticate();
                    if ($result->isValid()) {
                        $storage = new MyAuthStorage();
                        $storage->forgetMe();
                        $jos_admin_resource_table=$this->getServiceLocator()->get('Permission\Model\JosAdminResourceTable');
                        $white_list=$jos_admin_resource_table->getResourceByUsername($username);
                        $this->getAuthService()->getStorage()->write(array('username'=>$username,'white_list' => $white_list));         
                        
                        // lastime login
                        $jos_lasttime_login_table=$this->getServiceLocator()->get('Permission\Model\JosUserLasttimeLoginTable');
                        $user_lastime_login_exist=$jos_lasttime_login_table->getJosUserLasttimeLoginByArrayConditionAndArrayColumn(array('user_id'=>$user_exist[0]['id']),array());
                        $new_lasttime_login=new JosUserLasttimeLogin();
                        if($user_lastime_login_exist){
                            $new_lasttime_login->exchangeArray($user_lastime_login_exist[0]);
                        }
                        $new_lasttime_login->setUserId($user_exist[0]['id']);
                        $new_lasttime_login->setLasttimeLogin(date("Y-m-d H:i:s"));
                        $jos_lasttime_login_table->saveJosUserLasttimeLogin($new_lasttime_login);
                        return $this->redirect()->toUrl($url_login);
                    }
                }
            }                
        }
        $return_array['login_form']=$login_form;
        return $return_array;
    }

    public function logoutAction(){
        $this->getAuthService()->getStorage()->write(array(''));
    	$this->getAuthService()->clearIdentity();
    	return $this->redirect()->toRoute('permission/user', array('action'=>'login'));
    }
}
