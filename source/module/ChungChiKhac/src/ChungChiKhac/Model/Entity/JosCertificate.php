<?php
namespace ChungChiKhac\Model\Entity;

class JosCertificate
{

    protected $value_id;

    protected $year_id;

    protected $name;

    public function exchangeArray($data)
    {
        $this->value_id = (isset($data['value_id'])) ? $data['value_id'] : null;
        $this->name = (isset($data['name'])) ? $data['name'] : null;
        $this->year_id = (isset($data['year_id'])) ? $data['year_id'] : null;
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

    public function setYearId($year_id){
        $this->year_id=$year_id;
    }
    public function getYearId(){
        return $this->year_id;
    }

    public function setName($name){
        $this->name=$name;
    }
    public function getName(){
        return $this->name;
    }
}
