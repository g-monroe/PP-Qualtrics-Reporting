<?php
session_start();
define("CONFIG", "DATABASE");
//-Import Conf.
include("config/vdev.php");
define(DBCON_PASS, true);
include_once(ROOT . ASSETS . "main/" . VERSION . "php/libs/Controller/Globals.class.php");
include_once(ROOT . ASSETS . "main/" . VERSION . "php/libs/Controller/Account.class.php");
include_once(ROOT . ASSETS . "main/" . VERSION . "php/libs/Controller/Log.class.php");
include_once(ROOT . ASSETS . "main/" . VERSION . "php/libs/Controller/Qualtrics.class.php");
//-Class Conf.
$_Globals = new Globals();
$_Log = new Log();
$_Crypto = new Crypto();
  $_AccountHelper = new AccountHelper($_Globals, null, null, false, null, null, null, $_Log);
  $success = $_AccountHelper->performLoginCheck();
  if ($success[0]["Username"] == $_SESSION["user_id"]){

    if ($success[0]["loginUserAgent"] === $_SERVER['REMOTE_ADDR'].$_SERVER['HTTP_USER_AGENT']){
   //var_dump("Devices and Network Matched!");
    }else{
      $_Globals->redirect("login.php");
    }
  }else{
    $_Globals->redirect("login.php");
  }
  if (isset($_POST["Username"])){
    $user = $_Globals->noHTML($_POST["Username"]);
    $pass = $_POST["Password"];
    $rpass = $_POST["RePassword"];
    $email = $_POST["Email"];
    $indxStaff = $_Globals->noHTML($_POST["StaffIndex"]);
    $indxGroup = $_Globals->noHTML($_POST["GroupIndex"]);
    if (strlen($pass) < 7 || strlen($pass) > 47){
      die("Password too short or big!");
    }
    if ($pass !== $rpass){
      die("Passwords don't match!");
    }
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)){
      die("Isn't a valide email!");
    }
    if (strlen($user) < 4 || strlen($user) > 20){
      die("Username is too short or long!");
    }
    $ID = $_Globals->genRndStr(512);
    $appData = "{}";
      $params = array(
          "idd" => $ID,
          "sec2" => $ID,
          "pass" => $pass,
          "sec" => $pass,
          "data" => $appData,
          "user" => $user,
          "em" => $email,
          "indxGroup" => $indxGroup,
          "indxStaff" => $indxStaff
      );
    $sql = "INSERT INTO `accounts`(`ID`, `Username`, `Email`, `Password`, `UserGroup`, `StaffIndex`, `appData`) VALUES (:idd, :user, :em, AES_ENCRYPT(:pass, UNHEX(SHA2(:sec,512))), :indxGroup, :indxStaff, AES_ENCRYPT(:data, UNHEX(SHA2(:sec2,512))))";
    $result = $_AccountHelper->_Account->custom($sql, $params);
    die($result);
  }
  require_once(ROOT.ASSETS."main/".VERSION."library/view/".'StandardView.php'); //Template
  ob_start();
/**************** Add Content ****************/


?>
<div class="row">
		<div class="col-12">
			<div class="card">
				<div class="card-header">
					<h1>Add User</h1>
				</div>
				<div class="card-content">
					<div class="card-body">
            <div id="editable-list">
                <input type="text" id="Username" class="search form-control round border-primary mb-1" placeholder="Username" />
                  <input type="text" id="Email" class="search form-control round border-primary mb-1" placeholder="Email" />
                    <input type="text" id="GroupIndex" class="search form-control round border-primary mb-1" placeholder="UserGroup Index" />
                    <input type="text" id="StaffIndex" class="search form-control round border-primary mb-1" placeholder="Staff Index" />
                    <input type="password" id="Password" class="search form-control round border-primary mb-1" placeholder="Password" />
                    <input type="password" id="RePassword" class="search form-control round border-primary mb-1" placeholder="Re-Password" />
                <div class="row">
                  <div class="col-md-6 col-sm-12">
                      <button onclick="createUser();" class="sort btn btn-block btn-outline-success btn-round mb-2">Add User</button>
                  </div>
                    <div class="col-md-6 col-sm-12">
                        <button class="sort btn btn-block btn-outline-warning btn-round mb-2" data-sort="name">Sort by name</button>
                    </div>
                </div>

            </div>
					</div>
				</div>
			</div>
		</div>
	</div>
  <script>
  function createUser(){
    var user = document.getElementById("Username").value;
    var email = document.getElementById("Email").value;
    var pass = document.getElementById("Password").value;
    var repass = document.getElementById("RePassword").value;
    var indx1 = document.getElementById("GroupIndex").value;
    var indx2 = document.getElementById("StaffIndex").value;
    const xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
      if (this.readyState == 4 && this.status == 200) {
        console.log(this.responseText);
        if (this.responseText == "good"){
          window.location.reload();
        }
      }
    };
    xhttp.open("POST", "add-user.php", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send("Username=" + user + "&Email=" + email + "&GroupIndex=" + indx1 + "&StaffIndex=" + indx2 + "&Password=" + pass + "&RePassword=" + repass);
  }
  </script>

<?php
/*********************************************/
$content = ob_get_contents();
ob_end_clean();
$title = "Qualports - Dashboard";
$page = new StandardView($title, $content);
echo $page->display();
 ?>
