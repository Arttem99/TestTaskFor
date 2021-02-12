<?php
require_once $_SERVER['DOCUMENT_ROOT'] . "/clases/Connect_DB.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/scripts/action.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/clases/User.php";

class UsersDao
{

    private $xml;
    public $salt = "salt";

    function connectToXML(){
        $this->xml = new Connect_DB();
        $this->xml->Connect();
        return $this->xml->xml;
    }

    function getAll(){
        $users = $this->connectToXML();
        $userData = array();
        foreach ($users->user as $user){
            $userData[] =  array("login"=>$user->login, "password"=>$user->password, "email"=>$user->email, "name"=>$user->name);
        }
        return $userData;
    }

    function insert($user){
        $users = $this->connectToXML();
        $userData = $users->addChild("user");
        $userData->addChild("login", $user->getLogin());
        $userData->addChild("password", ($this->salt . md5(trim($user->getPassword()))));
        $userData->addChild("email", $user->getEmail());
        $userData->addChild("name", $user->getName());
        if ($users->asXML($_SERVER["DOCUMENT_ROOT"] . $this->xml->path)) {
            return true;
        } else {
            return false;
        }

    }

    function update($user){
        $users = $this->connectToXML();
        foreach ($users->user as $value)
        {
            if ($value->login == $user->getLogin()){
                if ($this->checkEmailDb($user->getEmail())){
//                    $value->password = md5($user->getPassword());
                    $value->email = $user->getEmail();
                    $value->name = $user->getName();
                    if ($users->asXML($_SERVER["DOCUMENT_ROOT"] . $this->xml->path)) {
                        return true;
                    } else {
                        return false;
                    }
                }

            }
        }
    }

    function delete($login){
        $users = $this->connectToXML();
        $toDelete = array($this->getUserByLogin($login));
        foreach ($toDelete as $user){
            $domDelete = dom_import_simplexml($user);
            $domDelete->parentNode->removeChild($domDelete);
        }
        if ($users->asXML($_SERVER["DOCUMENT_ROOT"] . $this->xml->path)) {
            return true;
        } else {
            return false;
        }
    }

    function getUserByLogin($login){
        $users = $this->connectToXML();
        foreach ($users->user as $user){
            if ($user->login == $login){
                return $user;
            }
        }
    }

    function checkLoginDb($login){
        $connect = new UsersDao();
        $users = $connect->connectToXML();
        foreach ($users->user as $user){
            if  ($user->login == $login){
                generation_exception("Такой логин уже существует!!!", "login");
                return false;
            }
        }
        return true;
    }

    function checkEmailDb($email){
        $connect = new UsersDao();
        $users = $connect->connectToXML();
        foreach ($users->user as $user){
            if  ($user->email == $email){
                generation_exception("Такой email уже существует!!!", "email");
                return false;
            }
        }
        return true;
    }
}