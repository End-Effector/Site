<?php
	/*Databases! Connection to database.*/
	
	ini_set('display_errors',1);
	error_reporting(-1);
	
	$conn_error = 'Could not connect server';
	$conn_error2 = 'Could not connect to database';
	
	$mysql_host = 'fdb15.biz.nf';
	$mysql_user = '2173810_ga';
	$mysql_pass = '766rafWUD!';
	
	/*Connect to the server/database.*/
	@$mysqlcon = mysqli_connect($mysql_host,$mysql_user,$mysql_pass) or die($conn_error);
	
	/*Select Database*/
	$mysql_db = '2173810_ga';
	mysqli_select_db($mysqlcon,$mysql_db) or die($conn_error2);
	
	//echo 'Connected';
	//phpinfo();
?>