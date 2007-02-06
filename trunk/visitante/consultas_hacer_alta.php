<?php

include("seguridad_intranet.php");
//include("../includes/fecha.php");


$vl_error=0;
	//Valido los datos
	
/*	if (!is_alphanumeric($vf_nombre,2,200) || ($vf_nombre=="")){
		$vl_mensaje_error.="ERROR: Se ha ingresado un nombre de exámen incorrecto<br>";
	    $vl_error=1;
   	}*/
	
	// tengo que validar que seleccione una comisión
if (!isset($vf_tema)){
	$vl_mensaje_error.="ERROR: Debes seleccionar un tema de la lista<br>";
	$vl_error=1;
}
	
	
if ($vf_consulta=="") 
	{$vl_mensaje_error.="No ha escrito una Consulta<br>";
	$vl_error=1;
	}
	

if ($vl_error == 1) {
		
		
		header("Location:index.php?id_catedra=$id_catedra&ver=consultas_altas.php&vf_tema=$vf_tema&mensaje=$vl_mensaje_error");die;}
		
		
		/*set_file("pagina","consultas_alta.html");
		//var_dump($vf_list_id_comision);
		//Selecciono todas los temas de la catedra
		$cons=mysql_query("select * from consultas_tema where id_catedra='$id_catedra'");
		
		
		//Muestro los temas
		while($tema=mysql_fetch_array($cons)){
				set_var('valoropcion',$tema['id_tema']);
				set_var('nombreopcion',$tema['nombre']);
				if($id_tema==$tema['id_tema']){
					set_var('selected','selected');
					}else{
					set_var('selected','');
					}
				parse("bloquetema","bloquetema",true);
				}

		set_var("mensaje","$vl_mensaje_error");
		
		set_var('idc',$id_catedra);
		set_var("firma",firma_web());
		set_var("consulta", "");
		parse("datos","datos");
		pparse("pagina");
		die();*/
	

mysql_query("Insert into consultas(
							id_consulta,
							id_catedra,
							id_tema,
							fecha_consulta,
							hora_consulta,
							fecha_respuesta,
							posicion,
							texto,
							respuesta,
							publicar,
							respondido,
							leido,
							nombre_alumno,
							id_alumno,
							registrado_alumno,
							email_alumno)
							
				values(
							'NULL',
							'$id_catedra',
							'$vf_tema',
							 now(),
							 now(),
							'NULL',
							'0',
							'$vf_consulta',
							'',
							'vl_publicar',
							'0',
							'0',
							'jose',
							'1',
							'1',
							'hola@dd.com')");
							
							
	$vl_id_consulta=mysql_insert_id();
	
    $vl_mensaje = "El exámen parcial ha sido ingresado con éxito";
	header("Location:index.php?id_catedra=48&ver=consultas.php");
	die();
?>