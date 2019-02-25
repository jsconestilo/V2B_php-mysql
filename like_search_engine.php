<?php  

require_once 'connection.php';
/**
 * Las lineas siguientes buscar noticias que contengan la palabra o palabras contenidas en la cadena de consulta search.
 * Sin embargo esta muy limitado, ya que si buscamos curso PHP tratará de localizar estas palabras seguidas una de otra y en ese orden.
 * 
 */

/*$sql = 'SELECT * FROM news WHERE title LIKE :search';
$statement = $pdo->prepare($sql);

$search_terms = isset($_GET['search']) ? $_GET['search'] : '';
$array_search['search'] = '%'. $search_terms .'%';

$statement->execute($array_search);

$results = $statement->fetchAll();*/




/**
 * Esta es otra forma de conseguir la busqueda con varias palabras que se pueden encontrar en orden o desorden dentro de un mismo titulo.
 */

//Esto me busca todo al igual que un SELECT * FROM news;... sin embargo como deseo condicionar, forzosamente necesito el WHERE
$sql = 'SELECT * FROM news WHERE 1';

if(isset($_GET['search'])) {
	//Retornamos un array con todos los terminos de busqueda desde la query string
	$terms_search = explode(' ', $_GET['search']);

	//Filtramos este nuevo array con la intensión de eliminar terminos como "de la los"
	//No es obligatorio pero resulta un reto
	$terms_search = array_filter($terms_search, function($term) {
		//solo considero los elementos (terminos de busqueda) que no contengan las siguientes palabras 
		return ($term != 'la' && $term != 'de' && $term != 'los');
	});

	//print_r($terms_search);
	//Estas dos variables me sirven para genererar marcadores de posicion dinámicos, así como almacenarlos y referenciar su valor en un array para pasarlos durante la ejecución de la consutla
	$contador = 1;
	$array_params = [];
	//Recorremos todos los terminos de busqueda
	foreach ($terms_search as $term) {
		//Concatenamos las condicionales en la busqueda SQL
		$sql .= " AND title LIKE :search{$contador}";
		//Guardamos en el array el marcador de posción con su respectivo valor. (el valor en caso del like debe llevar los %)
		$array_params[":search{$contador}"] = '%' . $term . '%';
		$contador++;
	}
}else{
	$array_params = [];
}
//Preparamos la consulta, ejecutamos con los valores, y obtennemos el resultado
$statement = $pdo->prepare($sql);
$statement->execute($array_params);
$results = $statement->fetchAll();

?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>Buscador</title>
	<link rel="stylesheet" href="">
</head>
<body>
	<h1>Buscador de Noticias</h1>

	<!--Actualmente no es necesario indicar que el action busque este mismo archivo con $_SERVER['PHP_SELF']
		otra forma de hacerlo es omitir por completo el atributo action...-->
	<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="get" accept-charset="utf-8">
		<label for="">Titulo de la Noticia</label>
		<input type="text" name="search" placeholder="Javascript PHP NodeJS" value="<?php echo isset($_GET['search']) ? $_GET['search'] : '' ?>">
		<input type="submit" value="Buscar">
	</form>

	<table>
		<thead>
			<tr>
				<th>TITLE</th>
				<th>CONTENT</th>
			</tr>
		</thead>
		<tbody>
		<?php foreach($results as $news): ?>
			<tr>
				<td><?php echo $news['title'] ?></td>
				<td><?php echo $news['content'] ?></td>
			</tr>
		<?php endforeach; ?>
		</tbody>
	</table>
</body>
</html>