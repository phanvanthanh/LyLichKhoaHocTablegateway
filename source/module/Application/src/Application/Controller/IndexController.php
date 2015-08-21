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
       	//die(var_dump($id));

       	// trả dữ liệu ra view
       	return $return_array;


    }

    public function editAction()
    {
       
    }

    public function editAllProfileAction(){
    	
    }
}
