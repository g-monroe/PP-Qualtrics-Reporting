<?php
session_start();
define("CONFIG", "DATABASE");
//-Import Conf.
include("config/vdev.php");
define(DBCON_PASS, true);
include_once(ROOT . ASSETS . "main/" . VERSION . "php/libs/Controller/Globals.class.php");
include_once(ROOT . ASSETS . "main/" . VERSION . "php/libs/Controller/Account.class.php");
include_once(ROOT . ASSETS . "main/" . VERSION . "php/libs/Controller/Log.class.php");
//-Class Conf.
$_Globals = new Globals();
$_Log = new Log();
$_Crypto = new Crypto();
if (isset($_GET['pass'])){
    $pass = $_GET['pass'];

    $hpass = $_Crypto->encrypt($pass, $pass, true);
    echo($hpass);
}else{
  $_AccountHelper = new AccountHelper($_Globals, null, null, false, null, null, null, $_Log);
  $success = $_AccountHelper->performLoginCheck();
  if ($success[0]["Username"] == $_SESSION["user_id"]){
    var_dump("Account is correct!</br>");
    if ($success[0]["loginUserAgent"] === $_SERVER['REMOTE_ADDR'].$_SERVER['HTTP_USER_AGENT']){
      var_dump("Devices and Network Matched!");
    }else{
      var_dump("Devices and Netword Is not the same!");
    }
  }
}
require_once(ROOT.ASSETS."main/".VERSION."library/view/".'StandardView.php'); //Template
ob_start();
/**************** Add Content ****************/
$content="Error: ".$_Log->grabReport()."</p>";
/*********************************************/
ob_end_clean();

$title = "Welcome | Research Institute for Studies in Education";
$page = new StandardView($title, $content);
echo $page->display();
 ?>
