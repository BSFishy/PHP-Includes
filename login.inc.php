<?php

if (class_exists("loginutils"))
    return;

class loginutils {

    var $db = "";
    var $error = array();
    var $valid = false;
    var $select = "";

    function loginutils($database) {
        $this->db = $database;
    }

    function login($post, $passwordEncrypted=false, $usernameName='user', $paswordName='pass') {
        if (isset($post[$usernameName]) && $post[$usernameName] != '') {
            $username = $post[$usernameName];
        } else {
            $this->error[] = "You must put in a username.";
        }

        if (isset($post[$paswordName]) && $post[$paswordName] != '') {
            $password = $post[$paswordName];
        } else {
            $this->error[] = "You must put in a password.";
        }

        if (isset($username) && isset($password)) {
            $loginValue = $this->loginWithCredentials($username, $password, $passwordEncrypted);
            $this->valid = $loginValue;
        }
    }

    function loginWithCredentials($username, $password, $passwordEncrypted=false, $table = 'users') {
        $select = $this->db->select("SELECT * FROM $table WHERE `username`=" . $this->db->mySQLSafe($username));
        if ($select == false) {
            $this->error[] = "That is not a valid username.";
            $this->valid = false;
            return false;
        }
        $npassword = ($passwordEncrypted ? $password : hash('sha512', $password . $select[0]['salt']));
        if ($select[0]['password'] == $npassword) {
            $this->valid = true;
            $this->select = $select;
            return true;
        } else {
            $this->error[] = 'That is not the correct password.';
            $this->valid = false;
            return false;
        }
    }

    function isValid() {
        return $this->valid;
    }

    function getUser() {
        if ($this->isValid()) {
            return $this->select;
        }
        return false;
    }

    function getErrors() {
        return $this->error;
    }

}
