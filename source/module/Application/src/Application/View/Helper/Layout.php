<?php
namespace Application\View\Helper;

use Zend\View\Helper\AbstractHelper;
use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class Layout extends AbstractHelper implements ServiceLocatorAwareInterface
{

    private $serviceLocator;

    public function getServiceLocator()
    {
        if (! $this->serviceLocator) {
            $this->serviceLocator = $this->setServiceLocator();
        }
        return $this->serviceLocator;
    }

    public function setServiceLocator(ServiceLocatorInterface $serviceLocator)
    {
        $this->serviceLocator = $serviceLocator;
    }

    public function __invoke()
    {

        $mvcEvent=$this->getServiceLocator()->getServiceLocator()->get('application')->getMvcEvent();
        $match=$mvcEvent->getRouteMatch();
        if(!$match){
            die('Route khong dung. Vui long kiem tra lai!');
        }
        $params=$match->getParams();
        // return array
        $return_array=array();
        //Get form login
        $login_form = $this->getServiceLocator()->getServiceLocator()->get('Permission\Form\LoginForm');
        // Get list giảng viên
        $jos_users_table = $this->getServiceLocator()->getServiceLocator()->get('Permission\Model\JosUsersTable');
        $danh_sach_giang_viens=$jos_users_table->getDanhSachGiangVien();        

        // id giang vien mặc định để đánh dấu đang chọn giảng viên nào trong bảng danh sách giảng viên trong layout
        if($params['controller']=='Application\Controller\Index'){           
            if(isset($params['id']) and $params['id']){
                $id_giang_vien_mac_dinh=$params['id'];
                $return_array['id_giang_vien_mac_dinh']=$id_giang_vien_mac_dinh;
            }
            else{
                if(isset($danh_sach_giang_viens[0]['id']) and $danh_sach_giang_viens[0]['id']){
                    $id_giang_vien_mac_dinh=$danh_sach_giang_viens[0]['id'];
                    $return_array['id_giang_vien_mac_dinh']=$id_giang_vien_mac_dinh;
                }            
            }
        }
        $return_array['danh_sach_giang_viens']=$danh_sach_giang_viens;
        $return_array['login_form']=$login_form;        
        return $return_array;
    }
}
?>