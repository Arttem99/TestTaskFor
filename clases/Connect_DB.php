<?php
class Connect_DB
{
    public $xml = "";
    public $path = "/database/db.xml";

    function __construct()
    {
        $this->xml = simplexml_load_file($_SERVER["DOCUMENT_ROOT"].$this->path);
    }

}