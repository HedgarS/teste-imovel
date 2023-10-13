<?php
date_default_timezone_set ('America/Sao_Paulo');
set_time_limit(0);

$root_dir		= $_SERVER['DOCUMENT_ROOT'].'/teste/';
$root_url		= 'http://'.$_SERVER['HTTP_HOST'].'/teste/';

define('COOKIELOCAL', str_replace('//', '/', realpath('./')).'/' );

## DIR
define('DIR_SITE',		$root_dir );
define('URL_SITE',		$root_url );
define('DIR_SYSTEM',	$root_dir . 'system/' );
define('DIR_DATABASE',	$root_dir . 'system/database/' );

$host = 'localhost';
$dbname = 'banco_teste';
$username = 'root';
$password = '';

try {
	$conn = new PDO("mysql:host=".$host.";dbname=".$dbname."", $username, $password);
	$cnx = $conn;
	
} catch (PDOException $pe) {
	die("Não foi possível se conectar ao banco de dados $dbname :" . $pe->getMessage());
}


?>