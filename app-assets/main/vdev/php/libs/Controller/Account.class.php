<?php
  require_once("easyCRUD.class.php");
  include_once(__DIR__ . '/../Crypto/Crypto.class.php');
  include_once("Globals.class.php");
  include_once("AccountHelper.class.php");
	class Account Extends Crud{

			# Your Table name
			protected $table = 'accounts';

			# Primary Key of the Table
			protected $pk	= 'loginToken';
      public function returnLog(){
          return $this->_Log;
      }
      public function replaceLog($newLog){
          $currLog = $this->returnLog();
          try{
              $newLog->errors =  array_merge($newLog->errors, $currLog->errors);
              $newLog->times  =  array_merge($newLog->times, $currLog->times);
              $newLog->calls  =  array_merge($newLog->calls, $currLog->calls);
              $newLog->logs   =  array_merge($newLog->logs, $currLog->logs);
              $this->_Log = $newLog;
          } catch (Exception $ex) {

          }
      }

	}

?>
