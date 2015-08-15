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

use Permission\Model\Entity\JosAdminResource;
use Permission\Form\EditPermissionForm;
use Permission\Form\EditResourceForm;

class PermissionController extends AbstractActionController
{
    public function indexAction()
    {
    }

    public function editAction(){
        $edit_resource_form=new EditResourceForm();
        // danh sách resources        
        $resource_table=$this->getServiceLocator()->get('Permission\Model\JosAdminResourceTable');
        $resources=$resource_table->getResourceByArrayConditionAndArrayColumn(array('resource_type'=>'Module', 'parent_id'=>0, 'is_hidden'=>0), array('resource_id', 'resource', 'resource_name'));
        // return array
        $return_array=array();
        $return_array['edit_resource_form']=$edit_resource_form;
        $return_array['resources']=$resources;
        // post
        $request=$this->getRequest();
        if($request->isPost()){
            $post=$request->getPost();
            // set form
            $edit_resource_form->setData($post);
            // kiểm tra nếu form hợp lệ
            if($edit_resource_form->isValid()){
                // kiểm tra resource id vừa nhập có tồn tại trong csdl và có phải là Module không
                $resource=$resource_table->getResourceByArrayConditionAndArrayColumn(array('resource_id'=>$post['resource_id'], 'resource_type'=>'Module'), array());
                // nếu tồn tại thì tiến hành sửa lại tên
                if($resource){
                    $new_resource=new JosAdminResource();
                    $new_resource->exchangeArray($resource[0]);
                    $new_resource->setResourceName($post['resource_name']);
                    $resource_table->saveResource($new_resource);
                    // thông báo lưu thành công
                    $this->flashMessenger()->addSuccessMessage('Thông báo, cập nhật thành công!');
                    return $this->redirect()->toRoute('permission/permission',array('action'=>'edit'));
                }
                // ngược lại không tồn tại hoặc không phải module
                else{
                    // thông báo không tìm thấy resource cần sửa
                    $this->flashMessenger()->addErrorMessage('Thông báo, không tìm thấy resource cần sửa. Vui lòng kiểm tra lại!');
                    return $this->redirect()->toRoute('permission/permission',array('action'=>'edit'));
                }
                
            }
            // ngược lại, nếu form không hợp lệ
            else{
                $return_array['edit_resource_form']=$edit_resource_form;
            }
        }       
        return $return_array;
    }

    public function updateAction(){
        //Auto Save All Controller and Action
        //truy cập tablegateway resource
        $resource_table=$this->getServiceLocator()->get('Permission\Model\JosAdminResourceTable');
        
        //Lấy danh sách module
        $manager= $this->getServiceLocator()->get('ModuleManager');
        $modules= $manager->getLoadedModules();
        $loaded_modules=array();
        $valmodule = array_keys($modules);

        //Xác định action bỏ qua
        $skip_actions_list    = array('notFoundAction', 'getMethodFromAction'); 
        foreach ($valmodule as $loaded_module){            
            $module_class = '\\' .$loaded_module . '\Module';
            $module_object = new $module_class;
            //truy cập phần cấu hình getConfig của từng module
            $config = $module_object->getConfig();
            //Lấy ra danh sách controller
            if (isset($config['controllers'])){
                $controllers = $config['controllers']['invokables'];
                foreach ($controllers as $key => $module_class) {                    
                    //Trả về danh sách các hàm trong class controller, bao gồm cả các hàm kế thừa
                    $tmp_array = get_class_methods($module_class);                    
                    //Lấy ra danh sách các hàm là action
                    foreach ($tmp_array as $action) {
                        if (substr($action, strlen($action)-6) === 'Action' && !in_array($action, $skip_actions_list)) {
                            //Chèn tên action vào mảng action controller
                            $array_modules[$loaded_module][$key][]=substr($action,0,(strlen($action)-6));
                        }
                    }
                }           
            }            
        } 

        
        $array_action_is_white_list=array(); 
        foreach ($array_modules as $key => $array_module) {            
            // kiểm tra tên module có tồn tại trong csdl chưa
            $module=$resource_table->getResourceByArrayConditionAndArrayColumn(array('resource_type'=>'Module', 'resource'=>$key, 'resource_object'=>'ACL'),array('resource_id'));
            // nếu chưa có thì lưu mới module
            if(!$module){
                $jos_admin_resource = new JosAdminResource();
                $jos_admin_resource -> setParentId(0);
                $jos_admin_resource -> setResource($key);
                $jos_admin_resource -> setResourceName($key.' Module');
                $jos_admin_resource -> setResourceType('Module');
                $jos_admin_resource -> setResourceObject('ACL');
                $jos_admin_resource -> setIsWhiteList(0);
                $jos_admin_resource -> setHidden(0);
                $resource_table->saveResource($jos_admin_resource);
                // đảm bảo module đã tồn tại trong csdl rồi
                $module=$resource_table->getResourceByArrayConditionAndArrayColumn(array('resource_type'=>'Module', 'resource'=>$key, 'resource_object'=>'ACL'),array('resource_id'));
            }
            $module_id=$module[0]['resource_id'];
            // luu controller  
            $array_controllers=$array_module;
            foreach ($array_controllers as $ctrl_key => $array_controller) {
                // get id controller
                $controller=$resource_table->getResourceByArrayConditionAndArrayColumn(array('resource_type'=>'Controller', 'resource'=>$ctrl_key, 'resource_object'=>'ACL', 'parent_id'=>$module_id), array('resource_id'));                
                // nếu chưa có controller
                if(!$controller){
                    $jos_admin_resource = new JosAdminResource();
                    $jos_admin_resource -> setParentId($module_id);
                    $jos_admin_resource -> setResource($ctrl_key);
                    $jos_admin_resource -> setResourceName($ctrl_key.' Controller');
                    $jos_admin_resource -> setResourceType('Controller');
                    $jos_admin_resource -> setResourceObject('ACL');
                    $jos_admin_resource -> setIsWhiteList(0);
                    $jos_admin_resource -> setHidden(0);
                    $resource_table->saveResource($jos_admin_resource);
                    // đảm bảo lấy được id controller
                    $controller=$resource_table->getResourceByArrayConditionAndArrayColumn(array('resource_type'=>'Controller', 'resource'=>$ctrl_key, 'resource_object'=>'ACL', 'parent_id'=>$module_id), array('resource_id')); 
                }
                
                $controller_id=$controller[0]['resource_id'];
                $array_actions=$array_controller;
                foreach ($array_actions as $array_action) {
                    $action=$resource_table->getResourceByArrayConditionAndArrayColumn(array('resource'=>$array_action, 'parent_id'=>$controller_id, 'resource_type'=>'Action', 'resource_object'=>'ACL'), array('resource_id'));
                    if(!$action){
                        $jos_admin_resource = new JosAdminResource();
                        $jos_admin_resource -> setParentId($controller_id);
                        $jos_admin_resource -> setResource($array_action);
                        $jos_admin_resource -> setResourceName($array_action.' Action');
                        $jos_admin_resource -> setResourceType('Action');
                        $jos_admin_resource -> setResourceObject('ACL');
                        $jos_admin_resource -> setIsWhiteList(0);   
                        $jos_admin_resource -> setHidden(0);       
                        $resource_table->saveResource($jos_admin_resource);
                    }
                }
            }
        }

        return $this->redirect()->toRoute('permission/permission');
        
    }
}
