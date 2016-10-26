<?php
if(class_exists("loginutils")) return;

class loginutils
{
    
    var $db = "";
    var $error = "";
    var $valid = false;
    var $select = "";
    
    function loginutils($database){
        $this->db = $database;
    }
    
    function login($username, $password, $table = 'users'){
        $select = $this->db->select("SELECT * FROM $table WHERE `username`=" . $this->db->mySQLSafe($username));
        if($select == false){
            $this->error = "That is not a valid username.";
            $this->valid = false;
            return;
        }
        if($select[0]['password'] == hash('sha512', $password . $select[0]['salt'])){
            $this->valid = true;
            $this->select = $select;
            return;
        }else{
            $this->error = 'That is not the correct password.';
            $this->valid = false;
            return;
        }
    }
    
    function isValid(){
        return $this->valid;
    }
    
    function getUser(){
        if($this->isValid()){
            return $this->select;
        }
        return false;
    }
}