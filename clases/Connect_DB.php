<?php
//require_once $_SERVER["DOCUMENT_ROOT"] . '/db.xml';
class Connect_DB
{
    public $xml = "";
    public $path = "/database/db.xml";

//    function __construct()
//    {
//        $this->xml = simplexml_load_file("database\db.xml");
//    }

    function Connect(){
        $this->xml = simplexml_load_file($_SERVER["DOCUMENT_ROOT"]."/database/db.xml");
    }
}