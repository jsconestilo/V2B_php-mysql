<?php  

require_once 'connection.php';

//Se estructura la consulta para localizar a los usuarios que se encuentran actualmetne activos en el sistema
$sql = 'SELECT * FROM users WHERE status_id = 1';
//Preparar la consulta (en este caso pudo haber sido con query para ahorrarnons un paso. NO hay intervención de datos por parte del usuario que se tengan que escapar)
$statement = $pdo->prepare($sql);
$statement->execute();
//Almacenamos un arreglo indexado o asociativo con los resultados de la consulta
//En caso de no haber registros nos retorna un array vacio.
$results = $statement->fetchAll();

?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>WHERE SQL PHP</title>
	<link rel="stylesheet" href="">
</head>
<body>
	<h3>Usuarios Activos</h3>
	<hr>
	<table>
		<thead>
			<tr>
				<th>Email</th>
				<th>Activo</th>
			</tr>
		</thead>
		<tbody>
		<?php foreach($results as $user): ?>
			<tr>
				<td><?php echo $user['email'] ?></td>
				<!--Generamos una url dinámica, pasando el valor de la variable id a la cadena de consulta (querystring)
					No es necesario el punto y coma. No hay mas lineas de código en este pequeño script-->
				<td><a href="where_detalles.php?id=<?php echo $user['id'] ?>" title="">Detalles</a></td>
			</tr>
		<?php endforeach; ?>
		</tbody>
	</table>
</body>
</html>