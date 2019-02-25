<?php  

$dsn = 'mysql:host=localhost;dbname=php_sql_course';
$user = 'root';
$password = '';

try {
	$pdo = new PDO($dsn, $user, $password);
	$pdo->exec('set names utf8');
} catch(PDOException $e) {
	echo "Error en la conexión con la base de datos: {$e->getMessage()}";
}


/**
 * Instrucciones PDO para Actualizar el Registro Seleccionado
 */

if($_POST) {
	if(isset($_POST['title']) && isset($_POST['content'])) {
		if(!empty(trim($_POST['title'])) && !empty(trim($_POST['content']))) {
			$sql_update 		= 'UPDATE news SET title = ?, content = ? WHERE id = ?';
			$statement_update 	= $pdo->prepare($sql_update);
			
			$id 		= $_POST['id'];
			$title 		= $_POST['title'];
			$content 	= $_POST['content'];

			$statement_update->execute([$title, $content, $id]);
		}
	}
}



/**
 * Instrucciones PDO para Mostrar los Detalles de la Noticia Seleccionada
 */

if(isset($_GET['id'])) {
	$sql_details 		= 'SELECT * FROM news WHERE id = ?';
	$statement_details	= $pdo->prepare($sql_details);
	
	$id_details 		= isset($_GET['id']) ? $_GET['id'] : 0;
	
	$statement_details->execute([$id_details]);
	$news_details 		= $statement_details->fetch();
}




/**
 * Instrucciones PDO para Seleccionar y Listar todas las Noticias
 */

$sql_list 		= 'SELECT * FROM news WHERE 1 ORDER BY id DESC';
$statement_list = $pdo->prepare($sql_list);
$statement_list->execute();
$news_list 		= $statement_list->fetchAll();   



?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>Update</title>
	<link rel="stylesheet" href="">
</head>
<body>
	<h1>UPDATE</h1>
	<hr>
	
	<!--Solo mostrar el formulario si existe una noticia seleccionada para ver sus detalles-->
	<?php if(isset($_GET['id'])): ?>
	<form method="POST" accept-charset="utf-8">
		<input type="hidden" name="id" value="<?php echo $news_details['id']; ?>">
		<div>
			<label for="">Title</label>
			<input type="text" name="title" placeholder="Titulo de la noticia" value="<?php echo $news_details['title']; ?>">
		</div>
		<div>
			<label for="">Content</label>
			<textarea name="content" placeholder="Contenido de la noticia"><?php echo $news_details['content']; ?></textarea>
		</div>
		<input type="submit" value="Actualizar">
	</form>
	<hr>
	<?php endif;?>
	
	<table>
		<thead>
			<tr>
				<th>ID</th>
				<th>TITLE</th>
				<th>CONTENT</th>
				<th>DETAILS</th>
			</tr>
		</thead>
		<tbody>
		<?php foreach($news_list as $noticia): ?>
			<tr>
				<td><?php echo $noticia['id']; ?></td>
				<td><?php echo $noticia['title']; ?></td>
				<td><?php echo $noticia['content']; ?></td>
				<td><a href="update.php?id=<?php echo $noticia['id']; ?>" title="">Ver Detalles</a></td>
			</tr>
		<?php endforeach; ?>
		</tbody>
	</table>
</body>
</html>