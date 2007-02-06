<?PHP

include('seguridad_intranet.php');

set_file('pagina','atomg.html');

$sql_cache = "SELECT * FROM cache_feed 
			  WHERE id_catedra = $_GET[id_catedra] 
			  		AND tipo = 'global'";
  		  		
$rs_cache = mysql_query($sql_cache);

$cache = mysql_fetch_array($rs_cache);

/*El feed esta desactualizado o no cacheado*/
if(!$cache || $cache[actualizado] == 1){
	/*SE SETEE LA INFORMACION DE LA CATEDRA*/
	$sql_catedra = "SELECT * FROM catedra WHERE id_catedra = $_GET[id_catedra]";
	$rs_catedra = mysql_query($sql_catedra);
	$catedra = mysql_fetch_array($rs_catedra);
	//set_var('titulo',htmlentities($tipo_feed."  ".$catedra[nombre]));
	set_var('titulo',$catedra[nombre]);

	set_var('tipo',"QQQ");
	set_var('id_catedra',$_GET[id_catedra]);


	/*SE OBTIENE TODA LA INFORMACION PARA EL FEED GLOBAL DE LA CATEDRA*/
	$sql_repositorio = "SELECT * FROM repositorio n, catedra c 
			WHERE n.id_catedra = c.id_catedra 
			AND	 c.id_catedra = $_GET[id_catedra]
			AND publicar = 1
			ORDER BY fecha desc";
	$rs_repositorio = mysql_query($sql_repositorio);
	
	$sql_apuntes = "SELECT * FROM apuntes n, catedra c 
			WHERE n.id_catedra = c.id_catedra 
			AND	 c.id_catedra = $_GET[id_catedra]
			AND publicar = 1
			ORDER BY fecha desc";
	$rs_apuntes = mysql_query($sql_apuntes);

	$sql_novedades = "SELECT * FROM novedades n, catedra c 
			WHERE n.id_catedra = c.id_catedra 
			AND	 c.id_catedra = $_GET[id_catedra]
			ORDER BY fecha desc";
	$rs_novedades = mysql_query($sql_novedades);
	

	$apunte_entry = mysql_fetch_array($rs_apuntes);
	$repositorio_entry = mysql_fetch_array($rs_repositorio);
	$novedades_entry = mysql_fetch_array($rs_novedades);
	
	while(true)
	{   
		if($apunte_entry[fecha] == 0 && $repositorio_entry[fecha] == 0
			&& $novedades_entry[fecha] == 0)	  
			break;
	  
	  	if($apunte_entry[fecha] > $repositorio_entry[fecha])
	  		if($apunte_entry[fecha] > $novedades_entry[fecha])
	  		{
	  			$fila = $apunte_entry;
	  			
	  			$tipo_feed = "Apuntes";
				$id_item = "id_apuntes";
				$titulo = "titulo";
				$contenido = "descripcion";
				$ver = "2";
	  			
	  			if(!$apunte_entry = mysql_fetch_array($rs_apuntes))
	  				$apunte_entry = array("fecha" => 0);
	  		}
			else
			{
				$fila = $novedades_entry; 
				
				$tipo_feed = "Novedades";
				$id_item = "id_novedades";
				$titulo = "titulo";
				$contenido = "contenido";
				$ver = "1";
				
				if(!$novedades_entry = mysql_fetch_array($rs_novedades))
					$novedades_entry = array("fecha" => 0);
			}
		else
			if($repositorio_entry[fecha] > $novedades_entry[fecha])
			{
				$fila = $repositorio_entry;
				
				$tipo_feed = "Repositorio";
				$id_item = "id_repositorio";
				$titulo = "titulo";
				$contenido = "descripcion";
				$ver = "10";
				
				if(!$repositorio_entry = mysql_fetch_array($rs_repositorio))
					$repositorio_entry = array("fecha" => 0);
			}
			else
			{
				$fila = $novedades_entry;
				
				$tipo_feed = "Novedades";
				$id_item = "id_novedades";
				$titulo = "titulo";
				$contenido = "contenido";
				$ver = "1";
				
				if(!$novedades_entry = mysql_fetch_array($rs_novedades))
					$novedades_entry = array("fecha" => 0);
			}
	  
	  	
	  
		//set_var('nombre_catedra',htmlentities($catedra[nombre]));
		//set_var('id_catedra',htmlentities($_GET[id_catedra]));
		set_var('nombre_catedra',$catedra[nombre]);
		set_var('id_catedra',$_GET[id_catedra]);

		
		
		//set_var('titulo_entry',htmlentities($tipo_feed." - ".$fila[$titulo]));
		set_var('titulo_entry',$tipo_feed." - ".$fila[$titulo]);

		
		//set_var('id',htmlentities($fila[$id_item]));
		set_var('id',$fila[$id_item]);

		set_var('fecha',$fila[fecha]);
		//set_var('contenido',htmlentities($fila[$contenido]));
		set_var('contenido',$fila[$contenido]);

		set_var("ver",$ver);
			
		parse('entry','entry',true);
	}
	
	/*NINGUN FEED*/
	if(!mysql_num_rows($rs_novedades) && !mysql_num_rows($rs_apuntes) 
		&& !mysql_num_rows($rs_repositorio)){
		set_var('entry',"");
	}

	
	$contenido = parse("main","main",true);
	
	/*No existe el registro del feed*/
	if(!$cache)
	{
		$sql_cache_insert = "INSERT INTO cache_feed 
							(id_catedra,tipo,contenido,actualizado)
							VALUES ('$_GET[id_catedra]','global','$contenido',0)"  ;
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