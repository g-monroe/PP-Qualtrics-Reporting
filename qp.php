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
if (isset($_POST['qp_TOKEN'])){
  if (strlen($_POST['qp_TOKEN']) == 40){
    $api = $_POST['qp_TOKEN'];
    $_Qual = new Qualtrics($api, $_Globals, $_Crypto, null, false, null, null, null, null, $_Log);
    $result = $_Qual->getSurveys();
    if ($result->getHttpStatus() == 200){
      $data = json_decode($result->__tostring(), true);
      $surveys = $data['result']['elements'];
      $_AccountHelper->updateQPToken($api);
      die("good");
    }else{
      die("Bad API Token for Qualtrics!");
    }
  }else{
    die("Invalid API Token for Qualtrics");
  }
}else if (isset($_POST['sesqp_TOKEN'])){
  if (strlen($_POST['sesqp_TOKEN']) == 40){
    $api = $_POST['sesqp_TOKEN'];
    $_Qual = new Qualtrics($api, $_Globals, $_Crypto, null, false, null, null, null, null, $_Log);
    $result = $_Qual->getSurveys();
    if ($result->getHttpStatus() == 200){
      $data = json_decode($result->__tostring(), true);
      $surveys = $data['result']['elements'];
      $_SESSION["qp_TOKEN"] = $api;
      die("good");
    }else{
      die("Bad API Token for Qualtrics!");
    }
  }else{
    die("Invalid API Token for Qualtrics");
  }
}else if (isset($_POST['testqp_TOKEN'])){
  if (strlen($_POST['testqp_TOKEN']) == 40){
    $api = $_POST['testqp_TOKEN'];
    $_Qual = new Qualtrics($api, $_Globals, $_Crypto, null, false, null, null, null, null, $_Log);
    $result = $_Qual->getSurveys();
    if ($result->getHttpStatus() == 200){
      $data = json_decode($result->__tostring(), true);
      $surveys = $data['result']['elements'];
      die("good");
    }else{
      die("Bad API Token for Qualtrics!");
    }
  }else{
    die("Invalid API Token for Qualtrics");
  }
}
if (isset($_SESSION['qp_TOKEN'])){
  $api = $_SESSION['qp_TOKEN'];
  $_Qual = new Qualtrics($api, $_Globals, $_Crypto, null, false, null, null, null, null, $_Log);
  $result = $_Qual->getSurveys();
  if ($result->getHttpStatus() == 200){
    $data = json_decode($result->__tostring(), true);
    $surveys = $data['result']['elements'];
    //die("good");
  }else{
    echo('<div class="row">
    		<div class="col-12">
    			<div class="card">
    				<div class="card-header">
    					<h1>Bad API Token for Qualtrics!</h1>
    				</div></div></div></div>');
  }
}
require_once(ROOT.ASSETS."main/".VERSION."library/view/".'StandardView.php'); //Template
ob_start();
/**************** Add Content ****************/
if (isset($_SESSION["qp_TOKEN"])){

?>
<div class="row">
		<div class="col-12">
			<div class="card">
				<div class="card-header">
					<h1>Surveys</h1>
				</div>
				<div class="card-content">
					<div class="card-body">
            <div id="editable-list">
                <input type="text" class="search form-control round border-primary mb-1" placeholder="Search" />
                <div class="row">
                    <div class="col-md-6 col-sm-12">
                        <button class="sort btn btn-block btn-outline-warning btn-round mb-2" data-sort="name">Sort by name</button>
                    </div>
                    <div class="col-md-6 col-sm-12">
                        <button class="sort btn btn-block btn-outline-success btn-round mb-2" data-sort="age">Sort by age</button>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table table-bordered table-lg text-center">
                        <thead>
                            <tr>
                                <th class="sort text-center" data-sort="name">Name</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <!-- IMPORTANT, class="list" have to be at tbody -->
                        <tbody class="list">
                          <?php
                            if (count($surveys) === 0){
                              echo("<p>You don't have any surveys at this time!");
                            }else{
                              $indx = 0;
                              foreach($surveys as $key=>$val) {
                                echo('<tr>
                                    <td class="name">'.$surveys[$key]["name"].'</td>
                                    <td class="edit"><a href="qp-Step1.php?survey='.$surveys[$key]["id"].'"><button  class="btn btn-outline-primary edit-item-btn">Create Report</button></td>
                                </tr>');
                              }
                              $indx++;
                            }
                           ?>
                        </tbody>
                    </table>
                </div>
            </div>
					</div>
				</div>
			</div>
		</div>
	</div>
<?php
}else{

?>
<div class="col-12">
			<div class="card">
				<div class="card-header">
          <i class="icon-qp-lg" style="float:left;"></i>
					<h4 class="card-title" id="heading-labels" style="    float: left;
    display: inline-flex;
    height: 64px;
    vertical-align: middle;
    padding-top: 19px;
    font-weight: bold;
    font-size: 24px;">Qualports</h4>
					<a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
        			<div class="heading-elements">
						<span class="badge badge-default badge-danger">Settings</span>
					</div>
				</div>
				<div class="card-body">
					<h4 class="card-title">Your Settings</h4>
					<p class="card-text">Below are your settings that overall help you interact with <code>Qualtrics</code> and <code>Qualports</code>! Star(*) means required. To get started you will need the following:</p>
          <p class="card-text"><code>*Qualtrics API Token</code>: it can be found in your <code>Account Settings Page</code> under <code>Qualtrics IDs</code>!</p>
          <p class="card-text"><code>Survey ID</code>: this is simply the ID of your survey. It can be found in your url when the Survey is selected or <code>Account Settings Page</code> under <code>Qualtrics IDs</code>!</p>
          <p class="card-text"><code>Unique Response IDs</code>: this is simply the ID of your response of the survey. Unique response IDs help Qualports sort through and grab required data to generate the reports from your survey!</p>
          <h4 class="card-title">Your API Token:</h4>
          <div class="card-block">
						<fieldset>
							<div class="input-group">
								<input id="tokenInput" type="password" class="form-control" placeholder="(40 characters long)">
								<div class="input-group-append">
									<button onclick="toggleToken();" type="button" class="btn btn-primary"><i id="updateTOKEN" class="icon-eye"></i></button>
								</div>
							</div>
						</fieldset>
					</div>
          <p class="block-tag text-left"><small class="badge badge-default badge-info">Your API Token should be 40 characters.</small></p>
          <button type="button" onclick="setAPI();" class="btn btn-success btn-min-width btn-glow mr-1 mb-1">Save to Account</button>
          <button type="button" onclick="saveAPI();" class="btn btn-info btn-min-width btn-glow mr-1 mb-1">Save to Session</button>
          <button type="button" onclick="testAPI();" class="btn btn-warning btn-min-width btn-glow mr-1 mb-1">Test API</button>
        </div>
			</div>
		</div>
    <script>
    function toggleToken(){
      var eleBTN = document.getElementById("updateTOKEN");
      var eleInp = document.getElementById("tokenInput");
      if (eleInp.type == "text"){
        eleInp.type = "password";
        eleBTN.className = "icon-eye";
        console.log("here");
      }else{
        console.log("2");
        eleInp.type = "text";
        eleBTN.className = "icon-ban";
      }
    }
    function setAPI(){
      var ele = document.getElementById("tokenInput").value;
      const xhttp = new XMLHttpRequest();
      xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
          console.log(this.responseText);
          if (this.responseText == "good"){
            window.location.reload();
          }
        }
      };
      xhttp.open("POST", "qp.php", true);
      xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
      xhttp.send("qp_TOKEN=" + ele);
    }
    function saveAPI(){
      var ele = document.getElementById("tokenInput").value;
      const xhttp = new XMLHttpRequest();
      xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
          console.log(this.responseText);
          if (this.responseText == "good"){
            window.location.reload();
          }
        }
      };
      xhttp.open("POST", "qp.php", true);
      xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
      xhttp.send("sesqp_TOKEN=" + ele);
    }
    function testAPI(){
      var ele = document.getElementById("tokenInput").value;
      const xhttp = new XMLHttpRequest();
      xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
          console.log(this.responseText);
        }
      };
      xhttp.open("POST", "qp.php", true);
      xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
      xhttp.send("testqp_TOKEN=" + ele);
    }
    </script>
<?php
}
/*********************************************/
$content = ob_get_contents();
ob_end_clean();
$title = "Qualports - Dashboard";
$page = new StandardView($title, $content);
echo $page->display();
 ?>
