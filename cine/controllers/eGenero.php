<?php
	ini_set('display_errors', 'on');
	session_start();
	include_once("../models/class.genero.php");
	$obj = new genero();
	if (isset($_POST['id_genero'])){
		echo $obj->delete($_POST['id_genero']);
	}
	else{
		echo "-2";
	}
?>
