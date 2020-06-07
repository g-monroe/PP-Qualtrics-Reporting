<?php
/*
Credit to: Artem at Zabsoft
http://www.php.net/manual/en/book.curl.php

Modified: Gavin Monroe
*/
class Request {
     protected $_useragent = 'Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1';
     protected $_url;
     protected $_followlocation;
     protected $_timeout;
     protected $_maxRedirects;
     protected $_cookieFileLocation = './cookie.txt';
     protected $_post;
     protected $_ch;
     protected $_get = false;
     protected $_postFields;
     protected $_headers;
     protected $_getFields = array();
     protected $_referer ="http://rise.hs.iastate.edu/";

     protected $_session;
     protected $_proxy = "tcp://proxy.its.iastate.edu:6969";
     protected $_webpage;
     protected $_includeHeader;
     protected $_noBody;
     protected $_status;
     protected $_binaryTransfer;
     public    $authentication = 0;
     public    $auth_name      = '';
     public    $auth_pass      = '';

     public function useAuth($use){
       $this->authentication = 0;
       if($use == true) $this->authentication = 1;
     }

     public function setName($name){
       $this->auth_name = $name;
     }
     public function setPass($pass){
       $this->auth_pass = $pass;
     }

     public function __construct($url, $followlocation = true, $timeOut = 40, $maxRedirecs = 4,$binaryTransfer = false,$includeHeader = false,$noBody = false)
     {
         $this->_url = $url;
         $this->_followlocation = $followlocation;
         $this->_timeout = $timeOut;
         $this->_maxRedirects = $maxRedirecs;
         $this->_noBody = $noBody;
         $this->_includeHeader = $includeHeader;
         $this->_binaryTransfer = $binaryTransfer;

         $this->_cookieFileLocation = dirname(__FILE__).'/cookie.txt';

     }

     public function setReferer($referer){
       $this->_referer = $referer;
     }

     public function setCookiFileLocation($path)
     {
         $this->_cookieFileLocation = $path;
     }

     public function setPost ($postFields)
     {
        $this->_post = true;
        $this->_get = false;
        $this->_postFields = $postFields;
     }
     public function setGet ($getFields)
     {
        $this->_get = true;
        $this->_post = false;
        $this->_getFields = $getFields;
     }
     public function setUserAgent($userAgent)
     {
         $this->_useragent = $userAgent;
     }
     public function setHeaders($headers){
       $this->_headers = $headers;
     }
     public function setCURL($ch){
       $this->_ch = $ch;
     }
     public function configCURL($url = 'nul'){
       if($url != 'nul'){
         $this->_url = $url;
       }
        curl_setopt($this->_ch,CURLOPT_URL,$this->_url);
        if($this->_get){
          curl_setopt($this->_ch,CURLOPT_HTTPHEADER,$this->_getFields);
        }else{
          curl_setopt($this->_ch,CURLOPT_HTTPHEADER,$this->_headers);
        }
        curl_setopt($this->_ch,CURLOPT_TIMEOUT,$this->_timeout);
        curl_setopt($this->_ch, CURLOPT_PROXY, $this->_proxy);
        curl_setopt($this->_ch,CURLOPT_MAXREDIRS,$this->_maxRedirects);
        curl_setopt($this->_ch,CURLOPT_RETURNTRANSFER,true);
        curl_setopt($this->_ch,CURLOPT_FOLLOWLOCATION,$this->_followlocation);
        curl_setopt($this->_ch,CURLOPT_COOKIEJAR,$this->_cookieFileLocation);
        curl_setopt($this->_ch,CURLOPT_COOKIEFILE,$this->_cookieFileLocation);

        if($this->authentication == 1){
          curl_setopt($this->_ch, CURLOPT_USERPWD, $this->auth_name.':'.$this->auth_pass);
        }
        if($this->_post){
           var_dump($this->_postFields);
           curl_setopt($this->_ch,CURLOPT_POST,true);
           curl_setopt($this->_ch,CURLOPT_POSTFIELDS,$this->_postFields);
        }

        if($this->_includeHeader)
        {
           curl_setopt($this->_ch,CURLOPT_HEADER,true);
        }

        if($this->_noBody)
        {
            curl_setopt($this->_ch,CURLOPT_NOBODY,true);
        }
        curl_setopt($this->_ch,CURLOPT_USERAGENT,$this->_useragent);
        curl_setopt($this->_ch,CURLOPT_REFERER,$this->_referer);
     }
     public function initCURL(){
       $this->_ch = curl_init();
     }
     public function closeCURL(){
       curl_close($this->_ch);
     }
     public function execCURL(){
      return curl_exec($this->_ch);
     }
     public function getCURL(){
       return $this->_ch;
     }
     public function createCurl($url = 'nul')
     {
        if($url != 'nul'){
          $this->_url = $url;
        }

         $s = curl_init();

         curl_setopt($s,CURLOPT_URL,$this->_url);
         if($this->_get){
           curl_setopt($s,CURLOPT_HTTPHEADER,$this->_getFields);
         }else{
           curl_setopt($s,CURLOPT_HTTPHEADER,$this->_headers);
         }
         curl_setopt($s,CURLOPT_TIMEOUT,$this->_timeout);
         curl_setopt($s, CURLOPT_PROXY, $this->_proxy);
         curl_setopt($s,CURLOPT_MAXREDIRS,$this->_maxRedirects);
         curl_setopt($s,CURLOPT_RETURNTRANSFER,true);
         curl_setopt($s,CURLOPT_FOLLOWLOCATION,$this->_followlocation);
         curl_setopt($s,CURLOPT_COOKIEJAR,$this->_cookieFileLocation);
         curl_setopt($s,CURLOPT_COOKIEFILE,$this->_cookieFileLocation);

         if($this->authentication == 1){
           curl_setopt($s, CURLOPT_USERPWD, $this->auth_name.':'.$this->auth_pass);
         }
         if($this->_post){
            curl_setopt($s,CURLOPT_POST,true);
            curl_setopt($s,CURLOPT_POSTFIELDS,$this->_postFields);
         }

         if($this->_includeHeader)
         {
               curl_setopt($s,CURLOPT_HEADER,true);
         }

         if($this->_noBody)
         {
             curl_setopt($s,CURLOPT_NOBODY,true);
         }
         curl_setopt($s,CURLOPT_USERAGENT,$this->_useragent);
         curl_setopt($s,CURLOPT_REFERER,$this->_referer);

         $this->_webpage = curl_exec($s);
         $this->_status = curl_getinfo($s,CURLINFO_HTTP_CODE);
         curl_close($s);

     }

   public function getHttpStatus()
   {
       return $this->_status;
   }

   public function __tostring(){
      return $this->_webpage;
   }
}
?>
