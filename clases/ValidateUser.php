<?php
require_once "Connect_DB.php";
require_once $_SERVER['DOCUMENT_ROOT']."/scripts/function.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/clases/UsersDao.php";

class ValidateUser
{

    function connectToXML(){
        $this->xml = new Connect_DB();
        $this->xml->Connect();
        return $this->xml->xml;
    }

    function checkLoginDb($login){
        $users = $this->connectToXML();
        foreach ($users->user as $user){
            if  ($user->login == $login){
                generation_exception("Такой логин уже существует!!!", "login");
                return false;
            }
        }
        return true;
    }

    function checkEmailDb($email){
        $users = $this->connectToXML();
        foreach ($users->user as $user){
            if  ($user->email == $email){
                generation_exception("Такой email уже существует!!!", "email");
                return false;
            }
        }
        return true;
    }

}