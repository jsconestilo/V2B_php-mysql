<?php  

$dsn = 'mysql:dbname=php_sql_course;host=localhost';
$user = 'root';
$password = '';

try {
	$pdo = new PDO($dsn, $user, $password);
	$pdo->exec('set names utf8');
} catch(PDOException $e) {
	echo 'Error en la conexión con la base de datos: ' . $e->getMessage();
}

$sql = 'SELECT * FROM news WHERE status <> 0 ORDER BY id DESC';
$statement = $pdo->prepare($sql);
$statement->execute();
$news = $statement->fetchAll();

?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>Delete Logical</title>
	<link rel="stylesheet" href="">
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css" integrity="sha384-HSMxcRTRxnN+Bdg0JdbxYKrThecOKuH5zCYotlSAcp1+c8xmyTe9GYg1l9a69psu" crossorigin="anonymous">
</head>
<body>
	<div class="bg-success">PHP con MySQL</div>
	<div class="container">
		<h1 class="text-center text-primary">Delete Logical</h1>
		<hr>
		<h2 class="bg-warning">News</h2>
		<table class="table table-hover table-striped">
			<thead>
				<tr>
					<th>ID</th>
					<th>TITLE</th>
					<th>CONTENT</th>
					<th>ACTION</th>
				</tr>
			</thead>
			<tbody>
			<?php foreach($news as $noticia): ?>
				<tr>
					<td><?php echo $noticia['id']; ?></td>
					<td><?php echo $noticia['title']; ?></td>
					<td><?php echo $noticia['content']; ?></td>

					<!--Esto es un error clásico, Las arañas Web golpean los enlaces e intencionalmente pueden eliminar registros. Un enfoque correcto es con el ejercicio anterior de borrado físico (form button)-->
					<td><a href="#" onclick="delete_logical(<?php echo $noticia['id']; ?>)" class="btn btn-danger">Eliminar</a></td>
				</tr>
			<?php endforeach; ?>
			</tbody>
		</table>
	</div>
	<script>
		function delete_logical(id_article) {
			let confirmation = confirm('¿Está seguro de querer eliminar el artículo con ID ' + id_article + '?');
			if(confirmation) {
				window.location = 'delete_logical_action.php?id=' + id_article;
			}
		}
	</script>
</body>
</html>