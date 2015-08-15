<?php
namespace Permission\Model\Entity;

class JosUsers
{
    protected $id;
    protected $name;
    protected $username;
    protected $email;    
    protected $password;
    protected $usertype;
    protected $block;
    protected $sendEmail;
    protected $gid;
    protected $registerDate;
    protected $lastvisitDate;
    protected $activation;
    protected $params;
    protected $stt;


    

    public function exchangeArray($data)
    {
        $this->id = (isset($data['id'])) ? $data['id'] : null;
        $this->name = (isset($data['name'])) ? $data['name'] : null;
        $this->username = (isset($data['username'])) ? $data['username'] : null;
        $this->email = (isset($data['email'])) ? $data['email'] : null;
        $this->password = (isset($data['password'])) ? $data['password'] : null;
        $this->usertype = (isset($data['usertype'])) ? $data['usertype'] : null;
        $this->block = (isset($data['block'])) ? $data['block'] : null;
        $this->sendEmail = (isset($data['sendEmail'])) ? $data['sendEmail'] : null;
        $this->gid = (isset($data['gid'])) ? $data['gid'] : null;
        $this->registerDate = (isset($data['registerDate'])) ? $data['registerDate'] : null;
        $this->lastvisitDate = (isset($data['lastvisitDate'])) ? $data['lastvisitDate'] : null;
        $this->activation = (isset($data['activation'])) ? $data['activation'] : null;
        $this->params = (isset($data['params'])) ? $data['params'] : null;
        $this->stt = (isset($data['stt'])) ? $data['stt'] : null;
        
    }

    

    public function getArrayCopy()
    {
        return get_object_vars($this);
    }

    public function setId($id){
        $this->id=$id;
    }
    public function getId(){
        return $this->id;
    }

    public function setName($name){
        $this->name=$name;
    }
    public function getName(){
        return $this->name;
    }

    public function setUsername($username){
        $this->username=$username;
    }
    public function getUsername(){
        return $this->username;
    }

    public function setEmail($email){
        $this->email=$email;
    }
    public function getEmail(){
        return $this->email;
    }

    public function setPassword($password){
        $this->password=$password;
    }
    public function getPassword(){
        return $this->password;
    }

    public function setUsertype($usertype){
        $this->usertype=$usertype;
    }
    public function getUsertype(){
        return $this->usertype;
    }

    public function setBlock($block){
        $this->block=$block;
    }
    public function getBlock(){
        return $this->block;
    }

    public function setSendEmail($sendEmail){
        $this->sendEmail=$sendEmail;
    }
    public function getSendEmail(){
        return $this->sendEmail;
    }

    public function setGid($gid){
        $this->gid=$gid;
    }
    public function getGid(){
        return $this->gid;
    }
    public function setRegisterDate($registerDate){
        $this->registerDate=$registerDate;
    }
    public function getRegisterDate(){
        return $this->registerDate;
    }
    public function setLastvisitDate($lastvisitDate){
        $this->lastvisitDate=$lastvisitDate;
    }
    public function getLastvisitDate(){
        return $this->lastvisitDate;
    }

    public function setActivation($activation){
        $this->activation=$activation;
    }
    public function getActivation(){
        return $this->activation;
    }

    public function setParams($params){
        $this->params=$params;
    }
    public function getParams(){
        return $this->params;
    }

    public function setStt($stt){
        $this->stt=$stt;
    }
    public function getStt(){
        return $this->stt;
    }

    
}
