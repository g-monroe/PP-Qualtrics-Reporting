<?php
include_once(__DIR__ . '/../Crypto/Crypto.class.php');
include_once(__DIR__ . '/../bootstrap.php');


include_once("Globals.class.php");
include_once("Account.class.php");
include_once("Log.class.php");
include_once("Request.class.php");
class Qualtrics{
//<editor-fold defaultstate="collapsed" desc="Declares">
    # Class Helpers
    protected $_Globals;
    protected $_Crypto;
    public $_Account;
    public $_Request;
    protected $_Log;
    protected $_SessionHelper;
    protected $token;
    protected $_foundFID = false;
    protected $_fID = "";
    protected $apiURL = "https://iastateeducation.qualtrics.com/API/v3/";
    protected $fields;
    # Checking if Completed
    public $done = false;
    public $error = "";
    public $success = false;
//</editor-fold>
//<editor-fold defaultstate="collapsed" desc="Constructor">
    public function __construct($apiToken = "",$classGlobals = null, $classCrypto = null, $classAccount = null, $check = false, $user = null, $pass = null, $classSessionHelper = null, $classRequest = null, $classLog = null)
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

        #Check Request Class
        if ($classRequest === null) {
            $this->_Request = new Request($this->apiURL);
        } else {
            $this->_Request = $classRequest;
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
        $this->token = $apiToken;
    }
    public function getSurveys(){
      $ext = "surveys";
      $headers = array("x-api-token: " . $this->token);
      return $this->sendRequest($ext, false, $headers);
    }
    public function pullResponses($surveyID = "null"){
      $this->_foundFID = false;
      //Get Questions
      $post = false;
      $ext = "surveys/".$surveyID;
      $headers = array("x-api-token: " . $this->token);
      $qResult = $this->sendRequest($ext, $post, $headers, $headers);
      $questions = json_decode($qResult->__tostring(), true);
      if($questions["meta"]["httpStatus"] !== "200 - OK"){
        return "Request Error - Questions failed. ".$questions["meta"]["httpStatus"];
      }else{
        $_SESSION["q_".$surveyID] = $questions;
      }
      //POST request with body
      $post = true;
      $ext = "surveys/".$surveyID."/export-responses";
      $fields = array("format" => "json", "compress" => false);
      $fields = json_encode($fields);
      $headers = array("x-api-token: " . $this->token, "Content-Type: application/json");
      $startResult = $this->sendRequest($ext, $post, $fields, $headers);
      $src = json_decode($startResult->__tostring(), true);
      if($src["meta"]["httpStatus"] !== "200 - OK"){
        return "Request Error - Start failed. ".$src["meta"]["httpStatus"]."<br/>".$responses["meta"]["requestId"];
      }
      $pID = $src["result"]["progressId"];
    //  return $pID;

    //GET Request Until Status = Complete
    $indx = 0;
  try {
       $fIDF = false;
       $ext = "surveys/".$surveyID."/export-responses/".$pID;
       $client = new GuzzleHttp\Client();

      do{
          if ($this->_foundFID){
            break;
          }
          $indx++;
          $promise = $client->getAsync($this->apiURL . $ext, ['proxy' => 'tcp://proxy.its.iastate.edu:6969', 'headers' => ['X-API-TOKEN' => $this->token]]);
          $promise->then(function ($response) {
            $json = $response->getBody() . PHP_EOL;
            $json2 = json_decode($json, true);
            if (strlen($json2["result"]["fileId"]) > 33){
              $this->_fID = $json2["result"]["fileId"];
              $this->_foundFID = true;
            }
          });
          $response = $promise->wait();
      }while($indx<100 && $this->_foundFID === false);
      }catch (GuzzleHttp\Exception\ClientException $e) {
          $response = $e->getResponse();
          $responseBodyAsString = $response->getBody()->getContents();
      }

      //Final Get Request return responses
      $post = false;
      $ext = "surveys/".$surveyID."/export-responses/".$this->_fID."/file";
      $headers = array("x-api-token: " . $this->token);
      $finalResult = $this->sendRequest($ext, $post, $headers, $headers);
      $responses = json_decode($finalResult->__tostring(), true);
      if(strlen($responses["meta"]["httpStatus"]) > 0){
        return "Request Error - Final failed. ".$responses["meta"]["httpStatus"]."<br/>".$responses["meta"]["requestId"];
      }else{
        $_SESSION[$surveyID] = $responses;
        return "good";
      }
    }
    private function sendRequest($ext = "", $post = true, $data = null, $headers = array("Expected:")){
      if($post && $data !== null){
          $this->_Request->setPost($data);
          $this->_Request->setHeaders($headers);
          $this->_Request->createCurl($this->apiURL . $ext);
      }else{
        $this->_Request->setGet($data);
        $this->_Request->setHeaders($headers);
        $this->_Request->createCurl($this->apiURL . $ext);
      }
      return $this->_Request;
    }

}
?>
