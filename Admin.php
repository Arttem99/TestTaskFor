<?
require_once $_SERVER["DOCUMENT_ROOT"] . "/clases/UsersDao.php"; ?>
<?
require_once $_SERVER["DOCUMENT_ROOT"] . "/scripts/function.php"; ?>
    <html>
    <head>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
    </head>
    <body>

    <div class="outputData">
        <? outputDataUser() ?>
    </div>
    <br>
    <?php //getUserByLogin("test05Test$") ?>
    <div class="Add_Edit_User">
        <form id="operation-form">
            <div class="block_login"><span>Login: </span> <input type="text" placeholder="Login" id="login"
                                                                 class="for-clear"><span id="err_login"
                                                                                         class="error"></span></div>
            <div class="block_pass"><span>Password: </span> <input type="password" placeholder="Password" id="password"
                                                                   class="for-clear"><span id="err_pass"
                                                                                           class="error"></span></div>
            <div class="block_conf_pass"><span>Confirm password: </span> <input type="password" placeholder="Password"
                                                                                id="comf_pass" class="for-clear"><span
                        id="err_confpass" class="error"></span></div>
            <div class="block_email"><span>Email: </span> <input type="email" placeholder="Email" id="email"
                                                                 class="for-clear"><span id="err_email"
                                                                                         class="error"></span></div>
            <div class="block_name"><span>Your Name: </span> <input type="text" placeholder="Name" id="name_user"
                                                                    class="for-clear"><span id="err_user"
                                                                                            class="error"></span></div>
            <input type="button" id="btn_sign_up" value="Add">
            <input type="button" id="btn_update" value="Update">

        </form>
    </div>

    <script src="js/script.js?<?
    echo mt_rand(); ?>"></script>
    </body>
    </html>
<?php
