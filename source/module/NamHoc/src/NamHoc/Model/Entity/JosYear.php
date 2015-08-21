<?php
namespace NamHoc\Model\Entity;

class JosYear
{

    protected $year_id;

    protected $is_active;

    public function exchangeArray($data)
    {
        $this->is_active = (isset($data['is_active'])) ? $data['is_active'] : 0;
        $this->year_id = (isset($data['year_id'])) ? $data['year_id'] : null;
    }

    public function getArrayCopy()
    {
        return get_object_vars($this);
    }    

    public function setIsActive($is_active){
        $this->is_active=$is_active;
    }
    public function getIsActive(){
        return $this->is_active;
    }

    public function setYearId($year_id){
        $this->year_id=$year_id;
    }
    public function getYearId(){
        return $this->year_id;
    }
}
