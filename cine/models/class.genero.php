<?php
ini_set('display_errors', 'off');
include_once("resources/class.database.php");

class genero{
	var $id_genero;
	var $nombre_genero;
  	var $descripcion_genero;
	var $id_obra;

function genero(){
}

function select($id_genero){
	$sql =  "SELECT * FROM pelicula.tbl_genero WHERE id_genero = '$id_genero'";
	try {
		$row = pg::query($sql);
		$row=pg_fetch_array($row);
		$this->id_genero = $row['id_genero'];
		$this->nombre_genero = $row['nombre_genero'];
		$this->descripcion_genero = $row['descripcion_genero'];
		$this->id_obra = $row['id_obra'];
		return true;
	}
	catch (DependencyException $e) {
	}
}

function delete($id_genero){
	$sql = "DELETE FROM pelicula.tbl_genero WHERE id_genero = '$id_genero'";
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
	if ($this->validaP($this->id_genero) == false){
		$sql = "INSERT INTO pelicula.tbl_genero( id_genero, nombre_genero, descripcion_genero, id_obra) VALUES ( '$this->id_genero', '$this->nombre_genero', '$this->descripcion_genero', '$this->id_obra')";
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
		$sql="UPDATE pelicula.tbl_genero set descripcion_genero='" . $this->descripcion_genero . "', nombre_genero='" . $this->nombre_genero . "',id_obra='" . $this->id_obra . "' WHERE id_genero='" . $this->id_genero . "'";
		pg::query("begin");
		$row = pg::query($sql);
		pg::query("commit");		
		echo "2";
	}
}

function validaP ($id_genero){
      $sql =  "SELECT * FROM pelicula.tbl_genero WHERE id_genero = '$id_genero'";
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
	
	$sql="SELECT * FROM pelicula.tbl_genero";
	try {
		echo "<div class='container' style='margin-top: 10px'>";
		echo "<table cellpadding='0' cellspacing='0' border='0' class='table table-striped table-bordered' id='example'>";
		echo "<thead>";
		echo "<tr>";
		echo "	<th>Codigo</th>";
		echo "	<th>Nombre</th>";
		echo "	<th>Descripcion</th>";
		echo "	<th>Obra</th>";
		echo "	<th>.</th>";
		echo "</tr>";
		echo "</thead>";
		echo "<tbody>";
		$result = pg::query($sql);
		while ($row= pg_fetch_array($result)){
			echo "<tr class='gradeA'>";
			echo "	<th>" . $row['id_genero'] . "</th>";
			echo "	<th>" . $row['nombre_genero'] . "</th>";
			echo "	<th>" . $row['descripcion_genero'] . "</th>";
			echo "	<th>" . $row['id_obra'] . "</th>";
			echo "	<th><a href='#' class='btn btn-danger' onclick='elimina(\"" . $row['id_genero'] . "\")'>X<i class='icon-white icon-trash'></i></a>.<a href='#' class='btn btn-primary' onclick='edit(\"" . $row['id_genero'] . "\", \"" . $row['nombre_genero'] . "\", \"" . $row['descripcion_genero'] . "\", \"" . $row['id_obra'] . "\")'>E<i class='icon-white icon-refresh'></i></a></th>";
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
	
	$sql="select * from pelicula.tbl_genero where descripcion_genero like 'A%'";
	try {
		echo "<div class='container' style='margin-top: 10px'>";
		echo "<table cellpadding='0' cellspacing='0' border='0' class='table table-striped table-bordered' id='example'>";
		echo "<thead>";
		echo "<tr>";
		echo "	<th>Codigo</th>";
		echo "	<th>Nombre</th>";
		echo "	<th>Descripcion</th>";
		echo "	<th>Obra</th>";
		echo "</tr>";
		echo "</thead>";
		echo "<tbody>";
		$result = pg::query($sql);
		while ($row= pg_fetch_array($result)){
			echo "<tr class='gradeA'>";
			echo "	<th>" . $row['id_genero'] . "</th>";
			echo "	<th>" . $row['nombre_genero'] . "</th>";
			echo "	<th>" . $row['descripcion_genero'] . "</th>";
			echo "	<th>" . $row['id_obra'] . "</th>";
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
	
	$sql="select * from pelicula.tbl_genero";	
	$tabla="";
	try {
		$tabla="<table>";
		$tabla=$tabla . "<tr>";
		$tabla=$tabla . "	<td>Codigo</td>";
		$tabla=$tabla . "	<td>Nombre</td>";
		$tabla=$tabla . "	<td>Descripcion</td>";
		$tabla=$tabla . "	<td>Obra</td>";

		$tabla=$tabla . "</tr>";

		$result = pg::query($sql);
		while ($row= pg_fetch_array($result)){
			$tabla=$tabla . "<tr>";
			$tabla=$tabla . "	<td>" . $row['id_genero'] . "</td>";
			$tabla=$tabla . "	<td>" . $row['nombre_genero'] . "</td>";
			$tabla=$tabla . "	<td>" . $row['descripcion_genero'] . "</td>";
			$tabla=$tabla . "	<td>" . $row['id_obra'] . "</td>";
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
	
	$sql="SELECT * FROM pelicula.tbl_genero";
	try {
		echo "<SELECT id_genero='id_genero'>";
		$result = pg::query($sql);
		while ($row= pg_fetch_array($result)){
			echo "<OPTION value='".$row['id_genero']."'> ".$row['nombre_genero']." ".$row['descripcion_genero']." ".$row['id_obra']."</OPTION>";
		}
		echo "</SELECT>";
	}
	catch (DependencyException $e) {
		pg::query("rollback");
	}
}

function getAutocomplete(){
	$res="";
	$sql="SELECT * FROM pelicula.tbl_genero";
	try {
		$result = pg::query($sql);
		while ($row= pg_fetch_array($result)){
			$res .= '"' . $row['id_genero'] . ', ' . $row['nombre_genero'] . ', ' . $row['descripcion_genero'] . ', ' . $row['id_obra'] . '"';
			$res .= ',';
		}
		$res = substr ($res, 0, -2);
		$res = substr ($res, 1);
	}
	catch (DependencyException $e) {
	}
	return $res;
}

function lista_obras(){
	$sql="SELECT * FROM pelicula.tbl_obra";
	
	$result = pg::query($sql); 
            if (!$result) { 
                echo "Problema con la consulta " . $query . "<br/>"; 
                echo pg_last_error(); 
                exit(); 
            } 
           $lista_obras = null;

            while($myrow = pg_fetch_assoc($result)) { 
                $lista_obras .= "<option value=\"".$myrow['id_obra']."\">".$myrow['nombre_obra']."</option>"; 
            }	
            echo $lista_obras;			
}
}
?>
