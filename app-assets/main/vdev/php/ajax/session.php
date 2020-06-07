<?php
/**
 * Created by PhpStorm.
 * User: Gavin Monroe
 * Date: 6/21/2018
 * Time: 10:16 AM
 */

//Config settings is as follows: Database Information, Display Errors
define("CONFIG", "DATABASE");
include($_SERVER['DOCUMENT_ROOT'] . "/../config/vdev.php");

define(DBCON_PASS, true);
// Require the person class file
require(ROOT . ASSETS . VERSION . "php/libs/Controller/Session.class.php");
require(ROOT . ASSETS . VERSION . "php/libs/Controller/SessionHelper.class.php");
require(ROOT . ASSETS . VERSION . "php/libs/Controller/Account.class.php");
include_once(ROOT . ASSETS . VERSION . "php/libs/Controller/Globals.class.php");
include_once(ROOT . ASSETS . VERSION . "php/libs/Controller/Log.class.php");
$_Globals = new Globals();
$_Session = new Session();
$_Log = new Log();
$request = file_get_contents('php://input');
$error = "";
if (count($_POST) !== 4) {
    $error = "Fire-wall blocked this request; Invalid Request!";
}
if (!isset($_SERVER["HTTP_REFERER"])) {
    $error = "Fire-wall blocked this request; Not hosted!";
}
//if (isset($_POST['csrf_token'])) {
//    if (!$_Globals->checkToken($_POST['csrf_token'], 'mainFCB_LoginForm')) {
//        $error = "Fire-wall blocked this request; CSRF Protection! Part 2!";
//    }
//}else{
//    $error = "Fire-wall blocked this request; CSRF Protection! Part 1";
//}
$user = "";
if ($error === "") {
    if (isset($_POST["user-name"]) && isset($_POST["user-password"])) {
        //$reCaptcha
        if (!$_Globals->validateCaptcha()) {
            $error = "Captcha was wrong! Please try again!";
        }
        //Set & Check Username/Email
        $user = $_POST["user-name"];
        //Check if not email
        if (!filter_var($user, FILTER_VALIDATE_EMAIL)) {
            //Remove special characters for security reasons
            $user = strip_tags($user);
            $user = htmlentities($user, ENT_QUOTES, "UTF-8");
        }
        //Check Size
        if (strlen($user) <= 2 || strlen($user) >= 28) {
            $error = "Username wasn't in correct parameters! Too small or big.";
        }

        //Check Password
        $pass = strip_tags($_POST["user-password"]);
        $pass = htmlentities($pass, ENT_QUOTES, "UTF-8");
        if (strlen($pass) <= 7 || strlen($pass) >= 49) {
            $error = "Password wasn't in correct parameters! Too small or big.";
        }

        if (!$error) {
            $_AccountHelper = new AccountHelper($_Globals, null, null, false, null, null, null, $_Log);
            $success = $_AccountHelper->performLoginCheck($user, $pass);
            $error = $_Log->grabLatestError();
        }

    } else {
        $error = "Please fill out all fields, thank you!";
    }
    if (strpos($_SERVER["HTTP_REFERER"], "https://www.farmbizsurvey.com/dashboard/login") !== false && $error === "NULL") {//Start new Session
        $session = new SessionHelper($user, true, $_Globals);
        $error = "";
    }
}
echo($error);
?>
