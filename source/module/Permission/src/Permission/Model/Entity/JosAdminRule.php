<?php
namespace Permission\Model\Entity;

class JosAdminRule
{
    protected $rule_id;

    protected $resource_id;

    protected $role_id;
    

    public function exchangeArray($data)
    {
        $this->rule_id = (isset($data['rule_id'])) ? $data['rule_id'] : null;
        $this->resource_id = (isset($data['resource_id'])) ? $data['resource_id'] : 1;
        $this->role_id = (isset($data['role_id'])) ? $data['role_id'] : 1;
    }

    public function getArrayCopy()
    {
        return get_object_vars($this);
    }

    public function setRuleId($rule_id){
        $this->rule_id=$rule_id;
    }
    public function getRuleId(){
        return $this->rule_id;
    }

    public function setResourceId($resource_id)
    {
        $this->resource_id = $resource_id;
    }

    public function getResourceId()
    {
        return $this->resource_id;
    }

    public function setRoleId($role_id){
        $this->role_id=$role_id;
    }
    public function getRoleId(){
        return $this->role_id;
    }
}
