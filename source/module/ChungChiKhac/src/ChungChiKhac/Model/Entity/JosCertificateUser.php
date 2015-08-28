<?php
namespace ChungChiKhac\Model\Entity;

class JosCertificateUser
{

    protected $value_id;

    protected $certificate_id;

    protected $user_id;

    protected $level;

    protected $note;

    public function exchangeArray($data)
    {
        $this->value_id = (isset($data['value_id'])) ? $data['value_id'] : null;
        $this->certificate_id = (isset($data['certificate_id'])) ? $data['certificate_id'] : null;
        $this->user_id = (isset($data['user_id'])) ? $data['user_id'] : null;
        $this->level = (isset($data['level'])) ? $data['level'] : null;
        $this->note = (isset($data['note'])) ? $data['note'] : 0;
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

    public function setCertificateId($certificate_id){
        $this->certificate_id=$certificate_id;
    }
    public function getCertificateId(){
        return $this->certificate_id;
    }

    public function setUserId($user_id){
        $this->user_id=$user_id;
    }
    public function getUserId(){
        return $this->user_id;
    }

    public function setLevel($level){
        $this->level=$level;
    }
    public function getLevel(){
        return $this->level;
    }

    public function setNote($note){
        $this->note=$note;
    }
    public function getNote(){
        return $this->note;
    }
}
