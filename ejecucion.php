<?php  

require_once 'connection.php';

//Se estructura la consulta SQL
$sql = 'SELECT * FROM users';
//Query, ejecuta una instrucción SQL sin escapar datos. Se recomienda utilizarla en consultas donde no intervengan datos provenientes del usuario.
$data = $pdo->query($sql);

//Recorremos los datos devueltos por la consulta. Por defecto nos retorna un arreglo indexado y asociativo (nombre de las columnas)
echo "<br><pre>";
foreach ($data as $row) {
	var_dump($row);
	//Comprobar la forma en que nos devuelve la información
	echo $row['email'] . ' - ' . $row[1] . '<br>';
}
echo "</pre>";
?>
