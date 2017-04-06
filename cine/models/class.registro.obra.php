<?php
ini_set('display_errors', 'off');
include_once("resources/class.database.php");

class registro_empleado{
	var $fecha;
  	var $id_empleado;

function registro_empleado(){
}

function insert(){
	$sql = "INSERT INTO administrador.tbl_registro_empleado( fecha, id_empleado) VALUES ( '$this->fecha', '$this->id_empleado')";
	try {
		pg::query("begin");
		$row = pg::query($sql);
		pg::query("commit");
		echo "1";
	}
	catch (DependencyException $e) {
		echo "Error: " . $e;
		pg::query("rollback");
		echo "-1";
	}
}

function getLista(){

	$sql="SELECT * FROM administrador.tbl_registro_empleado";
	try {
		echo "<SELECT id='id_r'>";
		$result = pg::query($sql);
		while ($row= pg_fetch_array($result)){
			echo "<OPTION value='".$row['id']."'> ".$row['nombre'].",".$row['salario']." </OPTION>";
		}
		echo "</SELECT>";
	}
	catch (DependencyException $e) {
		pg::query("rollback");
	}
}

function getAutocomplete(){
	$res="";
	$sql="SELECT * FROM administrador.tbl_registro_empleado";
	try {
		$result = pg::query($sql);
		while ($row= pg_fetch_array($result)){
			$res .= '"' . $row['id'] . ', ' . $row['nombre'] . ', ' . $row['salario'] . '"';
			$res .= ',';
		}
		$res = substr ($res, 0, -2);
		$res = substr ($res, 1);
	}
	catch (DependencyException $e) {
	}
	return $res;
}
}
?>
