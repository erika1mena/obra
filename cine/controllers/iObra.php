<?php
	ini_set('display_errors', 'on');
	session_start();
	include_once("../models/class.obra.php");
	$obj = new obra();
	if (isset($_POST['id_obra']) && isset($_POST['nombre_obra'])&& isset($_POST['descripcion_obra'])){
		$obj->id_obra=$_POST['id_obra'];
		$obj->nombre_obra=$_POST['nombre_obra'];
		$obj->descripcion_obra=$_POST['descripcion_obra'];
		echo $obj->insert();
	}
	else{
		echo "-1";
	}
?>
