<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/NgoaiNgu for the canonical source repository
 * @copyright Copyright (c) 2005-2014 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace ChungChiKhac\Controller;

use Zend\Mvc\Controller\AbstractActionController;

use ChungChiKhac\Form\AddCertificateForm;
use ChungChiKhac\Form\EditCertificateForm;
use ChungChiKhac\Model\Entity\JosCertificate;

class ChungChiKhacController extends AbstractActionController
{
    public function indexAction()
    {
    	// mảng trả về
    	$return_array =array();
    	// tạo điểm truy cập csdl jos_subject
    	$jos_certificate_table=$this->getServiceLocator()->get('ChungChiKhac\Model\JosCertificateTable');
    	// lấy tất cả môn học theo năm kích hoạt
    	$all_certificates=$jos_certificate_table->getCertificateByYearActive();
    	$return_array['all_certificates']=$all_certificates;
    	// add form
    	$add_form=new AddCertificateForm();
    	$return_array['add_form']=$add_form;

    	// edit form
    	$edit_form=new EditCertificateForm();
    	$return_array['edit_form']=$edit_form;


    	return $return_array;


    }

    public function addAction(){
        // add form
        $add_form=new AddCertificateForm();

        $request=$this->getRequest();
        if($request->isPost()){
            $post=$request->getPost();
            $add_form->setData($post);
            if($add_form->isValid()){
                $name=$post['name'];
                // khai báo model bảng jos_year
                $jos_year_table=$this->getServiceLocator()->get('NamHoc\Model\JosYearTable');
                // lấy year_id default
                $years=$jos_year_table->getYearByArrayConditionAndArrayColumn(array('is_active'));
                // không tồn tại year default
                if(!$years){
                    $this->flashMessenger()->addErrorMessage('Lỗi. Bạn muốn thêm chứng chỉ này vào năm học nào? Vui lòng kiểm tra lại!');
                    return $this->redirect()->toRoute('chung_chi_khac/crud', array('action'=>'index'));
                }
                // tạo điểm truy cập csdl jos_certificate
                $jos_certificate_table=$this->getServiceLocator()->get('ChungChiKhac\Model\JosCertificateTable');
                // kiểm tra với năm hiện tại có tồn tại chứng chỉ này chưa
                $jos_certificate_exist=$jos_certificate_table->getCertificateByArrayConditionAndArrayColumn(array('name'=>$name, 'year_id'=>$years[0]['year_id']));
                if($jos_certificate_exist){
                    $this->flashMessenger()->addErrorMessage('Lỗi. Chứng chỉ vừa thêm đã tồn tại. Vui lòng kiểm tra lại!');
                    return $this->redirect()->toRoute('chung_chi_khac/crud', array('action'=>'index'));
                }
                // thêm vào csdl
                $new_certificate=new JosCertificate();
                $new_certificate->setName($name);
                $new_certificate->setYearId($years[0]['year_id']);
                // lưu môn học
                $jos_certificate_table->saveCertificate($new_certificate);
                // lưu thành công
                $this->flashMessenger()->addSuccessMessage('Chúc mừng, thêm chứng chỉ mới thành công!');
                return $this->redirect()->toRoute('chung_chi_khac/crud', array('action'=>'index'));
                
            }
        }
        $this->flashMessenger()->addErrorMessage('Lỗi, thực thi không thành công. Vui lòng kiểm tra lại!');
        return $this->redirect()->toRoute('mon_hoc/crud', array('action'=>'index'));
                
                
    }

    public function editAction(){
        // edit form
        $edit_form=new EditCertificateForm();

        $request=$this->getRequest();
        if($request->isPost()){
            $post=$request->getPost();
            $edit_form->setData($post);
            if($edit_form->isValid()){
                // khai báo model bảng jos_year
                $jos_year_table=$this->getServiceLocator()->get('NamHoc\Model\JosYearTable');
                // lấy year_id default
                $years=$jos_year_table->getYearByArrayConditionAndArrayColumn(array('is_active'));
                // không tồn tại year default
                if(!$years){
                    $this->flashMessenger()->addErrorMessage('Lỗi. Bạn muốn thêm chứng chỉ này vào năm học nào? Vui lòng kiểm tra lại!');
                    return $this->redirect()->toRoute('chung_chi_khac/crud', array('action'=>'index'));
                }
                // tạo điểm truy cập csdl jos_certificate
                $jos_certificate_table=$this->getServiceLocator()->get('ChungChiKhac\Model\JosCertificateTable');
                // kiểm tra id vừa post có tồn tại không
                $certificate=$jos_certificate_table->getCertificateByArrayConditionAndArrayColumn(array('value_id'=>$post['value_id']), array('year_id'));
                if(!$certificate){
                    $this->flashMessenger()->addErrorMessage('Lỗi. Chứng chỉ cần sửa không tồn tại. Vui lòng kiểm tra lại!');
                    return $this->redirect()->toRoute('chung_chi_khac/crud', array('action'=>'index'));
                }
                // kiểm tra với năm hiện tại có tồn tại dòng nào có tên như trên chưa
                // nếu có kiểm tra có khác id không
                $jos_certificate_exist=$jos_certificate_table->getCertificateByArrayConditionAndArrayColumn(array('name'=>$post['name'], 'year_id'=>$years[0]['year_id']), array('value_id'));
                if($jos_certificate_exist and $post['value_id']!=$jos_certificate_exist[0]['value_id']){
                    $this->flashMessenger()->addErrorMessage('Lỗi. Tên chứng chỉ này đã tồn tại. Vui lòng kiểm tra lại!');
                    return $this->redirect()->toRoute('chung_chi_khac/crud', array('action'=>'index'));
                }
                // luu lại
                $new_certificate=new JosCertificate();
                $new_certificate->exchangeArray($post);
                $new_certificate->setYearId($certificate[0]['year_id']);
                $jos_certificate_table->saveCertificate($new_certificate);
                // thông báo thành công
                $this->flashMessenger()->addSuccessMessage('Chúc mừng, cập nhật chứng chỉ thành công!');
                return $this->redirect()->toRoute('chung_chi_khac/crud', array('action'=>'index'));
            }
        }
        $this->flashMessenger()->addErrorMessage('Lỗi, thực thi không thành công. Vui lòng kiểm tra lại!');
        return $this->redirect()->toRoute('chung_chi_khac/crud', array('action'=>'index'));
         


    }

    public function deleteAction(){
    	// lấy id certificate
    	$value_id=$this->params('id');
    	// tạo điểm kết nối csdl bảng jos_certificate_table
    	$jos_certificate_table=$this->getServiceLocator()->get('ChungChiKhac\Model\JosCertificateTable');
    	$certificate_exist=$jos_certificate_table->getCertificateByArrayConditionAndArrayColumn(array('value_id'=>$value_id), array('name'));
    	if(!$certificate_exist){
    		$this->flashMessenger()->addErrorMessage('Lỗi, Chứng chỉ cần xóa không tồn tại. Vui lòng kiểm tra lại!');
    		return $this->redirect()->toRoute('chung_chi_khac/crud', array('action'=>'index'));
    	}
    	// xóa certificate theo value_id
    	$jos_certificate_table->deleteCertificateById($value_id);
    	$this->flashMessenger()->addSuccessMessage('Chúc mừng, Xóa chứng chỉ thành công!');
    	return $this->redirect()->toRoute('chung_chi_khac/crud', array('action'=>'index'));
    }
}
