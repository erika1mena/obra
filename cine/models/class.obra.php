<?php
ini_set('display_errors', 'off');
include_once("resources/class.database.php");

class obra{
	var $id_obra;
  	var $nombre_obra;
	var $descripcion_obra;
	

function obra(){
}

function select($id_obra){
	$sql =  "SELECT * FROM pelicula.tbl_obra WHERE id_obra = '$id_obra'";
	try {
		$row = pg::query($sql);
		$row=pg_fetch_array($row);
		$this->id_obra = $row['id_obra'];
		$this->nombre_obra = $row['nombre_obra'];
		$this->descripcion_obra = $row['descripcion_obra'];
		return true;
	}
	catch (DependencyException $e) {
	}
}

function delete($id_obra){
	$sql = "DELETE FROM pelicula.tbl_obra WHERE id_obra = '$id_obra'";
	try {
		pg::query("begin");
		$row = pg::query($sql);
		pg::query("commit");
		return "1";
	}
	catch (DependencyException $e) {
		pg::query("rollback");
		return "-1";
	}
}

function insert(){
//echo "me llamo";
	if ($this->validaP($this->id_obra) == false){
		$sql = "INSERT INTO pelicula.tbl_obra( id_obra, nombre_obra, descripcion_obra) VALUES ( '$this->id_obra', '$this->nombre_obra', '$this->descripcion_obra')";
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
	else{
		$sql="UPDATE pelicula.tbl_obra set nombre_obra='" . $this->nombre_obra . "', descripcion_obra='" . $this->descripcion_obra . "' WHERE id_obra='" . $this->id_obra . "'";
		pg::query("begin");
		$row = pg::query($sql);
		pg::query("commit");		
		echo "2";
	}
}

function validaP ($id_obra){
      $sql =  "SELECT * FROM pelicula.tbl_obra WHERE id_obra = '$id_obra'";
      try {
		$row = pg::query($sql);
		if(pg_num_rows($row) == 0){
		        return false;
	        }
		else{
			return true;
		 }
		}
		catch (DependencyException $e) {
			//pg::query("rollback");
			return false;
		}
}

function getTabla(){
	
	$sql="SELECT * FROM pelicula.tbl_obra";
	try {
		echo "<div class='container' style='margin-top: 10px'>";
		echo "<table cellpadding='0' cellspacing='0' border='0' class='table table-striped table-bordered' id='example'>";
		echo "<thead>";
		echo "<tr>";
		echo "	<th>Codigo</th>";
		echo "	<th>Nombre</th>";
		echo "	<th>Descripcion</th>";
		echo "	<th>.</th>";
		echo "</tr>";
		echo "</thead>";
		echo "<tbody>";
		$result = pg::query($sql);
		while ($row= pg_fetch_array($result)){
			echo "<tr class='gradeA'>";
			echo "	<th>" . $row['id_obra'] . "</th>";
			echo "	<th>" . $row['nombre_obra'] . "</th>";
			echo "	<th>" . $row['descripcion_obra'] . "</th>";
			echo "	<th><a href='#' class='btn btn-danger' onclick='elimina(\"" . $row['id_obra'] . "\")'>X<i class='icon-white icon-trash'></i></a>.<a href='#' class='btn btn-primary' onclick='edit(\"" . $row['id_obra'] . "\", \"" . $row['nombre_obra'] . "\", \"" . $row['descripcion_obra'] . "\")'>E<i class='icon-white icon-refresh'></i></a></th>";
			echo "</tr>";
		}
		echo "</tbody>";
		echo "</table>";
		echo "</div>";
	}
	catch (DependencyException $e) {
		echo "Procedimiento sql invalido en el servidor";
	}
}

function getTablaInicianPorA(){
	
	$sql="select * from pelicula.tbl_obra where nombre like 'A%'";
	try {
		echo "<div class='container' style='margin-top: 10px'>";
		echo "<table cellpadding='0' cellspacing='0' border='0' class='table table-striped table-bordered' id='example'>";
		echo "<thead>";
		echo "<tr>";
		echo "	<th>Codigo</th>";
		echo "	<th>Nombre</th>";
		echo "	<th>Descripcion</th>";

		echo "</tr>";
		echo "</thead>";
		echo "<tbody>";
		$result = pg::query($sql);
		while ($row= pg_fetch_array($result)){
			echo "<tr class='gradeA'>";
			echo "	<th>" . $row['id_obra'] . "</th>";
			echo "	<th>" . $row['nombre_obra'] . "</th>";
			echo "	<th>" . $row['descripcion_obra'] . "</th>";
			echo "</tr>";
		}
		echo "</tbody>";
		echo "</table>";
		echo "</div>";
	}
	catch (DependencyException $e) {
		echo "Procedimiento sql invalido en el servidor";
	}
}

function getTablaPDF(){
	
	$sql="select * from pelicula.tbl_obra";	
	$tabla="";
	try {
		$tabla="<table>";
		$tabla=$tabla . "<tr>";
		$tabla=$tabla . "	<td>Codigo</td>";
		$tabla=$tabla . "	<td>Nombre</td>";
		$tabla=$tabla . "	<td>Descripcion</td>";

		$tabla=$tabla . "</tr>";

		$result = pg::query($sql);
		while ($row= pg_fetch_array($result)){
			$tabla=$tabla . "<tr>";
			$tabla=$tabla . "	<td>" . $row['id_obra'] . "</td>";
			$tabla=$tabla . "	<td>" . $row['nombre_obra'] . "</td>";
			$tabla=$tabla . "	<td>" . $row['descripcion_obra'] . "</td>";
			$tabla=$tabla . "</tr>";
		}
		$tabla=$tabla . "</table>";
	}
	catch (DependencyException $e) {
		echo "Procedimiento sql invalido en el servidor";
	}
	return $tabla;
}

function getLista(){
	
	$sql="SELECT * FROM pelicula.tbl_obra";
	try {
		echo "<SELECT id_obra='id_obra'>";
		$result = pg::query($sql);
		while ($row= pg_fetch_array($result)){
			echo "<OPTION value='".$row['id_obra']."'> ".$row['nombre_obra']." ".$row['descripcion_obra']." </OPTION>";
		
		}
		echo "</SELECT>";
	}
	catch (DependencyException $e) {
		pg::query("rollback");
	}
}

function getAutocomplete(){
	$res="";
	$sql="SELECT * FROM pelicula.tbl_obra";
	try {
		$result = pg::query($sql);
		while ($row= pg_fetch_array($result)){
			$res .= '"' . $row['id_obra'] . ', ' . $row['nombre_obra'] . ', ' . $row['descripcion_obra'] . '"';
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
