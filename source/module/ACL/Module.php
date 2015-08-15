<?php
namespace ACL;

use Zend\Mvc\ModuleRouteListener;
use Zend\Mvc\MvcEvent;
use ACL\Utility\Acl;

class Module
{

    public function getConfig()
    {
        return array();
    }

    public function onBootstrap(MvcEvent $e)
    { // Phân quyền ACL
        $eventManager = $e->getApplication()->getEventManager();        
        $eventManager->attach(MvcEvent::EVENT_DISPATCH, array(
            $this,
            'boforeDispatch'
        ), 100);
    }

    function boforeDispatch(MvcEvent $event)
    {
        $sm = $event->getApplication()->getServiceManager();
        $auth = $sm->get('AuthService');
        $read=$sm->get("AuthService")->getStorage()->read();
        // nếu chưa có white_list
        if(!isset($read['white_list']) and (!$auth->hasIdentity() || !isset($read['username']))){
            // lấy white_list chưa đăng nhập
            $jos_admin_resource_table=$sm->get('Permission\Model\JosAdminResourceTable');
            $white_list=$jos_admin_resource_table->getResourceByWhiteList(1);
            $sm->get("AuthService")->getStorage()->write(array('white_list' => $white_list));
        
        }
        $read=$sm->get("AuthService")->getStorage()->read();
        $white_lists=$read['white_list']; 
        // url cần chuyển tới
        $params=$event->getRouteMatch()->getParams();
        $controller=$params['controller'];
        $action=$params['action'];
        // duyệt qua white_list nếu không nằm trong white list thì không có quyền
        $is_white_list=0;      
        foreach ($white_lists as $key => $white_list) {            
            if($white_list['controller']==$controller and $white_list['action']==$action){
                $is_white_list=1;
                break;            
            }
        }        
        if($is_white_list==0){
            die('Xin loi, Duong dan khong hop le. Vui long kiem tra lai!');
        }
         
    }

    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__
                )
            )
        );
    }
}