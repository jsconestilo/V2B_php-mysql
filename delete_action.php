<?php  

$dsn = 'mysql:host=localhost;dbname=php_sql_course';
$user = 'root';
$password = '';

try {
	$pdo = new PDO($dsn, $user, $password);
	$pdo->exec('set names utf8');
} catch(PDOException $e) {
	echo 'Error en la conexión con la base de datos: ' . $e->getMessage(); 
}

if(isset($_GET['id'])) {
	$sql = 'DELETE FROM news WHERE id = ?';
	$statement = $pdo->prepare($sql);

	$id = $_GET['id'];

	$statement->execute([$id]);

	header('Location: delete.php');	

}


?>