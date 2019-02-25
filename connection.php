<?php  

//Nombre de Origen de los Datos (DataSourceName)
$dsn = 'mysql:dbname=php_sql_course;host=127.0.0.1';
$user = 'root';
$password = '';

try {
	$pdo = new PDO($dsn, $user, $password, [PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"]);
	//$pdo->exec("set names utf8");

	echo 'Conexión exitosa';
} catch(PDOException $e) {
	echo 'Error al conectar con la base de datos: ' . $e->getMessage();
}


?>