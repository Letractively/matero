<?php
/************************************************************************
*                 Nombre Sistema:   Matero.
*                  Nombre Script:   modulos_listado.php
*                          Autor:   Angeletti, Mariano R.
*                 Fecha Creacion:   19-09-03.
*            Ultima Modificacion:   19-09-03.
*           Campos que lee en BD:   tabla administrador
*      Campos que Modifica en BD:   ninguna
*  Descripcion de funcionamiento:   realiza el logueo del usuario
*              Funciones que usa:
*                Que falta Hacer:
*       Validaciones que realiza:
************************************************************************/
include("seguridad_intranet.php");
// cantidad de modulos en configuracion.php
$vl_nro_modulos = count($vc_array_modulos);
$sql_modulos_listado = "Select *
                            from modulos
                            where id_catedra='$vs_id_catedra'
                            ";
//echo $sql_modulos_listado;							
$vl_consulta=mysql_query($sql_modulos_listado);

/*if (!mysql_num_rows($vl_consulta)){
                                      $vl_mensaje="ERROR: No existen modulos cargados";
                                      header("Location:menu.php?PHPSESSID=$PHPSESSID&mensaje=$vl_mensaje");
                                      die;}
else {*/
// verifico la cantidad de modulos en la bd y la comparo conel de configuracion.php
/*	if ($vl_nro_modulos != mysql_num_rows($vl_consulta)) 		
		{ $vl_array_esta=array();
			$vl_keys_modulos = array_keys($vc_array_modulos);
			while ($vl_fila=mysql_fetch_array($vl_consulta))
			 { 
		  		if(array_key_exists($vl_fila[id_modulo],$vc_array_modulos))
				{
				array_push($vl_array_esta,$vl_fila[id_modulo]);
				}		
			 } // fin while
			 $vl_array_aux=array();
			 foreach($vl_keys_modulos as $vl_id){
			 	if (!in_array($vl_id,$vl_array_esta))
			 	{
				array_push($vl_array_aux,$vl_id);
				}
			 }
 			foreach($vl_array_aux as $vl_id_modulo){
			mysql_query("INSERT INTO modulos (
												id_modulo,
												id_catedra,
												modulo,
												publicar)
												VALUES (
												'NULL',
												'$vs_id_catedra',
												$vl_id_modulo,
												'0'
												 )");		
			} // fin foreach del que insert
			$mensaje="Se han generado nuevos módulos para administrar";
			$vl_otra_vez=1;
			}// finif


//**** parseo los modulos
if ($vl_otra_vez==1) {$vl_consulta=mysql_query("Select *
                            from modulos
                            where id_catedra='$vs_id_catedra'
                            ");}
*/

        set_file("pagina","modulos_listado.html");

        while ($vl_fila=mysql_fetch_array($vl_consulta)){
			set_var("titulo",$vc_array_modulos[$vl_fila[modulo]]);
			set_var("idm",$vl_fila[id_modulo]);
			if ($vl_fila[publicar]==1){ set_var("check","checked");}
			else {set_var("check","");}
			parse("profe","profe",true);
        }
//}

set_var("mensaje",$mensaje);
set_var("firma",firma());
parse("datos","datos",true);
pparse("pagina");

?>