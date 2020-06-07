<?php

/**
 * This class handles database access
 *
 * author: Emmanuel Owusu
 * created: 2/13/2008
 */

class DataAccess {
    
   /**
    * Database resource
    */
    private var $connection;
	
   /**
    * Query resource
    */
    private var $query;
 
   /**
    * Constucts a new DataAccess object
    * @param $host string hostname for MySQL server
    * @param $db string MySQL database name
	* @param $pw string MySQL password
    */
    function DataAccess ($host, $db, $pw) {
        $this->connection = mysql_pconnect($host, $db, $pw) or trigger_error(mysql_error(), E_USER_ERROR);
        mysql_select_db($db,$this->connection);
    }
 
   /**
    * Fetches a query resources and stores it in a local member
    * @param $sql string the database query to run
    * @return void
    */
    function fetch($sql) {
        $this->query = mysql_unbuffered_query($sql,$this->connection);
    }
 
   /**
    * Returns an associative array of a query row
    * @return mixed
    */
    function getNextRow () {
        if ( $row = mysql_fetch_array($this->query, MYSQL_ASSOC) )
            return $row;
        else
            return false;
    }
}
?>