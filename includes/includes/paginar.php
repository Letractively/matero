<?php
/************************************************************************
*                 Nombre Sistema:   
*                  Nombre Script:   paginar.php
*                          Autor:   Marcos A. Botta
*                 Fecha Creacion:   4-5-2003
*            Ultima Modificacion:
*           Campos que lee en BD:
*      Campos que Modifica en BD:   Ninguna
*  Descripcion de funcionamiento:   funciones que ayudan a paginar.
*              Funciones que usa:
*                Que falta Hacer:
************************************************************************/
function paginar($vp_total_items,
				 $vp_tamanio_pagina,
				 $vp_script_paginado,
				 $vf_pag,
				 $vp_imprimir_en){
				 	
// salida ->  
/*
 <table>
 	<tr>
 		<td>
 		   < - 1 - 2 - 3 - 4 - 5 - 6 - >
 		</td>
 	</tr>
 </table>
*/
// funcion paginado. por Marcos A. Botta
// $vp_total_items: cantidad total de items
// $vp_tamanio_pagina: cantidad de items que muestra por página
// $vp_script_paginado: que script lo llamó (además cual llamará nuevamente)
// $vp_imprimir_en: en que lugar de la página se imprime, eso tiene que estar dentro del template
//////////////////////////////////////////  paginado  //////////////////////////////////////////
	// armo tabla de paginado
	$vl_cantidad_paginas = ceil($vp_total_items/$vp_tamanio_pagina);
	if($vl_cantidad_paginas<=1){
		$vl_tabal_paginado="";
		}
	else
		{
		$vl_tabla_paginado = "<table with=\"100%\"><tr><td>";
		if($vf_pag>1){// si es la primer página -> no muestro link a anterior
			$vl_ant = $vf_pag - 1;
			$vl_tabla_paginado ="$vl_tabla_paginado <a href=\"$vp_script_paginado"."vf_pag=$vl_ant\"><</a>";
			}			

		for($vl_cont=1; $vl_cont<=$vl_cantidad_paginas;$vl_cont++){
			if($vl_cont==$vf_pag){ // si el es la página actual -> no linkeo
				$vl_tabla_paginado = "$vl_tabla_paginado <font color=#000000><b>$vl_cont</b></font>";
				}
			else{
				$vl_tabla_paginado = "$vl_tabla_paginado
		  							  <a href=\"$vp_script_paginado"."vf_pag=$vl_cont\">$vl_cont</a>";
				}
			}

		if($vf_pag<$vl_cantidad_paginas){ // si es la ultima página -> no muestro link a siguiente
			$vl_sig = $vf_pag + 1;
			$vl_tabla_paginado = "$vl_tabla_paginado <a href=\"$vp_script_paginado"."vf_pag=$vl_sig\">></a>";
			}
	
		$vl_tabla_paginado = "$vl_tabla_paginado</td></tr></table>"; // fin de la tabla paginado
		}
		
set_var($vp_imprimir_en,$vl_tabla_paginado);
}


//echo paginar2(299,20,"hola",2);


function paginar2($vp_total_items,
				 $vp_tamanio_pagina,
				 $vp_script_paginado,
				 $vp_pag,
				 $vp_estilo_tabla,
				 $vp_estilo_celda,
				 $vp_estilo_link,
				 $vp_estilo_texto){
// salida ->  
/*
 <table>
 	<tr>
 		Página 2 de 18
 	</tr>
 	<tr>
 		Mensajes: 1 al 10 de 87
 	</tr>
 	<tr>
 	    << < Página 1 de 18 > >>
 	</tr>
 </table>
*/
// funcion paginado. por Marcos A. Botta
// $vp_total_items: cantidad total de items
// $vp_tamanio_pagina: cantidad de items que muestra por página
// $vp_script_paginado: que script lo llamó (además cual llamará nuevamente)
// $vp_imprimir_en: en que lugar de la página se imprime, eso tiene que estar dentro del template
//////////////////////////////////////////  paginado  //////////////////////////////////////////
	// armo tabla de paginado
	$vl_cantidad_paginas = ceil($vp_total_items/$vp_tamanio_pagina);
	
	$vl_tabla_paginado = "<table width=\"100%\" border=1 class=\"$vp_estilo_tabla\"><tr>";
	$vl_tabla_paginado .= "<td class=\"$vp_estilo_celda\">Página $vp_pag de $vl_cantidad_paginas</td>";
	
	$vl_desde = ($vp_pag - 1) * $vp_tamanio_pagina;
	$vl_hasta = $vl_desde + $vp_tamanio_pagina; 
	$vl_tabla_paginado .= "<td>Mensajes: $vl_desde a $vl_hasta de $vp_total_items</td>";
		
	
	// links a pagina anterior y a inicio
	if($vp_pag==1){
		$vl_link_inicio = "";
		$vl_anterior = "";
		}
	else
	 {$vl_link_inicio = "<a href=\"$vp_script_paginado"."vf_pag=1\"><<</a>";
	  $vl_anterior = $vp_pag - 1;
	  $vl_link_anterior = "<a href=\"$vp_script_paginado"."vf_pag=$vl_anterior\"><</a>";
	  } 
	
	
	// links a pagina siguiente y a final
	if($vp_pag==$vl_cantidad_paginas){
		$vl_link_siguiente = "";
		$vl_link_fin = "";
		}
	else{
		$vl_siguiente = $vp_pag + 1;
		$vl_link_siguiente = "<a href=\"$vp_script_paginado"."vf_pag=$vl_siguiente\">></a>";
		$vl_link_fin = "<a href=\"$vp_script_paginado"."vf_pag=$vl_cantidad_paginas\">>></a>";
	    }
	    
	$vl_tabla_paginado .= "<td>$vl_link_inicio &nbsp $vl_link_anterior Página $vp_pag de $vl_cantidad_paginas $vl_link_siguiente &nbsp; $vl_link_fin</td>";
	$vl_tabla_paginado .= "</tr></table>";
		
return $vl_tabla_paginado;
// set_var($vp_imprimir_en,$vl_tabla_paginado);
}
///////////////////////   fin  funcion paginado //////////////////////////////////////////////////////
?>