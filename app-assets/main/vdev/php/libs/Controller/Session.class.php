<?php
  require_once("easyCRUD.class.php");
  include_once("Crypto.class.php");
  include_once("Globals.class.php");
  include_once("SessionHelper.class.php");
	class Session Extends Crud{

			# Your Table name
			protected $table = 'sessions';

			# Primary Key of the Table
			protected $pk	= 'ID';
			public function reset(){
				unset($this->ID);
                                unset($this->PhpID);
                                unset($this->UserID);
                                unset($this->AccountID);
                                unset($this->IP);
                                unset($this->PrivateKey);
                                unset($this->Browser);
                                unset($this->LastRequest);
			}
                        public function returnLog(){
                            return $this->_Log;
                        }
                        public function replaceLog($newLog){
                            $currLog = $this->returnLog();
                            $newLog->errors =  array_merge($newLog->errors, $currLog->errors);
                            $newLog->times =  array_merge($newLog->times, $currLog->times);
                            $newLog->calls =  array_merge($newLog->calls, $currLog->calls);
                            $newLog->logs =  array_merge($newLog->logs, $currLog->logs);
                            $this->_Log = $newLog;
                        }

	}

?>
