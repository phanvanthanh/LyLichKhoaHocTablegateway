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

use Application\Form\EditCertificateForm;
use ChungChiKhac\Model\Entity\JosCertificateUser;
use Application\FunctionClass\FunctionClass;

class IndexController extends AbstractActionController
{
    public function indexAction()
    {
    	//danh sách trả về
    	$return_array=array();

     	// lấy id giảng viên
     	$id=$this->params('id');
     	$return_array['id']=$id;
      // nếu tồn tại id giảng viên cần xem
      if($id){
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

        // lấy year_id default
        $jos_year_table=$this->getServiceLocator()->get('NamHoc\Model\JosYearTable');
        $year=$jos_year_table->getYearByArrayConditionAndArrayColumn(array('is_active'=>1));
        if(!$year or !isset($year[0]['year_id'])){
          die('Lỗi, Không xác định được năm cần sửa');
        }
        $year_id=$year[0]['year_id'];

        $service_config = $this->getServiceLocator()->get('config');
        $function_class = new FunctionClass();
        // THÔNG TIN CÁ NHÂN
          // 1
            // Chú ý: dữ liệu trả về của nhóm thông tin cá nhân là: infor_array_options và infor_jos_infors
            // kết nối bảng dữ liệu
            $infor_table_jos_attribute_option=$this->getServiceLocator()->get('Attribute\Model\JosAttributeOptionTable');
            $infor_table_jos_infor=$this->getServiceLocator()->get('Application\Model\JosInfomationTable');
            $jos_attribute_table=$this->getServiceLocator()->get('Attribute\Model\JosAttributeTable');
            // lấy dữ liệu attribute option
            $infor_array_get_options=$infor_table_jos_attribute_option->getAllAttributeOptionByYearActive(array(), array('key', 'label'), array('attribute_code'));
            $infor_array_options=array();
            $infor_var_attribute_code='';
            foreach ($infor_array_get_options as $infor_array_get_option) {
              if($infor_var_attribute_code!=$infor_array_get_option['attribute_code']){
                $infor_var_attribute_code=$infor_array_get_option['attribute_code'];
                if(!isset($infor_array_options[$infor_var_attribute_code])){
                  $infor_array_options[$infor_var_attribute_code]=array();
                }              
              }
              $infor_array_options[$infor_var_attribute_code][$infor_array_get_option['key']]=$infor_array_get_option['label'];
            }
            $return_array['infor_array_options']=$infor_array_options;
            // lấy dữ liệu information            
            $infor_jos_infors=$infor_table_jos_infor->getInfomationAttributeByArrayConditionAndArrayColumns(array('t1.user_id'=>$id, 't2.year_id'=>$year_id), array('value'), array('attribute_code', 'frontend_label', 'frontend_input'));
            // nếu chưa có jos infor nào thì hiển thị dữ liệu rỗng cho từng attribute code
            if(!$infor_jos_infors){
              // lấy tất cả attribute ở năm đang active            
              $infor_jos_infors=$jos_attribute_table->getAttributeByYearActive(array('attribute_code', 'frontend_label', 'frontend_input'));
            }
            $return_array['infor_jos_infors']=$infor_jos_infors;

          // 2
            // điểm truy cập csdl
              $certificate_table_jos_certificate=$this->getServiceLocator()->get('ChungChiKhac\Model\JosCertificateTable');
              $certificate_table_jos_certificate_user=$this->getServiceLocator()->get('ChungChiKhac\Model\JosCertificateUserTable');
              //  lấy tất cả chứng chỉ trong năm đang active
              $certificate_infors=$certificate_table_jos_certificate_user->getCertificateUserAndCertificateByArrayConditionAndArrayColumns(array('t1.user_id'=>$id, 't2.year_id'=>$year_id), array('certificate_id', 'level', 'note'), array('name'));
              if(!$certificate_infors){
                $certificate_infors=$certificate_table_jos_certificate->getCertificateByYearActive();
              }
              $return_array['certificate_infors']=$certificate_infors;
              $source_model=array();
              $source_model['source_model']['cetificate']='ngoai_ngu';
              // truy cập vào config lấy ra danh sách config
              $ngoai_ngu = $function_class->selectElementArray(array('array_element' => $source_model, 'array' => $service_config ));
              $return_array['ngoai_ngu']=$ngoai_ngu;
      }
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
          // lấy year_id default
          $jos_year_table=$this->getServiceLocator()->get('NamHoc\Model\JosYearTable');
          $year=$jos_year_table->getYearByArrayConditionAndArrayColumn(array('is_active'=>1));
          if(!$year or !isset($year[0]['year_id'])){
            die('Lỗi, Không xác định được năm cần sửa');
          }
          $year_id=$year[0]['year_id'];
          // THÔNG TIN CÁ NHÂN 
            // 1. 
              // lấy tất cả attribute ở năm đang active
              $jos_attribute_table=$this->getServiceLocator()->get('Attribute\Model\JosAttributeTable');
              $all_attributes=$jos_attribute_table->getAttributeByYearActive();
              $return_array['all_attributes']=$all_attributes;
              // cập nhật thông tin cá nhân form     
              $edit_infor_form=new EditInforForm($this->getServiceLocator(), $all_attributes);
              // lấy dữ liệu information
              $jos_infor_table=$this->getServiceLocator()->get('Application\Model\JosInfomationTable');
              $jos_infors=$jos_infor_table->getInfomationAttributeByArrayConditionAndArrayColumns(array('t1.user_id'=>$id, 't2.year_id'=>$year_id), array('value'), array('attribute_code'));
              // nếu tồn tại dữ liệu của người dùng này, thì tùy chỉnh lại dữ liệu để set vào form edit infor form
              if($jos_infors){
                foreach ($jos_infors as $key => $jos_infor) {
                  $data_edit_infor_form[$jos_infor['attribute_code']]=$jos_infor['value'];
                }
                // set dữ liệu vào form
                if($data_edit_infor_form){
                  $edit_infor_form->setData($data_edit_infor_form);
                }
              }                          
              $return_array['edit_infor_form']=$edit_infor_form;
            // 2
              // điểm truy cập csdl
              $certificate_table_jos_certificate=$this->getServiceLocator()->get('ChungChiKhac\Model\JosCertificateTable');
              $certificate_table_jos_certificate_user=$this->getServiceLocator()->get('ChungChiKhac\Model\JosCertificateUserTable');
              //  lấy tất cả chứng chỉ trong năm đang active
              $certificate_lists=$certificate_table_jos_certificate->getCertificateByYearActive();
              $return_array['certificate_lists']=$certificate_lists;
              // tạo form certificate
              $certificate_edit_form=new EditCertificateForm($this->getServiceLocator(), $certificate_lists);
              
              // lấy dữ liệu đã nhập trước đó set vào form để hiển thị
              $certificate_infors=$certificate_table_jos_certificate_user->getCertificateUserAndCertificateByArrayConditionAndArrayColumns(array('t1.user_id'=>$id, 't2.year_id'=>$year_id), array('certificate_id', 'level', 'note'), array('name'));
              $certificate_form_data=array();
              if($certificate_infors){
                foreach ($certificate_infors as $key => $certificate_infor) {
                  $certificate_id='certificate_id_'.$certificate_infor['certificate_id'];
                  $certificate_form_data[$certificate_id]=$certificate_infor['certificate_id'];
                  
                  $certificate_name='certificate_name_'.$certificate_infor['certificate_id'];
                  $certificate_form_data[$certificate_name]=$certificate_infor['name'];
                  
                  if($certificate_infor['name']=='Ngoại ngữ'){
                    //var_dump($certificate_infor['note']);
                    $certificate_loai_ngoai_ngu='certificate_loai_ngoai_ngu_'.$certificate_infor['certificate_id'];
                    $certificate_form_data[$certificate_loai_ngoai_ngu]=$certificate_infor['note'];

                    $certificate_level='certificate_level_'.$certificate_infor['certificate_id'];
                    $certificate_form_data[$certificate_level]=$certificate_infor['level'];
                  }
                  else{
                    $certificate_note='certificate_note_'.$certificate_infor['certificate_id'];
                    $certificate_form_data[$certificate_note]=$certificate_infor['note'];

                    $certificate_check='certificate_check_'.$certificate_infor['certificate_id'];
                    $certificate_form_data[$certificate_check]=1;
                    if($certificate_infor['note']=='0'){
                      $certificate_form_data[$certificate_check]=0;
                      $certificate_form_data[$certificate_note]='';
                    }
                  } 
                }
                if($certificate_form_data){
                  $certificate_edit_form->setData($certificate_form_data);
                }
              }
              $return_array['certificate_edit_form']=$certificate_edit_form;
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
                  $error.=' '.$key.',';
                  continue;
                }
                else{
                  if($attribute_exist[0]['frontend_input']=='Select'){
                    // kiểm tra dữ liệu select post qua có tồn tại không
                    $option_exist=$jos_attribute_option_table->getAttributeOptionByArrayConditionAndArrayColumn(array('attribute_id'=>$attribute_exist[0]['attribute_id'], 'key'=>$p));
                    if(!$option_exist){
                      $error.=' '.$key.',';
                      $p='';
                    }
                  }
                }
                // kiểm tra bảng infor đã có dòng thông tin theo attribute code chưa
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
                $error='dữ liệu cột: '.$error.' nhập không đúng. Vui lòng kiểm tra lại!';
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

    

