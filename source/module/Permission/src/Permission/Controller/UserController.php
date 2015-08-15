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
        // Kiểm tra có phải request POST
        if ($this->request->isPost()) {
            $post = $this->request->getPost();
            $login_form->setData($post);
            if($login_form->isValid()){
                $username=$post['username'];
                $password=$post['password'];
                // Xác định lớp chứng thực authentication
                $this->getAuthService()->getAdapter()->setIdentity($username)->setCredential($password);
                $result = $this->getAuthService()->authenticate();
                if ($result->isValid()) {
                    $storage = new MyAuthStorage();
                    $storage->forgetMe();
                    $jos_admin_resource_table=$this->getServiceLocator()->get('Permission\Model\JosAdminResourceTable');
                    $white_list=$jos_admin_resource_table->getResourceByUsername($username);
                    $this->getAuthService()->getStorage()->write(array('username'=>$username,'white_list' => $white_list));         
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
