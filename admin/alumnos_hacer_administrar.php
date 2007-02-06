<?php
/************************************************************************
*                 Nombre Sistema:   Matero.
*                  Nombre Script:   comision_hacer_administrar.php
*                          Autor:   A.U.S. Sánchez, Guido S.
*                 Fecha Creacion:   21-02-04.
*            Ultima Modificacion:   21-02-04.
*           Campos que lee en BD:
*      Campos que Modifica en BD:
*  Descripcion de funcionamiento:   Elimina los alumnos seleccionados y modifica los emails
*              Funciones que usa:
*                Que falta Hacer:
*       Validaciones que realiza:
************************************************************************/
include("seguridad_intranet.php");
include ("../includes/paginar.php");
$vl_consulta_alumnos=mysql_query("SELECT *
                                  FROM alumno_comision
                                  WHERE id_comision=$vf_id_comision");

if (isset($vf_elim)) {
                if (mysql_num_rows($vl_consulta_alumnos)){
                        $vl_alumnos_eliminados=0;
                        while($vl_fila_alumno=mysql_fetch_array($vl_consulta_alumnos)){
                                $vl_elininar_alumno="vf_eliminar".$vl_fila_alumno[id_alumno];
                                if (isset($$vl_elininar_alumno)){
                                   $vl_alumnos_eliminados++;
                                   mysql_query("DELETE FROM alumno_comision WHERE id_alumno=$vl_fila_alumno[id_alumno] and id_comision=$vf_id_comision");
                                }
                        }
                        if ($vl_alumnos_eliminados==0){
                                $vl_mensaje="ERROR: Debes seleccionar un alumno";
                                header("Location:alumnos_administrar.php?PHPSESSID=$PHPSESSID&vl_mensaje=$vl_mensaje&vf_id_comision=$vf_id_comision&vf_pag=$vf_pag");
                                die();
                        }
                        else  $vl_mensaje="Se eliminaron con éxito $vl_alumnos_eliminados alumnos";
                }

} // if $vf_elim està seteada

if (isset($vf_actualizar)){
        if (mysql_num_rows($vl_consulta_alumnos))
              {
                $vl_pila_de_errores=array();
                while($vl_fila_alumno=mysql_fetch_array($vl_consulta_alumnos)){
                             $vl_email_alumno="vf_email".$vl_fila_alumno[id_alumno];
                             $vl_email_alumno=$$vl_email_alumno;
                                //Valido si el email tiene un formato correcto
                             if ((!is_email($vl_email_alumno) && ($vl_email_alumno!="")))
                                      array_push($vl_pila_de_errores,$vl_fila_alumno[id_alumno]);
                             else if ($vl_email_alumno!="") 
							 		mysql_query("UPDATE alumno_comision
                                               SET email='$vl_email_alumno'
                                               WHERE  id_comision='$vf_id_comision' and
                                                      id_alumno='$vl_fila_alumno[id_alumno]'");
                }
                        if (!count($vl_pila_de_errores))
                        {
                                $vl_mensaje="Se actualizaron exitosamente los emails de los alumnos";
                                header("Location:alumnos_administrar.php?PHPSESSID=$PHPSESSID&vl_mensaje=$vl_mensaje&vf_id_comision=$vf_id_comision&vf_pag=$vf_pag");
                                die();
                        }
                        else{ // si hubo errores
                                // mandar arreglo
								$vf_pila_de_errores=implode (":", $vl_pila_de_errores);
								$vl_mensaje="ERROR: Las filas marcadas poseen un formato de e-mail incorrecto";
                                header("Location:alumnos_administrar.php?PHPSESSID=$PHPSESSID&vf_id_comision=$vf_id_comision&vf_pag=$vf_pag&vl_mensaje=$vl_mensaje&vf_pila_de_errores=$vf_pila_de_errores");
                                die();
                        }
/*                              set_file("pagina","alumnos_administrar.html");
                                set_var("ord","asc");
                                $vl_consulta_alumnos=mysql_query("SELECT *, comision.nombre as nombre_comision, alumno.nombre as nombre_alumno
                                                                                        FROM alumno_comision,comision,alumno WHERE alumno_comision.id_comision=$vs_id_comision
                                                                                                                                                                        and alumno_comision.id_comision=comision.id_comision
                                                                                                                                                                        and alumno_comision.id_alumno=alumno.lib_univ");
                                if (mysql_num_rows($vl_consulta_alumnos)){
                                        while($vl_fila_alumno=mysql_fetch_array($vl_consulta_alumnos)){
                                                if (in_array($vl_fila_alumno[lib_univ],$vl_pila_de_errores)){
                                                        $vl_email_alumno="vf_email".$vl_fila_alumno[id_alumno];
                                                        $vl_email_alumno=$$vl_email_alumno;
                                                        set_var("estilo","com_tabla_cuerpo_advertencia");
                                                        set_var("email","$vl_email_alumno");
                                                }
                                                else{
                                                        set_var("estilo","com_tabla_cuerpo");
                                                        set_var("email","$vl_fila_alumno[email]");
                                                }
                                                set_var("nombre_comision","$vl_fila_alumno[nombre_comision]");
                                                set_var("lu","$vl_fila_alumno[lib_univ]");
                                                set_var("nombre","$vl_fila_alumno[nombre_alumno]");
                                                set_var("apellido","$vl_fila_alumno[apellido]");
                                                set_var("id_alumno","$vl_fila_comision[lib_univ]");
                                                parse("bloque_listado","bloque_listado",true);
                                        } // while
                                        $mensaje="ERROR: Las filas marcadas poseen un formato de e-mail incorrecto";
                                        set_var("mensaje","$mensaje");
                                        set_var("firma",firma());
                                        pparse("pagina");
                                        die();
                                } // si existen alumnos
                        } // si hubo errores*/
/*                           else{
                        header("Location:alumnos_administrar.php?PHPSESSID=$PHPSESSID&vf_id_comision=$vf_id_comision");
                        die();
                }*/

	} // si existen alumnos en la comisiòn
}
header("Location:alumnos_administrar.php?PHPSESSID=$PHPSESSID&vf_id_comision=$vf_id_comision&vf_pag=$vf_pag");
die();
?>