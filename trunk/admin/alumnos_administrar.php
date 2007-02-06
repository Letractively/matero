<?php
/************************************************************************
*                 Nombre Sistema:   Matero.
*                  Nombre Script:   comision_administrar.php
*                          Autor:   A.U.S. Sánchez, Guido S. 
*                 Fecha Creacion:   03-02-04.
*            Ultima Modificacion:   03-02-04.
*           Campos que lee en BD:   
*      Campos que Modifica en BD:   ninguna
*  Descripcion de funcionamiento:   inicializa el listado de alumnos
*              Funciones que usa:
*                Que falta Hacer:
*       Validaciones que realiza:
************************************************************************/
include("seguridad_intranet.php");
include ("../includes/paginar.php");

$vl_bloque="<tr class=\"{estilo}\" height=\"25\"> 
                  <td><div align=\"center\">{lu}</div></td>
                  <td><div align=\"center\">{apellido}</div></td>
                  <td><div align=\"center\">{nombre}</div></td>
                  <td><div align=\"center\"> 
                      <input name=\"vf_email{lu}\" type=\"text\" value=\"{email}\" class=\"campo_texto\">
                    </div></td>
                  <td><div align=\"center\"> 
                      <input type=\"checkbox\" name=\"vf_eliminar{lu}\" value=\"1\" {checked_eliminar}>
                    </div></td>
                </tr>";

$vl_bloque1="<tr class=\"cat_tabla_cuerpo\" height=\"40\"> 
                  <td colspan=\"5\" valign=\"middle\">
				  <div align=\"center\">NO EXISTEN ALUMNOS EN LA COMISIÓN</div>
				  </td>
            </tr>";
								
set_file("pagina","alumnos_administrar.html");

$vl_consulta_comisiones=mysql_query("SELECT * FROM comision WHERE id_catedra=$vs_id_catedra and activa='1'
									 ORDER BY fecha_alta ASC");

$vl_num_rows=mysql_num_rows($vl_consulta_comisiones);

if ($vl_num_rows){
	set_var("ocultar_listado","");
	set_var("ocultar_listado1","");
	while($vl_fila_comision=mysql_fetch_array($vl_consulta_comisiones)){
		set_var("nombre_comision","$vl_fila_comision[nombre]");
		set_var("id_comision","$vl_fila_comision[id_comision]");
		set_var("sesion","$PHPSESSID");
		if (!isset($vf_id_comision)) $vf_id_comision=$vl_fila_comision[id_comision];
		if ($vl_fila_comision[id_comision]==$vf_id_comision) 
			set_var("selected_comision","selected");
		else set_var("selected_comision","");	
		parse("bloque_listado_comisiones","bloque_listado_comisiones",true);
	}
	
}
else{
    $vl_mensaje_error="ERROR: No existen comision activas";
    header("Location:menu.php?mensaje=$vl_mensaje_error&PHPSESSID=$PHPSESSID");
}

if (!isset($ordenar)){set_var("ord","asc");$ordenar= 'apellido';$ord='desc';} 
else{if ($ord=="asc") $ord="desc";
	 else $ord="asc";
	 set_var("ord","$ord");
}


$vl_consulta_alumnos=mysql_query("SELECT *
									FROM alumno_comision ac,alumno a
									WHERE ac.id_comision=$vf_id_comision
										AND ac.id_alumno=a.lib_univ
									ORDER BY $ordenar $ord");
if (mysql_num_rows($vl_consulta_alumnos)){									
	////PAGINACION////////////////////////////		
	$vl_total_renglones = mysql_num_rows($vl_consulta_alumnos);
	$vl_tamanio_pagina = $vc_tamanio_pagina_alumnos; // tamaño de página seteado en configuracion.php
	if(!isset($vf_pag)) $vf_pag = 1;  		// si es la primer vez que entra, que muestre la primer página
	set_var("paginado",paginar5($vl_total_renglones,$vl_tamanio_pagina,"alumnos_administrar.php?vf_id_comision=$vf_id_comision&",$vf_pag,"cat_tabla_cuerpo","none","none","none"));
	$vl_desde = $vl_tamanio_pagina*($vf_pag-1);
	$vl_hasta = $vl_desde + $vl_tamanio_pagina;
	$vl_renglon = $vl_desde; // esta variable se usa para paginar
	mysql_data_seek($vl_consulta_alumnos,$vl_desde);
	//////////////////////////////////////////
	
	$vf_pila_de_errores = explode (":", $vf_pila_de_errores);
		
	while(($vl_fila_alumno=mysql_fetch_array($vl_consulta_alumnos)) and ($vl_renglon<$vl_hasta)){
		$vl_renglon++; /// para paginar, no olvidar!!!!
		set_var("bloque","$vl_bloque");
		set_var("ocultar_botones","");
		set_var("ocultar_botones1","");		
		set_var("nombre_comision","$vl_fila_alumno[nombre_comision]");
		set_var("lu","$vl_fila_alumno[lib_univ]");
		set_var("nombre","$vl_fila_alumno[nombre]");
		set_var("apellido","$vl_fila_alumno[apellido]");
		set_var("id_alumno","$vl_fila_comision[lib_univ]");
		set_var("id_comision","$vf_id_comision");
		//.cat_tabla_cuerpo_advertencia
		if (in_array($vl_fila_alumno[lib_univ],$vf_pila_de_errores)){
            $vl_email_alumno="vf_email".$vl_fila_alumno[lib_univ];
            $vl_email_alumno=$$vl_email_alumno;
            set_var("estilo","cat_tabla_cuerpo_advertencia");
            set_var("email","$vl_fila_alumno[email]");
        }
        else{
        	set_var("estilo","cat_tabla_cuerpo");
            set_var("email","$vl_fila_alumno[email]");
        }		
		set_var("vf_pag","$vf_pag");
		parse("bloque_listado","bloque_listado",true);
	}
} // si existen alumnos
else{
    $vl_mensaje="ERROR: No existen alumnos en la comision seleccionada";
	set_var("paginado","");
	set_var("bloque","$vl_bloque1");
	set_var("ocultar_botones","<!--");
	set_var("ocultar_botones1","-->");		
	set_var("estilo","cat_tabla_cuerpo");	
	parse("bloque_listado","bloque_listado",true);
}
set_var("sesion","$PHPSESSID");
set_var("firma",firma());    
set_var("mensaje","$vl_mensaje");
pparse("pagina");
die();
?>