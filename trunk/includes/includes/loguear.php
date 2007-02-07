<?php
/***************************************************************************
*                 Nombre Sistema:   Litoral.
*                  Nombre Script:   loguear.php
*                          Autor:   Sánchez, Guido S.
*                 Fecha Creacion:   17:02 27/03/2003.
*            Ultima Modificacion:   10:02 02/07/2003.
*           Campos que lee en BD:   
*      Campos que Modifica en BD:   
*  Descripcion de funcionamiento:   realiza el logueo de los usuarios registrados al portal.
*              Funciones que usa:
*                Que falta Hacer:  
****************************************************************************/

function loguear_usuario($vp_usuario,$vp_pass){
global $vs_usuario_logueado;
	
	$vl_consulta="select *
    	       	  from  usuario_registrado
			      where nick= '$vp_usuario' AND
			      		validado = 1 AND
		   			    pass= '$vp_pass'";
					
	$vl_result = mysql_query($vl_consulta);
	   		 
	if(mysql_num_rows($vl_result)==0){
		//die("No existe el usuario");
		return 0;
	}
   
   
	//verifico que no este vencida el password 
	$vl_fila=mysql_fetch_array($vl_result);
	
	//$vs_usuario_logueado = mysql_fetch_array($vl_result);
	$vs_usuario_logueado =$vl_fila;
	$vs_usuario_logueado["pass"] = "";
	$vs_logueado = 1;
	ini_alter("session.use_cookies","0");
	session_start();
	session_register('vs_logueado');
	session_register('vs_usuario_logueado');
	
	// actualiza fecha del ultimo acceso
	$vl_update = "update usuario_registrado set
								 fecha_ultimo_logueo  = now()
						where id_usuario_registrado = $vs_usuario_logueado[id_usuario_registrado]";
/*	
	echo $vl_update;
	die();
	*/
	
	mysql_query($vl_update);
	//////////
	// incremento loguados en 1 cada vez que es se loguea un usuario
	$vl_fecha=date("Y-m-d");
	mysql_query("UPDATE contador_accesos SET 
							LOGUEADOS=(LOGUEADOS + 1)
							WHERE fecha='$vl_fecha'	");
	
	return 1;
}
?>