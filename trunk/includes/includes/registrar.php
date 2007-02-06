<?PHP
///////////////////////////////////////////////
//         funciones de seguridad            //
///////////////////////////////////////////////

function registrar($vp_id_objeto,$vp_descripcion,$vp_operacion,$vp_nombre_modulo,$vp_nombre_tabla){
	//función que deja registro de la acción del usuario en la tabla log de la bd.
	//Autor: Guido; Fecha: 02/04/03
	global $PHPSESSID;
	global $REMOTE_ADDR;
	global $vs_usuario_logueado;

	$vl_nick_usuario="$vs_usuario_logueado[nick]($vs_usuario_logueado[id_usuario])";

	$vl_consulta_log="INSERT INTO log (id_usuario,
									nick_usuario,
				  	 				sesionid,
									id_objeto,
									ip_origen,
									time_stamp,
						    		descripcion,
						    		operacion,
						    		nombre_modulo,
						    		tabla) 
							VALUES( '$vs_usuario_logueado[id_usuario]',
									'$vl_nick_usuario',
									'$PHPSESSID',
									'$vp_id_objeto',
									'$REMOTE_ADDR',
									 now(),
									'$vp_descripcion',
									'$vp_operacion',
									'$vp_nombre_modulo',
									'$vp_nombre_tabla')"; 
	mysql_query($vl_consulta_log);
	}
?>