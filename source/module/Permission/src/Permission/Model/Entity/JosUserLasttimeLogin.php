<?php
namespace Permission\Model\Entity;

class JosUserLasttimeLogin
{

    protected $value_id;

    protected $user_id;

    protected $year_id;

    protected $lasttime_login;


    public function exchangeArray($data)
    {
        $this->value_id = (isset($data['value_id'])) ? $data['value_id'] : null;
        $this->user_id = (isset($data['user_id'])) ? $data['user_id'] : null;
        $this->lasttime_login = (isset($data['lasttime_login'])) ? $data['lasttime_login'] : null;
        
    }

    public function getArrayCopy()
    {
        return get_object_vars($this);
    }

    public function setValueId($value_id){
        $this->value_id=$value_id;
    }
    public function getValueId(){
        return $this->value_id;
    }

    public function setUserId($user_id){
        $this->user_id=$user_id;
    }
    public function getUserId(){
        return $this->user_id;
    }   

    public function setLasttimeLogin($lasttime_login){
        $this->lasttime_login=$lasttime_login;
    }
    public function getLasttimeLogin(){
        return $this->lasttime_login;
    }
}
