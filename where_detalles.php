<?php  

require_once 'connection.php';

//Mostrar el usuario cuyo id conincida con la query_string pasada como parametro y que su estado sea activo
$sql = 'SELECT users.*, status.name FROM users INNER JOIN status ON status.id = users.status_id WHERE users.id = ? AND status_id = 0';
$statement = $pdo->prepare($sql);
//Antes de ejecutar, paso un arreglo con todos los datos para que sean referenciados con la consulta (?)
$statement->execute([$_GET['id']]);
//Se sabe de antemano que esta consulta retorna un solo registro o ninguno, por ello invoco el método fetch(), que retorna el siguiente registro en el set de resultados (para nuestro caso el primero y unico. o ninguno)
//En este caso el resultado lo manda como un array indexado y también asociativo
$result = $statement->fetch();

//Importante, si la consulta retorna cero registros, fetch() al no encontrar nada retorna un false (Por ello es que se utiliza en estructiras de tipo while. Es como un apuntador al siguiente registro, al haber retorna true y se itera, al no haber, retorna false y sale del ciclo)

?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>Detalles</title>
	<link rel="stylesheet" href="">
</head>
<body>
	<h3>Detalles del usuario</h3>
	<hr>
	<table>
		<thead>
			<tr>
				<th>ID</th>
				<th>EMAIL</th>
				<th>PASSWORD</th>
				<th>STATUS</th>
			</tr>
		</thead>
		<tbody>
			<tr>
				<td><?php echo $result['id'] ?></td>
				<td><?php echo $result['email'] ?></td>
				<td><?php echo $result['password'] ?></td>
				<td><?php echo $result['name'] ?></td>
			</tr>
		</tbody>
	</table>
</body>
</html>