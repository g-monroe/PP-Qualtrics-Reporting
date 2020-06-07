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
  $params = NULL;
  $result = $_AccountHelper->_Account->custom("SELECT `Username` FROM `accounts` WHERE 1", $params);
require_once(ROOT.ASSETS."main/".VERSION."library/view/".'StandardView.php'); //Template
ob_start();
/**************** Add Content ****************/


?>
<div class="row">
		<div class="col-12">
			<div class="card">
				<div class="card-header">
					<h1>Users</h1>
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
                        <button onclick="window.location.href = 'add-user.php';" class="sort btn btn-block btn-outline-success btn-round mb-2">Add User</button>
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
                            if (count($result) === 0){
                              echo("<p>You don't have any surveys at this time!");
                            }else{
                              $indx = 0;
                              foreach($result as $key=>$val) {
                                echo('<tr>
                                    <td class="name">'.$result[$key]["Username"].'</td>
                                    <td class="edit"><button class="btn btn-outline-primary edit-item-btn">Edit</button></td>
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
/*********************************************/
$content = ob_get_contents();
ob_end_clean();
$title = "Qualports - Dashboard";
$page = new StandardView($title, $content);
echo $page->display();
 ?>
