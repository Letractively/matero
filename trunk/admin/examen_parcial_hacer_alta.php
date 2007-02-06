<?php
/************************************************************************
*                 Nombre Sistema:   Matero.
*                  Nombre Script:   final_hacer_alta.php
*                          Autor:   A.U.S. Sánchez, Guido S. 
*                 Fecha Creacion:   27-02-04.
*            Ultima Modificacion:   27-02-04.
*           Campos que lee en BD:   examen_parcial
*      Campos que Modifica en BD:   ninguna
*  Descripcion de funcionamiento:   realiza un alta de exámen parcial
*              Funciones que usa:
*                Que falta Hacer:
*       Validaciones que realiza:
************************************************************************/
include("seguridad_intranet.php");
include("../includes/fecha.php");


	$vl_error=0;
	//Valido los datos
	
	if (!is_alphanumeric($vf_nombre,2,200) || ($vf_nombre=="")){
		$vl_mensaje_error.="ERROR: Se ha ingresado un nombre de exámen incorrecto<br>";
	    $vl_error=1;
   	}
	
	// tengo que validar que seleccione una comisión
	if (!sizeof($vf_list_id_comision)){
   		$vl_mensaje_error.="ERROR: Debes seleccionar una comisión de la lista<br>";
   		$vl_error=1;
	}
	
	switch(is_date_ok($vf_dia,$vf_mes,$vf_anio)){
		case '1':  $vl_mensaje_error.="ERROR: Se ha ingresado un año incorrecto <br>";
				   $vl_error=1;
				   break;
		case '2':  $vl_mensaje_error.="ERROR: Se ha ingresado un mes incorrecto <br>";
				   $vl_error=1;
				   break;
		case '3':  $vl_mensaje_error.="ERROR: Se ha ingresado un día incorrecto <br>";
				   $vl_error=1;
				   break;
		case '5':  $vl_mensaje_error.="ERROR: Se ha ingresado un día incorrecto <br>";
				   $vl_error=1;
				   break;		   		   		   
		case '4': break;		   
	}
	
	if(($vf_hora=="" or $vf_minutos=="")or (!is_numeric($vf_minutos)) or (!is_numeric($vf_hora))){
       $vl_mensaje_error.="ERROR: Debes ingresar una hora correcta para el exámen<br>";
	   $vl_error=1;
   	}	
	else{
		$vl_hora=(int)$vf_hora;
		$vl_minutos=(int)$vf_minutos;
		if($vl_hora>24 or $vl_hora<=0){
    	   $vl_mensaje_error.="ERROR: Se ha ingresado una hora incorrecta <br>";
		   $vl_error=1;
   		}	
		if($vl_minutos>59 or $vl_minutos<0){
    	  $vl_mensaje_error.="ERROR: Se ha ingresado minutos incorrectos <br>";
		  $vl_error=1;
   		}
	}	
	if ($vl_error == 1) {
		
		set_file("pagina","examen_parcial_alta.html");
		var_dump($vf_list_id_comision);
		$vl_consulta=mysql_query("SELECT * FROM comision WHERE id_catedra=$vs_id_catedra and activa='1'");		
		$vl_num_comisiones=mysql_num_rows($vl_consulta);		
		if ($vl_num_comisiones > 1){
			while($vl_fila_comision=mysql_fetch_array($vl_consulta)){
				set_var("nombre_comision","$vl_fila_comision[nombre]");
				set_var("id_comision","$vl_fila_comision[id_comision]");
				if (isset($vf_list_id_comision))
                    foreach( $vf_list_id_comision as $key => $value ) {
                          if ($value==$vl_fila_comision[id_comision]) set_var("selected$vl_fila_comision[id_comision]","selected");
						  //else set_var("selected_comision","");
                	}
				parse("datos_comisiones","datos_comisiones",true);
			}
		}
		else{
			$vl_fila_comision=mysql_fetch_array($vl_consulta);
			set_var("selected_comision","selected");
			set_var("nombre_comision","$vl_fila_comision[nombre]");
			set_var("id_comision","$vl_fila_comision[id_comision]");
			parse("datos_comisiones","datos_comisiones",true);
		}
		set_var("mensaje","$vl_mensaje_error");
		set_var("nombre_examen","$vf_nombre");
		if (!isset($vf_check_publicar)) set_var("checked_examen","");		
		else set_var("checked_examen","checked");
		set_var("descrip_examen",$vf_descrip);
		set_var("comentario_notas",$vf_comentario_notas);
		$vl_mes=$vf_mes;
		set_var("anio",$vf_anio);
		set_var("selected_mes$vl_mes","selected");
		set_var("dia",$vf_dia);
		set_var("hora",$vl_hora);
		set_var("min",$vl_minutos);
		set_var("firma",firma());
		parse("datos_examen_parcial","datos_examen_parcial",true);
		pparse("pagina");
		die();
	}

	$vl_fecha = "$vf_anio-$vf_mes-$vf_dia";
	$vl_hora = "$vf_hora:$vf_minutos";
	if (!isset($vf_check_publicar)) $vf_check_publicar='0';

	mysql_query("INSERT INTO examen_parcial (id_examen_parcial,
										   nombre,
										   descrip,
										   fecha,
										   hora,
   										   comentario_notas,
										   publicar) 
						VALUES (
										   'NULL',							   
										   '$vf_nombre',
										   '$vf_descrip',
										   '$vl_fecha',
										   '$vl_hora',
										   '$vf_comentario_notas',
										   '$vf_check_publicar')
						");

	$vl_id_examen_parcial=mysql_insert_id();
	
	foreach($vf_list_id_comision as $key => $value ) {
    	mysql_query("INSERT INTO examen_parcial_comision VALUES ('$vl_id_examen_parcial','$value')");
	}	
	
	$vl_mensaje = "El exámen parcial ha sido ingresado con éxito";
	header("Location:examen_parcial_alta.php?PHPSESSID=$PHPSESSID&mensaje=$vl_mensaje");
	die();
?>