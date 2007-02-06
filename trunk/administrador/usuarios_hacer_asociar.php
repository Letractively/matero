<?php
/************************************************************************
*                 Nombre Sistema:   Matero
*                  Nombre Script:   usuario_hacer_asociar.php
*                          Autor:   Guido S., Mariano A.
*                 Fecha Creacion:   19-09-03.
*            Ultima Modificacion:   19-09-03.
*           Campos que lee en BD:   tabla usuario
*      Campos que Modifica en BD:   Ninguna
*  Descripcion de funcionamiento:   inicializa el template alta_usuario.
*              Funciones que usa:
*                Que falta Hacer:   nada.-
*
************************************************************************/
//Incluye archivos de seguridad
include ("seguridad_intranet.php");


// Obtengo las catedras que el usuario administra
$vl_usuario_administra=mysql_query("select id_catedra
                               from usuario_catedra
                               where id_usuario='$idu'
                               ");
$vl_array_administra=array();
if (!mysql_num_rows($vl_usuario_administra)){
             $vl_catedras='No tiene asignada ninguna cátedra';
             }
else{
     while($vl_fila=mysql_fetch_array($vl_usuario_administra)){
     array_push($vl_array_administra,$vl_fila[id_catedra]);
     }
}

foreach ($vf_list_catedras as $vl_seleccionada){

          if (!in_array($vl_seleccionada,$vl_array_administra)){// inserto el reg...si ya estaba registrado no hago nada
                          $vl_insert="Insert usuario_catedra (
                                                     id_catedra,
                                                     id_usuario)
                                                     values(
                                                     '$vl_seleccionada',
                                                     '$idu')";
                            mysql_query($vl_insert);
          }
}
   ///// si estaba registrado y ahora no lo selecciono, debo eliminar el registro
foreach($vl_array_administra as $vl_registrado)
{
 if (!in_array($vl_registrado, $vf_list_catedras)) {
                              $vl_update="Delete from usuario_catedra
                                              where id_catedra='$vl_registrado'
                                              and id_usuario='$idu'";
                                mysql_query($vl_update);

 }
}

header("Location:usuarios_administrador.php?PHPSESSID=$PHPSESSID&mensaje=La modificación se realizó con éxito");
?>