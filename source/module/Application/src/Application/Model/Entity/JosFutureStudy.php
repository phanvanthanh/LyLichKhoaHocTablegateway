<?php
namespace Application\Model\Entity;

class JosFutureStudy
{

    protected $value_id;

    protected $user_id;

    protected $subject_name;

    protected $year_id;

    protected $address;

    protected $time_from;

    protected $time_to;

    protected $note;


    public function exchangeArray($data)
    {
        $this->value_id = (isset($data['value_id'])) ? $data['value_id'] : null;
        $this->user_id = (isset($data['user_id'])) ? $data['user_id'] : null;
        $this->subject_name = (isset($data['subject_name'])) ? $data['subject_name'] : null;
        $this->year_id = (isset($data['year_id'])) ? $data['year_id'] : null;
        $this->address = (isset($data['address'])) ? $data['address'] : null;
        $this->time_from = (isset($data['time_from'])) ? $data['time_from'] : null;
        $this->time_to = (isset($data['time_to'])) ? $data['time_to'] : null;
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

    public function setSubjectName($subject_name){
        $this->subject_name=$subject_name;
    }
    public function getSubjectName(){
        return $this->subject_name;
    } 

    public function setAddress($address){
        $this->address=$address;
    }
    public function getAddress(){
        return $this->address;
    } 

    public function setTimeFrom($time_from){
        $this->time_from=$time_from;
    }
    public function getTimeFrom(){
        return $this->time_from;
    } 

    public function setTimeTo($time_to){
        $this->time_to=$time_to;
    }
    public function getTimeTo(){
        return $this->time_to;
    }

    public function setNote($note){
        $this->note=$note;
    }
    public function getNote(){
        return $this->note;
    }   
}
