<?php
//ERROR REPORTING
error_reporting(E_ALL);
ini_set('display_errors', 0);
$ip = $_SERVER['REMOTE_ADDR'];
$nowtime = date("Y-m-d H:i:s");
$userAgent = $_SERVER['HTTP_USER_AGENT'];

/**
 * Global Definitions
 * for the ELPS, RISE, and CCLP websites
 *
 * author: Emmanuel Owusu
 * created: 12/19/2008
 */

/**
 * Directory Definitions
 */
 //define("ROOT_DIR", $_SERVER['DOCUMENT_ROOT']."/");

 define("ROOT_DIR", $_SERVER['DOCUMENT_ROOT']."/new-web/"); // Temporary Root for New RISE Site
 define("LIBRARY_DIR", ROOT_DIR . "library/");

/**
 * Library Definitions
 */
 define("MODEL_DIR", LIBRARY_DIR . "model/");
 define("VIEW_DIR", LIBRARY_DIR . "view/");
 define("CONTROLLER_DIR", LIBRARY_DIR . "controller/");

/**
 * Template Engine Definitions
 */
 define("TEMPLATE_DIR", LIBRARY_DIR . "template/");
 define("TEMPLATE", TEMPLATE_DIR . "template.htm");
 define("TEMPLATE_COMPONENTS_DIR", TEMPLATE_DIR . "components/");

 define("META", TEMPLATE_COMPONENTS_DIR . "meta.php");
 define("LINK", TEMPLATE_COMPONENTS_DIR . "link.php");
 define("SCRIPT", TEMPLATE_COMPONENTS_DIR . "script.php");
 define("HEADER", TEMPLATE_COMPONENTS_DIR . "header.php");
 define("FOOTER", TEMPLATE_COMPONENTS_DIR . "footer.php");
 define("SIDEBAR", TEMPLATE_COMPONENTS_DIR . "sidebar.php");

/**
 * URL Definitions
 */
 define("ROOT_URL", "/");
 define("IMAGE_URL",  ROOT_URL."image/");
 define("DOCUMENT_URL",  ROOT_URL."document/");
 define("SCRIPT_URL",  ROOT_URL."script/");
 define("STYLE_DIR",  ROOT_URL."style/");

 /**
  * Contact Definitions
  */
 define ("WEBMASTER_EMAIL", "jjm1@iastate.edu");
 define ("ELPS_EMAIL", "edldrshp@iastate.edu");
 define ("RISE_EMAIL", "rise@iastate.edu");
 define ("CCLP_EMAIL", "laanan@iastate.edu");

/**
 * MySQL Server Definitons
 */
define ("MYSQL_SERVER", "db01.hs.iastate.edu");

//define ("ELPS_DATABASE", "elps");
//define ("ELPS_PASSWORD", "pod7frowm5");
//$ELPS_CONNECTION = mysql_pconnect(MYSQL_SERVER2, ELPS_DATABASE, ELPS_PASSWORD) or trigger_error(mysql_error(), E_USER_ERROR);

define ("RISE_DATABASE", "hs_rise");
define ("RISE_PASSWORD", "risEvMicyewyob1");
/////////////////////////////////////////////






/*$RISE_CONNECTION = mysql_pconnect(MYSQL_SERVER, RISE_DATABASE, RISE_PASSWORD) or trigger_error(mysql_error(), E_USER_ERROR);*/

//define ("CCLP_DATABASE", "cclp");
//define ("CCLP_PASSWORD", "Spip7Knesp");
//$CCLP_CONNECTION = mysql_pconnect(MYSQL_SERVER2, CCLP_DATABASE, CCLP_PASSWORD) or trigger_error(mysql_error(), E_USER_ERROR);

/*
 * Connect to database
 */
/*function dbconn($db){

	$dbh = NULL;

	if ($db == "hs_rise") {
		$dbhost = "db01.hs.iastate.edu";
		$dbname = "hs_rise";
		$dbuser = "hs_rise";
		$dbpass = "risEvMicyewyob1";
	} else {
		return NULL;
	}

	try {
		$dbh = new PDO("mysql:host={$dbhost};dbname={$dbname}",$dbuser,$dbpass);
		$dbh->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
	} catch (PDOException $e) {
		errorPage("Error connecting to the database.",$e->getMessage());
	}
	return $dbh;
}
*/

/*
 * Gets row(s) of data and return result(s).
 *
 * $sql: The SQL query
 * $param: Array of parameters for the placeholder "?". Must match the number of placeholders in $sql
 * $dbh: Database handler
 * $dim: Dimension of the result; 1 = one result; all others = many
 */
/*function getdata2($dbh,$sql,$param,$dim){

	$limit = "";
	if($dim == 1){
		$limit_str = "LIMIT 1";
	}
	$sql = $sql ." $limit_str";

	try {
		$sth = $dbh->prepare($sql);
		$sth->execute($param);
	} catch (PDOException $e){
		errorPage("Error in getting data",$e->getMessage());
	}
	if($dim == 1){
		$results = $sth->fetch(PDO::FETCH_ASSOC);
	} else {
		$results = $sth->fetchAll(PDO::FETCH_ASSOC);
	}

	return $results;
}*/
?>
