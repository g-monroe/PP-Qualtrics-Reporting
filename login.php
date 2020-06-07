<?php
#Session starts
#CSRF Login token

if (count($_POST) === 4){
  //Configure
  if (session_status() == PHP_SESSION_NONE) {
    session_start();
  }
  //-Access - Conf
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
  if ($_SESSION['token'] === $_POST['token']) {

      if (!$_Globals->validateCaptcha()){
        die("Captcha Failed. Try again!");
      }//END - Captcha Checking - BOT SECURITY

      //Grab RAW Inputs
      $user = $_POST['user-name'];
      $pass = $_POST['user-password'];
      //Check if Email and then Username
      if (!filter_var($user, FILTER_VALIDATE_EMAIL)) {//If not Email
        if (strlen($user) <= 3){
          die("Username is not correct parameters.");
        }else{//If username is to correct length
          //Remove special Characters - SECURITY
          $user = $_Globals->stripSpecialChars($user);
        }//END - User Length
      }//END - Email validate

      if (strlen($pass) < 7){
        die("Password is not in a correct parameter style.");
      }//END - Password Length
      $_AccountHelper = new AccountHelper($_Globals, null, null, false, null, null, null, $_Log);
      $success = $_AccountHelper->performLogin($user, $user, $pass);
      die($success);

  } else {//If there is no session
    die("CSRF error.");
  }//END - SESSION Checking - CSRF SECURITY
}else{//If not a valid post request.
  if (session_status() == PHP_SESSION_NONE) {
    session_start();
    $length = 32;
    $_SESSION['token'] = substr(base_convert(sha1(uniqid(mt_rand())), 16, 36), 0, $length);
  }
}//END - Check number of POST vars - Spider SECURITY
?>
<!DOCTYPE html>
<html class="loading" lang="en" data-textdirection="ltr">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta name="description" content="phpPress is a powerful tool to overall control and maintain your website.">
    <meta name="keywords" content="User Control Panel">
    <title>Login - phpPress</title>
    <link rel="shortcut icon" type="image/x-icon" href="app-assets/images/ico/favicon.ico">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Muli:300,400,500,700" rel="stylesheet">
    <!-- BEGIN VENDOR CSS-->
    <link rel="stylesheet" type="text/css" href="app-assets/css/vendors.css">
    <link rel="stylesheet" type="text/css" href="app-assets/vendors/css/forms/icheck/icheck.css">
    <link rel="stylesheet" type="text/css" href="app-assets/vendors/css/forms/icheck/custom.css">
    <!-- END VENDOR CSS-->
    <!-- BEGIN ROBUST CSS-->
    <link rel="stylesheet" type="text/css" href="app-assets/css/app.css">
    <!-- END ROBUST CSS-->
    <!-- BEGIN Page Level CSS-->
    <link rel="stylesheet" type="text/css" href="app-assets/css/core/menu/menu-types/vertical-menu.css">
    <link rel="stylesheet" type="text/css" href="app-assets/css/core/colors/palette-gradient.css">
    <link rel="stylesheet" type="text/css" href="app-assets/css/pages/login-register.css">
    <!-- END Page Level CSS-->
    <!-- BEGIN Custom CSS-->
    <link rel="stylesheet" type="text/css" href="assets/css/style.css">
    <script src='https://www.google.com/recaptcha/api.js'></script>
    <!-- END Custom CSS-->
  </head>
  <body class="vertical-layout vertical-menu 1-column   menu-expanded blank-page blank-page" data-open="click" data-menu="vertical-menu" data-col="1-column">
    <!-- ////////////////////////////////////////////////////////////////////////////-->
    <div class="app-content content">
      <div class="content-wrapper">
        <div class="content-header row">
        </div>
        <div class="content-body"><section class="flexbox-container">
    <div class="col-12 d-flex align-items-center justify-content-center">
        <div class="col-md-4 col-10 box-shadow-2 p-0">
            <div class="card border-grey border-lighten-3 m-0">
                <div class="card-header border-0" style="padding-bottom:0px;">
                    <div class="card-title text-center">
                        <div class="p-1"><img src="app-assets/images/logo/logo-dark.png" alt="branding logo"></div>
                    </div>
                    <h6 class="card-subtitle line-on-side text-muted text-center font-small-3 pt-2"><span>Login with phpPress</span></h6>
                    <div style="display:none" class="alert alert-danger alert-dismissible mb-2" role="alert" id="notify">

    						    </div>
                </div>
                <div class="card-content">
                    <div class="card-body">
                        <form id="login" class="form-horizontal form-simple" action="" method="POST" novalidate>
                          <script>
                            var login = function(response) {
                              document.getElementById("notify").style.display = "none";
                            //setAlert(false, true, "Please wait!");
                            //showAlert();
                            const form = document.getElementById('login');
                            var data = {};
                            for (var i = 0, ii = form.length; i < ii; ++i) {
                                var input = form[i];
                                if (input.name) {
                                    data[input.name] = input.value;
                                }
                            }
                            sendSession(data);
                          };
                          function sendSession(data){
                            var ele = document.getElementById("notify");
                              // construct an HTTP request
                              //var xhr = new XMLHttpRequest();
                              //xhr.open("post", "https://www.farmbizsurvey.com/assets/v1/php/ajax/session.php", true);
                              //xhr.setRequestHeader('Content-Type', 'application/json');
                              var params = typeof data == 'string' ? data : Object.keys(data).map(
                                  function(k){ return encodeURIComponent(k) + '=' + encodeURIComponent(data[k]) }
                              ).join('&');

                              var xhr = window.XMLHttpRequest ? new XMLHttpRequest() : new ActiveXObject("Microsoft.XMLHTTP");
                              xhr.open('POST', window.location.href);
                              xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
                              xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
                              xhr.send(params);
                              xhr.onloadend = function () {
                                  if (xhr.status == 200){
                                      grecaptcha.reset();
                                      ele.style.display = "block";
                                      ele.innerHTML =xhr.responseText;
                                      if (xhr.responseText == "Success"){
                                        window.location.href = "index.php";
                                      }
                                      console.log(xhr.responseText);
                                  }else{//Server Error
                                      ele.style.display = "block";
                                      ele.innerHTML = "Server Error! Come back later!"
                                  }
                              };
                             }
                            </script>
                            <fieldset class="form-group position-relative has-icon-left mb-0">
                                <input type="text" class="form-control form-control-lg input-lg" name="user-name" id="user-name" placeholder="Your Username/E-Mail" required>
                                <div class="form-control-position">
                                    <i class="ft-user"></i>
                                </div>
                            </fieldset>
                            <fieldset class="form-group position-relative has-icon-left">
                                <input type="password" class="form-control form-control-lg input-lg" name="user-password" id="user-password" placeholder="Enter Password" required>
                                <div class="form-control-position">
                                    <i class="fa fa-key"></i>
                                </div>
                                <input type="hidden" name="token" value="<?=$_SESSION['token']?>">
                            </fieldset>

                            <button data-callback="login" data-sitekey="6LeeonQUAAAAAMLmm04ttvvj4wy_HcPa9E_ERxdE" class="btn btn-info btn-lg btn-block g-recaptcha">Login</button>
                        </form>

                    </div>
                </div>
                <div class="card-footer">
                    <div class="">
                        <p class="float-sm-left text-center m-0"><a href="recover-password.html" class="card-link">Recover password</a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

        </div>
      </div>
    </div>
    <!-- ////////////////////////////////////////////////////////////////////////////-->

    <!-- BEGIN VENDOR JS-->
    <script src="app-assets/vendors/js/vendors.min.js" type="text/javascript"></script>
    <!-- BEGIN VENDOR JS-->
    <!-- BEGIN PAGE VENDOR JS-->
    <script src="app-assets/vendors/js/forms/icheck/icheck.min.js" type="text/javascript"></script>
    <script src="app-assets/vendors/js/forms/validation/jqBootstrapValidation.js" type="text/javascript"></script>
    <!-- END PAGE VENDOR JS-->
    <!-- BEGIN ROBUST JS-->
    <script src="app-assets/js/core/app-menu.js" type="text/javascript"></script>
    <script src="app-assets/js/core/app.js" type="text/javascript"></script>
    <!-- END ROBUST JS-->
    <!-- BEGIN PAGE LEVEL JS-->
    <script src="app-assets/js/scripts/forms/form-login-register.js" type="text/javascript"></script>
    <!-- END PAGE LEVEL JS-->
  </body>

</html>
