<?php
include_once(__DIR__ . '/../Crypto/Crypto.class.php');
  include_once(__DIR__ . '/../PhpMailer/Sender.php');
include_once("Globals.class.php");
include_once("Account.class.php");
include_once("Log.class.php");
class AccountHelper{
//<editor-fold defaultstate="collapsed" desc="Declares">
    # Class Helpers
    protected $_Globals;
    protected $_Crypto;
    public $_Account;
    protected $_Log;
    protected $_SessionHelper;
    protected $account;
    # Checking if Completed
    public $done = false;
    public $error = "";
    public $success = false;
//</editor-fold>
//<editor-fold defaultstate="collapsed" desc="Constructor">
    public function __construct($classGlobals = null, $classCrypto = null, $classAccount = null, $check = false, $user = null, $pass = null, $classSessionHelper = null, $classLog = null)
    {

        #Check Globals Class
        if ($classGlobals === null) {
            $this->_Globals = new Globals();
        } else {
            $this->_Globals = $classGlobals;
        }

        #Check Crypto Class
        if ($classCrypto === null) {
            $this->_Crypto = new Crypto();
        } else {
            $this->_Crypto = $classCrypto;
        }

        #Check Log Class
        if ($classLog === null) {
            $this->_Log = new Log();
        } else {
            $this->_Log = $classLog;
        }

        #Check Account Class
        if ($classAccount === null) {
            $this->_Account = new Account();
            $this->_Account->replaceLog($this->_Log);
        } else {
            $this->_Account = $classAccount;
            $this->_Account->replaceLog($this->_Log);
        }
    }
    public function performPasswordChange($email = "", $code = "", $pass = ""){
      if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {//If not Email
        return "Must be an email!";
      }//END - Email validate
      $params = array(
        "mail" => $email
      );
      $result = $this->_Account->custom("SELECT count(Email), loginToken FROM  `accounts` WHERE `Email`=:mail", $params);
      if ($result[0][0] === 0){
        return "No Account found!";
      }
      if ($result[0][1] === NULL){
        return "Account not found!";
      }
      $pieces = explode("~", $result[0][1]);
      if (count($pieces) <= 1){
        return "Code couldn't be find, resend reset link.";
      }else{
        $dbCode = $pieces[1];
        $dbEmail = $pieces[2];
        if ($dbCode !== $code || $dbEmail !== $email){
          return "Invalid password reset.";
        }
        $params = array(
          "mail" => $email,
          "sec" => $pass,
          "pass" => $pass
        );
        $result = $this->_Account->custom("UPDATE `accounts` SET `Password`=AES_ENCRYPT(:pass, UNHEX(SHA2(:sec,512))) WHERE `Email`=:mail)", $params);
        return $result;
      }
    }
    public function performRecovery($email = "", $sender = null){
      if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {//If not Email
        return "Must be an email!";
      }//END - Email validate
      $params = array(
        "mail" => $email
      );
      $result = $this->_Account->custom("SELECT count(Email), loginToken FROM  `accounts` WHERE `Email`=:mail", $params);
      if ($result[0][0] === 0){
        return "No Account found!";
      }
      if ($result[0][1] === NULL){
        return "Account not found!";
      }
      $pieces = explode("~", $result[0][1]);
      if (count($pieces) <= 1){
        $now = $this->_Globals->NOW();
        $prv= $this->_Globals->genRndStr(16);
        $tok = $now."~".$prv."~".$email;
        $params = array(
          "mail" => $email,
          "input" => $tok
        );
        $setResult = $this->_Account->custom("UPDATE `accounts` SET `loginToken`=:input WHERE `Email`=:mail", $params);
        $mail = array(
          "body"    => "You have requested to change your password Click here: https://rise.hs.iastate.edu/p-p/recover.php?email=".$email."&code=".$prv,
          "subject" => "Reset Password phpPress.",
          "to"      => $email
        );
        $send = new Sender($this->_Globals, null,  $this->_Logs, $mail["body"], $mail["subject"], $email, "}V9]G=GjLYxDR&Q/FWaD]_", false);
        return $send->sendMail();
        //    Date~Key
      }else{
        $dt = date_parse($pieces[0]);
        $now = date_parse($this->_Globals->NOW());
        if ($dt["day"] !== $now["day"] && $dt["year"] !== $now["year"] && $dt["month"] !== $now["month"] && $dt["hour"] !== $now["hour"]){
          $now = $this->_Globals->NOW();
          $prv= $this->_Globals->genRndStr(16);
          $tok = $now."~".$prv."~".$email;
          $params = array(
            "mail" => $email,
            "input" => $tok
          );
          $setResult = $this->_Account->custom("UPDATE `accounts` SET `loginToken`=:input WHERE `Email`=:mail", $params);
          $mail = array(
            "body"    => "You have requested to change your password Click here: https://rise.hs.iastate.edu/p-p/recover.php?email=".$email."&code=".$prv,
            "subject" => "Reset Password phpPress.",
            "to"      => $email
          );
          $send = new Sender($this->_Globals, null,  $this->_Logs, $mail["body"], $mail["subject"], $email, "}V9]G=GjLYxDR&Q/FWaD]_", false);
          return $send->sendMail();
        }else{
          return "Recovery sent in the last hour. Check your email or try again later.";
        }
      }
    }
    public function performLogin($username = "", $email = "", $pass = ""){
      $this->_Log->reportLog("Made it", "AcountHelper->performLogin");
      if ($username === "" && $email === ""){
        $this->_Log->reportError("Parameters not find for ".$username." or ".$email.".", "AcountHelper->performLogin");
        return "Parameters are not meet.";
      }
      if ($password === ""){
        $this->_Log->reportError("Parameters not find for passwords.", "AcountHelper->performLogin");
        return "Paramenters are no meet.";
      }
    $this->_Log->reportLog("Made it past the parameters", "AcountHelper->performLogin");
      try{
        $params = array(
            "sec" => $pass,
            "pass" => $pass,
            "user" => $username,
            "mail" => $username
        );
        $result = $this->_Account->custom("SELECT CAST(AES_DECRYPT(`appData`,UNHEX(SHA2(`ID`, 512))) AS CHAR(512)) appData
FROM  `accounts` WHERE `Password`=AES_ENCRYPT(:pass, UNHEX(SHA2(:sec,512))) AND (`Username`=:user OR `Email`=:mail)", $params);
        if (count($result[0][0]) !== 1){
          $this->_Log->reportError("Accounts not find for ".$username." or ".$email.".", "AcountHelper->performLogin");
          return "Account/Password wrong.";
        }else{
          $data = $result[0][0];
          $data = json_decode($data, true);
          foreach ($data as $key => $value) {
            $_SESSION[$key] = $value;
          }
          $keyToken = $this->_Globals->genRndStr(256);
          $token = $this->_Globals->genRndStr(256);
          $_SESSION['user_id'] = $username;
          $_SESSION['logout_time'] = 60;
          $_SESSION['login_time'] = date("Y-m-d H:i:s");
          $_SESSION['device'] =  $_SERVER['HTTP_USER_AGENT'];
          $_SESSION['address'] = $_SERVER['REMOTE_ADDR'];
          $_SESSION['login_token'] = $token;
          $params = array(
              "sec" => $pass,
              "pass" => $pass,
              "user" => $username,
              "data" => $username,
              "tokenSec" => $token.$keyToken,
              "mail" => $username,
              "agent" => $_SESSION['address'].$_SESSION['device'],
              "token" => $token,
              "key" => $keyToken
          );
          $result = $this->_Account->custom("UPDATE `accounts` SET `loginUserAgent`=:agent, `loginToken`=:token, `loginPrivateKey`=:key, `loginData`=AES_ENCRYPT(:data, UNHEX(SHA2(:tokenSec,512))) WHERE `Password`=AES_ENCRYPT(:pass, UNHEX(SHA2(:sec,512))) AND (`Username`=:user OR `Email`=:mail)", $params);
          return "Success";
        }
      }catch(Exception $e){
        return "Error!";
      }
      return "Unperformed action!";
  }
  public function updateQPToken($apiTOKEN){
    $token = $_SESSION['login_token'];
    $params = NULL;
    $ID = $this->_Account->custom("SELECT `ID` FROM `accounts` WHERE `loginToken`='".$token."'", $params);
    $ID = $ID[0][0];
    $result = $this->_Account->custom("SELECT CAST(AES_DECRYPT(`appData`,UNHEX(SHA2(`ID`, 512))) AS CHAR(512)) appData FROM `accounts` WHERE `loginToken`='".$token."'", $params);
    $data = $result[0][0];
    $data = json_decode($data, true);
    $exists = false;
    foreach ($data as $key => $value) {
      if ($key === 'qp_TOKEN'){
        $exists = true;
        $data[$key] = $apiTOKEN;
      }
    }
    if (!$exists){
      $data["qp_TOKEN"] = $apiTOKEN;
    }
    $jsonData = json_encode($data);
    $params = array(
        "data" => $jsonData,
        "idd" => $ID,
        "token" => $token
    );
    $result = $this->_Account->custom("UPDATE `accounts` SET `appData`=AES_ENCRYPT(:data, UNHEX(SHA2(:idd,512))) WHERE `loginToken`=:token", $params);
    $_SESSION['qp_TOKEN'] = $apiTOKEN;
    return $result;
  }
  public function performLoginCheck(){
    $token = $_SESSION['login_token'];
    $params = NULL;
    $result = $this->_Account->custom("SELECT loginUserAgent, Username FROM `accounts` WHERE loginData=AES_ENCRYPT((SELECT Username FROM `accounts` WHERE `loginToken`='".$token."'), UNHEX(SHA2(CONCAT('".$token."',(SELECT loginPrivateKey FROM `accounts` WHERE `loginToken`='".$token."')) ,512)))", $params);
    return $result;
  }
//</editor-fold>
//<editor-fold defaultstate="collapsed" desc="Account-Helpers">
    public function pullAccount($accID){
        try{

            $this->_Account->Username = $accID;
            $results = $this->_Account->Find();
            if (count($results) === 0){
                $this->_Log->reportError("Pulling account resulted in a NULL find for ".$accID.".", "AcountHelper->pullAccount");
            }else{
                $this->_Log->reportLog("Pulling account resulted in a find for ".$accID.".", "AcountHelper->pullAccount");
            }
            $this->setAccount($results);
        }catch (Exception $e){
            //ReportError
            $this->_Log->reportError("Couldn't find account due to database issue.", "AcountHelper->pullAccount");
            $this->done = true;
            return false;
        }
        $this->done = true;
        return false;
    }
    public function pullAll(){
        try{
            /* @var $results type */
            $results = $this->_Account->findAll();
            $results = $this->_Globals->delete_col($results, "Password");
            return $results;
        }catch (Exception $e){
            //ReportError
            $this->_Log->reportError("Couldn't find account due to database issue.", "AcountHelper->pullAll");
            $this->done = true;
            return false;
        }
        $this->done = true;
        return false;
    }
    public function getCountUser($user){
        try{
            $this->_Account->Username = $user;
            $this->_Account->Email = $user;
            $results = $this->_Account->FindOR();
            $users = array_column($results, 'Password');
            return count($users);
        }catch (Exception $e){
            //ReportError
            return 0;
        }
        return 0;
    }
    //</editor-fold>
//<editor-fold defaultstate="collapsed" desc="Helpers">
    protected function setAccount($input)
    {
        $this->account = $input;
    }
    public function getAccount(){
        return $this->account;
    }
    public function resetAccount(){
        $this->_Account = new Account();
    }
    //</editor-fold>
}
?>
