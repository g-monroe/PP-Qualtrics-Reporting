<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
include("config/vdev.php");
define(DBCON_PASS, true);
include_once(ROOT . ASSETS . "main/" . VERSION . "php/libs/Controller/Globals.class.php");
include_once(ROOT . ASSETS . "main/" . VERSION . "php/libs/Controller/Account.class.php");
include_once(ROOT . ASSETS . "main/" . VERSION . "php/libs/Controller/Log.class.php");
include_once(ROOT . ASSETS . "main/" . VERSION . "php/libs/bootstrap.php");
require(ROOT . ASSETS . "main/" . VERSION . 'php/libs/PhpMailer/Exception.php');
require(ROOT . ASSETS . "main/" . VERSION . 'php/libs/PhpMailer/PHPMailer.php');
require(ROOT . ASSETS . "main/" . VERSION . 'php/libs/PhpMailer/SMTP.php');
	class Sender{

			# Your Table name
			protected $sendEmail = 'rise@iastate.edu';
      protected $sendKey = "}V9]G=GjLYxDR&Q/FWaD]_";
      protected $_key = "";
      protected $_body = "Empty Body";
      protected $_receiver = "";
      protected $_subject = "Empty Subject";
      public function __construct($classGlobals = null, $classCrypto = null,  $classLog = null, $body = null, $sub = null, $receiver = null, $key = null, $send = false)  {
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


          #set Key
          if ($key !== null){
            $this->setKey($key);
          }
          #Set body
          if ($body !== null) {
            $this->setBody($body);
          }
          #Set Subject
          if ($sub !== null) {
            $this->setSubject($sub);
          }
          #Set receiver
          if ($receiver !== null) {
            $this->setReceiver($receiver);
          }
          #Send if thats all the user wants to do.
          if ($send){
            return $this->sendMail();
          }
      }
      public function setKey($key = null){
        $this->_key = $key;
      }
      public function checkKey(){
        if ($this->_key === $this->sendKey){
          return true;
        }else{
          return false;
        }
      }
      public function setBody($body){
        if (strlen($body) < 2){
          return false;
        }
        $this->_body = $body;
        return true;
      }
      public function setSubject($sub){
        if (strlen($sub) < 2){
          return false;
        }
        $this->_subject = $sub;
        return true;
      }
      public function setReceiver($receiver){
        //Check if Email
        if (!filter_var($receiver, FILTER_VALIDATE_EMAIL)) {//If not Email
          return false;
        }//END - Email validate
        $this->_receiver = $receiver;
        return true;
      }
      public function checkEmail(){
        //Check if Email
        if (!filter_var($this->_receiver, FILTER_VALIDATE_EMAIL)) {//If not Email
          return false;
        }//END - Email validate
        if (strlen($this->_subject) < 2){
          return false;
        }//END - Subject Validate
        if (strlen($this->_body) < 2){
          return false;
        }//END - Body Invakudate
        return true;
      }
      public function sendMail(){
        if (!$this->checkKey()){
          return "Couldn't send because key wasn't set!";
        }
        if (!$this->checkEmail()){
          return "Couldn't send mail is invalid!";
        }
        set_time_limit(120);

        $mail = new PHPMailer(true);                              // Passing `true` enables exceptions
        try {

          $mail = new PHPMailer(true);
          $mail->isSMTP();
          $mail->Host = 'mailhub.iastate.edu';
          $mail->Port       = 587;
          $mail->SMTPSecure = 'tls';
          $mail->SMTPAuth   = false;
          $mail->SetFrom($this->sendEmail, 'phpPress Account Recovery');
          $mail->addAddress($this->_receiver, 'ToEmail');
          $mail->SMTPDebug  = 0;
          $mail->IsHTML(true);
          $mail->Subject = $this->_subject;
          $mail->Body    = $this->_body;
          $mail->AltBody = $this->_body;

          if(!$mail->send()) {
            return false;
          } else {
            return true;
          }
        } catch (Exception $e) {
            return false;
        }
      }
	}

?>
