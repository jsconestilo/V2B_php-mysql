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

$sql = 'SELECT * FROM news WHERE 1 ORDER BY id DESC';
$statement = $pdo->prepare($sql);
$statement->execute();
$news = $statement->fetchAll();

?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>Delete</title>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css" integrity="sha384-HSMxcRTRxnN+Bdg0JdbxYKrThecOKuH5zCYotlSAcp1+c8xmyTe9GYg1l9a69psu" crossorigin="anonymous">
	<link rel="stylesheet" href="">

</head>
<body>
	<div class="container">
		
		<h1 class="alert alert-danger">Delete</h1>
		<hr>
		<table class="table table-striped table-hover">
			<thead>
				<tr>
					<th>ID</th>
					<th>TITLE</th>
					<th>CONTENT</th>
					<th>DETAILS</th>
				</tr>
			</thead>
			<tbody>
			<?php foreach($news as $noticia): ?>
				<tr>
					<td><?php echo $noticia['id']; ?></td>
					<td><?php echo $noticia['title']; ?></td>
					<td><?php echo $noticia['content']; ?></td>
					<td>
						<form method="get">
							<button type="button" class="btn btn-danger" data-ident="<?php echo $noticia['id']; ?>">Eliminar</button>
						</form>
					</td>
				</tr>
			<?php endforeach; ?>
			</tbody>
		</table>
	</div>
	<script>
		let btn_delete = document.getElementsByClassName('btn-danger');
		//console.
		for(let btn of btn_delete) {
			btn.addEventListener('click', function() {
			
				let id = btn.dataset.ident;
				let confirmation = confirm('¿Esta seguro de querer eliminar el registro con ID = ' + id);
				if(confirmation) {
					window.location = 'delete_action.php?id=' + id;
				}
			});
		}
	</script>
</body>
</html>