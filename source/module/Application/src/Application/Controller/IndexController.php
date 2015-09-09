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
use Application\Form\AddCongTacGiangDayForm;
use Application\Form\EditCongTacGiangDayForm;
use Application\Form\EditCTNCForm;
use Application\Form\AddFutureHDNCKHForm;
use Application\Form\EditFutureHDNCKHForm;
use Application\Form\AddOrtherWorkForm;
use Application\Form\EditOrtherWorkForm;
use Application\Form\AddFutureOrtherWorkForm;
use Application\Form\EditFutureOrtherWorkForm;
use Application\Form\AddFutureStudyForm;
use Application\Form\EditFutureStudyForm;
use Application\Form\AddScientificReportForm;
use Application\Form\EditScientificReportForm;
use Application\Model\Entity\JosTeaching;
use Application\Model\Entity\JosFutureTeaching;
use Application\Model\Entity\JosScienceResearchOfUser;
use Application\Model\Entity\JosFutureScienceResearchOfUser;
use Application\Model\Entity\JosOrtherWork;
use Application\Model\Entity\JosFutureOrtherWork;
use Application\Model\Entity\JosFutureStudy;
use Application\Model\Entity\JosScientificReport;

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
        $return_array['can_edit']=0;
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
                $return_array['can_edit']=1;
                break;
            }
          }
        }
        if($user_id==$id){
          $return_array['can_edit']=1;
        }

        // biến cần sử dụng
        $service_config = $this->getServiceLocator()->get('config');
        $function_class = new FunctionClass();

        $jos_year_table=$this->getServiceLocator()->get('NamHoc\Model\JosYearTable');
        $infor_table_jos_attribute_option=$this->getServiceLocator()->get('Attribute\Model\JosAttributeOptionTable');
        $infor_table_jos_infor=$this->getServiceLocator()->get('Application\Model\JosInfomationTable');
        $jos_attribute_table=$this->getServiceLocator()->get('Attribute\Model\JosAttributeTable');
        $certificate_table_jos_certificate=$this->getServiceLocator()->get('ChungChiKhac\Model\JosCertificateTable');
        $certificate_table_jos_certificate_user=$this->getServiceLocator()->get('ChungChiKhac\Model\JosCertificateUserTable');
        $teaching_table=$this->getServiceLocator()->get('Application\Model\JosTeachingTable');     
        $future_teaching_table=$this->getServiceLocator()->get('Application\Model\JosFutureTeachingTable');     
        $science_research_Table=$this->getServiceLocator()->get('Application\Model\JosScienceResearchOfUserTable');     
        $science_activity_Table=$this->getServiceLocator()->get('CongTacNghienCuu\Model\JosScienceActivityTable');
        $future_science_research_Table=$this->getServiceLocator()->get('Application\Model\JosFutureScienceResearchOfUserTable');
        $orther_work_table=$this->getServiceLocator()->get('Application\Model\JosOrtherWorkTable');
        $future_orther_work_table=$this->getServiceLocator()->get('Application\Model\JosFutureOrtherWorkTable');
        $future_study_table=$this->getServiceLocator()->get('Application\Model\JosFutureStudyTable');
        $scientific_report_table=$this->getServiceLocator()->get('Application\Model\JosScientificReportTable');
        
        // lấy dữ liệu mặc định default        
        $year=$jos_year_table->getYearByArrayConditionAndArrayColumn(array('is_active'=>1));
        if(!$year or !isset($year[0]['year_id'])){
          die('Lỗi, Không xác định được năm cần sửa');
        }
        $year_id=$year[0]['year_id'];

        /*
          THÔNG TIN CÁ NHÂN: phần 1
        */
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
            $all_attributes=$jos_attribute_table->getAttributeByYearActive();
            $infor_jos_infors=$all_attributes;           
          }
          $return_array['infor_jos_infors']=$infor_jos_infors;
          // nếu người dùng hiện tại có quyền sửa
          if($return_array['can_edit']==1){
            if(!isset($all_attributes)){
              $all_attributes=$jos_attribute_table->getAttributeByYearActive();
            }
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
              if($data_edit_infor_form){
                $edit_infor_form->setData($data_edit_infor_form);
              }
            }                          
            $return_array['edit_infor_form']=$edit_infor_form;
          }
        /*
          THÔNG TIN CÁ NHÂN: phần 2
        */
          //  lấy tất cả chứng chỉ của user trong năm đang active
          $certificate_infors=$certificate_table_jos_certificate_user->getCertificateUserAndCertificateByArrayConditionAndArrayColumns(array('t1.user_id'=>$id, 't2.year_id'=>$year_id), array('certificate_id', 'level', 'note'), array('name'));
          // nếu không có dữ liệu thì lấy mặc định ra hiển thị đỡ
          if(!$certificate_infors){
            $certificate_lists=$certificate_table_jos_certificate->getCertificateByYearActive();
            $certificate_infors=$certificate_lists;
          }
          $return_array['certificate_infors']=$certificate_infors;
          $source_model=array();
          $source_model['source_model']['cetificate']='ngoai_ngu';
          // truy cập vào config lấy ra danh sách config
          $ngoai_ngu = $function_class->selectElementArray(array('array_element' => $source_model, 'array' => $service_config ));
          $return_array['ngoai_ngu']=$ngoai_ngu;
          // nếu người dùng hiện tại có quyền sửa
          if($return_array['can_edit']==1){
            //  lấy tất cả chứng chỉ trong năm đang active
            if(!isset($certificate_lists)){
              $certificate_lists=$certificate_table_jos_certificate->getCertificateByYearActive();
            }
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
          }
        /*
          KINH NGHIỆM LÀM VIỆC
            Phần 1: Công tác giảng dạy
        */
          $teaching_alls=$teaching_table->getTeachingAndSubjectByArrayConditionAndArrayColumns(array('t1.user_id'=>$id, 't2.year_id'=>$year_id), array(), array('name'));
          $return_array['teaching_alls']=$teaching_alls;
          if($return_array['can_edit']==1){
            $teaching_edit_form=new EditCongTacGiangDayForm($this->getServiceLocator());
            $teaching_add_form=new AddCongTacGiangDayForm($this->getServiceLocator());
            $return_array['teaching_edit_form']=$teaching_edit_form;
            $return_array['teaching_add_form']=$teaching_add_form;

            // truy cập vào config lấy ra danh sách config bậc học
            $bac_hoc=array();
            $bac_hoc_source_model=array();
            $bac_hoc_source_model['source_model']['application']='bac_hoc';
            $bac_hoc = $function_class->selectElementArray(array('array_element' => $bac_hoc_source_model, 'array' => $service_config ));
            $return_array['bac_hoc']=$bac_hoc;

            // truy cập vào config lấy ra danh sách config hệ đào tạo
            $he_dao_tao=array();
            $he_dao_tao_source_model=array();
            $he_dao_tao_source_model['source_model']['application']='he_dao_tao';
            $he_dao_tao = $function_class->selectElementArray(array('array_element' => $he_dao_tao_source_model, 'array' => $service_config ));
            $return_array['he_dao_tao']=$he_dao_tao;

          }

        /*
          KINH NGHIỆM LÀM VIỆC
            Phần 2: Công tác nghiên cứu khoa học
        */
          $science_activity_alls=$science_activity_Table->getScienceActivityByArrayConditionAndArrayColumn(array('year_id'=>$year_id), array());
          $science_research_alls=$science_research_Table->getScienceResearchAndScienceActivityByArrayConditionAndArrayColumns(array('t1.user_id'=>$id, 't2.year_id'=>$year_id), array(), array('name'));
          $science_researchs=array();
          foreach ($science_research_alls as $key => $science_research_all) {
            $activity_id=$science_research_all['science_activity_id'];
            $science_researchs[$activity_id]=$science_research_all;
          }
          $return_array['science_activity_alls']=$science_activity_alls;
          $return_array['science_researchs']=$science_researchs;
          if($return_array['can_edit']==1){
            $edit_ctnc_form=new EditCTNCForm();
            $return_array['edit_ctnc_form']=$edit_ctnc_form;
          }

        /*
          KINH NGHIỆM LÀM VIỆC
            Phần 3: Công tác khác
        */
          $orther_works=$orther_work_table->getOrtherWorkByArrayConditionAndArrayColumns(array('user_id'=>$id, 'year_id'=>$year_id), array());
          $return_array['orther_works']=$orther_works;
          if($return_array['can_edit']==1){
            $add_orther_work_form=new AddOrtherWorkForm();
            $edit_orther_work_form=new EditOrtherWorkForm();
            $return_array['add_orther_work_form']=$add_orther_work_form;
            $return_array['edit_orther_work_form']=$edit_orther_work_form;
          }

        /*
          DỊNH HƯỚNG PHÁT TRIỂN
            Phần 1: Công tác giảng dạy
        */
          $future_teaching_alls=$future_teaching_table->getFutureTeachingAndSubjectByArrayConditionAndArrayColumns(array('t1.user_id'=>$id, 't2.year_id'=>$year_id), array(), array('name'));
          $return_array['future_teaching_alls']=$future_teaching_alls;
          if($return_array['can_edit']==1){
            $future_teaching_edit_form=new EditCongTacGiangDayForm($this->getServiceLocator());
            $future_teaching_add_form=new AddCongTacGiangDayForm($this->getServiceLocator());
            $return_array['future_teaching_edit_form']=$future_teaching_edit_form;
            $return_array['future_teaching_add_form']=$future_teaching_add_form;
          }

        /*
          DỊNH HƯỚNG PHÁT TRIỂN
            Phần 2: Công tác nghiên cứu khoa học
        */
          $future_science_research_alls=$future_science_research_Table->getFutureScienceResearchByArrayConditionAndArrayColumns(array('user_id'=>$id, 'year_id'=>$year_id), array());
          $return_array['future_science_research_alls']=$future_science_research_alls;
          if($return_array['can_edit']==1){
            $add_future_hdnckh_form=new AddFutureHDNCKHForm();
            $edit_future_hdnckh_form=new EditFutureHDNCKHForm();
            $return_array['add_future_hdnckh_form']=$add_future_hdnckh_form;
            $return_array['edit_future_hdnckh_form']=$edit_future_hdnckh_form;
          }
        /*
          DỊNH HƯỚNG PHÁT TRIỂN
            Phần 3: Học tập nâng cao trình độ
        */

          $future_studys=$future_study_table->getFutureStudyByArrayConditionAndArrayColumns(array('user_id'=>$id, 'year_id'=>$year_id), array());
          $return_array['future_studys']=$future_studys;
          if($return_array['can_edit']==1){
            $add_future_study_form=new AddFutureStudyForm();
            $edit_future_study_form=new EditFutureStudyForm();
            $return_array['add_future_study_form']=$add_future_study_form;
            $return_array['edit_future_study_form']=$edit_future_study_form;
          }


        /*
          DỊNH HƯỚNG PHÁT TRIỂN
            Phần 4: Công tác khác
        */
          $future_orther_works=$future_orther_work_table->getFutureOrtherWorkByArrayConditionAndArrayColumns(array('user_id'=>$id, 'year_id'=>$year_id), array());
          $return_array['future_orther_works']=$future_orther_works;
          if($return_array['can_edit']==1){
            $add_future_orther_work_form=new AddFutureOrtherWorkForm();
            $edit_future_orther_work_form=new EditFutureOrtherWorkForm();
            $return_array['add_future_orther_work_form']=$add_future_orther_work_form;
            $return_array['edit_future_orther_work_form']=$edit_future_orther_work_form;
          }

        /*
          CÁC BÀI BÁO CÁO KHOA HỌC ĐÃ CÔNG BỐ
        */
          $scientific_reports=$scientific_report_table->getScientificReportByArrayConditionAndArrayColumns(array('user_id'=>$id, 'year_id'=>$year_id), array());
          $return_array['scientific_reports']=$scientific_reports;
          if($return_array['can_edit']==1){
            $add_scientific_report_form=new AddScientificReportForm();
            $edit_scientific_report_form=new EditScientificReportForm();
            $return_array['add_scientific_report_form']=$add_scientific_report_form;
            $return_array['edit_scientific_report_form']=$edit_scientific_report_form;
          }

        
      }// nếu tồn tại $id
     	// trả dữ liệu ra view
     	return $return_array;
    }

    /*
      THÔNG TIN CÁ NHÂN
        phần 1: thông tin cá nhân
    */
    public function editInforAction(){
        
      $request=$this->getRequest();
      if($request->isPost()) // kiểm tra nếu post dữ liệu
      {
        // post
        $post=$request->getPost();
        if(isset($post['id'])){
          // điểm truy cập csdl
          $jos_attribute_table=$this->getServiceLocator()->get('Attribute\Model\JosAttributeTable');
          $jos_users_table=$this->getServiceLocator()->get('Permission\Model\JosUsersTable');
          $jos_year_table=$this->getServiceLocator()->get('NamHoc\Model\JosYearTable');
          $jos_infor_table=$this->getServiceLocator()->get('Application\Model\JosInfomationTable');
          $jos_attribute_table=$this->getServiceLocator()->get('Attribute\Model\JosAttributeTable');
          $jos_attribute_option_table=$this->getServiceLocator()->get('Attribute\Model\JosAttributeOptionTable');
                
          
          $id=$post['id']; unset($post['id']);        
          // nếu đã đăng nhập
          $read=$this->getServiceLocator()->get('AuthService')->getStorage()->read();
          if(isset($read['username']) and $read['username']){
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
              // tạo form
              $all_attributes=$jos_attribute_table->getAttributeByYearActive();
              $edit_infor_form=new EditInforForm($this->getServiceLocator(), $all_attributes);
              $edit_infor_form->setData($post);
              if($edit_infor_form->isValid()){
                // lấy year_id default              
                $year=$jos_year_table->getYearByArrayConditionAndArrayColumn(array('is_active'=>1));
                if(!$year or !isset($year[0]['year_id'])){
                  die('Lỗi, Không xác định được năm cần sửa!');
                }
                $year_id=$year[0]['year_id'];
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
                  $this->flashMessenger()->addSuccessMessage('Cập nhật thành công!');
                }
                // có một số lỗi trong quá trình cập nhật
                else{
                  $error='dữ liệu cột: '.$error.' nhập không đúng. Vui lòng kiểm tra lại!';
                  $this->flashMessenger()->addErrorMessage($error);
                }              
                return $this->redirect()->toRoute('application/crud', array('action'=>'index', 'id'=>$id));
              }
            }
          }     
        }
        if(isset($id)){
          $this->flashMessenger()->addErrorMessage('Bạn không có quyền truy cập. Vui lòng kiểm tra lại!');
          return $this->redirect()->toRoute('application/crud', array('action'=>'index', 'id'=>$id));
        } 
      }        
      // không có quyền sửa
      $this->flashMessenger()->addErrorMessage('Bạn không có quyền truy cập. Vui lòng kiểm tra lại!');
      return $this->redirect()->toRoute('application/crud', array('action'=>'index'));
    }


    /*
      THÔNG TIN CÁ NHÂN
        phần 2: chứng chỉ khác
    */
    public function editCertificateAction(){ 
      $request=$this->getRequest();
      if($request->isPost()) // kiểm tra nếu post dữ liệu
      {
        $post=$request->getPost();
        if(isset($post['id'])){          
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
              // lấy year_id default
              $jos_year_table=$this->getServiceLocator()->get('NamHoc\Model\JosYearTable');
              $year=$jos_year_table->getYearByArrayConditionAndArrayColumn(array('is_active'=>1));
              if(!$year or !isset($year[0]['year_id'])){
                die('Lỗi, Không xác định được năm cần sửa');
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
                  $this->flashMessenger()->addSuccessMessage('Cập nhật thành công!');
                }
                // có một số lỗi trong quá trình cập nhật
                else{
                  $error='dữ liệu cột: '.$error.' nhập không đúng. Vui lòng kiểm tra lại!';
                  $this->flashMessenger()->addErrorMessage($error);
                }
                return $this->redirect()->toRoute('application/crud', array('action'=>'index', 'id'=>$id));
              }
            }
          }                  
        }
        if(isset($id)){
          $this->flashMessenger()->addErrorMessage('Bạn không có quyền truy cập. Vui lòng kiểm tra lại!');
          return $this->redirect()->toRoute('application/crud', array('action'=>'index', 'id'=>$id));
        }
      }  
      $this->flashMessenger()->addErrorMessage('Bạn không có quyền truy cập. Vui lòng kiểm tra lại!');
      return $this->redirect()->toRoute('application/crud', array('action'=>'index'));
    }

    /*
      KINH NGHIỆM LÀM VIỆC
        phần 1: công tác giảng dạy - add
    */
    public function addTeachingAction(){
        
      $request=$this->getRequest();
      if($request->isPost()) // kiểm tra nếu post dữ liệu
      {
        // post
        $post=$request->getPost();
        if(isset($post['id'])){
          $id=$post['id']; unset($post['id']);
          // điểm truy cập csdl
          $jos_users_table=$this->getServiceLocator()->get('Permission\Model\JosUsersTable');
          $jos_year_table=$this->getServiceLocator()->get('NamHoc\Model\JosYearTable');
          $jos_teaching_table=$this->getServiceLocator()->get('Application\Model\JosTeachingTable');
          
          $service_config = $this->getServiceLocator()->get('config');
          $function_class = new FunctionClass();
                
          // nếu đã đăng nhập
          $read=$this->getServiceLocator()->get('AuthService')->getStorage()->read();
          if(isset($read['username']) and $read['username']){
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
              $teaching_add_form=new AddCongTacGiangDayForm($this->getServiceLocator());
              $teaching_add_form->setData($post);
              if($teaching_add_form->isValid()){
                // lấy year_id default
                $year=$jos_year_table->getYearByArrayConditionAndArrayColumn(array('is_active'=>1));
                if(!$year or !isset($year[0]['year_id'])){
                  die('Lỗi, Không xác định được năm cần sửa');
                }
                $year_id=$year[0]['year_id'];
                
                // kiểm tra dữ liệu post đã tồn tại chưa nếu tồn tại rồi thì sửa
                $teaching_exist=$jos_teaching_table->getTeachingAndSubjectByArrayConditionAndArrayColumns(array('t1.user_id'=>$id, 't1.subject_id'=>$post['ten_mon'], 't2.year_id'=>$year_id), array('value_id'), array());             
                if($teaching_exist){
                  $this->flashMessenger()->addErrorMessage('Tên môn học đã tồn tại. Vui lòng kiểm tra lại!');
                  return $this->redirect()->toRoute('application/crud', array('action'=>'index', 'id'=>$id));
                }

                // truy cập vào config lấy ra danh sách config bậc học
                $bac_hocs=array();
                $bac_hoc_source_model=array();
                $bac_hoc_source_model['source_model']['application']='bac_hoc';
                $bac_hocs = $function_class->selectElementArray(array('array_element' => $bac_hoc_source_model, 'array' => $service_config ));
                $bac_hoc=''; $co_bac_hoc=0;
                foreach ($bac_hocs as $key => $bh) {
                  if(isset($post['bac_hoc_'.$key]) and $post['bac_hoc_'.$key]==1){
                    $co_bac_hoc++;
                    if($co_bac_hoc>1){ $bac_hoc.=', '; }
                    $bac_hoc.=$bh;
                  }
                }

                // truy cập vào config lấy ra danh sách config hệ đào tạo
                $he_dao_taos=array();
                $he_dao_tao_source_model=array();
                $he_dao_tao_source_model['source_model']['application']='he_dao_tao';
                $he_dao_taos = $function_class->selectElementArray(array('array_element' => $he_dao_tao_source_model, 'array' => $service_config ));
                $he_dao_tao=''; $co_he_dao_tao=0;
                foreach ($he_dao_taos as $key => $hdt) {
                  if(isset($post['he_dao_tao_'.$key]) and $post['he_dao_tao_'.$key]==1){
                    $co_he_dao_tao++;
                    if($co_he_dao_tao>1){ $he_dao_tao.=', '; }
                    $he_dao_tao.=$hdt;
                  }
                }

                $teaching_new=new JosTeaching();
                $teaching_new->setSubjectId($post['ten_mon']);
                $teaching_new->setUserId($id);
                $teaching_new->setLessonNumber($post['so_tiet']);
                $teaching_new->setQualifications($bac_hoc);
                $teaching_new->setEduSystem($he_dao_tao);
                $teaching_new->setNote($post['ghi_chu']);
                $jos_teaching_table->saveJosTeaching($teaching_new);
                // thông báo thành công
                $this->flashMessenger()->addSuccessMessage('Chúc mừng thêm mới thành công. Vui lòng kiểm tra lại!');
                return $this->redirect()->toRoute('application/crud', array('action'=>'index', 'id'=>$id));
              
              }
              // form không hợp lệ
              $this->flashMessenger()->addErrorMessage('Dữ liệu nhập không đúng. Vui lòng kiểm tra lại!');
              return $this->redirect()->toRoute('application/crud', array('action'=>'index', 'id'=>$id));
            
            }
          }               
        }
        if(isset($id)){
          $this->flashMessenger()->addErrorMessage('Bạn không có quyền truy cập. Vui lòng kiểm tra lại!');
          return $this->redirect()->toRoute('application/crud', array('action'=>'index', 'id'=>$id));
        } 
      }        
      // không có quyền sửa
      $this->flashMessenger()->addErrorMessage('Bạn không có quyền truy cập. Vui lòng kiểm tra lại!');
      return $this->redirect()->toRoute('application/crud', array('action'=>'index'));
    }

    /*
      KINH NGHIỆM LÀM VIỆC
        phần 1: công tác giảng dạy - edit
    */
    public function editTeachingAction(){
        
      $id=$this->params('id'); 
      $request=$this->getRequest();
      if($request->isPost()) // kiểm tra nếu post dữ liệu
      {
        // điểm truy cập csdl
        $jos_users_table=$this->getServiceLocator()->get('Permission\Model\JosUsersTable');
        $jos_year_table=$this->getServiceLocator()->get('NamHoc\Model\JosYearTable');
        $jos_teaching_table=$this->getServiceLocator()->get('Application\Model\JosTeachingTable');
          
        $service_config = $this->getServiceLocator()->get('config');
        $function_class = new FunctionClass();
                       
        // post
        $post=$request->getPost();              
        // nếu đã đăng nhập
        $read=$this->getServiceLocator()->get('AuthService')->getStorage()->read();
        if(isset($read['username']) and $read['username']){
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
            $teaching_edit_form=new EditCongTacGiangDayForm($this->getServiceLocator());
            $teaching_edit_form->setData($post);
            if($teaching_edit_form->isValid()){
              // lấy year_id default
              $jos_year_table=$this->getServiceLocator()->get('NamHoc\Model\JosYearTable');
              $year=$jos_year_table->getYearByArrayConditionAndArrayColumn(array('is_active'=>1));
              if(!$year or !isset($year[0]['year_id'])){
                die('Lỗi, Không xác định được năm cần sửa');
              }
              $year_id=$year[0]['year_id'];

              // kiểm tra dữ liệu post đã tồn tại chưa nếu tồn tại rồi thì sửa
              $teaching_exist=$jos_teaching_table->getTeachingAndSubjectByArrayConditionAndArrayColumns(array('t1.user_id'=>$id, 't1.subject_id'=>$post['ten_mon'], 't2.year_id'=>$year_id), array(), array());             
              if((!$teaching_exist or ($teaching_exist and ($teaching_exist[0]['value_id']==$post['id_cong_tac']))) and ($edit_all_profile==1 or $teaching_exist[0]['user_id']==$id)){
                // truy cập vào config lấy ra danh sách config bậc học
                $bac_hocs=array();
                $bac_hoc_source_model=array();
                $bac_hoc_source_model['source_model']['application']='bac_hoc';
                $bac_hocs = $function_class->selectElementArray(array('array_element' => $bac_hoc_source_model, 'array' => $service_config ));
                $bac_hoc=''; $co_bac_hoc=0;
                foreach ($bac_hocs as $key => $bh) {
                  if(isset($post['bac_hoc_'.$key]) and $post['bac_hoc_'.$key]==1){
                    $co_bac_hoc++;
                    if($co_bac_hoc>1){ $bac_hoc.=', '; }
                    $bac_hoc.=$bh;
                  }
                }

                // truy cập vào config lấy ra danh sách config hệ đào tạo
                $he_dao_taos=array();
                $he_dao_tao_source_model=array();
                $he_dao_tao_source_model['source_model']['application']='he_dao_tao';
                $he_dao_taos = $function_class->selectElementArray(array('array_element' => $he_dao_tao_source_model, 'array' => $service_config ));
                $he_dao_tao=''; $co_he_dao_tao=0;
                foreach ($he_dao_taos as $key => $hdt) {
                  if(isset($post['he_dao_tao_'.$key]) and $post['he_dao_tao_'.$key]==1){
                    $co_he_dao_tao++;
                    if($co_he_dao_tao>1){ $he_dao_tao.=', '; }
                    $he_dao_tao.=$hdt;
                  }
                }

                $teaching_new=new JosTeaching();
                $teaching_new->setValueId($post['id_cong_tac']);
                $teaching_new->setSubjectId($post['ten_mon']);
                $teaching_new->setUserId($id);
                $teaching_new->setLessonNumber($post['so_tiet']);
                $teaching_new->setQualifications($bac_hoc);
                $teaching_new->setEduSystem($he_dao_tao);
                $teaching_new->setNote($post['ghi_chu']);
                $jos_teaching_table->saveJosTeaching($teaching_new);

                $this->flashMessenger()->addSuccessMessage('Chúc mừng, cập nhật thành công!');
                return $this->redirect()->toRoute('application/crud', array('action'=>'index', 'id'=>$id));
              }
            }
          }
        }     
      } 
      if(isset($id)){
        $this->flashMessenger()->addErrorMessage('Bạn không có quyền truy cập. Vui lòng kiểm tra lại!');
        return $this->redirect()->toRoute('application/crud', array('action'=>'index', 'id'=>$id));
      }       
      // không có quyền sửa
      $this->flashMessenger()->addErrorMessage('Bạn không có quyền truy cập. Vui lòng kiểm tra lại!');
      return $this->redirect()->toRoute('application/crud', array('action'=>'index'));
    }

    /*
      KINH NGHIỆM LÀM VIỆC
        phần 1: công tác giảng dạy - delete
    */
    public function deleteTeachingAction(){        
      // điểm truy cập csdl
      $jos_users_table=$this->getServiceLocator()->get('Permission\Model\JosUsersTable');
      $jos_year_table=$this->getServiceLocator()->get('NamHoc\Model\JosYearTable');
      $jos_teaching_table=$this->getServiceLocator()->get('Application\Model\JosTeachingTable');      
      
      $teaching_id=$this->params('id');
      if($teaching_id){       
        $teaching_exist=$jos_teaching_table->getTeachingByArrayConditionAndArrayColumns(array('value_id'=>$teaching_id), array('user_id'));
        // nếu đã đăng nhập
        $read=$this->getServiceLocator()->get('AuthService')->getStorage()->read();
        if($teaching_exist and isset($teaching_exist[0]['user_id']) and $teaching_exist[0]['user_id'] and isset($read['username']) and $read['username']){
          $id=$teaching_exist[0]['user_id'];
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
            // xóa
            $jos_teaching_table->deleteTeachingById($teaching_id);
            $this->flashMessenger()->addSuccessMessage('Chúc mừng xóa thành công!');
            return $this->redirect()->toRoute('application/crud', array('action'=>'index', 'id'=>$user[0]['id']));
          }
          if(isset($user[0]['id']) and $user[0]['id']){
            $this->flashMessenger()->addErrorMessage('Bạn không có quyền truy cập. Vui lòng kiểm tra lại!');
            return $this->redirect()->toRoute('application/crud', array('action'=>'index', 'id'=>$user[0]['id']));
          }
        }  
      }        
      // không có quyền sửa
      $this->flashMessenger()->addErrorMessage('Bạn không có quyền truy cập. Vui lòng kiểm tra lại!');
      return $this->redirect()->toRoute('application/crud', array('action'=>'index'));
    }

    /*
      KINH NGHIỆM LÀM VIỆC
        phần 2: công tác nghiên cứu khoa học
    */
    public function editHoatDongNghienCuuKhoaHocAction(){
      // điểm truy cập csdl
      $jos_users_table=$this->getServiceLocator()->get('Permission\Model\JosUsersTable');
      $jos_year_table=$this->getServiceLocator()->get('NamHoc\Model\JosYearTable');
      $jos_science_research_of_user_table=$this->getServiceLocator()->get('Application\Model\JosScienceResearchOfUserTable');
      $jos_science_activity_table=$this->getServiceLocator()->get('CongTacNghienCuu\Model\JosScienceActivityTable');
      $id_giang_vien=$this->params('id');
      $read=$this->getServiceLocator()->get('AuthService')->getStorage()->read();
      if(isset($read['username']) and $read['username']){
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
        if($user and isset($user[0]['id']) and $id_giang_vien==$user[0]['id']){   
          // nếu đã đăng nhập            
          $edit_all_profile=1;
        }
        // có quyền
        if($edit_all_profile==1){
          $request=$this->getRequest();
          if($request->isPost()){
            $post=$request->getPost();
            $edit_ctnc_form=new EditCTNCForm();
            $edit_ctnc_form->setData($post);
            if($edit_ctnc_form->isValid()){
              // lấy year_id default
              $jos_year_table=$this->getServiceLocator()->get('NamHoc\Model\JosYearTable');
              $year=$jos_year_table->getYearByArrayConditionAndArrayColumn(array('is_active'=>1));
              if(!$year or !isset($year[0]['year_id'])){
                die('Lỗi, Không xác định được năm cần sửa');
              }
              $year_id=$year[0]['year_id'];
              // nếu hoạt động nghiên cứu khoa học cần sửa hỏng tồn tại thì không sửa
              $science_activity_exist=$jos_science_activity_table->getScienceActivityByArrayConditionAndArrayColumn(array('year_id'=>$year_id, 'value_id'=>$post['id_hoat_dong']), array('name'));
              if($science_activity_exist){  
                // lấy dữ liệu lên
                $science_research_exist=$jos_science_research_of_user_table->getScienceResearchAndScienceActivityByArrayConditionAndArrayColumns(array('t1.user_id'=>$id_giang_vien, 't1.science_activity_id'=>$post['id_hoat_dong'], 't2.year_id'=>$year_id), array(), array());
                // nếu post trang_thai==1 thì sửa hoặc thêm mới
                if($post['trang_thai']==1){

                  $science_research_new=new JosScienceResearchOfUser();
                  $science_research_new->exchangeArray($post);
                  if($science_research_exist and isset($science_research_exist[0]['value_id'])){
                    $science_research_new->setValueId($science_research_exist[0]['value_id']);
                  }
                  $science_research_new->setUserId($id_giang_vien);
                  $science_research_new->setScienceActivityId($post['id_hoat_dong']);
                  $science_research_new->setNote($post['ghi_chu']);
                  // xử lý lại ngày bắt đầu
                  $time_from = strtotime($post['time_from']);
                  $time_from = date('Y-m-d',$time_from);
                  $science_research_new->setTimeFrom($time_from);
                  // xử lý lại ngày kết thúc
                  $time_to = strtotime($post['time_to']);
                  $time_to = date('Y-m-d',$time_to);
                  $science_research_new->setTimeTo($time_to);
                  $jos_science_research_of_user_table->saveJosScienceResearch($science_research_new);
                }
                else{
                  if($science_research_exist and isset($science_research_exist[0]['value_id'])){
                    $jos_science_research_of_user_table->deleteScienceResearchById($science_research_exist[0]['value_id']);
                  }
                }
                $this->flashMessenger()->addSuccessMessage('Chúc mừng, cập nhật thành công!');
                return $this->redirect()->toRoute('application/crud', array('action'=>'index', 'id'=>$id_giang_vien));
              }              
            }
          }
        }
      }
      if(isset($id_giang_vien)){
        $this->flashMessenger()->addErrorMessage('Bạn không có quyền truy cập. Vui lòng kiểm tra lại!');
        return $this->redirect()->toRoute('application/crud', array('action'=>'index', 'id'=>$id_giang_vien));
      }  
      $this->flashMessenger()->addErrorMessage('Bạn không có quyền truy cập. Vui lòng kiểm tra lại!');
      return $this->redirect()->toRoute('application/crud', array('action'=>'index'));     
    }

    /*
      KINH NGHIỆM LÀM VIỆC
        phần 3: công tác khác - add
    */
    public function addOrtherWorkAction(){
      // điểm truy cập csdl
      $jos_users_table=$this->getServiceLocator()->get('Permission\Model\JosUsersTable');
      $jos_year_table=$this->getServiceLocator()->get('NamHoc\Model\JosYearTable');
      $jos_orther_work_table=$this->getServiceLocator()->get('Application\Model\JosOrtherWorkTable');
      $id_giang_vien=$this->params('id');
      $read=$this->getServiceLocator()->get('AuthService')->getStorage()->read();
      if(isset($read['username']) and $read['username']){
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
        if($user and isset($user[0]['id']) and $id_giang_vien==$user[0]['id']){   
          // nếu đã đăng nhập            
          $edit_all_profile=1;
        }
        // có quyền
        if($edit_all_profile==1){
          $request=$this->getRequest();
          if($request->isPost()){
            $post=$request->getPost();
            $add_orther_work_form=new AddOrtherWorkForm();
            $add_orther_work_form->setData($post);
            if($add_orther_work_form->isValid()){
              // lấy year_id default
              $year=$jos_year_table->getYearByArrayConditionAndArrayColumn(array('is_active'=>1));
              if(!$year or !isset($year[0]['year_id'])){
                die('Lỗi, Không xác định được năm cần sửa');
              }
              $year_id=$year[0]['year_id'];
              // Kiểm tra nếu orther_work đã tồn tại thì không add, ko tồn tại thì add
              $orther_work_exist=$jos_orther_work_table->getOrtherWorkByArrayConditionAndArrayColumns(array('year_id'=>$year_id, 'user_id'=>$id_giang_vien, 'content'=>$post['content']), array());
              if(!$orther_work_exist){
                $orther_work_new=new JosOrtherWork();
                $orther_work_new->exchangeArray($post);
                $orther_work_new->setUserId($id_giang_vien);
                $orther_work_new->setYearId($year_id);

                $time_from = date('Y-m-d',strtotime($post['time_from']));
                $orther_work_new->setTimeFrom($time_from);

                $time_to = date('Y-m-d',strtotime($post['time_to']));
                $orther_work_new->setTimeTo($time_to);

                $jos_orther_work_table->saveJosOrtherWork($orther_work_new);
                $this->flashMessenger()->addSuccessMessage('Chúc mừng thêm mới thành công!');
                return $this->redirect()->toRoute('application/crud', array('action'=>'index', 'id'=>$id_giang_vien));
              }          
            }
          }
        }
      }
      if(isset($id_giang_vien)){
        $this->flashMessenger()->addErrorMessage('Bạn không có quyền truy cập. Vui lòng kiểm tra lại!');
        return $this->redirect()->toRoute('application/crud', array('action'=>'index', 'id'=>$id_giang_vien));
      }  
      $this->flashMessenger()->addErrorMessage('Bạn không có quyền truy cập. Vui lòng kiểm tra lại!');
      return $this->redirect()->toRoute('application/crud', array('action'=>'index'));     
    }

    /*
      KINH NGHIỆM LÀM VIỆC
        phần 3: công tác khác - edit
    */
    public function editOrtherWorkAction(){
      // điểm truy cập csdl
      $jos_users_table=$this->getServiceLocator()->get('Permission\Model\JosUsersTable');
      $jos_year_table=$this->getServiceLocator()->get('NamHoc\Model\JosYearTable');
      $jos_orther_work_table=$this->getServiceLocator()->get('Application\Model\JosOrtherWorkTable');
      $id_giang_vien=$this->params('id');
      $read=$this->getServiceLocator()->get('AuthService')->getStorage()->read();
      if(isset($read['username']) and $read['username']){
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
        if($user and isset($user[0]['id']) and $id_giang_vien==$user[0]['id']){   
          // nếu đã đăng nhập            
          $edit_all_profile=1;
        }
        // có quyền
        if($edit_all_profile==1){
          $request=$this->getRequest();
          if($request->isPost()){
            $post=$request->getPost();
            $edit_orther_work_form=new EditOrtherWorkForm();
            $edit_orther_work_form->setData($post);
            if($edit_orther_work_form->isValid()){
              // lấy year_id default
              $year=$jos_year_table->getYearByArrayConditionAndArrayColumn(array('is_active'=>1));
              if(!$year or !isset($year[0]['year_id'])){
                die('Lỗi, Không xác định được năm cần sửa');
              }
              $year_id=$year[0]['year_id'];
              // Kiểm tra nếu science_research đã tồn tại thì không add, ko tồn tại thì add
              $orther_work_exist=$jos_orther_work_table->getOrtherWorkByArrayConditionAndArrayColumns(array('user_id'=>$id_giang_vien, 'year_id'=>$year_id, 'content'=>$post['content']), array());
              if(!$orther_work_exist or ($orther_work_exist and $orther_work_exist[0]['value_id']==$post['value_id'])){
                $orther_work_new=new JosOrtherWork();
                $orther_work_new->exchangeArray($post);
                $orther_work_new->setUserId($id_giang_vien);
                $orther_work_new->setYearId($year_id);
                
               
                $time_from = date('Y-m-d',strtotime($post['time_from']));
                $orther_work_new->setTimeFrom($time_from);
                
                $time_to = date('Y-m-d', strtotime($post['time_to']));
                $orther_work_new->setTimeTo($time_to);

                $jos_orther_work_table->saveJosOrtherWork($orther_work_new);
                $this->flashMessenger()->addSuccessMessage('Chúc mừng cập nhật thành công!');
                return $this->redirect()->toRoute('application/crud', array('action'=>'index', 'id'=>$id_giang_vien));
              }          
            }
          }
        }
      }
      if(isset($id_giang_vien)){
        $this->flashMessenger()->addErrorMessage('Bạn không có quyền truy cập. Vui lòng kiểm tra lại!');
        return $this->redirect()->toRoute('application/crud', array('action'=>'index', 'id'=>$id_giang_vien));
      }  
      $this->flashMessenger()->addErrorMessage('Bạn không có quyền truy cập. Vui lòng kiểm tra lại!');
      return $this->redirect()->toRoute('application/crud', array('action'=>'index'));     
    }

    /*
      KINH NGHIỆM LÀM VIỆC
        phần 3: công tác khác - delete
    */
    public function deleteOrtherWorkAction(){
      // điểm truy cập csdl
      $jos_users_table=$this->getServiceLocator()->get('Permission\Model\JosUsersTable');
      $jos_year_table=$this->getServiceLocator()->get('NamHoc\Model\JosYearTable');
      $jos_orther_work_table=$this->getServiceLocator()->get('Application\Model\JosOrtherWorkTable');
      $id=$this->params('id');
      $read=$this->getServiceLocator()->get('AuthService')->getStorage()->read();
      if(isset($read['username']) and $read['username']){
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

        // lấy year_id default
        $year=$jos_year_table->getYearByArrayConditionAndArrayColumn(array('is_active'=>1));
        if(!$year or !isset($year[0]['year_id'])){
          die('Lỗi, Không xác định được năm cần sửa');
        }
        $year_id=$year[0]['year_id'];
        // Kiểm tra nếu science_research đã tồn tại thì không add, ko tồn tại thì add
        $orther_work_exist=$jos_orther_work_table->getOrtherWorkByArrayConditionAndArrayColumns(array('value_id'=>$id, 'year_id'=>$year_id), array('user_id'));
        if($orther_work_exist and $user and isset($user[0]['id'])){
          if(isset($orther_work_exist[0]['user_id']) and ($orther_work_exist[0]['user_id']==$user[0]['id'] or $edit_all_profile==1)){
            // được quyền xóa
            $jos_orther_work_table->deleteOrtherWorkById($id);
            $this->flashMessenger()->addSuccessMessage('Chúc mừng xóa thành công!');
            return $this->redirect()->toRoute('application/crud', array('action'=>'index', 'id'=>$user[0]['id']));
          }
        }        
      }
      if(isset($user[0]['id'])){
        $this->flashMessenger()->addErrorMessage('Bạn không có quyền truy cập. Vui lòng kiểm tra lại!');
        return $this->redirect()->toRoute('application/crud', array('action'=>'index', 'id'=>$user[0]['id']));
      }  
      $this->flashMessenger()->addErrorMessage('Bạn không có quyền truy cập. Vui lòng kiểm tra lại!');
      return $this->redirect()->toRoute('application/crud', array('action'=>'index'));     
    }

    /*
      ĐỊNH HƯỚNG PHÁT TRIỂN
        phần 1: công tác giảng dạy - add
    */
    public function addFutureTeachingAction(){
        
      $request=$this->getRequest();
      if($request->isPost()) // kiểm tra nếu post dữ liệu
      {
        // post
        $post=$request->getPost();
        if(isset($post['id'])){
          $id=$post['id']; unset($post['id']);
          // điểm truy cập csdl
          $jos_users_table=$this->getServiceLocator()->get('Permission\Model\JosUsersTable');
          $jos_year_table=$this->getServiceLocator()->get('NamHoc\Model\JosYearTable');
          $jos_future_teaching_table=$this->getServiceLocator()->get('Application\Model\JosFutureTeachingTable');
          
          $service_config = $this->getServiceLocator()->get('config');
          $function_class = new FunctionClass();
                
          // nếu đã đăng nhập
          $read=$this->getServiceLocator()->get('AuthService')->getStorage()->read();
          if(isset($read['username']) and $read['username']){
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
              $future_teaching_add_form=new AddCongTacGiangDayForm($this->getServiceLocator());
              $future_teaching_add_form->setData($post);
              if($future_teaching_add_form->isValid()){
                // lấy year_id default
                $year=$jos_year_table->getYearByArrayConditionAndArrayColumn(array('is_active'=>1));
                if(!$year or !isset($year[0]['year_id'])){
                  die('Lỗi, Không xác định được năm cần sửa');
                }
                $year_id=$year[0]['year_id'];
                
                // kiểm tra dữ liệu post đã tồn tại chưa nếu tồn tại rồi thì sửa
                $teaching_exist=$jos_future_teaching_table->getFutureTeachingAndSubjectByArrayConditionAndArrayColumns(array('t1.user_id'=>$id, 't1.subject_id'=>$post['ten_mon'], 't2.year_id'=>$year_id), array('value_id'), array());             
                if($teaching_exist){
                  $this->flashMessenger()->addErrorMessage('Tên môn học đã tồn tại. Vui lòng kiểm tra lại!');
                  return $this->redirect()->toRoute('application/crud', array('action'=>'index', 'id'=>$id));
                }

                // truy cập vào config lấy ra danh sách config bậc học
                $bac_hocs=array();
                $bac_hoc_source_model=array();
                $bac_hoc_source_model['source_model']['application']='bac_hoc';
                $bac_hocs = $function_class->selectElementArray(array('array_element' => $bac_hoc_source_model, 'array' => $service_config ));
                $bac_hoc=''; $co_bac_hoc=0;
                foreach ($bac_hocs as $key => $bh) {
                  if(isset($post['bac_hoc_'.$key]) and $post['bac_hoc_'.$key]==1){
                    $co_bac_hoc++;
                    if($co_bac_hoc>1){ $bac_hoc.=', '; }
                    $bac_hoc.=$bh;
                  }
                }

                // truy cập vào config lấy ra danh sách config hệ đào tạo
                $he_dao_taos=array();
                $he_dao_tao_source_model=array();
                $he_dao_tao_source_model['source_model']['application']='he_dao_tao';
                $he_dao_taos = $function_class->selectElementArray(array('array_element' => $he_dao_tao_source_model, 'array' => $service_config ));
                $he_dao_tao=''; $co_he_dao_tao=0;
                foreach ($he_dao_taos as $key => $hdt) {
                  if(isset($post['he_dao_tao_'.$key]) and $post['he_dao_tao_'.$key]==1){
                    $co_he_dao_tao++;
                    if($co_he_dao_tao>1){ $he_dao_tao.=', '; }
                    $he_dao_tao.=$hdt;
                  }
                }

                $future_teaching_new=new JosFutureTeaching();
                $future_teaching_new->setSubjectId($post['ten_mon']);
                $future_teaching_new->setUserId($id);
                $future_teaching_new->setLessonNumber($post['so_tiet']);
                $future_teaching_new->setQualifications($bac_hoc);
                $future_teaching_new->setEduSystem($he_dao_tao);
                $future_teaching_new->setNote($post['ghi_chu']);
                $jos_future_teaching_table->saveJosFutureTeaching($future_teaching_new);
                // thông báo thành công
                $this->flashMessenger()->addSuccessMessage('Chúc mừng thêm mới thành công. Vui lòng kiểm tra lại!');
                return $this->redirect()->toRoute('application/crud', array('action'=>'index', 'id'=>$id));
              
              }
              // form không hợp lệ
              $this->flashMessenger()->addErrorMessage('Dữ liệu nhập không đúng. Vui lòng kiểm tra lại!');
              return $this->redirect()->toRoute('application/crud', array('action'=>'index', 'id'=>$id));
            
            }
          }               
        }
        if(isset($id)){
          $this->flashMessenger()->addErrorMessage('Bạn không có quyền truy cập. Vui lòng kiểm tra lại!');
          return $this->redirect()->toRoute('application/crud', array('action'=>'index', 'id'=>$id));
        } 
      }        
      // không có quyền sửa
      $this->flashMessenger()->addErrorMessage('Bạn không có quyền truy cập. Vui lòng kiểm tra lại!');
      return $this->redirect()->toRoute('application/crud', array('action'=>'index'));
    }

    /*
      ĐỊNH HƯỚNG PHÁT TRIỂN
        phần 1: công tác giảng dạy - edit
    */
    public function editFutureTeachingAction(){
      $id=$this->params('id'); 
      $request=$this->getRequest();
      if($request->isPost()) // kiểm tra nếu post dữ liệu
      {
        // điểm truy cập csdl
        $jos_users_table=$this->getServiceLocator()->get('Permission\Model\JosUsersTable');
        $jos_year_table=$this->getServiceLocator()->get('NamHoc\Model\JosYearTable');
        $jos_future_teaching_table=$this->getServiceLocator()->get('Application\Model\JosFutureTeachingTable');
          
        $service_config = $this->getServiceLocator()->get('config');
        $function_class = new FunctionClass();
                       
        // post
        $post=$request->getPost();              
        // nếu đã đăng nhập
        $read=$this->getServiceLocator()->get('AuthService')->getStorage()->read();
        if(isset($read['username']) and $read['username']){
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
            $future_teaching_edit_form=new EditCongTacGiangDayForm($this->getServiceLocator());
            $future_teaching_edit_form->setData($post);
            if($future_teaching_edit_form->isValid()){
              // lấy year_id default
              $jos_year_table=$this->getServiceLocator()->get('NamHoc\Model\JosYearTable');
              $year=$jos_year_table->getYearByArrayConditionAndArrayColumn(array('is_active'=>1));
              if(!$year or !isset($year[0]['year_id'])){
                die('Lỗi, Không xác định được năm cần sửa');
              }
              $year_id=$year[0]['year_id'];

              // kiểm tra dữ liệu post đã tồn tại chưa nếu tồn tại rồi thì sửa
              $future_teaching_exist=$jos_future_teaching_table->getFutureTeachingAndSubjectByArrayConditionAndArrayColumns(array('t1.user_id'=>$id, 't1.subject_id'=>$post['ten_mon'], 't2.year_id'=>$year_id), array(), array());             
              if((!$future_teaching_exist or ($future_teaching_exist and $future_teaching_exist[0]['value_id']==$post['id_cong_tac'])) and ($edit_all_profile==1 or $future_teaching_exist[0]['user_id']==$id)){
              //if(!$future_teaching_exist or ($future_teaching_exist and $future_teaching_exist[0]['value_id']==$post['id_cong_tac']) and ($edit_all_profile==1 or $future_teaching_exist[0]['user_id']==$id)){
                // truy cập vào config lấy ra danh sách config bậc học
                $bac_hocs=array();
                $bac_hoc_source_model=array();
                $bac_hoc_source_model['source_model']['application']='bac_hoc';
                $bac_hocs = $function_class->selectElementArray(array('array_element' => $bac_hoc_source_model, 'array' => $service_config ));
                $bac_hoc=''; $co_bac_hoc=0;
                foreach ($bac_hocs as $key => $bh) {
                  if(isset($post['bac_hoc_'.$key]) and $post['bac_hoc_'.$key]==1){
                    $co_bac_hoc++;
                    if($co_bac_hoc>1){ $bac_hoc.=', '; }
                    $bac_hoc.=$bh;
                  }
                }

                // truy cập vào config lấy ra danh sách config hệ đào tạo
                $he_dao_taos=array();
                $he_dao_tao_source_model=array();
                $he_dao_tao_source_model['source_model']['application']='he_dao_tao';
                $he_dao_taos = $function_class->selectElementArray(array('array_element' => $he_dao_tao_source_model, 'array' => $service_config ));
                $he_dao_tao=''; $co_he_dao_tao=0;
                foreach ($he_dao_taos as $key => $hdt) {
                  if(isset($post['he_dao_tao_'.$key]) and $post['he_dao_tao_'.$key]==1){
                    $co_he_dao_tao++;
                    if($co_he_dao_tao>1){ $he_dao_tao.=', '; }
                    $he_dao_tao.=$hdt;
                  }
                }

                $future_teaching_new=new JosFutureTeaching();
                $future_teaching_new->setValueId($post['id_cong_tac']);
                $future_teaching_new->setSubjectId($post['ten_mon']);
                $future_teaching_new->setUserId($id);
                $future_teaching_new->setLessonNumber($post['so_tiet']);
                $future_teaching_new->setQualifications($bac_hoc);
                $future_teaching_new->setEduSystem($he_dao_tao);
                $future_teaching_new->setNote($post['ghi_chu']);
                $jos_future_teaching_table->saveJosFutureTeaching($future_teaching_new);

                $this->flashMessenger()->addSuccessMessage('Chúc mừng, cập nhật thành công!');
                return $this->redirect()->toRoute('application/crud', array('action'=>'index', 'id'=>$id));
              }
            }
          }
        }     
      } 
      if(isset($id)){
        $this->flashMessenger()->addErrorMessage('Bạn không có quyền truy cập. Vui lòng kiểm tra lại!');
        return $this->redirect()->toRoute('application/crud', array('action'=>'index', 'id'=>$id));
      }       
      // không có quyền sửa
      $this->flashMessenger()->addErrorMessage('Bạn không có quyền truy cập. Vui lòng kiểm tra lại!');
      return $this->redirect()->toRoute('application/crud', array('action'=>'index'));
    }

    /*
      ĐỊNH HƯỚNG PHÁT TRIỂN
        phần 1: công tác giảng dạy - delete
    */
    public function deleteFutureTeachingAction(){        
      // điểm truy cập csdl
      $jos_users_table=$this->getServiceLocator()->get('Permission\Model\JosUsersTable');
      $jos_year_table=$this->getServiceLocator()->get('NamHoc\Model\JosYearTable');
      $jos_future_teaching_table=$this->getServiceLocator()->get('Application\Model\JosFutureTeachingTable');      
      
      $future_teaching_id=$this->params('id');
      if($future_teaching_id){       
        $future_teaching_exist=$jos_future_teaching_table->getFutureTeachingByArrayConditionAndArrayColumns(array('value_id'=>$future_teaching_id), array('user_id'));
        // nếu đã đăng nhập
        $read=$this->getServiceLocator()->get('AuthService')->getStorage()->read();
        if($future_teaching_exist and isset($future_teaching_exist[0]['user_id']) and $future_teaching_exist[0]['user_id'] and isset($read['username']) and $read['username']){
          $id=$future_teaching_exist[0]['user_id'];
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
            // xóa
            $jos_future_teaching_table->deleteFutureTeachingById($future_teaching_id);
            $this->flashMessenger()->addSuccessMessage('Chúc mừng xóa thành công!');
            return $this->redirect()->toRoute('application/crud', array('action'=>'index', 'id'=>$user[0]['id']));
          }
          if(isset($user[0]['id']) and $user[0]['id']){
            $this->flashMessenger()->addErrorMessage('Bạn không có quyền truy cập. Vui lòng kiểm tra lại!');
            return $this->redirect()->toRoute('application/crud', array('action'=>'index', 'id'=>$user[0]['id']));
          }
        }  
      }        
      // không có quyền sửa
      $this->flashMessenger()->addErrorMessage('Bạn không có quyền truy cập. Vui lòng kiểm tra lại!');
      return $this->redirect()->toRoute('application/crud', array('action'=>'index'));
    }

    /*
      ĐỊNH HƯỚNG PHÁT TRIỂN
        phần 2: công tác nghiên cứu khoa học - add
    */
    public function addFutureHoatDongNghienCuuKhoaHocAction(){
      // điểm truy cập csdl
      $jos_users_table=$this->getServiceLocator()->get('Permission\Model\JosUsersTable');
      $jos_year_table=$this->getServiceLocator()->get('NamHoc\Model\JosYearTable');
      $jos_future_science_research_of_user_table=$this->getServiceLocator()->get('Application\Model\JosFutureScienceResearchOfUserTable');
      $id_giang_vien=$this->params('id');
      $read=$this->getServiceLocator()->get('AuthService')->getStorage()->read();
      if(isset($read['username']) and $read['username']){
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
        if($user and isset($user[0]['id']) and $id_giang_vien==$user[0]['id']){   
          // nếu đã đăng nhập            
          $edit_all_profile=1;
        }
        // có quyền
        if($edit_all_profile==1){
          $request=$this->getRequest();
          if($request->isPost()){
            $post=$request->getPost();
            $add_future_hdnckh_form=new AddFutureHDNCKHForm();
            $add_future_hdnckh_form->setData($post);
            if($add_future_hdnckh_form->isValid()){
              // lấy year_id default
              $year=$jos_year_table->getYearByArrayConditionAndArrayColumn(array('is_active'=>1));
              if(!$year or !isset($year[0]['year_id'])){
                die('Lỗi, Không xác định được năm cần sửa');
              }
              $year_id=$year[0]['year_id'];
              // Kiểm tra nếu science_research đã tồn tại thì không add, ko tồn tại thì add
              $future_science_research_exist=$jos_future_science_research_of_user_table->getFutureScienceResearchByArrayConditionAndArrayColumns(array('user_id'=>$id_giang_vien, 'year_id'=>$year_id, 'science_activity_name'=>$post['science_activity_name']), array());
              if(!$future_science_research_exist){
                $future_science_research_new=new JosFutureScienceResearchOfUser();
                $future_science_research_new->exchangeArray($post);
                $future_science_research_new->setUserId($id_giang_vien);
                $future_science_research_new->setYearId($year_id);
                $time_from = strtotime($post['time_from']);
                $time_from = date('Y-m-d',$time_from);
                $future_science_research_new->setTimeFrom($time_from);
                $jos_future_science_research_of_user_table->saveJosFutureScienceResearch($future_science_research_new);
                $this->flashMessenger()->addSuccessMessage('Chúc mừng thêm mới hoạt động nghiên cứu thành công!');
                return $this->redirect()->toRoute('application/crud', array('action'=>'index', 'id'=>$id_giang_vien));
              }          
            }
          }
        }
      }
      if(isset($id_giang_vien)){
        $this->flashMessenger()->addErrorMessage('Bạn không có quyền truy cập. Vui lòng kiểm tra lại!');
        return $this->redirect()->toRoute('application/crud', array('action'=>'index', 'id'=>$id_giang_vien));
      }  
      $this->flashMessenger()->addErrorMessage('Bạn không có quyền truy cập. Vui lòng kiểm tra lại!');
      return $this->redirect()->toRoute('application/crud', array('action'=>'index'));     
    }

    /*
      ĐỊNH HƯỚNG PHÁT TRIỂN
        phần 2: công tác nghiên cứu khoa học - edit
    */
    public function editFutureHoatDongNghienCuuKhoaHocAction(){
      // điểm truy cập csdl
      $jos_users_table=$this->getServiceLocator()->get('Permission\Model\JosUsersTable');
      $jos_year_table=$this->getServiceLocator()->get('NamHoc\Model\JosYearTable');
      $jos_future_science_research_of_user_table=$this->getServiceLocator()->get('Application\Model\JosFutureScienceResearchOfUserTable');
      $id_giang_vien=$this->params('id');
      $read=$this->getServiceLocator()->get('AuthService')->getStorage()->read();
      if(isset($read['username']) and $read['username']){
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
        if($user and isset($user[0]['id']) and $id_giang_vien==$user[0]['id']){   
          // nếu đã đăng nhập            
          $edit_all_profile=1;
        }
        // có quyền
        if($edit_all_profile==1){
          $request=$this->getRequest();
          if($request->isPost()){
            $post=$request->getPost();
            $edit_future_hdnckh_form=new EditFutureHDNCKHForm();
            $edit_future_hdnckh_form->setData($post);
            if($edit_future_hdnckh_form->isValid()){
              // lấy year_id default
              $year=$jos_year_table->getYearByArrayConditionAndArrayColumn(array('is_active'=>1));
              if(!$year or !isset($year[0]['year_id'])){
                die('Lỗi, Không xác định được năm cần sửa');
              }
              $year_id=$year[0]['year_id'];
              // Kiểm tra nếu science_research đã tồn tại thì không add, ko tồn tại thì add
              $future_science_research_exist=$jos_future_science_research_of_user_table->getFutureScienceResearchByArrayConditionAndArrayColumns(array('user_id'=>$id_giang_vien, 'year_id'=>$year_id, 'science_activity_name'=>$post['science_activity_name']), array());
              if(!$future_science_research_exist or ($future_science_research_exist and $future_science_research_exist[0]['value_id']==$post['value_id'])){
                $future_science_research_new=new JosFutureScienceResearchOfUser();
                $future_science_research_new->exchangeArray($post);
                $future_science_research_new->setUserId($id_giang_vien);
                $future_science_research_new->setYearId($year_id);
                $time_from = strtotime($post['time_from']);
                $time_from = date('Y-m-d',$time_from);
                $future_science_research_new->setTimeFrom($time_from);
                $jos_future_science_research_of_user_table->saveJosFutureScienceResearch($future_science_research_new);
                $this->flashMessenger()->addSuccessMessage('Chúc mừng cập nhật thành công!');
                return $this->redirect()->toRoute('application/crud', array('action'=>'index', 'id'=>$id_giang_vien));
              }          
            }
          }
        }
      }
      if(isset($id_giang_vien)){
        $this->flashMessenger()->addErrorMessage('Bạn không có quyền truy cập. Vui lòng kiểm tra lại!');
        return $this->redirect()->toRoute('application/crud', array('action'=>'index', 'id'=>$id_giang_vien));
      }  
      $this->flashMessenger()->addErrorMessage('Bạn không có quyền truy cập. Vui lòng kiểm tra lại!');
      return $this->redirect()->toRoute('application/crud', array('action'=>'index'));     
    }

    /*
      ĐỊNH HƯỚNG PHÁT TRIỂN
        phần 2: hoạt động nghiên cứu khoa học - delete
    */
    public function deleteFutureHoatDongNghienCuuKhoaHocAction(){
      // điểm truy cập csdl
      $jos_users_table=$this->getServiceLocator()->get('Permission\Model\JosUsersTable');
      $jos_year_table=$this->getServiceLocator()->get('NamHoc\Model\JosYearTable');
      $jos_future_science_research_of_user_table=$this->getServiceLocator()->get('Application\Model\JosFutureScienceResearchOfUserTable');
      $id=$this->params('id');
      $read=$this->getServiceLocator()->get('AuthService')->getStorage()->read();
      if(isset($read['username']) and $read['username']){
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

        // lấy year_id default
        $year=$jos_year_table->getYearByArrayConditionAndArrayColumn(array('is_active'=>1));
        if(!$year or !isset($year[0]['year_id'])){
          die('Lỗi, Không xác định được năm cần sửa');
        }
        $year_id=$year[0]['year_id'];
        // Kiểm tra nếu science_research đã tồn tại thì không add, ko tồn tại thì add
        $future_science_research_exist=$jos_future_science_research_of_user_table->getFutureScienceResearchByArrayConditionAndArrayColumns(array('value_id'=>$id, 'year_id'=>$year_id), array('user_id'));
        if($future_science_research_exist and $user and isset($user[0]['id'])){
          if(isset($future_science_research_exist[0]['user_id']) and ($future_science_research_exist[0]['user_id']==$user[0]['id'] or $edit_all_profile==1)){
            // được quyền xóa
            $jos_future_science_research_of_user_table->deleteFutureScienceResearchById($id);
            $this->flashMessenger()->addSuccessMessage('Chúc mừng xóa hoạt động nghiên cứu thành công!');
            return $this->redirect()->toRoute('application/crud', array('action'=>'index', 'id'=>$user[0]['id']));
          }
        }        
      }
      if(isset($user[0]['id'])){
        $this->flashMessenger()->addErrorMessage('Bạn không có quyền truy cập. Vui lòng kiểm tra lại!');
        return $this->redirect()->toRoute('application/crud', array('action'=>'index', 'id'=>$user[0]['id']));
      }  
      $this->flashMessenger()->addErrorMessage('Bạn không có quyền truy cập. Vui lòng kiểm tra lại!');
      return $this->redirect()->toRoute('application/crud', array('action'=>'index'));     
    }

    /*
      ĐỊNH HƯỚNG PHÁT TRIỂN
        phần 3: học tập nâng cao trình độ - add
    */
    public function addFutureStudyAction(){
      // điểm truy cập csdl
      $jos_users_table=$this->getServiceLocator()->get('Permission\Model\JosUsersTable');
      $jos_year_table=$this->getServiceLocator()->get('NamHoc\Model\JosYearTable');
      $jos_future_study_table=$this->getServiceLocator()->get('Application\Model\JosFutureStudyTable');
      $id_giang_vien=$this->params('id');
      $read=$this->getServiceLocator()->get('AuthService')->getStorage()->read();
      if(isset($read['username']) and $read['username']){
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
        if($user and isset($user[0]['id']) and $id_giang_vien==$user[0]['id']){   
          // nếu đã đăng nhập            
          $edit_all_profile=1;
        }
        // có quyền
        if($edit_all_profile==1){
          $request=$this->getRequest();
          if($request->isPost()){
            $post=$request->getPost();
            $add_future_study_form=new AddFutureStudyForm();
            $add_future_study_form->setData($post);
            if($add_future_study_form->isValid()){
              // lấy year_id default
              $year=$jos_year_table->getYearByArrayConditionAndArrayColumn(array('is_active'=>1));
              if(!$year or !isset($year[0]['year_id'])){
                die('Lỗi, Không xác định được năm cần sửa');
              }
              $year_id=$year[0]['year_id'];
              // Kiểm tra nếu orther_work đã tồn tại thì không add, ko tồn tại thì add
              $future_study_exist=$jos_future_study_table->getFutureStudyByArrayConditionAndArrayColumns(array('year_id'=>$year_id, 'user_id'=>$id_giang_vien, 'subject_name'=>$post['subject_name']), array());
              if(!$future_study_exist){
                $future_study_new=new JosFutureStudy();
                $future_study_new->exchangeArray($post);
                $future_study_new->setUserId($id_giang_vien);
                $future_study_new->setYearId($year_id);

                $time_from = date('Y-m-d',strtotime($post['time_from']));
                $future_study_new->setTimeFrom($time_from);

                $time_to = date('Y-m-d',strtotime($post['time_to']));
                $future_study_new->setTimeTo($time_to);

                $jos_future_study_table->saveJosFutureStudy($future_study_new);
                $this->flashMessenger()->addSuccessMessage('Chúc mừng thêm mới thành công!');
                return $this->redirect()->toRoute('application/crud', array('action'=>'index', 'id'=>$id_giang_vien));
              }          
            }
          }
        }
      }
      if(isset($id_giang_vien)){
        $this->flashMessenger()->addErrorMessage('Bạn không có quyền truy cập. Vui lòng kiểm tra lại!');
        return $this->redirect()->toRoute('application/crud', array('action'=>'index', 'id'=>$id_giang_vien));
      }  
      $this->flashMessenger()->addErrorMessage('Bạn không có quyền truy cập. Vui lòng kiểm tra lại!');
      return $this->redirect()->toRoute('application/crud', array('action'=>'index'));     
    }

    /*
      ĐỊNH HƯỚNG PHÁT TRIỂN
        phần 3: học tập nâng cao trình độ - edit
    */
    public function editFutureStudyAction(){
      // điểm truy cập csdl
      $jos_users_table=$this->getServiceLocator()->get('Permission\Model\JosUsersTable');
      $jos_year_table=$this->getServiceLocator()->get('NamHoc\Model\JosYearTable');
      $jos_future_study_table=$this->getServiceLocator()->get('Application\Model\JosFutureStudyTable');
      $id_giang_vien=$this->params('id');
      $read=$this->getServiceLocator()->get('AuthService')->getStorage()->read();
      if(isset($read['username']) and $read['username']){
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
        if($user and isset($user[0]['id']) and $id_giang_vien==$user[0]['id']){   
          // nếu đã đăng nhập            
          $edit_all_profile=1;
        }
        // có quyền
        if($edit_all_profile==1){
          $request=$this->getRequest();
          if($request->isPost()){
            $post=$request->getPost();
            $edit_future_study_form=new EditFutureStudyForm();
            $edit_future_study_form->setData($post);
            if($edit_future_study_form->isValid()){
              // lấy year_id default
              $year=$jos_year_table->getYearByArrayConditionAndArrayColumn(array('is_active'=>1));
              if(!$year or !isset($year[0]['year_id'])){
                die('Lỗi, Không xác định được năm cần sửa');
              }
              $year_id=$year[0]['year_id'];
              // Kiểm tra nếu science_research đã tồn tại thì không add, ko tồn tại thì add
              $future_study_exist=$jos_future_study_table->getFutureStudyByArrayConditionAndArrayColumns(array('user_id'=>$id_giang_vien, 'year_id'=>$year_id, 'subject_name'=>$post['subject_name']), array());
              if(!$future_study_exist or ($future_study_exist and $future_study_exist[0]['value_id']==$post['value_id'])){
                $future_study_new=new JosFutureStudy();
                $future_study_new->exchangeArray($post);
                $future_study_new->setUserId($id_giang_vien);
                $future_study_new->setYearId($year_id);
                
                $time_from = date('Y-m-d',strtotime($post['time_from']));
                $future_study_new->setTimeFrom($time_from);
               
                $time_to = date('Y-m-d',strtotime($post['time_to']));
                $future_study_new->setTimeTo($time_to);
                
                $jos_future_study_table->saveJosFutureStudy($future_study_new);
                
                $this->flashMessenger()->addSuccessMessage('Chúc mừng cập nhật thành công!');
                return $this->redirect()->toRoute('application/crud', array('action'=>'index', 'id'=>$id_giang_vien));
              }          
            }
          }
        }
      }
      if(isset($id_giang_vien)){
        $this->flashMessenger()->addErrorMessage('Bạn không có quyền truy cập. Vui lòng kiểm tra lại!');
        return $this->redirect()->toRoute('application/crud', array('action'=>'index', 'id'=>$id_giang_vien));
      }  
      $this->flashMessenger()->addErrorMessage('Bạn không có quyền truy cập. Vui lòng kiểm tra lại!');
      return $this->redirect()->toRoute('application/crud', array('action'=>'index'));     
    }

    /*
      ĐỊNH HƯỚNG PHÁT TRIỂN
        phần 3: học tập nâng cao trình độ - delete
    */
    public function deleteFutureStudyAction(){
      // điểm truy cập csdl
      $jos_users_table=$this->getServiceLocator()->get('Permission\Model\JosUsersTable');
      $jos_year_table=$this->getServiceLocator()->get('NamHoc\Model\JosYearTable');
      $jos_future_study_table=$this->getServiceLocator()->get('Application\Model\JosFutureStudyTable');
      $id=$this->params('id');
      $read=$this->getServiceLocator()->get('AuthService')->getStorage()->read();
      if(isset($read['username']) and $read['username']){
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

        // lấy year_id default
        $year=$jos_year_table->getYearByArrayConditionAndArrayColumn(array('is_active'=>1));
        if(!$year or !isset($year[0]['year_id'])){
          die('Lỗi, Không xác định được năm cần sửa');
        }
        $year_id=$year[0]['year_id'];
        // Kiểm tra nếu science_research đã tồn tại thì không add, ko tồn tại thì add
        $future_study_exist=$jos_future_study_table->getFutureStudyByArrayConditionAndArrayColumns(array('value_id'=>$id, 'year_id'=>$year_id), array('user_id'));
        if($future_study_exist and $user and isset($user[0]['id'])){
          if(isset($future_study_exist[0]['user_id']) and ($future_study_exist[0]['user_id']==$user[0]['id'] or $edit_all_profile==1)){
            // được quyền xóa
            $jos_future_study_table->deleteFutureStudyById($id);
            $this->flashMessenger()->addSuccessMessage('Chúc mừng xóa thành công!');
            return $this->redirect()->toRoute('application/crud', array('action'=>'index', 'id'=>$user[0]['id']));
          }
        }        
      }
      if(isset($future_study_exist[0]['user_id'])){
        $this->flashMessenger()->addErrorMessage('Bạn không có quyền truy cập. Vui lòng kiểm tra lại!');
        return $this->redirect()->toRoute('application/crud', array('action'=>'index', 'id'=>$future_study_exist[0]['user_id']));
      }  
      $this->flashMessenger()->addErrorMessage('Bạn không có quyền truy cập. Vui lòng kiểm tra lại!');
      return $this->redirect()->toRoute('application/crud', array('action'=>'index'));     
    }


    /*
      ĐỊNH HƯỚNG PHÁT TRIỂN
        phần 4: công tác khác - add
    */
    public function addFutureOrtherWorkAction(){
      // điểm truy cập csdl
      $jos_users_table=$this->getServiceLocator()->get('Permission\Model\JosUsersTable');
      $jos_year_table=$this->getServiceLocator()->get('NamHoc\Model\JosYearTable');
      $jos_future_orther_work_table=$this->getServiceLocator()->get('Application\Model\JosFutureOrtherWorkTable');
      $id_giang_vien=$this->params('id');
      $read=$this->getServiceLocator()->get('AuthService')->getStorage()->read();
      if(isset($read['username']) and $read['username']){
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
        if($user and isset($user[0]['id']) and $id_giang_vien==$user[0]['id']){   
          // nếu đã đăng nhập            
          $edit_all_profile=1;
        }
        // có quyền
        if($edit_all_profile==1){
          $request=$this->getRequest();
          if($request->isPost()){
            $post=$request->getPost();
            $add_future_orther_work_form=new AddFutureOrtherWorkForm();
            $add_future_orther_work_form->setData($post);
            if($add_future_orther_work_form->isValid()){
              // lấy year_id default
              $year=$jos_year_table->getYearByArrayConditionAndArrayColumn(array('is_active'=>1));
              if(!$year or !isset($year[0]['year_id'])){
                die('Lỗi, Không xác định được năm cần sửa');
              }
              $year_id=$year[0]['year_id'];
              // Kiểm tra nếu orther_work đã tồn tại thì không add, ko tồn tại thì add
              $future_orther_work_exist=$jos_future_orther_work_table->getFutureOrtherWorkByArrayConditionAndArrayColumns(array('year_id'=>$year_id, 'user_id'=>$id_giang_vien, 'content'=>$post['content']), array());
              if(!$future_orther_work_exist){
                $future_orther_work_new=new JosFutureOrtherWork();
                $future_orther_work_new->exchangeArray($post);
                $future_orther_work_new->setUserId($id_giang_vien);
                $future_orther_work_new->setYearId($year_id);

                $time_from = date('Y-m-d',strtotime($post['time_from']));
                $future_orther_work_new->setTimeFrom($time_from);

                $time_to = date('Y-m-d',strtotime($post['time_to']));
                $future_orther_work_new->setTimeTo($time_to);

                $jos_future_orther_work_table->saveJosFutureOrtherWork($future_orther_work_new);
                $this->flashMessenger()->addSuccessMessage('Chúc mừng thêm mới thành công!');
                return $this->redirect()->toRoute('application/crud', array('action'=>'index', 'id'=>$id_giang_vien));
              }          
            }
          }
        }
      }
      if(isset($id_giang_vien)){
        $this->flashMessenger()->addErrorMessage('Bạn không có quyền truy cập. Vui lòng kiểm tra lại!');
        return $this->redirect()->toRoute('application/crud', array('action'=>'index', 'id'=>$id_giang_vien));
      }  
      $this->flashMessenger()->addErrorMessage('Bạn không có quyền truy cập. Vui lòng kiểm tra lại!');
      return $this->redirect()->toRoute('application/crud', array('action'=>'index'));     
    }

    /*
      ĐỊNH HƯỚNG PHÁT TRIỂN
        phần 4: công tác khác - edit
    */
    public function editFutureOrtherWorkAction(){
      // điểm truy cập csdl
      $jos_users_table=$this->getServiceLocator()->get('Permission\Model\JosUsersTable');
      $jos_year_table=$this->getServiceLocator()->get('NamHoc\Model\JosYearTable');
      $jos_future_orther_work_table=$this->getServiceLocator()->get('Application\Model\JosFutureOrtherWorkTable');
      $id_giang_vien=$this->params('id');
      $read=$this->getServiceLocator()->get('AuthService')->getStorage()->read();
      if(isset($read['username']) and $read['username']){
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
        if($user and isset($user[0]['id']) and $id_giang_vien==$user[0]['id']){   
          // nếu đã đăng nhập            
          $edit_all_profile=1;
        }
        // có quyền
        if($edit_all_profile==1){
          $request=$this->getRequest();
          if($request->isPost()){
            $post=$request->getPost();
            $edit_future_orther_work_form=new EditFutureOrtherWorkForm();
            $edit_future_orther_work_form->setData($post);
            if($edit_future_orther_work_form->isValid()){
              // lấy year_id default
              $year=$jos_year_table->getYearByArrayConditionAndArrayColumn(array('is_active'=>1));
              if(!$year or !isset($year[0]['year_id'])){
                die('Lỗi, Không xác định được năm cần sửa');
              }
              $year_id=$year[0]['year_id'];
              // Kiểm tra nếu science_research đã tồn tại thì không add, ko tồn tại thì add
              $future_orther_work_exist=$jos_future_orther_work_table->getFutureOrtherWorkByArrayConditionAndArrayColumns(array('user_id'=>$id_giang_vien, 'year_id'=>$year_id, 'content'=>$post['content']), array());
              if(!$future_orther_work_exist or ($future_orther_work_exist and $future_orther_work_exist[0]['value_id']==$post['value_id'])){
                $future_orther_work_new=new JosFutureOrtherWork();
                $future_orther_work_new->exchangeArray($post);
                $future_orther_work_new->setUserId($id_giang_vien);
                $future_orther_work_new->setYearId($year_id);
                
                $time_from = date('Y-m-d',strtotime($post['time_from']));
                $future_orther_work_new->setTimeFrom($time_from);
               
                $time_to = date('Y-m-d',strtotime($post['time_to']));
                $future_orther_work_new->setTimeTo($time_to);
                
                $jos_future_orther_work_table->saveJosFutureOrtherWork($future_orther_work_new);
                //die(var_dump($future_orther_work_new));
                $this->flashMessenger()->addSuccessMessage('Chúc mừng cập nhật thành công!');
                return $this->redirect()->toRoute('application/crud', array('action'=>'index', 'id'=>$id_giang_vien));
              }          
            }
          }
        }
      }
      if(isset($id_giang_vien)){
        $this->flashMessenger()->addErrorMessage('Bạn không có quyền truy cập. Vui lòng kiểm tra lại!');
        return $this->redirect()->toRoute('application/crud', array('action'=>'index', 'id'=>$id_giang_vien));
      }  
      $this->flashMessenger()->addErrorMessage('Bạn không có quyền truy cập. Vui lòng kiểm tra lại!');
      return $this->redirect()->toRoute('application/crud', array('action'=>'index'));     
    }

    /*
      ĐỊNH HƯỚNG PHÁT TRIỂN
        phần 4: công tác khác - delete
    */
    public function deleteFutureOrtherWorkAction(){
      // điểm truy cập csdl
      $jos_users_table=$this->getServiceLocator()->get('Permission\Model\JosUsersTable');
      $jos_year_table=$this->getServiceLocator()->get('NamHoc\Model\JosYearTable');
      $jos_future_orther_work_table=$this->getServiceLocator()->get('Application\Model\JosFutureOrtherWorkTable');
      $id=$this->params('id');
      $read=$this->getServiceLocator()->get('AuthService')->getStorage()->read();
      if(isset($read['username']) and $read['username']){
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

        // lấy year_id default
        $year=$jos_year_table->getYearByArrayConditionAndArrayColumn(array('is_active'=>1));
        if(!$year or !isset($year[0]['year_id'])){
          die('Lỗi, Không xác định được năm cần sửa');
        }
        $year_id=$year[0]['year_id'];
        // Kiểm tra nếu science_research đã tồn tại thì không add, ko tồn tại thì add
        $future_orther_work_exist=$jos_future_orther_work_table->getFutureOrtherWorkByArrayConditionAndArrayColumns(array('value_id'=>$id, 'year_id'=>$year_id), array('user_id'));
        if($future_orther_work_exist and $user and isset($user[0]['id'])){
          if(isset($future_orther_work_exist[0]['user_id']) and ($future_orther_work_exist[0]['user_id']==$user[0]['id'] or $edit_all_profile==1)){
            // được quyền xóa
            $jos_future_orther_work_table->deleteFutureOrtherWorkById($id);
            $this->flashMessenger()->addSuccessMessage('Chúc mừng xóa thành công!');
            return $this->redirect()->toRoute('application/crud', array('action'=>'index', 'id'=>$user[0]['id']));
          }
        }        
      }
      if(isset($user[0]['id'])){
        $this->flashMessenger()->addErrorMessage('Bạn không có quyền truy cập. Vui lòng kiểm tra lại!');
        return $this->redirect()->toRoute('application/crud', array('action'=>'index', 'id'=>$user[0]['id']));
      }  
      $this->flashMessenger()->addErrorMessage('Bạn không có quyền truy cập. Vui lòng kiểm tra lại!');
      return $this->redirect()->toRoute('application/crud', array('action'=>'index'));     
    }


    /*
      CÁC BÀI BÁO CÁO ĐÃ CÔNG BỐ
        add
    */
    public function addScientificReportAction(){
      // điểm truy cập csdl
      $jos_users_table=$this->getServiceLocator()->get('Permission\Model\JosUsersTable');
      $jos_year_table=$this->getServiceLocator()->get('NamHoc\Model\JosYearTable');
      $jos_scientific_report_table=$this->getServiceLocator()->get('Application\Model\JosScientificReportTable');
      $id_giang_vien=$this->params('id');
      $read=$this->getServiceLocator()->get('AuthService')->getStorage()->read();
      if(isset($read['username']) and $read['username']){
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
        if($user and isset($user[0]['id']) and $id_giang_vien==$user[0]['id']){   
          // nếu đã đăng nhập            
          $edit_all_profile=1;
        }
        // có quyền
        if($edit_all_profile==1){
          $request=$this->getRequest();
          if($request->isPost()){
            $post=$request->getPost();
            $add_scientific_report_form=new AddScientificReportForm();
            $add_scientific_report_form->setData($post);
            if($add_scientific_report_form->isValid()){
              // lấy year_id default
              $year=$jos_year_table->getYearByArrayConditionAndArrayColumn(array('is_active'=>1));
              if(!$year or !isset($year[0]['year_id'])){
                die('Lỗi, Không xác định được năm cần sửa');
              }
              $year_id=$year[0]['year_id'];
              // Kiểm tra nếu orther_work đã tồn tại thì không add, ko tồn tại thì add
              $scientific_report_exist=$jos_scientific_report_table->getScientificReportByArrayConditionAndArrayColumns(array('year_id'=>$year_id, 'user_id'=>$id_giang_vien, 'name'=>$post['name']), array());
              if(!$scientific_report_exist){
                $scientific_report_new=new JosScientificReport();
                $scientific_report_new->exchangeArray($post);
                $scientific_report_new->setUserId($id_giang_vien);
                $scientific_report_new->setYearId($year_id);

                $publish_date = date('Y-m-d',strtotime($post['publish_date']));
                $scientific_report_new->setPublishDate($publish_date);                

                $jos_scientific_report_table->saveJosScientificReport($scientific_report_new);
                $this->flashMessenger()->addSuccessMessage('Chúc mừng thêm mới thành công!');
                return $this->redirect()->toRoute('application/crud', array('action'=>'index', 'id'=>$id_giang_vien));
              }          
            }
          }
        }
      }
      if(isset($id_giang_vien)){
        $this->flashMessenger()->addErrorMessage('Bạn không có quyền truy cập. Vui lòng kiểm tra lại!');
        return $this->redirect()->toRoute('application/crud', array('action'=>'index', 'id'=>$id_giang_vien));
      }  
      $this->flashMessenger()->addErrorMessage('Bạn không có quyền truy cập. Vui lòng kiểm tra lại!');
      return $this->redirect()->toRoute('application/crud', array('action'=>'index'));     
    }
    
    /*
      CÁC BÀI BÁO CÁO ĐÃ CÔNG BỐ
        edit
    */
    public function editScientificReportAction(){
      // điểm truy cập csdl
      $jos_users_table=$this->getServiceLocator()->get('Permission\Model\JosUsersTable');
      $jos_year_table=$this->getServiceLocator()->get('NamHoc\Model\JosYearTable');
      $jos_scientific_report_table=$this->getServiceLocator()->get('Application\Model\JosScientificReportTable');
      $id_giang_vien=$this->params('id');
      $read=$this->getServiceLocator()->get('AuthService')->getStorage()->read();
      if(isset($read['username']) and $read['username']){
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
        if($user and isset($user[0]['id']) and $id_giang_vien==$user[0]['id']){   
          // nếu đã đăng nhập            
          $edit_all_profile=1;
        }
        // có quyền
        if($edit_all_profile==1){
          $request=$this->getRequest();
          if($request->isPost()){
            $post=$request->getPost();
            $edit_scientific_report_form=new EditScientificReportForm();
            $edit_scientific_report_form->setData($post);
            if($edit_scientific_report_form->isValid()){
              // lấy year_id default
              $year=$jos_year_table->getYearByArrayConditionAndArrayColumn(array('is_active'=>1));
              if(!$year or !isset($year[0]['year_id'])){
                die('Lỗi, Không xác định được năm cần sửa');
              }
              $year_id=$year[0]['year_id'];
              // Kiểm tra nếu science_research đã tồn tại thì không add, ko tồn tại thì add
              $scientific_report_exist=$jos_scientific_report_table->getScientificReportByArrayConditionAndArrayColumns(array('user_id'=>$id_giang_vien, 'year_id'=>$year_id, 'name'=>$post['name']), array());
              if(!$scientific_report_exist or ($scientific_report_exist and $scientific_report_exist[0]['value_id']==$post['value_id'])){
                $scientific_report_new=new JosScientificReport();
                $scientific_report_new->exchangeArray($post);
                $scientific_report_new->setUserId($id_giang_vien);
                $scientific_report_new->setYearId($year_id);
                
                $publish_date = date('Y-m-d',strtotime($post['publish_date']));
                $scientific_report_new->setPublishDate($publish_date);
                              
                $jos_scientific_report_table->saveJosScientificReport($scientific_report_new);
                $this->flashMessenger()->addSuccessMessage('Chúc mừng cập nhật thành công!');
                return $this->redirect()->toRoute('application/crud', array('action'=>'index', 'id'=>$id_giang_vien));
              }          
            }
          }
        }
      }
      if(isset($id_giang_vien)){
        $this->flashMessenger()->addErrorMessage('Bạn không có quyền truy cập. Vui lòng kiểm tra lại!');
        return $this->redirect()->toRoute('application/crud', array('action'=>'index', 'id'=>$id_giang_vien));
      }  
      $this->flashMessenger()->addErrorMessage('Bạn không có quyền truy cập. Vui lòng kiểm tra lại!');
      return $this->redirect()->toRoute('application/crud', array('action'=>'index'));     
    }

    /*
      CÁC BÀI BÁO CÁO ĐÃ CÔNG BỐ
        delete
    */
    public function deleteScientificReportAction(){
      // điểm truy cập csdl
      $jos_users_table=$this->getServiceLocator()->get('Permission\Model\JosUsersTable');
      $jos_year_table=$this->getServiceLocator()->get('NamHoc\Model\JosYearTable');
      $jos_scientific_report_table=$this->getServiceLocator()->get('Application\Model\JosScientificReportTable');
      $id=$this->params('id');
      $read=$this->getServiceLocator()->get('AuthService')->getStorage()->read();
      if(isset($read['username']) and $read['username']){
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

        // lấy year_id default
        $year=$jos_year_table->getYearByArrayConditionAndArrayColumn(array('is_active'=>1));
        if(!$year or !isset($year[0]['year_id'])){
          die('Lỗi, Không xác định được năm cần sửa');
        }
        $year_id=$year[0]['year_id'];
        // Kiểm tra nếu science_research đã tồn tại thì không add, ko tồn tại thì add
        $scientific_report_exist=$jos_scientific_report_table->getScientificReportByArrayConditionAndArrayColumns(array('value_id'=>$id, 'year_id'=>$year_id), array('user_id'));
        if($scientific_report_exist and $user and isset($user[0]['id'])){
          if(isset($scientific_report_exist[0]['user_id']) and ($scientific_report_exist[0]['user_id']==$user[0]['id'] or $edit_all_profile==1)){
            // được quyền xóa
            $jos_scientific_report_table->deleteScientificReportById($id);
            $this->flashMessenger()->addSuccessMessage('Chúc mừng xóa thành công!');
            return $this->redirect()->toRoute('application/crud', array('action'=>'index', 'id'=>$scientific_report_exist[0]['user_id']));
          }
        }        
      }
      if(isset($user[0]['id'])){
        $this->flashMessenger()->addErrorMessage('Bạn không có quyền truy cập. Vui lòng kiểm tra lại!');
        return $this->redirect()->toRoute('application/crud', array('action'=>'index', 'id'=>$user[0]['id']));
      }  
      $this->flashMessenger()->addErrorMessage('Bạn không có quyền truy cập. Vui lòng kiểm tra lại!');
      return $this->redirect()->toRoute('application/crud', array('action'=>'index'));     
    }


    
    public function editAction()
    {
    }

    public function editAllProfileAction()
    {
    }
    
  
}
