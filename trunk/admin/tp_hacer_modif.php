<?php
/************************************************************************
*                 Nombre Sistema:   Matero.
*                  Nombre Script:   tp_hacer_modif.php
*                          Autor:   Angeletti, Mariano 
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

$size_max_archivo_cont=3048576; //la utilizamos para validar el tamaño del archivo de contenido(1MB en bytes)

	$vl_error=0;
	//Valido los datos
	
	if (!is_alphanumeric($vf_nombre,2,200) || ($vf_nombre=="")){
		$vl_mensaje_error.="ERROR: Se ha ingresado un nombre de tp incorrecto<br>";
	    $vl_error=1;
   	}
	
	// tengo que validar que seleccione una comisión
	if (!sizeof($vf_list_id_comision)){
   		$vl_mensaje_error.="ERROR: Debes seleccionar una comisión de la lista<br>";
   		$vl_error=1;
	}
	
	// si el usuario eligió adjuntar archivo se fija que este no tenga tamaño 0
if(($vf_archivo_name!="")&&($vf_archivo_size>$size_max_archivo_cont)){
     $vl_mensaje_error = "Error: el archivo contenido debe ser menor a ".$size_max_archivo_cont." bytes";
     $vl_error = 1;

     }

// si el usuario eligió adjuntar archivo se fija que este no tenga tamaño 0
if( ($vf_archivo_name!="") && ($vf_archivo_size==0)){
      $vl_mensaje_error = "El archivo $vf_archivo_name adjuntado tiene tamaño 0";
      $vl_error = 1;

      }

// si el usuario eligió adjuntar archivo se fija que este se haya subido correctmente

if (($vf_archivo_name!="")&&(!is_uploaded_file($vf_archivo))){
   $vl_mensaje_error=nl2br("Error al subir el archivo, intente nuevamente en unos instantes");
   $vl_error=1;
  }
	
if (!isset($vf_sin_fecha)) {	
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
       $vl_mensaje_error.="ERROR: Debes ingresar una hora correcta para la entrega del TP<br>";
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
	
}	
if ($vl_error == 1) {
	
	set_file("pagina","tp_modif.html");
	$vl_consulta=mysql_query("SELECT * FROM comision WHERE id_catedra=$vs_id_catedra and activa='1'");		
	$vl_num_comisiones=mysql_num_rows($vl_consulta);		
	if ($vl_num_comisiones > 1){
		while($vl_fila_comision=mysql_fetch_array($vl_consulta)){
			set_var("nombre_comision","$vl_fila_comision[nombre]");
			if (isset($vf_list_id_comision))
				foreach( $vf_list_id_comision as $key => $value ) {
					  if ($value==$vl_fila_comision[id_comision]) set_var("selected$vl_fila_comision[id_comision]","selected");
					  else set_var("selected_comision","");
				}
			set_var("id_comision","$vl_fila_comision[id_comision]");
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
	set_var("nombre",$vf_nombre);
	if (!isset($vf_check_publicar)) set_var("checked_examen","");		
	else set_var("checked_examen","checked");
	set_var("descrip_tp",$vf_descrip);
	set_var("comentario_notas",$vf_comentario_notas);
	$vl_mes=$vf_mes;
	set_var("anio",$vf_anio);
	set_var("selected_mes$vl_mes","selected");
	set_var("dia",$vf_dia);
	set_var("hora",$vf_hora);
	set_var("min",$vf_minutos);
	if ($vf_check_publicar==1) set_var("checked_tp","checked");
	else set_var("checked_tp","");
	if (!isset($vf_sin_fecha)) set_var("checked_sin_fecha","");		
	else set_var("checked_sin_fecha","checked");		
/*	if ($vf_archivo_viejo!="")set_var("archivo",$vf_archivo_viejo.'&nbsp;
							<input name="vf_eliminar" type="checkbox" id="vf_eliminar" value="1">&nbsp; Si desea eliminar el archivo, habilite el check box');
*/  if ($vf_archivo_viejo!=""){
			set_var("archivo",$vf_archivo_viejo);
			set_var("comenta",'&nbsp;<input name="vf_eliminar" type="checkbox" id="vf_eliminar" value="1">&nbsp; Si desea eliminar el archivo, habilite el check box');						
	}else{
		 	set_var("archivo","");
	  		set_var("comenta","");
	}
	set_var("id_comision_actual",$vf_id_comision);
	set_var("PHPSESSID",$PHPSESSID);
	set_var("firma",firma());
	parse("datos_tp","datos_tp",true);
	pparse("pagina");
	die();
}

if ($vf_archivo_name!=""){
                $vl_archivo_nombre=str_replace(" ","_",$vf_archivo_name);
        }
else { $vl_archivo_nombre="";}



if ($vf_archivo_viejo!="" && $vf_eliminar=="1"){
	unlink("../archivos/$vs_id_catedra/$vc_directorio_tps/$vf_id_tp/$vf_archivo_viejo");
	$vl_update=",archivo=''";
}

if($vf_archivo_name!=""){
  $vl_archivo_nombre=str_replace(" ","_",$vf_archivo_name);           
  move_uploaded_file($vf_archivo,"../archivos/$vs_id_catedra/$vc_directorio_tps/$vf_id_tp/$vl_archivo_nombre");
  //Valido que el archivo este realmente en el directorio adecuado
  if(!is_file("../archivos/$vs_id_catedra/$vc_directorio_tps/$vf_id_tp/$vl_archivo_nombre")){
	$vl_mensaje.="Advertencia: Se ha cargado el TP pero no se ha subido el ARCHIVO<br>";
	//mysql_query("UPDATE trabajo_practico SET archivo='' WHERE id_tp='$vf_id_tp'");		
	$vl_update="";
  }else{
  	$vl_update=",archivo='$vl_archivo_nombre'";
  }
  if (($vf_archivo_viejo!="")&&($vf_eliminar!="1"))
	unlink("../archivos/$vs_id_catedra/$vc_directorio_tps/$vf_id_tp/$vf_archivo_viejo");
}



////////////////////////////////
if (!isset($vf_sin_fecha)){
	$vl_fecha = "$vf_anio-$vf_mes-$vf_dia";
	$vl_hora = "$vf_hora:$vf_minutos";
}	
	if (!isset($vf_check_publicar)) $vf_check_publicar='0';
	else $vf_check_publicar='1';


//die();

	mysql_query("UPDATE trabajo_practico SET
										   nombre='$vf_nombre',
										   descrip='$vf_descrip',
										   fecha_entrega='$vl_fecha',
										   hora='$vl_hora',
   										   comentario_notas='$vf_comentario_notas',
										   publicar='$vf_check_publicar'
										   $vl_update
				WHERE id_tp = '$vf_id_tp'
				");
	
	mysql_query("DELETE FROM tp_comision WHERE id_tp = '$vf_id_tp' ");	
	foreach($vf_list_id_comision as $key => $value ) {
    	mysql_query("INSERT INTO tp_comision VALUES ('$value','$vf_id_tp')");
	}
	
//////////////////////////////
	$vl_mensaje.= "<br><b>El TP ha sido modificado con éxito</b>";
	header("Location:tp_modif.php?PHPSESSID=$PHPSESSID&mensaje2=$vl_mensaje&vf_id_tp=$vf_id_tp&vf_id_comision=$vf_id_comision");
	die();
?>