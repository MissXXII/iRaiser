<?php

class ClientInfo {

    private $name;
    private $database;
    private $valid;
    

    public function __construct( $name, $database, $valid) {
        $this->name = $name;
        $this->database = $database;
        $this->valid = $valid;
    }
    

    public function getName() {
        return $this->name;
    }
    
    public function getDatabase() {
        return $this->database;
    }
    
    public function getValid() {
        return $this->valid;
    }
    
}