<?php
namespace Application\Model\Entity;

class JosScienceResearchOfUser
{

    protected $value_id;

    protected $user_id;

    protected $science_activity_id;

    protected $time_from;

    protected $time_to;

    protected $note;


    public function exchangeArray($data)
    {
        $this->value_id = (isset($data['value_id'])) ? $data['value_id'] : null;
        $this->user_id = (isset($data['user_id'])) ? $data['user_id'] : null;

        $this->science_activity_id = (isset($data['science_activity_id'])) ? $data['science_activity_id'] : null;
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

    public function setScienceActivityId($science_activity_id){
        $this->science_activity_id=$science_activity_id;
    }
    public function getScienceActivityId(){
        return $this->science_activity_id;
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
