<?php  

require_once 'connection.php';

$sql = 'SELECT * FROM users';

$statement = $pdo->prepare($sql);

$statement->execute();

$result = $statement->fetchAll();

/*echo "<br><pre>";
	var_dump($result);
echo "<pre>";*/


$sql_status = 'SELECT users.*, status.name FROM users INNER JOIN status ON status.id = users.status_id';
$statement_status = $pdo->prepare($sql_status);
$statement_status->execute();
$results_status = $statement_status->fetchAll();
//var_dump($results_status);
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>Consultas PHP SQL</title>
	<link rel="stylesheet" href="">
</head>
<body>
	<h2>Seleccionar Datos</h2>
	<hr>
	<h3>Usuarios</h3>
	<table>
		<thead>
			<tr>
				<th>ID</th>
				<th>EMAIL</th>
				<th>STATUS</th>
			</tr>
		</thead>
		<tbody>
		<?php foreach($result as $user): ?>
			<tr>
				<td><?php echo $user['id']; ?></td>
				<td><?php echo $user['email']; ?></td>
				<td><?php echo $user['status_id']; ?></td>
			</tr>
		<?php endforeach; ?>
		</tbody>
	</table>

	<h3>Usuarios y Estados</h3>
	<table>
		<thead>
			<tr>
				<th>ID</th>
				<th>EMAIL</th>
				<th>STATUS</th>
			</tr>
		</thead>
		<tbody>
		<?php foreach($results_status as $user): ?>
			<tr>
				<td><?php echo $user['id']; ?></td>
				<td><?php echo $user['email']; ?></td>
				<td><?php echo $user['name']; ?></td>
			</tr>
		<?php endforeach; ?>
		</tbody>
	</table>
</body>
</html>