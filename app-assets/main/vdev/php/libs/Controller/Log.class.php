<?php
/* *
* Log 			A logger class which creates logs when an exception is thrown.
* @author		Author: Gavin Monroe. 
* @version      0.1a
*/
class Log {
    public $errors = array();
    public $logs = array();
    public $calls = array();
    public $times = array();
    public $errorLevel = 0;
    # @string, Log directory name
    private $path = '/logs/';
    private $start = 0;
    private $final = 0;
    private $total = 0;
    public $switch = "0";
    # @void, Default Constructor, Sets the timezone and path of the log files.
    public function __construct() {
        date_default_timezone_set('America/Chicago');
        $this->path  = dirname(__FILE__)  . $this->path;
        $t = microtime(true);
        $micro = ($t - floor($t)) * 1000000;
        $this->start = $micro;
    }
    public function reportError($info, $from){
        $t = microtime(true);
        $ms = ($t - floor($t)) * 1000000;
        $this->final = $ms;
        $this->total = $this->final - $this->start;
        $micro = sprintf("%06d",ms);
        $d = new DateTime( date('Y-m-d H:i:s.'.$micro, $t) );
        $NOW = $d->format("H:i:s.u");
        array_push($this->calls, $from." FROM ".$this->getFunctionCalls());
        array_push($this->errors, $info);
        array_push($this->times, $NOW);
        array_push($this->logs, "NULL");
        $this->errorLevel = 2;
    }
    public function reportLog($info, $from){
        $t = microtime(true);
        $ms = ($t - floor($t)) * 1000000;
        $this->final = $ms;
        $this->total = $this->final - $this->start;
        $micro = sprintf("%06d",$ms);
        $d = new DateTime( date('Y-m-d H:i:s.'.$micro, $t) );
        $NOW = $d->format("H:i:s.u");
        array_push($this->calls, $from." FROM ".$this->getFunctionCalls());
        array_push($this->logs, $info);
        array_push($this->times, $NOW);
        array_push($this->errors, "NULL");
        ($this->errorLevel !== 2)?$this->errorLevel:1;
    }
    public function grabReport(){
      $output = '<table style="width:100%; border: 1px solid black; background-color:white;"><tbody><tr style="background-color:lightcyan"><th>Info</th><th>Time</th><th>Call From</th></tr>';
      $output=$output."<tr style='background-color:lightgray; '>"."<td style='text-align: center;'>Errors:".$this->getErrCount().", Logs:".count($this->logs)."; </td>"."<td style='text-align: center;'>Eclipsed:".round($this->grabTotal() / 1000000, 3)."ms</td>"."<td style='text-align: center;'>Total Calls:".count($this->calls)."</td></tr>";
      for ($i = 0; $i < count($this->calls); $i++) {
        if ($this->logs[$i] === "NULL"){
          $output=$output."<tr style='border-bottom: 1px solid black; background-color:lightcoral'>"."<td>".$this->errors[$i]."</td>"."<td>".$this->times[$i]."</td>"."<td>".$this->calls[$i]."</td></tr>";
        }else{
          $output=$output."<tr style='border-bottom: 1px solid black; background-color:lightyellow';>"."<td>".$this->logs[$i]."</td>"."<td>".$this->times[$i]."</td>"."<td>".$this->calls[$i]."</td></tr>";
        }
      }
      return $output."</tbody></table>";
    }
    public function getErrCount(){
        $cnt = 0;
        if (count($this->errors) !== 0){
            foreach($this->errors as &$val){
                if ($val !== "NULL"){
                    $cnt++;
                }
            }
        }
        return $cnt;
    }
    public function grabTotal(){
        return $this->total;
    }
    public function grabLatestError(){
        if (count($this->errors) > 0){
            $last = count($this->errors) - 1;
            return $this->errors[$last];
        }else{
            return 0;
        }
    }
    public function getFunctionCalls(){
        $arr = debug_backtrace();
        $output = "";
        $i =0;
        foreach($arr as &$val){
            if($i === 2){
                $output = $val["function"];
            }else{
                if ($val["function"] === "__construct"){
                    $output = $output."=>".$val["function"]."(".$val["class"].")";
                }else{
                    $output = $output."=>".$val["function"];
                }
            }
            $i++;
        }
        return $output;
    }
    public function grabErrLvl(){
        return $this->errorLevel;
    }
    /**
     *   @void
     *	Creates the log
     *
     *   @param string $message the message which is written into the log.
     *	@description:
     *	 1. Checks if directory exists, if not, create one and call this method again.
     *	 2. Checks if log already exists.
     *	 3. If not, new log gets created. Log is written into the logs folder.
     *	 4. Logname is current date(Year - Month - Day).
     *	 5. If log exists, edit method called.
     *	 6. Edit method modifies the current log.
     */
    public function write($message) {
        // if ($switch == "1"){
        // 		$date = new DateTime();
        // 		$log = $this->path . $date->format('Y-m-d').".txt";
        //
        // 		if(is_dir($this->path)) {
        // 			if(!file_exists($log)) {
        // 				$fh  = fopen($log, 'a+') or die("Fatal Error !");
        // 				$logcontent = "Time : " . $date->format('H:i:s')."\r\n" . $message ."\r\n";
        // 				fwrite($fh, $logcontent);
        // 				fclose($fh);
        // 			}
        // 			else {
        // 				$this->edit($log,$date, $message);
        // 			}
        // 		}
        // 		else {
        // 			  if(mkdir($this->path,0777) === true)
        // 			  {
        // 				 $this->write($message);
        // 			  }
        // 		}
        // 	}
    }

    /**
     *  @void
     *  Gets called if log exists.
     *  Modifies current log and adds the message to the log.
     *
     * @param string $log
     * @param DateTimeObject $date
     * @param string $message
     */
    private function edit($log,$date,$message) {
        echo($message."</br>");
        // if ($switch == "1"){
        // 	$logcontent = "Time : " . $date->format('H:i:s')."\r\n" . $message ."\r\n\r\n";
        // 	$logcontent = $logcontent . file_get_contents($log);
        // 	file_put_contents($log, $logcontent);
        // }
    }
}
?>
