<?php
	ini_set('display_errors', 'on');
	session_start();
	include_once("../models/class.obra.php");
	$obj = new obra();
	if (isset($_POST['id_obra'])){
		echo $obj->delete($_POST['id_obra']);
	}
	else{
		echo "-2";
	}
?>
