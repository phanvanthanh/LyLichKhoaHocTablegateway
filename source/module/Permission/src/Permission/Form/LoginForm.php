<?php
namespace Permission\Form;

use Zend\Form\Form;

class LoginForm extends Form
{

    public function __construct()
    {
        parent::__construct("login_form");
        $this->setAttribute('method', 'post');
        
        $this->add(array(
            'name' => 'username',
            'type' => 'Zend\Form\Element\Text',    
            
            'options' => array(
                'label' => "Username:",
                
            ),
            'attributes' => array(
                'required' => true,
                'placeholder'=>'Nhập tên đăng nhập',
                'title' => 'Tên đăng nhập',
                'class' => 'form-control'
            )
        ));
        
        $this->add(array(
            'name' => 'password',
            'type' => 'Zend\Form\Element\Password',
            'options' => array(
                'label' => "Mật khẩu:"
            ),
            'attributes' => array(
                'required' => true,
                'placeholder'=>'Nhập mật khẩu',
                'title' => 'Mật khẩu',
                'class' => ' form-control'
            )
        ));

        $this->add(array(
            'name' => 'url',
            'type' => 'Zend\Form\Element\Hidden'
        ));
        
        $this->add(array(
            'name' => 'submit',
            'type' => 'Zend\Form\Element\Submit',
            'attributes' => array(
                'value' => 'Đăng nhập',
                'class' => 'btn btn-default btn-block',
                'title' => 'Đăng nhập'
            )
        ));
    }
}