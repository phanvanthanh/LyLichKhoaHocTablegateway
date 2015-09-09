<?php
namespace Application\Model\Entity;

class JosScientificReport
{

    protected $value_id;

    protected $user_id;

    protected $year_id;

    protected $name;

    protected $publish_date;

    protected $publish_place;

    protected $note;


    public function exchangeArray($data)
    {
        $this->value_id = (isset($data['value_id'])) ? $data['value_id'] : null;
        $this->user_id = (isset($data['user_id'])) ? $data['user_id'] : null;
        $this->year_id = (isset($data['year_id'])) ? $data['year_id'] : null;
        $this->name = (isset($data['name'])) ? $data['name'] : null;
        $this->publish_date = (isset($data['publish_date'])) ? $data['publish_date'] : null;
        $this->publish_place = (isset($data['publish_place'])) ? $data['publish_place'] : null;
        $this->note = (isset($data['note'])) ? $data['note'] : null;

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

    public function setPublishDate($publish_date){
        $this->publish_date=$publish_date;
    }
    public function getPublishDate(){
        return $this->publish_date;
    } 

    public function setPublishPlace($publish_place){
        $this->publish_place=$publish_place;
    }
    public function getPublishPlace(){
        return $this->publish_place;
    }

    public function setNote($note){
        $this->note=$note;
    }
    public function getNote(){
        return $this->note;
    }   
}
