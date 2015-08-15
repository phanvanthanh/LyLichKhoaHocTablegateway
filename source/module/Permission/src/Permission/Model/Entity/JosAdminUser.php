<?php
namespace Permission\Model\Entity;

class JosAdminUser
{
    protected $user_id;

    protected $user_name;

    public function exchangeArray($data)
    {
        $this->user_id = (isset($data['user_id'])) ? $data['user_id'] : null;
        $this->user_name = (isset($data['user_name'])) ? $data['user_name'] : null;
    }

    public function getArrayCopy()
    {
        return get_object_vars($this);
    }

    public function setUserId($user_id){
        $this->user_id=$user_id;
    }
    public function getUserId(){
        return $this->user_id;
    }

    public function setUserName($user_name){
        $this->user_name=$user_name;
    }
    public function getUserName(){
        return $this->user_name;
    }
}
