<?php
namespace Application\Model\Entity;

class JosInfomation
{

    protected $value_id;

    protected $attribute_id;

    protected $user_id;

    protected $value;

    public function exchangeArray($data)
    {
        $this->value_id = (isset($data['value_id'])) ? $data['value_id'] : null;
        $this->attribute_id = (isset($data['attribute_id'])) ? $data['attribute_id'] : null;        
        $this->user_id = (isset($data['user_id'])) ? $data['user_id'] : null;
        $this->value = (isset($data['value'])) ? $data['value'] : 'Text';
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

    public function setAttributeId($attribute_id){
        $this->attribute_id=$attribute_id;
    }
    public function getAttributeId(){
        return $this->attribute_id;
    }

    public function setUserId($user_id){
        $this->user_id=$user_id;
    }
    public function getUserId(){
        return $this->user_id;
    }

    public function setValue($value){
        $this->value=$value;
    }
    public function getValue(){
        return $this->value;
    }
    

}
