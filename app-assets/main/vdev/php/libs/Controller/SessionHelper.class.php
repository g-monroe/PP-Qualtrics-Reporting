<?php
include_once("Crypto.class.php");
include_once("Globals.class.php");
include_once("Session.class.php");
include_once("Log.class.php");
class SessionHelper
{
//<editor-fold defaultstate="collapsed" desc="Declares">
    # Class Helpers
    protected $_Globals;
    protected $_Crypto;
    protected $_Session;
    protected $_Log;
    # Security/Token generate
    protected $publicKey;
    protected $privateKey;
    protected $token;
    protected $masterToken;
    protected $accountID;
    protected $cryptedAccountID;
    public $account;
    # Checking if Completed
    public $started = false;
    public $done = false;
    public $error = null;
    public $errorLevel = 0;
    public $droppedID = false;
    public $droppedToken = false;
//</editor-fold>
    
//<editor-fold defaultstate="collapsed" desc="Constructor">
    public function __construct($accID, $start = false, $classGlobals = null, $classCrypto = null, $classSession = null, $classLog = null)
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
        
        #Check Session Class
        if ($classSession === null) {
            $this->_Session = new Session();
            $this->_Session->replaceLog($this->_Log);
        } else {
            $this->_Session = $classSession;
            $this->_Session->replaceLog($this->_Log);
        }
        if ($start) {
            $this->closeSession();
            $this->setAccount($accID);
            if ($this->setSession()) {
                if ($this->sendSession()) {
                    $this->started = true;
                } else {
                    $this->_Log->reportError("Couldn't initialize cookies with server and placement.", "SessionHelper->constructor->sendSession");
                    $this->errorLevel = 2;
                }
            } else {
                $this->_Log->reportError("Couldn't initialize cookies for encryption and placement.", "SessionHelper->constructor->setSession");
                $this->errorLevel = 2;
            }
        } else {
            //Check Session Time
            $this->started = $this->checkSession();
        }
        $this->done = true;
    }
//</editor-fold>

//<editor-fold defaultstate="collapsed" desc="Returns/Sets">
    public function getCryptedAccountID()
    {
        return $this->cryptedAccountID;
    }
    public function getStarted()
    {
        return $this->started;
    }
    public function getAccountID()
    {
        return $this->accountID;
    }

    public function getPrivateKey($fromSession)
    {
        if ($this->_Session === $fromSession) {
            return $this->privateKey;
        } else {
            return null;
        }
    }

    public function getSessionToken()
    {
        return $this->token;
    }

    public function getCookieToken()
    {
        if (isset($_COOKIE["token"])) {
            return $this->_Globals->noHTML($_COOKIE["token"]);
        }
        return null;
    }

    public function getCookiePublicKey()
    {
        if (isset($_COOKIE["key"])) {
            return $this->_Globals->noHTML($_COOKIE["key"]);
        }
        return null;
    }

    public function getCookieAccountID()
    {
        if (isset($_COOKIE["accID"])) {
            return $this->_Globals->noHTML($_COOKIE["accID"]);
        }
        return null;
    }

    protected function setPublicKey($input)
    {
        $this->publicKey = $input;
    }

    protected function setPrivateKey($input)
    {
        $this->privateKey = $input;
    }

    protected function setToken($input)
    {
        $this->token = $input;
    }

    protected function setAccount($input)
    {
        $this->accountID = $input;
    }

    protected function setCryptedAccount($input)
    {
        $this->cryptedAccountID = $input;
    }
    public function setAccountCols($input)
    {
        $this->account = $input;
    }
    public function getAccountCols(){
        return $this->account;
    }
        public function closeSession()
    {
        $this->dropTokenSession();
        $this->dropIDSession();
        $this->_Globals->deleteCookies();
        $this->started = false;
    }
//</editor-fold>
    
