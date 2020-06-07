<?php

class Globals
{

    public $loginURL = "#";

    public function __construct()
    {

    }

    function validateCaptcha()
    {
      if (isset($_POST['g-recaptcha-response'])){
          # Verify captcha
          $post_data = http_build_query(
              array(
                  'secret' => '6LeeonQUAAAAAPwg-9lxtS569oUi73qqAo39-7tq',
                  'response' => $_POST['g-recaptcha-response'],
                  'remoteip' => $_SERVER['REMOTE_ADDR']
              )
          );
          $opts = array('http' =>
                array(
                'method'  => 'POST',
                'header'  => 'Content-type: application/x-www-form-urlencoded',
                'content' => $post_data,
                'proxy' => 'tcp://proxy.its.iastate.edu:6969',
                'request_fulluri' => TRUE,
                )
              );
          $context  = stream_context_create($opts);
          $response = file_get_contents('https://www.google.com/recaptcha/api/siteverify', false, $context);
          $result = json_decode($response);
          if ($result->success) {
            return true;
          }else{
            return false;
          }
      }else{
        return false;
      }
    }
    function stripSpecialChars($str){
      if (preg_match('/[\'^£$%&*()}{@#~?><>,|=_+¬-]/', $str)){
        return preg_replace('/[^A-Za-z0-9\-]/', '', $str);
      }else{
        return $str;
      }
    }
    function delete_col(&$array, $key) {
        $arr = $array;
        $max = count($arr);
        for($i = 0; $i < $max; $i++){
            unset($arr[$i][$key]);
        }
        return $arr;
    }
    function delete_row(&$array, $offset) {
        return array_splice($array, $offset, 1);
    }
    function generateToken($formName)
    {
        $secretKey = 'VHnH!Bg72GfwveK!9PcUeO$hd0rYlTnU';
        if (!session_id()) {
            session_start();
        }
        $sessionId = session_id();

        return sha1($formName . $sessionId . $secretKey);

    }
    function checkToken( $token, $formName ){
        return $token === $this->generateToken( $formName );
    }

    public function NOW()
    {
        return date('Y-m-d H:i:s');
    }
    
    public function getIP()
    {
        return $_SERVER["REMOTE_ADDR"];
    }

    public function getBrowser()
    {
        return $_SERVER["HTTP_USER_AGENT"];
    }

    public function getTokenPart()
    {
        return "_RISE_fuzzy_piano_347";
    }

    public function getTokenSplitter()
    {
        return "[~:-:{RISE}:-:~]";
    }

    public function getMasterToken()
    {
        return $this->getIP() . $this->getTokenSplitter() . $this->getBrowser() . $this->getTokenSplitter() . $this->getTokenPart();
    }

    function setCook($key, $value, $seconds)
    {
        try {
            setcookie($key, $value, time() + $seconds, '/');
            return true;
        } catch (Exception $e) {
            return false;
        }//End Try
    }//End Fucntion

    function deleteCookies()
    {
        if (isset($_SERVER['HTTP_COOKIE'])) {
            $cookies = explode(';', $_SERVER['HTTP_COOKIE']);
            foreach ($cookies as $cookie) {
                $parts = explode('=', $cookie);
                $name = trim($parts[0]);
                if ($name != "accID") {
                    setcookie($name, '', time() - 1000);
                    setcookie($name, '', time() - 1000, '/');
                }
            }
        }
    }

    function redirect($url)
    {
        header("Location: " . $url);
        die();
    }//End Function

    #Generate Random Strings
    public function genRndStr($num)
    {//Generate String
        $chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charsLength = strlen($chars);
        $code = '';
        for ($i = 0; $i < $num; $i++) {
            $code .= $chars[rand(0, $charsLength - 1)];
        }//End(1)
        return $code;
    }//End If

    function startsWith($haystack, $needle)
    {
        $length = strlen($needle);
        return (substr($haystack, 0, $length) === $needle);
    }

    function endsWith($haystack, $needle)
    {
        $length = strlen($needle);

        return $length === 0 ||
            (substr($haystack, -$length) === $needle);
    }

    function noHTML($input, $encoding = 'UTF-8')
    {
        $input = strip_tags($input); // Strip tags
        return htmlentities($input, ENT_QUOTES | ENT_HTML5, $encoding); //Strip all special chars
    }//End Function


}

?>
