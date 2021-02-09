<?php
require_once "Connect_DB.php";
require_once $_SERVER["DOCUMENT_ROOT"]."/scripts/function.php";
require_once $_SERVER["DOCUMENT_ROOT"]."/clases/User.php";

class UsersDao
{

    private $xml;

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
        $userData->addChild("password", md5($user->getPassword()));
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
                $value->password = md5($user->getPassword());
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

    function delete($login){
        $users = $this->connectToXML();
        $toDelete = array($this->getUserByLogin($users, $login));
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

    function getUserByLogin($users, $login){
        foreach ($users->user as $user){
            if ($user->login == $login){
                return $user;
            }
        }
    }
}