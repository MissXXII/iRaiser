<?php

class NotificationInfo {

    private $id;
    private $creationDate;
    private $message;

    public function __construct($id = 0, $creationDate = "", $message = "") {
        $this->id = $id;
        $this->creationDate = $creationDate;
        $this->message = $message;
    }
    
    public function setId($id) {
        $this->id = $id;
    }

    public function setCreationDate($creationDate) {
        $this->creationDate = $creationDate;
    }

    public function setMessage($message){
        $this->message = $message;
    }
    
    public function getId() {
        return $this->id;
    }
    
    public function getCreationDate() {
        return $this->creationDate;
    }
    
    public function getMessage(){
        return $this->message;
    }
}