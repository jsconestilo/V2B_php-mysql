<?php  

$dsn = 'mysql:host=localhost;dbname=php_sql_course';
$user = 'root';
$password = '';

try {
	$pdo = new PDO($dsn, $user, $password);
} catch(PDOException $e) {
	echo 'Error en la conexión con la base de datos ' . $e->getMessage();
}

/**
 * COUNT(*) retorna un solo registro con el número de registros contenidos en dicha tabla
 * 			es importante darle un alias, de lo contrario hay que inspeccionar el arreglo devuelto
 * 			y ver que indice retorna
 */
$sql = 'SELECT COUNT(*) AS total_users FROM users';
$statement = $pdo->prepare($sql);
$statement->execute();
$user = $statement->fetch();


$sql = 'SELECT COUNT(*) AS total_news FROM news';
$statement = $pdo->prepare($sql);
$statement->execute();
$news = $statement->fetch();


$sql = 'SELECT COUNT(*) AS total_status FROM status';
$statement = $pdo->prepare($sql);
$statement->execute();
$status = $statement->fetch();


$sql = 'SELECT COUNT(*) AS total_logs FROM users_log';
$statement = $pdo->prepare($sql);
$statement->execute();
$logs = $statement->fetch();

/**
 * Esta es una consulta condicionada, solo queremos que cuente cuantos registros hay con el estatis activo
 */
$sql = 'SELECT COUNT(*) AS total_active_users FROM users WHERE status_id = 1';
$statement = $pdo->prepare($sql);
$statement->execute();
$active_users = $statement->fetch();


$sql = 'SELECT COUNT(*) AS total_inactive_users FROM users WHERE status_id = 2';
$statement = $pdo->prepare($sql);
$statement->execute();
$inactive_users = $statement->fetch();


$sql = 'SELECT COUNT(*) AS total_types FROM users_type';
$statement = $pdo->prepare($sql);
$statement->execute();
$types = $statement->fetch();

?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>Contar número de registros en tablas</title>
	<link rel="stylesheet" href="">
</head>
<body>
	<h3>Contar Número de Registros en Tablas</h3>
	<hr>
	<table>
		<thead>
			<tr>
				<th>USERS</th>
				<th>NEWS</th>
				<th>STATUS</th>
				<th>LOGS</th>
				<th>ACTIVE USERS</th>
				<th>INACTIVE USERS</th>
				<th>TYPES</th>
			</tr>
		</thead>
		<tbody>
			<tr>
				<!--Recordar que fetch() retorna los resultados en un array heterogeneo, es decir de forma indexada y asociativa-->
				<td><?php echo $user[0] ?></td>
				<td><?php echo $news['total_news'] ?></td>
				<td><?php echo $status['total_status'] ?></td>
				<td><?php echo $logs['total_logs'] ?></td>
				<td><?php echo $active_users['total_active_users'] ?></td>
				<td><?php echo $inactive_users['total_inactive_users'] ?></td>
				<td><?php echo $types['total_types'] ?></td>
			</tr>
		</tbody>
	</table>
</body>
</html>