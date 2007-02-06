<?PHP

include('seguridad_intranet.php');

set_file('pagina','atom.html');

$sql_cache = "SELECT * FROM cache_feed 
			  WHERE id_catedra = $_GET[id_catedra] 
			  		AND tipo = '$_GET[tipo]'";	
  		  		
$rs_cache = mysql_query($sql_cache);

$cache = mysql_fetch_array($rs_cache);

/*El feed esta desactualizado o no cacheado*/
if(!$cache || $cache[actualizado] == 1){
	$fecha = "fecha";
	if($_GET[tipo] == "nov")
	{
		$tipo_feed = "Novedades";
		$tabla = "novedades";
		$id_item = "id_novedades";
		$titulo = "titulo";
		$contenido = "contenido";
		$sql_publicar = "";
		
	}else if($_GET[tipo] == "ap")
	{
		$tipo_feed = "Apuntes";
		$tabla = "apuntes";
		$id_item = "id_apuntes";
		$titulo = "titulo";
		$contenido = "descripcion";
		$sql_publicar = "AND publicar = 1";
		
	}else if($_GET[tipo] == "rep")
	{
		$tipo_feed = "Repositorio";
		$tabla = "repositorio";
		$id_item = "id_repositorio";
		$titulo = "titulo";
		$contenido = "descripcion";
		$sql_publicar = "AND publicar = 1";
	}
	
	$sql_catedra = "SELECT * FROM catedra WHERE id_catedra = $_GET[id_catedra]";
	$rs_catedra = mysql_query($sql_catedra);
	$catedra = mysql_fetch_array($rs_catedra);
	//set_var('titulo',htmlentities($tipo_feed."  ".$catedra[nombre]));
	set_var('titulo',$tipo_feed." - ".$catedra[nombre]);
	set_var('tipo',$_GET[tipo]);
	set_var('id_catedra',$_GET[id_catedra]);
	
	$sql = "SELECT * FROM $tabla n, catedra c 
			WHERE n.id_catedra = c.id_catedra 
			AND	 c.id_catedra = $_GET[id_catedra]
			$sql_publicar
			ORDER BY fecha desc";
		
	$rs = mysql_query($sql);
	
	
	while($fila = mysql_fetch_array($rs))
	{   
		//set_var('nombre_catedra',htmlentities($fila[nombre]));
		//set_var('id_catedra',htmlentities($fila[id_catedra]));
		
		set_var('nombre_catedra',$fila[nombre]);
		set_var('id_catedra',$fila[id_catedra]);
		
		//set_var('titulo_entry',htmlentities($tipo_feed." - ".$fila[$titulo]));
		set_var('titulo_entry',$tipo_feed." - ".$fila[$titulo]);
		//set_var('id',htmlentities($fila[$id_item]));
		set_var('id',$fila[$id_item]);
		set_var('fecha',$fila[fecha]);
		//set_var('contenido',htmlentities($fila[$contenido]));
		set_var('contenido',$fila[$contenido]);
			
		parse('entry','entry',true);
	}
	
	if(!mysql_num_rows($rs)){
		set_var('entry',"");
	}
	
	$contenido = parse("main","main",true);
	
	/*No existe el registro del feed*/
	if(!$cache)
	{
		$sql_cache_insert = "INSERT INTO cache_feed 
							(id_catedra,tipo,contenido,actualizado)
							VALUES ('$_GET[id_catedra]','$_GET[tipo]','$contenido',0)"  ;
		mysql_query($sql_cache_insert);
	}
	else
	{
	 	$sql_cache_update = "UPDATE cache_feed 
							SET contenido = '$contenido', actualizado = 0 WHERE id = $cache[id]"; 
		mysql_query($sql_cache_update); 
	}
			
	header('Content-type: application/xml');
	
	pparse('pagina');
}/*El feed esta cacheado*/
else
{
  header('Content-type: application/xml');
  echo $cache[contenido];
}

?>