<?php

class CRUD
{

    private $connection;
    public $salt = "salt";

    function __construct($connection)
    {
        $this->connection = $connection;
    }

    function create($user)
    {
        $users = $this->connection->xml;
        $userData = $users->addChild("user");
        $userData->addChild("login", $user->getLogin());
        $userData->addChild("password", ($this->salt . md5(trim($user->getPassword()))));
        $userData->addChild("email", $user->getEmail());
        $userData->addChild("name", $user->getName());
        if ($users->asXML($_SERVER["DOCUMENT_ROOT"] . $this->connection->path)) {
            return true;
        } else {
            return false;
        }
    }

    function read()
    {
        $users = $this->connection->xml;
        $userData = array();
        foreach ($users->user as $user) {
            $userData[] = array("login" => $user->login, "password" => $user->password, "email" => $user->email, "name" => $user->name);
        }
        return $userData;
    }


    function update($login, $user)
    {
        $users = $this->connection->xml;
        foreach ($users->user as $value) {
            if ($value->login == $login) {
                $value->login = $user->getlogin();
                $value->password = $this->salt . md5(trim($user->getPassword()));
                $value->email = $user->getEmail();
                $value->name = $user->getName();
                if ($users->asXML($_SERVER["DOCUMENT_ROOT"] . $this->connection->path)) {
                    return true;
                } else {
                    return false;
                }
            }
        }
    }

    function delete($login)
    {
        $users = $this->connection->xml;;
        foreach ($login as $user) {
            $domDelete = dom_import_simplexml($user);
            $domDelete->parentNode->removeChild($domDelete);
        }
        if ($users->asXML($_SERVER["DOCUMENT_ROOT"] . $this->connection->path)) {
            return true;
        } else {
            return false;
        }
    }

}