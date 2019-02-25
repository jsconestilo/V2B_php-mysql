<?php  

$dsn = 'mysql:host=localhost;dbname=php_sql_course';
$user = 'root';
$password = '';

try {
	$pdo = new PDO($dsn, $user, $password);
	$pdo->exec("set names utf8");
}catch(PDOException $e) {
	echo 'Error en la conexión con la base de datos ' . $e->getMessage();
}

$message = '';

if($_POST) {
	if(!empty(trim($_POST['title'])) && !empty(trim($_POST['content']))) {
		$sql_insert = 'INSERT INTO news (publish_date, title, content, status) VALUES (?, ?, ?, ?)';
		$statement_insert = $pdo->prepare($sql_insert);

		$published 	= date('Y-m-d');
		$title 		= $_POST['title'];
		$content 	= $_POST['content'];
		$status 	= 1;
		$params = [$published, $title, $content, $status];

		$statement_insert->execute($params);

		$message = 'Registro exitoso';
	}else{
		$message = "Problemas al registrar la noticia";
	}
}


$sql = 'SELECT * FROM news ORDER BY id DESC';

$statement = $pdo->prepare($sql);
$statement->execute();
$news = $statement->fetchAll();

?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>Insertar Noticias</title>
	<link rel="stylesheet" href="">
	<style type="text/css" media="screen">
		.mensaje {
			background: teal;
			color: white;
			padding: .5em;
			margin-bottom: 1em;
		}
	</style>
</head>
<body>
	<h1>INSERT</h1>
	<div class="mensaje">
		<?php echo $message; ?>
	</div>
	<form method="POST" accept-charset="utf-8">
		<div>
			<label for="">Title</label>
			<input type="text" name="title" placeholder="Ingrese titulo de la noticia">
		</div>
		<div>
			<label for="">Content</label>
			<textarea name="content" placeholder="Ingrese el contenido del la noticia"></textarea>
		</div>
		<input type="submit" value="Registrar">
	</form>
	<hr>
	<table>
		<thead>
			<tr>
				<th>ID</th>
				<th>Title</th>
				<th>Content</th>
			</tr>
		</thead>
		<tbody>
		<?php foreach($news as $noticia): ?>
			<tr>
				<td><?php echo $noticia['id']; ?></td>
				<td><?php echo $noticia['title']; ?></td>
				<td><?php echo $noticia['content']; ?></td>
			</tr>
		<?php endforeach; ?>
		</tbody>
	</table>
</body>
</html>