<?php
/************************************************************************
*                 Nombre Sistema:   Matero.
*                  Nombre Script:   tp_administrar.php
*                          Autor:   A.U.S. Sánchez, Guido S. , Angeletti, Mariano
*                 Fecha Creacion:   28-02-04.
*            Ultima Modificacion:   28-02-04.
*           Campos que lee en BD:   ninguna
*      Campos que Modifica en BD:   ninguna
*  Descripcion de funcionamiento:   inicializa el template de administrar parciales
*              Funciones que usa:
*                Que falta Hacer:
*       Validaciones que realiza:
************************************************************************/
include("seguridad_intranet.php");
include ("../includes/paginar.php");
include ("../includes/fecha.php");

$bloque="<tr valign=\"middle\" class=\"cat_tabla_cuerpo\"> 
                  <td> 
                    <div align=\"center\"><b>{fecha}</b><br>
                      {hora}</div></td>
                  <td> 
                    <div align=\"center\">{nombre}</div></td>
                  <td> 
                    <div align=\"center\"><a href=\"tp_pasar_notas.php?vf_id_tp={id_tp}&vf_id_comision={idc}\">notas</a></div></td>
                  <td> 
                    <div align=\"center\"><a href=\"tp_modif.php?vf_id_tp={id_tp}&vf_id_comision={idc}\">modif. 
                      TP </a></div></td>
                  <td> 
                    <div align=\"center\"> 
                      <input type=\"checkbox\" name=\"vf_eliminar{id_tp}\" value=\"1\">
                    </div></td>
                </tr>";

$bloque1="  <tr class=\"cat_tabla_cuerpo\" height=\"8\"> 
                  <td height=\"35\" colspan=\"5\"><div align=\"center\">No existen ex&aacute;menes 
                      parciales para la comisi&oacute;n</div></td>
                </tr>";
set_file("pagina","tp_administrar.html");

$vl_consulta_comisiones=mysql_query("SELECT * FROM comision WHERE id_catedra=$vs_id_catedra and activa='1'
									 ORDER BY fecha_alta ASC");

$vl_num_rows=mysql_num_rows($vl_consulta_comisiones);
if ($vl_num_rows){
	set_var("ocultar_listado","");
	set_var("ocultar_listado1","");
	while($vl_fila_comision=mysql_fetch_array($vl_consulta_comisiones)){
		set_var("nombre_comision","$vl_fila_comision[nombre]");
		set_var("id_comision_list","$vl_fila_comision[id_comision]"); // para los listados desplegables
		set_var("sesion","$PHPSESSID");
		if (!isset($vf_id_comision)) $vf_id_comision=$vl_fila_comision[id_comision]; //seteo la comision por defecto
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

if (!isset($ordenar)){set_var("ord","asc");$ordenar= "fecha_entrega";$ord="desc";} 
else{if ($ord=="asc") $ord="desc";
	 else $ord="asc";
	 set_var("ord","$ord");
}



$vl_consulta=mysql_query("SELECT e.*
     						FROM tp_comision ec, trabajo_practico e
							WHERE ec.id_comision=$vf_id_comision and
								  ec.id_tp=e.id_tp
							ORDER BY $ordenar $ord");
	
	if (mysql_num_rows($vl_consulta)){
	
		////PAGINACION////////////////////////////		
		$vl_total_renglones = mysql_num_rows($vl_consulta);
		$vl_tamanio_pagina = $vc_tamanio_pagina_examen_parcial; // tamaño de página seteado en configuracion.php
		if(!isset($vf_pag)) $vf_pag = 1;  		// si es la primer vez que entra, que muestre la primer página
		set_var("paginado",paginar5($vl_total_renglones,$vl_tamanio_pagina,"tp_administrar.php?vf_id_comision=$vf_id_comision&",$vf_pag,"cat_tabla_cuerpo","none","none","none"));
		$vl_desde = $vl_tamanio_pagina*($vf_pag-1);
		$vl_hasta = $vl_desde + $vl_tamanio_pagina;
		$vl_renglon = $vl_desde; // esta variable se usa para paginar
		mysql_data_seek($vl_consulta,$vl_desde);
		//////////////////////////////////////////

		while(($vl_fila_comision=mysql_fetch_array($vl_consulta)) and ($vl_renglon<$vl_hasta)){
			$vl_renglon++; /// para paginar, no olvidar!!!!
			set_var("bloque","$bloque");
			set_var("ocultar_botones","");
			set_var("ocultar_botones1","");		
			set_var("fecha",convertir_fecha("$vl_fila_comision[fecha_entrega]"));
			set_var("hora","$vl_fila_comision[hora]");			
			set_var("nombre","$vl_fila_comision[nombre]");							
			set_var("id_tp","$vl_fila_comision[id_tp]");
			set_var("id_comision","$vf_id_comision");
						
			parse("bloque_tp","bloque_tp",true);
		}
			set_var("idc","$vf_id_comision");
			set_var("mensaje","$mensaje");
			set_var("firma",firma());
			pparse("pagina");
	}
	else{
		$mensaje="No existen tps para la comisión seleccionada";
		set_var("bloque","$bloque1");
		set_var("ocultar_botones","<!--");
		set_var("ocultar_botones1","-->");		
		set_var("paginado","");		
		set_var("id_examen_parcial","$vl_fila_comision[id_examen_parcial]");
		set_var("idc","$vf_id_comision");
		set_var("id_comision","$vf_id_comision");								
		parse("bloque_tp","bloque_tp",true);
		set_var("mensaje","$mensaje");
		set_var("firma",firma());
		pparse("pagina");
	};
die();
?>