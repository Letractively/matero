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
		set_file("pagina","examen_parcial_modificar.html");
		
		$vl_consulta=mysql_query("SELECT * FROM comision WHERE id_catedra=$vs_id_catedra and activa='1'");
		
		$vl_num_comisiones=mysql_num_rows($vl_consulta);
		if ($vl_num_comisiones > 1){
			// muestro las comisiones 
			while($vl_fila_comision=mysql_fetch_array($vl_consulta)){
				set_var("nombre_comision","$vl_fila_comision[nombre]");
				if ($vf_id_comision==$vl_fila_comision[id_comision]) set_var("selected_comision","selected");
				else set_var("selected_comision","");
				set_var("id_comision","$vl_fila_comision[id_comision]");
				parse("datos_comisiones","datos_comisiones",true);
			}
		}
		elseif ($vl_num_comisiones == '1') {
			$vl_fila_comision=mysql_fetch_array($vl_consulta);
			set_var("selected_comision","selected");
			set_var("nombre_comision","$vl_fila_comision[nombre]");
			set_var("id_comision","$vl_fila_comision[id_comision]");
			parse("datos_comisiones","datos_comisiones",true);
		}
		else{
			$vl_mensaje="No existen comisiones activas!!!!!";
			header("Location:menu.php?PHPSESSID=$PHPSESSID&mensaje=$vl_mensaje");
			die();
		}
		
		////////////////////
		//Verifico a cuantas comisiones pertenece el examen
		$vl_comision_ep = mysql_query("SELECT *
										FROM examen_parcial_comision
										WHERE id_examen_parcial = $vf_id_examen_parcial ");
		$vl_cantidad_com=0;								
		while ($vl_fila = mysql_fetch_array($vl_comision_ep))								
			{	$vl_cantidad_com += 1;
				set_var("selected$vl_fila[id_comision]","selected");	
			}
		if ($vl_cantidad_com > 1) $mensaje="Este exámen parcial pertenece a más de una comisión, cualquier cambio que efectúe <br>
													afectará a las demás comisiones seleccionadas";
		////////////////////////////////////
		
		
		set_var("mensaje",$vl_mensaje_error);
		set_var("id_comision_actual",$vf_id_comision);
		set_var("id_examen_parcial",$vf_id_examen_parcial);
		set_var("nombre_examen",$vf_nombre);
		if ($vl_fila[publicar]==1) set_var("checked_examen","checked");
		else set_var("checked_examen","");
		set_var("descrip_examen",$vf_descrip);
		set_var("comentario_notas",$vf_comentario_notas);
		set_var("anio",$vf_anio);
		
    	set_var("selected_mes$vf_mes","selected");

		set_var("dia",$vf_dia);
		set_var("hora",$vf_hora);
		set_var("min",$vf_minutos);

		set_var("vf_id_tp",$vf_id_tp);						
		set_var("firma",firma());
		parse("datos_examen_parcial","datos_examen_parcial",true);
		pparse("pagina");
		die();
	}

	$vl_fecha = "$vf_anio-$vf_mes-$vf_dia";
	$vl_hora = "$vf_hora:$vf_minutos";
	if (!isset($vf_check_publicar)) $vf_check_publicar='0';

	mysql_query("UPDATE examen_parcial SET
				 nombre='$vf_nombre',
				 descrip='$vf_descrip',
				 fecha='$vl_fecha',
				 hora='$vl_hora',
				 comentario_notas='$vf_comentario_notas',
				 publicar='$vf_check_publicar'
				 WHERE id_examen_parcial='$vf_id_examen_parcial'");
	

	
	mysql_query("DELETE FROM examen_parcial_comision WHERE id_examen_parcial='$vf_id_examen_parcial'");
	
	foreach($vf_list_id_comision as $key => $value ) {
    	mysql_query("INSERT INTO examen_parcial_comision VALUES ('$vf_id_examen_parcial','$value')");
	}
	
	$vl_mensaje = "El exámen parcial ha sido modificado con éxito";
	header("Location:examen_parcial_administrar.php?PHPSESSID=$PHPSESSID&mensaje=$vl_mensaje");
	die();
?>