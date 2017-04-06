<?php
	ini_set('display_errors', 'on');
	session_start();
	include_once("../models/class.genero.php");
	$obj = new genero();
	if (isset($_POST['id_genero']) && isset($_POST['nombre_genero']) && isset($_POST['descripcion_genero']) && isset($_POST['id_obra'])){
		$obj->id_genero=$_POST['id_genero'];
		$obj->nombre_genero=$_POST['nombre_genero'];
		$obj->descripcion_genero=$_POST['descripcion_genero'];
		$obj->id_obra=$_POST['id_obra'];
		echo $obj->insert();
	}
	else{
		echo "-1";
	}
?>
