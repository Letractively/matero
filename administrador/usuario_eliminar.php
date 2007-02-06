<?php
/************************************************************************
*                 Nombre Sistema:   Matero.
*                  Nombre Script:   menu.php
*                          Autor:   A.U.S. Sánchez, Guido S. - Angeletti, Mariano R.
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


if ($vf_accion="Eliminar")
{
 $vl_consulta=mysql_query("Select * from usuario");
 if (!mysql_num_rows($vl_consulta)) {echo "Problemas con Usuarios en BD";}
 else {
       while($vl_fila=mysql_fetch_array($vl_consulta)){
       $vl_idu="vf_elim_$vl_fila[id_usuario]";
       $vl_idu=$$vl_idu;
        if($vl_idu=='1'){ $vl_id=$vl_fila[id_usuario];
                    mysql_query("Delete from usuario where id_usuario='$vl_id'");
        }
       }


 }
header("Location:usuarios_administrador.php?PHPSESSID=$PHPSESSID");
};

?>