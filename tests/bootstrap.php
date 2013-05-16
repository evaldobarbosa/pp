<?php
ini_set("display_errors", "on");
//ini_set("error_reporting",E_ALL ^ E_NOTICE ^ E_WARNING);
ini_set("error_reporting",E_ALL);

require_once __DIR__ . '/../vendor/autoload.php';

$conn = new PDO(
  'mysql:host=localhost;dbname=mydb',
	"dbuser",
	"dbuser123",
	array( PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8' )
);
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
