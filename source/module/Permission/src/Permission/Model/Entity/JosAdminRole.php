<?php
namespace Permission\Model\Entity;

class JosAdminRole
{

    protected $role_id;

    protected $role_name;


    public function exchangeArray($data)
    {
        $this->role_id = (isset($data['role_id'])) ? $data['role_id'] : null;
        $this->role_name = (isset($data['role_name'])) ? $data['role_name'] : null;
        
    }

    public function getArrayCopy()
    {
        return get_object_vars($this);
    }

    public function setRoleId($role_id){
        $this->role_id=$role_id;
    }
    public function getRoleId(){
        return $this->role_id;
    }

    public function setRoleName($role_name){
        $this->role_name=$role_name;
    }
    public function getRoleName(){
        return $this->role_name;
    }
}