//<editor-fold defaultstate="collapsed" desc="Session Helpers">
    private function setSession()
    {
        try {
            //Generate token & Set
            $this->setToken($this->generateSessionToken());
            $this->_Globals->setCook("token", $this->token, 3600);
            //Set Public Key
            $this->_Globals->setCook("key", $this->publicKey, 3600);
            //Generate & Set Account ID
            $this->setCryptedAccount($this->_Crypto->encrypt($this->accountID, $this->privateKey, true));
            $this->_Globals->setCook("accID", $this->cryptedAccountID, 3600);
            $this->_Log->reportLog("Finished Set Session!", "SessionHelper->constructor->setSession");
            //Return
            return true;
        } catch (Exception $e) {
            return false;
        }
    }

    private function generateSessionToken()
    {
        $pubKey = $this->_Globals->genRndStr(32);   //Stays with Client
        $priKey = $this->_Globals->genRndStr(32);   //Stays With Server
        $this->_Log->reportLog("Private Key & Public Key Generated", "SessionHelper->setSession->generateSessionToken");
        try {
            $this->setPublicKey($pubKey);
            $this->setPrivateKey($priKey);
            //Set it to Master Token
            $this->setToken($this->_Globals->getMasterToken());
            //Encrypt Master Token
            return $this->_Crypto->encrypt($this->token, $pubKey . $priKey, true);
        } catch (Exception $e) {
            return null;
        }
        return null;
    }
    public function updateSessionTime()
    {
        $newToken = $_COOKIE["token"];
        $newAccountID = $this->getCookieAccountID();
        $newPublicKey = $this->getCookiePublicKey();
        if ($newToken === null || $newAccountID === null || $newPublicKey === null) {
            $this->_Log->reportError("Invalid token session contents; Couldn't verify true validation of session.", "SessionHelper->updateSessionTime");
            return false;
        }
        //Delete cookies
        //$this->_Globals->deleteCooks();

        //Set Token
        $this->_Globals->setCook("token", $newToken, 3600);
        //Set Public Key
        $this->_Globals->setCook("key", $newPublicKey, 3600);
        //Set Account ID
        $this->_Globals->setCook("accID", $newAccountID, 3600);

        //Update Session Time on server.
        $sessionID = $this->pullSessionID();
        if ($sessionID !== null) {
            $this->_Session->ID = $sessionID;
            $this->_Session->LastRequest = $this->_Globals->NOW();
            $results = $this->_Session->Save($sessionID);
            $this->_Log->reportLog("Session was updated!", "SessionHelper->constructor->updateSessionTime");
            if ($results >= 1) {
                return true;
            } else {
                $this->_Log->reportLog("Couldn't update session.", "SessionHelper->updateSessionTime");
                return false;
            }
        } else {
            $this->_Log->reportLog("Couldn't grab identification; Couldn't verify true validation of session.", "SessionHelper->updateSessionTime");
            return false;
        }
    }

    public function checkSession($info = "")
    {
        $clientToken = html_entity_decode($this->getCookieToken(), ENT_QUOTES | ENT_HTML5, 'UTF-8');
        if ($clientToken !== null) {
            $privKey = $this->pullPrivateKey();
            $pubKey = $this->getCookiePublicKey();
            if ($privKey !== null && $pubKey !== null) {
                try {
                    $decryptedToken = $this->_Crypto->decrypt($clientToken, $pubKey . $privKey, true);

                    $pieces = explode($this->_Globals->getTokenSplitter(), $decryptedToken);
                    //SET
                    $ip = $pieces[0];
                    $browser = $pieces[1];
                    $auth = $pieces[2];
                    $newPieces = array($this->_Globals->getIP(), $this->_Globals->getBrowser(), $this->_Globals->getTokenPart());
                    if ($ip === "" || $browser === "" || $auth === "") {
                        $this->_Log->reportError("Invalid token session contents; Couldn't verify true validation of session.", "SessionHelper->checkSession");
                        return false;
                    }
                    if ($ip !== $this->_Globals->getIP() || $browser !== $this->_Globals->getBrowser() || $auth !== $this->_Globals->getTokenPart()) {
                        $this->_Log->reportError("Change of token session contents; Invalid true validation of session.", "SessionHelper->checkSession");
                        return false;
                    }
                    $enterTime = $this->pullLastRequest();
                    if ($enterTime !== null) {
                        $this->_Log->reportLog("Checked Session.", "SessionHelper->checkSession");
                        return $this->checkSessionTime($enterTime);
                    } else {
                        $this->_Log->reportError("Couldn't find time contents; Couldn't verify true validation of session.", "SessionHelper->checkSession");
                        return false;
                    }
                } catch (Exception $e) {
                    $this->closeSession();
                    $this->_Log->reportError("Couldn't decrypt contents; Couldn't verify true validation of session.", "SessionHelper->checkSession");
                    return false;
                }
            } else {
                $this->_Log->reportError("Couldn't grab decryption contents; Couldn't verify true validation of session.", "SessionHelper->checkSession");
                return false;
            }
        } else {
            $this->_Log->reportError("Token wasn't set; Couldn't verify true validation of session.", "SessionHelper->checkSession");
            return false;
        }
    }

    public function checkSessionTime($enterTime = null)
    {
        if ($enterTime !== null) {
            $timeDiffernce = $this->_Globals->NOW() - $enterTime;
            if ($timeDiffernce > 3600) { // exprie after one hour (3600 seconds)
                // unset session
                $this->_Log->reportError("Session TimeOut; Bad Session.", "SessionHelper->checkSessionTime");
                return false;
            } else {
                if ($this->updateSessionTime()) {
                    return true;
                } else {
                    return false;
                }
            }
        } else {
            $this->_Log->reportError("Couldn't find time contents; Couldn't verify true validation of session.", "SessionHelper->checkSessionTime");
            return false;
        }
    }

    private function pullPrivateKey()
    {
        $result = $this->getCookieToken();
        if ($result !== null) {
            $this->_Session->PhpID = $result;
            $results = $this->_Session->Find();
            $this->account = $results;
            $privKeys = array_column($results, 'PrivateKey');
            if ($privKeys !== null) {
                $this->_Log->reportLog("Pulled Private key result!", "SessionHelper->pullPrivateKey");
                return $privKeys[0];
            } else {
                $this->_Log->reportError("PROBLEM pulling Private key result was null!", "SessionHelper->pullPrivateKey");
                return null;
            }
        } else {
            $this->_Log->reportError("PROBLEM pulling Private key cookie was null!", "SessionHelper->pullPrivateKey");
            return null;
        }
    }

    private function pullLastRequest()
    {
        $result = $this->getCookieToken();
        if ($result !== null) {
            $this->_Session->PhpID = $result;
            $results = $this->_Session->Find();
            $lastReqs = array_column($results, 'LastRequest');
            if ($lastReqs !== null) {
                $this->_Log->reportLog("Pulled Last Request result!", "SessionHelper->pullLastRequest");
                return $lastReqs[0];
            } else {
                $this->_Log->reportError("PROBLEM pulling Lastrequest result was null!", "SessionHelper->pullLastRequest");
                return null;
            }
        } else {
            $this->_Log->reportError("PROBLEM pulling cookie token was null!", "SessionHelper->pullLastRequest");
            return null;
        }
    }

    private function pullSessionID()
    {
        $result = $this->getCookieToken();
        if ($result !== null) {
            $this->_Session->PhpID = $result;
            $results = $this->_Session->Find();
            $sesID = array_column($results, 'ID');
            if ($sesID !== null) {
                 $this->_Log->reportLog("Pulled SessionID result!", "SessionHelper->pullSessionID");
                return $sesID[0];
            } else {
                $this->_Log->reportError("PROBLEM pulling Session result was null!", "SessionHelper->pullSessionID");
                return null;
            }
        } else {
            $this->_Log->reportError("PROBLEM pulling Session Token cookie was null!", "SessionHelper->pullSessionID");
            return null;
        }
    }

    /*
     # 	1. Clear all sessions with the same Account ID;
     #  2. Check VARS
     #  3. Create Session on Server.
    */
    public function sendSession()
    {
        $ip = $this->_Globals->getIP();
        $browser = $this->_Globals->getBrowser();
        $now = $this->_Globals->NOW();
        $priKey = $this->privateKey;
        $rndID = $this->_Globals->genRndStr(32);
        $accID = $this->getAccountID();
        $cryptedID = $this->getCryptedAccountID();
        $tokID = $this->_Globals->noHTML($this->getSessionToken());
        #1.
        $droppedID = $this->dropIDSession(true);
        #2.
        if ($accID === null || $cryptedID === null) {
            $this->_Log->reportError("Send Session couldn't find crypted or account!", "SessionHelper->sendSession");
            return false;
        }
        #3.
        $this->_Session->ID = $rndID;
        $this->_Session->PhpID = $tokID;
        $this->_Session->UserID = $accID;
        $this->_Session->AccountID = $cryptedID;
        $this->_Session->IP = $ip;
        $this->_Session->PrivateKey = $priKey;
        $this->_Session->Browser = $browser;
        $this->_Session->LastRequest = $now;
        $created = $this->_Session->Create();
        $this->_Log->reportLog("Sent Session!", "SessionHelper->sendSession");
        return $created;
    }

    public function countSessions($new = false, $tok = false, $id = null, $info = "1")
    {

        if ($new) {
            $this->_Session->UserID = $id;
            $result = $this->_Session->Find();
            $this->_Log->reportLog("Counted Session of new!", "SessionHelper->countSessions");
            return count($result);
        } else {
            if ($tok) {
                $this->_Session->PhpID = $id;
                $result = $this->_Session->Find();
                $this->_Log->reportLog("Counted Session with token!", "SessionHelper->countSessions");
                return count($result);
            } else {
                $priKey = $this->pullPrivateKey();
                if ($priKey !== null) {
                    $this->_Log->reportError("PROBLEM couldn't pull private key!", "SessionHelper->countSessions");
                    return null;
                }
                try {
                    $decryptedAccountID = $this->_Crypto->decrypt($id, $priKey, true);
                    $this->_Session->UserID = $decryptedAccountID;
                    $result = $this->_Session->Find();
                    $this->_Log->reportLog("Counted Session with no token!", "SessionHelper->countSessions");
                    return count($result);
                } catch (Exception $e) {
                    $this->_Log->reportError("PROBLEM couldn't find Session with db problem!", "SessionHelper->countSessions");
                    return null;
                }
            }
        }
        return null;
    }

    public function dropIDSession($new = false)
    {

        $accID = null;
        if ($new) {
            $accID = $this->getAccountID();
        } else {
            $accID = $this->getCryptedAccountID();
        }
        if ($accID !== null) {
            $result = $this->countSessions($new, false, $accID, "Account Pull");
            if ($result >= 1 && $result !== null) {
                $this->_Session->UserID = $accID;
                $delete = $this->_Session->Delete(array("UserID" => $accID));
                $this->_Log->reportLog("Dropped Session by ID!", "SessionHelper->dropIDSession");
                return $delete;
            }
        }
        return false;
    }

    public function dropTokenSession()
    {
        $tokenID = $this->getCookieToken();
        if ($tokenID !== null) {
            $result = $this->countSessions(false, true, $tokenID, "Token Pull");
            if ($result >= 1 && $result !== null) {
                $this->_Session->PhpID = $tokenID;
                $delete = $this->_Session->Delete(array("PhpID" => $tokenID));
                 $this->_Log->reportLog("Dropped Session by Token!", "SessionHelper->dropTokenSession");
                return true;
            }
        }
        return false;
    }
    //</editor-fold>
    
