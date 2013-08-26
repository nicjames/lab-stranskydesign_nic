<?php

// now defined at the top of each test so we grab the classes from the appropriate app
// define("CLASS_FILEROOT", "c:/wamp/www/lab.com/gumballmachine");

//http://www.php.net/manual/de/function.spl-autoload-register.php
// php 4/5 method
spl_autoload_extensions(".php"); // comma-separated list
spl_autoload_register();
function my_autoload ($pClassName) {
	$pClassName = str_replace('\\','/',$pClassName);
	// stransky Aug 12 2010. now using absolute namespacing.
	//include(FILEROOT . "/classes/" . $pClassName . ".php");
	include(CLASS_FILEROOT . "/" . $pClassName . ".php");
}
spl_autoload_register("my_autoload");

// php 5 method, doesnt seem to work when executing phpunit tests
/*
function __autoload($className) {
	$className = str_replace('\\','/',$className);
	include(CLASS_FILEROOT . "/" . $className . ".php");
}
 * 
 */
function debug($o) {
	echo "<pre>"; print_r($o); echo "</pre>";
}

$output_media_type = 'browser';
function out($t) { 
	global $output_media_type;
	if($output_media_type == "browser") {
		echo "<div style='border:1px solid black'>$t</div>"; 
	} elseif ($output_media_type == "shell") {
		echo "* $t\n";
	}
	
}

/////////////////////////////////////////////////////////////////////////////////////////////
// PDO - http://net.tutsplus.com/tutorials/php/php-database-access-are-you-doing-it-correctly/
/////////////////////////////////////////////////////////////////////////////////////////////

function idb_connect() {
	global $output_media_type;
	if($output_media_type == 'browser') {
		$server_name = $_SERVER['SERVER_NAME'];

		switch ($server_name){
			//local dev
			case 'lab.stranskydesign.com.localhost':
						$server = 'localhost';
						$username = 'root';
						$password = '';
						$database = 'cartoonaday';
			break;

				//LIVE SERVER
			default:

						$server = 'localhost';
						$username = 'xxx';
						$password = 'xxx';
						$database = 'xxx';
			break;

		}
	} else {
		// if shell, we're in a local dev environment running unit tests
		$server = 'localhost';
		$username = 'root';
		$password = '';
		$database = 'cartoonaday';

	}
	// MySQL connection
	define("db_host", $server);
	define("db_user", $username);
	define("db_pass", $password);
	define("db_name", $database);	
	global $_DB;
	try {
		$_DB = new PDO('mysql:host='.db_host.';dbname='.db_name,db_user,db_pass);
		$_DB->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	} catch(PDOException $e) {
		echo "ERROR: " . $e->getMessage();
	}
}

function idb_sel($query,$params_array){
        if(!$query)return false;
        global $_DB;
        $results = NULL;
        $stmt = idb_query($query,$params_array);
        while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
                $results[] = $row;
        }
        return $results;
}
function idb_exe($query,$params_array){
        if(!$query)return false;
        global $_DB;
        idb_query($query,$params_array);
        return $_DB->lastInsertId();
}
function idb_exe_aff($query){
        if(!$query)return false;
        global $_DB;
        idb_query($query);
        return mysql_affected_rows();
}	
function idb_query($query,$params_array) {//Function to query the database.
        global $_DB;
		try {
			$stmt = $_DB->prepare($query);
			// OR $stmt->bindParam(':id', $id, PDO::PARAM_INT); but we no likey - would be important if we were doing something more dynamic.
			$stmt->execute($params_array);
			return $stmt;
		} catch(PDOException $e) {
			idb_error($query,$e);
		}
}
function idb_error($query, $e) {
        die('<hr/><h1>Error in query</h1><font color="#000000">'. $e->getFile() .'<br/>Line:'. $e->getLine() .'<br/><b>' . $e->getCode() . ' - ' . $e->getMessage() . '<br><br>' . $query . '<br><br><small><font color="#ff0000">[STOP]</font></small><br><br></b></font>');
}

/////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////
function db_connect() {
	global $output_media_type;
	if($output_media_type == 'browser') {
		$server_name = $_SERVER['SERVER_NAME'];

		switch ($server_name){
			//local dev
			case 'lab.stranskydesign.com.localhost':
						$server = 'localhost';
						$username = 'root';
						$password = '';
						$database = 'cartoonaday';
			break;

				//LIVE SERVER
			default:

						$server = 'localhost';
						$username = 'xxx';
						$password = 'xxx';
						$database = 'xxx';
			break;

		}
	} else {
		// if shell, we're in a local dev environment running unit tests
		$server = 'localhost';
		$username = 'root';
		$password = '';
		$database = 'cartoonaday';

	}
	// MySQL connection
	define("db_host", $server);
	define("db_user", $username);
	define("db_pass", $password);
	define("db_name", $database);	
	global $_DB;
	$_DB = mysql_connect(db_host,db_user,db_pass) or die("Unable to connect to database");
	@mysql_select_db(db_name) or die("Unable to select database " . db_name);
}


// sql query and exe functions		

function db_sel($query){
        if(!$query)return false;

        global $_DB;
        $result = NULL;

        $r      = db_query($query, $_DB);
        while($row = mysql_fetch_assoc($r)){
                $result[] = $row;
        }
        mysql_free_result($r);
        return $result;
}
function db_exe($query){
        if(!$query)return false;
        global $_DB;
        db_query($query);
        return mysql_insert_id();
}
function db_exe_aff($query){
        if(!$query)return false;
        global $_DB;
        db_query($query);
        return mysql_affected_rows();
}	
function db_query($query) {//Function to query the database.
        global $_DB;
        $result = mysql_query($query, $_DB) or db_error($query, mysql_errno($_DB), mysql_error($_DB));
        return $result;
}
function db_error($query, $errno, $error) {
        die('<font color="#000000"><b>' . $errno . ' - ' . $error . '<br><br>' . $query . '<br><br><small><font color="#ff0000">[STOP]</font></small><br><br></b></font>');
}
/////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////

$cwd = getcwd();

//define("CLASS_FILEROOT", "c:/wamp/www/lab.stranskydesign.com.localhost/master/paypalipn");
define("CLASS_FILEROOT", "$cwd/paypalipn");
//define("OUTPUT_MEDIA_TYPE", "browser");
?>
