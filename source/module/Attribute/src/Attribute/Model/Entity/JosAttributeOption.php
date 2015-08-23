<?php
namespace Attribute\Model\Entity;

class JosAttributeOption
{

    protected $value_id;

    protected $attribute_id;

    protected $key;

    protected $label;

    public function exchangeArray($data)
    {
        $this->attribute_id = (isset($data['attribute_id'])) ? $data['attribute_id'] : null;
        $this->value_id = (isset($data['value_id'])) ? $data['value_id'] : null;
        $this->key = (isset($data['key'])) ? $data['key'] : null;
        $this->label = (isset($data['label'])) ? $data['label'] : null;
        
    }

    public function getArrayCopy()
    {
        return get_object_vars($this);
    }  

    public function setKey($key){
        $this->key=$key;
    }
    public function getKey(){
        return $this->key;
    }

    public function setLabel($label){
        $this->label=$label;
    }
    public function getLabel(){
        return $this->label;
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

    
}
