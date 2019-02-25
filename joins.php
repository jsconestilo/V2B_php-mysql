<?php  

$dsn = 'mysql:host=localhost;dbname=php_sql_course';
$user = 'root';
$password = '';

try {
	$pdo = new PDO($dsn, $user, $password);
}catch(PDOException $e) {
	echo 'Error en la conexión ' . $e->getMessage();
}

$sql = 'SELECT users.*, status.name as status, users_type.type 
		FROM users 
		INNER JOIN status ON status.id = users.status_id 
		INNER JOIN users_type ON users_type.id = users.user_type_id';

$statement = $pdo->prepare($sql);
$statement->execute();
$users = $statement->fetchAll();


//Al emplear LEFT JOINT le indico que me muestre todos los usuarios (toma esa tabla pivote) incluyendo aquellos que no hallan accedido al sistema (no se encuentran en la tabla de la derecha)

$sql = 'SELECT users.*, status.name as status, users_type.type, users_log.id AS idlog, users_log.user_id, users_log.date_logged_in
		FROM users
		INNER JOIN status ON status.id = users.status_id
		INNER JOIN users_type ON users_type.id = users.user_type_id
		LEFT JOIN users_log ON users_log.user_id = users.id';

$statement = $pdo->prepare($sql);
$statement->execute();
$usuarios = $statement->fetchAll();

echo $sql;
//echo "<pre>";
//var_dump($users);
//echo "</pre>";
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>Joins</title>
	<link rel="stylesheet" href="">
</head>
<body>
	<h3>Usuarios con tipo y status</h3>
	<hr>
	<table>
		<thead>
			<tr>
				<th>ID</th>
				<th>Email</th>
				<th>Status</th>
				<th>Type</th>
			</tr>
		</thead>
		<tbody>
		<?php foreach($users as $user): ?>
			<tr>
				<td><?php echo $user['id']; ?></td>
				<td><?php echo $user['email']; ?></td>
				<td><?php echo $user['status']; ?></td>
				<td><?php echo $user['type']; ?></td>
			</tr>
		<?php endforeach;  ?>
		</tbody>
	</table>
	<h3>Usuarios con Bitacora</h3>
	<hr>
	<table>
		<thead>
			<tr>
				<th>ID</th>
				<th>Email</th>
				<th>Password</th>
				<th>Status</th>
				<th>Type</th>
				<th>ID Log</th>
				<th>Date</th>
				<th>ID User</th>
			</tr>
		</thead>
		<tbody>
		<?php foreach($usuarios as $usuario): ?>
			<tr>
				<td><?php echo $usuario['id'] ?></td>
				<td><?php echo $usuario['email'] ?></td>
				<td><?php echo $usuario['password'] ?></td>
				<td><?php echo $usuario['status'] ?></td>
				<td><?php echo $usuario['type'] ?></td>
				<td><?php echo $usuario['idlog'] ?></td>
				<td><?php echo $usuario['date_logged_in'] ?></td>
				<td><?php echo $usuario['user_id'] ?></td>
			</tr>
		<?php endforeach; ?>
		</tbody>
	</table>
</body>
</html>