<?php
namespace Attribute\Model\Entity;

class JosAttribute
{

    protected $attribute_id;

    protected $attribute_code;

    protected $year_id;

    protected $frontend_label;

    protected $value_table;

    public function exchangeArray($data)
    {
        $this->attribute_id = (isset($data['attribute_id'])) ? $data['attribute_id'] : null;
        $this->attribute_code = (isset($data['attribute_code'])) ? $data['attribute_code'] : null;
        $this->year_id = (isset($data['year_id'])) ? $data['year_id'] : null;
        $this->frontend_label = (isset($data['frontend_label'])) ? $data['frontend_label'] : null;
        $this->value_table = (isset($data['value_table'])) ? $data['value_table'] : null;
    }

    public function getArrayCopy()
    {
        return get_object_vars($this);
    }    

    public function setAttributeId($attribute_id){
        $this->attribute_id=$attribute_id;
    }
    public function getAttributeId(){
        return $this->attribute_id;
    }

    public function setAttributeCode($attribute_code){
        $this->attribute_code=$attribute_code;
    }
    public function getAttributeCode(){
        return $this->attribute_code;
    }

    public function setYearId($year_id){
        $this->year_id=$year_id;
    }
    public function getYearId(){
        return $this->year_id;
    }

    public function setFrontendLabel($frontend_label){
        $this->frontend_label=$frontend_label;
    }
    public function getFrontendLabel(){
        return $this->frontend_label;
    }

    public function setValueTable($value_table){
        $this->value_table=$value_table;
    }
    public function getValueTable(){
        return $this->value_table;
    }
}