//<editor-fold defaultstate="collapsed" desc="Helpers">
    public function checkAdminAccess($ses, $acc, $log, $glob){
                $userID = $ses->account[0]['UserID'];
                $acc->pullAccount($userID);
                try{
                    $staffType = (int)$acc->getAccount()[0]["Type"];
                    if ($staffType !== 2){
                      $log->reportError("You don't have permission to access this page! StaffType = ".$staffType.".", "file->PermissionsCheck->UserType");
                    }else{
                      $log->reportLog("You do have permission to access this page!", "file->PermissionsCheck->UserType");
                    }
                } catch (Exception $ex) {
                    $log->reportError("Couldn't verify user's type.", "file->PermissionsCheck->UserType");
                }
                if ($log->grabErrLvl() === 2){
                  $errMsg = $log->grabLatestError();
                  $accID = $ses->getCookieAccountID();
                  $ses->closeSession();
                  $glob->deleteCookies();
                  $glob->setCook("accID", $accID, 600);
                  if ($errMsg !== "NULL"){
                    return $errMsg;
                  }
                }
                return "";
        }
    public function checkAccess($ses, $acc, $log, $glob){
                if ($log->grabErrLvl() === 2){
                  $errMsg = $log->grabLatestError();
                  $accID = $ses->getCookieAccountID();
                  $ses->closeSession();
                  $glob->deleteCookies();
                  $glob->setCook("accID", $accID, 600);
                  if ($errMsg !== "NULL"){
                      return $errMsg;
                  }
                }
                return "";
        }
//</<editor-fold>
}

?>
