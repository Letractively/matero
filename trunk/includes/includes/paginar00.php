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



function paginar2($vp_total_items,
				 $vp_tamanio_pagina,
				 $vp_script_paginado,
				 $vf_pag){
				 	
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

///////////////////////   fin  funcion paginado //////////////////////////////////////////////////////
?>