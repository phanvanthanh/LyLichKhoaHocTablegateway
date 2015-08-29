<?php
namespace Application\Model\Entity;

class JosTeaching
{

    protected $value_id;

    protected $user_id;

    protected $subject_id;

    protected $lesson_number;

    protected $qualifications;

    protected $edu_system;

    protected $note;


    public function exchangeArray($data)
    {
        $this->value_id = (isset($data['value_id'])) ? $data['value_id'] : null;
        $this->user_id = (isset($data['user_id'])) ? $data['user_id'] : null;

        $this->subject_id = (isset($data['subject_id'])) ? $data['subject_id'] : null;
        $this->lesson_number = (isset($data['lesson_number'])) ? $data['lesson_number'] : null;
        $this->qualifications = (isset($data['qualifications'])) ? $data['qualifications'] : null;
        $this->edu_system = (isset($data['edu_system'])) ? $data['edu_system'] : null;
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

    public function setSubjectId($subject_id){
        $this->subject_id=$subject_id;
    }
    public function getSubjectId(){
        return $this->subject_id;
    } 

    public function setLessonNumber($lesson_number){
        $this->lesson_number=$lesson_number;
    }
    public function getLessonNumber(){
        return $this->lesson_number;
    } 

    public function setQualifications($qualifications){
        $this->qualifications=$qualifications;
    }
    public function getQualifications(){
        return $this->qualifications;
    }

    public function setEduSystem($edu_system){
        $this->edu_system=$edu_system;
    }
    public function getEduSystem(){
        return $this->edu_system;
    }

    public function setNote($note){
        $this->note=$note;
    }
    public function getNote(){
        return $this->note;
    }   
}
