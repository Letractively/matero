<?php
/************************************************************************
*                 Nombre Sistema:   Matero.
*                  Nombre Script:   apuntes_modificaciones.php
*                          Autor:   Angeletti, Mariano R.
*                 Fecha Creacion:   19-09-03.
*            Ultima Modificacion:   19-09-03.
*           Campos que lee en BD:   tabla administrador
*      Campos que Modifica en BD:   ninguna
*  Descripcion de funcionamiento:   segun la accion que se haya iniciado, puede eliminar, guardad cambios de posicion o ir a la pantalla de agregar otro integrante
*              Funciones que usa:
*                Que falta Hacer:
*       Validaciones que realiza:
************************************************************************/
include("seguridad_intranet.php");
// CHINO
///////////
switch($boton)
{
case 'Actualizar':
	$vl_consulta=mysql_query("Select *  
						  from apuntes
                          where id_catedra='$vs_id_catedra'");

      while($vl_fila=mysql_fetch_array($vl_consulta)){
          $vl_id="vf_pos_$vl_fila[id_apuntes]";
          $vl_id=$$vl_id;
          mysql_query("UPDATE apuntes SET
                       posicion='$vl_id'
                       WHERE id_apuntes='$vl_fila[id_apuntes]'
                       and id_catedra='$vs_id_catedra' "); //capaz que esta de mas
	 }
	$vl_mensaje="Orden de Apuntes MODIFICADOS satisfactoriamente";
	break;
//////////////////////////////////
case 'Agregar otro apunte': 
				 header("Location:apunte_alta.php?PHPSESSID=$PHPSESSID&menu=1");
              		die;  
			  		break; 


case 'Eliminar': 
                    $vl_query=mysql_query("Select *
                                           from apuntes
                                           where id_catedra='$vs_id_catedra'");
				     if (!mysql_num_rows($vl_query))
                                       { header("Location:menu.php?PHPSESSID=$PHPSESSID");
                                       die;
                                       }

					   else{

     			 while ($vl_fila=mysql_fetch_array($vl_query)){
                	$vl_elim="vf_elim_".$vl_fila[id_apuntes];
                  	$vl_elim=$$vl_elim;
                   	if ($vl_elim==1)    {
                       if ($vl_fila[nombre_archivo]!="")// deldir("../archivos/$vs_id_catedra/$vc_directorio_apuntes/$vl_fila[id_apuntes]");
                            {
                          unlink("../archivos/$vs_id_catedra/$vc_directorio_apuntes/$vl_fila[id_apuntes]/$vl_fila[nombre_archivo]");
                          }
                       rmdir("../archivos/$vs_id_catedra/$vc_directorio_apuntes/$vl_fila[id_apuntes]/");
                       mysql_query("Delete From apuntes where id_apuntes='$vl_fila[id_apuntes]' and id_catedra='$vs_id_catedra'");
                       $vl_mensaje="Eliminación exitosa";
                    	}// if
      			}
      	       //while
      		}//else
			break;		

case 'Publicar':
 
				    $vl_query=mysql_query("Select *
                                           from apuntes
                                           where id_catedra='$vs_id_catedra'");
   				  if (!mysql_num_rows($vl_query))
                	                       { header("Location:menu.php?PHPSESSID=$PHPSESSID");
                    	                   die;
                        	               }
				     else{
			      while ($vl_fila=mysql_fetch_array($vl_query))
				  {
               		 $vl_pub="vf_pub_".$vl_fila[id_apuntes];
                  		$vl_pub=$$vl_pub;
				  		if ($vl_pub==1) $vl_publicar=1;
				  		else $vl_publicar=0;
				  mysql_query("UPDATE apuntes SET
				  				publicar = '$vl_publicar'
								WHERE id_apuntes = $vl_fila[id_apuntes]
								and id_catedra = '$vs_id_catedra'");
				 }
				}
			$vl_mensaje="Se actualizó las publicaciones de forma correcta";
			break;

}// switch

header("Location:apuntes_listado.php?PHPSESSID=$PHPSESSID&mensaje=$vl_mensaje");


?>