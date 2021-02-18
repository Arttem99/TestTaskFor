<?php
require_once $_SERVER['DOCUMENT_ROOT'] . "/scripts/function.php";

session_start();

if (isset($_POST["method"])) {
    if ($_POST["method"] == "data_transfer_for_Registration") {
        data_transfer_for_Registration();
    }
    if ($_POST["method"] == "update") {
        update();
    }
    if ($_POST["method"] == "authorization") {
        authorization();
    }
    if ($_POST["method"] == "exit") {
        exits();
    }
    if ($_POST["method"] == "delete") {
        deleteUser();
    }
    if ($_POST["method"] == "viewInfo") {
        viewInfo();
    }
    if ($_POST["method"] == "getInfo") {
        getDataUser();
    }
}


