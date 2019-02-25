<?php  

require_once 'connection.php';

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

//PAGINADOR
//
//Determino cuantos registros me retornó la consulta
$total_registros = count($results);
$registros_por_pagina = 3;
//ceil() redondea hacia arriba. 10 registros / 3 por pagina.... debería mostrarme 4 páginas (1 registro en la ultima)
$total_paginas = ceil($total_registros / $registros_por_pagina);
//Determino en que página me encuentro aculmente (al inicio no habra page, por tanto me posiciono en 0. 
//Recordar que LIMIT no incluye en punto de inicio. Por tanto, si el enlace de paginación dice 1, programaticamente lo debo colocar en 0, si dice 2 lo coloco en 1, etc.
$pagina_actual = isset($_GET['page']) ? $_GET['page'] - 1 : 0;
$pagina_actual = isset($_GET['page']) ? $_GET['page'] - 1 : $_GET['page'] = 0; //para el control de error en clase active
//Determino cual va a ser mi punto de partida (primer paramero de LIMIT)
$posicion_inicio = $pagina_actual * $registros_por_pagina;

$sql .= " LIMIT {$posicion_inicio},{$registros_por_pagina}";
$statement = $pdo->prepare($sql);
$statement->execute($array_params);
$results = $statement->fetchAll();

echo !isset($_GET['page']);
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>Buscador</title>
	<style type="text/css" media="screen">
		.active {
			color: red;
		}
	</style>
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
	<?php for($i=1; $i<=$total_paginas; $i++): ?>
		<a href="paging.php?page=<?php echo $i; ?>" class="<?php echo ($i == $_GET['page']) ? 'active' : ''; ?>"><?php echo $i; ?></a>
	<?php endfor; ?>
</body>
</html>