    public function ajaxCertificateAction(){
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
              // điểm truy cập csdl
              $certificate_table_jos_certificate=$this->getServiceLocator()->get('ChungChiKhac\Model\JosCertificateTable');
              $certificate_table_jos_certificate_user=$this->getServiceLocator()->get('ChungChiKhac\Model\JosCertificateUserTable');
              //  lấy tất cả chứng chỉ trong năm đang active
              $certificate_lists=$certificate_table_jos_certificate->getCertificateByYearActive();
              // tạo form certificate
              $certificate_edit_form=new EditCertificateForm($this->getServiceLocator(), $certificate_lists);
              $certificate_edit_form->setData($post);
              if($certificate_edit_form->isValid()){
                $error='';
                foreach ($certificate_lists as $key => $certificate_list) {
                  // xóa bỏ dữ liệu
                  $certificate_table_jos_certificate_user->deleteCertificateUser(array('certificate_id'=>$certificate_list['value_id'], 'user_id'=>$id));
                  $certificate_user_new=new JosCertificateUser();
                  if($certificate_list['name']=='Ngoại ngữ'){
                    $certificate_user_new->setCertificateId($certificate_list['value_id']);
                    $certificate_user_new->setUserId($id);
                    $certificate_level  = '';
                    if(isset($post['certificate_level_'.$certificate_list['value_id']])){
                      $certificate_level   =$post['certificate_level_'.$certificate_list['value_id']];
                    }
                    $certificate_user_new->setLevel($certificate_level);
                    $certificate_note='';
                    if(isset($post['certificate_loai_ngoai_ngu_'.$certificate_list['value_id']])){
                      $certificate_note   =$post['certificate_loai_ngoai_ngu_'.$certificate_list['value_id']];
                    }
                    $certificate_user_new->setNote($certificate_note);
                  }
                  else{
                    $certificate_user_new->setCertificateId($certificate_list['value_id']);
                    $certificate_user_new->setUserId($id);
                    $certificate_level  = '';
                    $certificate_user_new->setLevel($certificate_level);
                    $certificate_note=0;
                    if(isset($post['certificate_check_'.$certificate_list['value_id']]) and isset($post['certificate_note_'.$certificate_list['value_id']]) and $post['certificate_check_'.$certificate_list['value_id']]==1){
                      $certificate_note   =$post['certificate_note_'.$certificate_list['value_id']];
                    }
                    $certificate_user_new->setNote($certificate_note);
                  }
                  $certificate_table_jos_certificate_user->saveCertificateUser($certificate_user_new);

                }

                // cập nhật thành công
                if(!$error){
                  $response[]=array('error'=>0);
                }
                // có một số lỗi trong quá trình cập nhật
                else{
                  $error='dữ liệu cột: '.$error.' nhập không đúng. Vui lòng kiểm tra lại!';
                  $response[]=array('error'=>1, 'error_name'=>$error);
                }
                
                $json = new JsonModel($response);
                return $json;
              } 
              $response[]=array('error'=>1, 'error_name'=>'form! không hợp lệ vui lòng kiểm tra lại');
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
