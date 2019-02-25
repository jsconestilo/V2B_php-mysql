<?php  

$dsn = 'mysql:host=localhost;dbname=php_sql_course';
$user = 'root';
$password = '';

try {
	$pdo = new PDO($dsn, $user, $password);
	$pdo->exec('set names utf8');
} catch(PDOException $e) {
	echo 'Error en la conexión: ' . $e->getMessage();
}

/**
 * La importancia de preparar (escapar de inyecciones SQL) nuestras consultas (?) (:marcado)
 *
 * delete.php?id=5 OR 1;   esta consulta se cumple para todos (no solo el 5, ya que el 1 lo toma como verdadero)
 *
 * delete.php?id=7;UPDATE users SET password='brinca' (Elimina el id 7, pero actualiza ademas todos los registros de la tabla users en password = brinca)
 *
 * prepare() de PDO hace esto por nosotros ESCAPA NUESTAS CONSULTAS DE NYECCIONES SQL TRADICIONALES. Es por ello que en sql no se coloca el valor de la variable que pasa el usuario (? en lugar de $_GET['id'])
 */


if(isset($_GET['id'])) {
	$id = $_GET['id'];
	
	$sql = "UPDATE news SET status = 0 WHERE id = ?";
	$statement = $pdo->prepare($sql);
	$statement->execute([$id]);

	header('Location: delete_logical.php');
}

?>