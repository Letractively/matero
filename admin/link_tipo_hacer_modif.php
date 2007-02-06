<?php
/************************************************************************
*                 Nombre Sistema:   Matero.
*                  Nombre Script:   link_tipo_hacer_modif.php
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


$vl_error=0;
//Valido los datos

//Valido el nombre
if (!is_alphanumeric($vf_nombre,2,200) || ($vf_nombre==""))
   {$vl_mensaje_error.="Se ha ingresado un nombre incorrecto<br>";
   $vl_error=1;
   }



if($vl_error==1){
set_file("pagina","link_tipo_modif.html");
set_var("nombre",$vf_nombre);
set_var("descri",$vf_descri);
set_var("mensaje",$vl_mensaje_error);
set_var("firma",firma());
set_var("idi",$idi);
parse("datos","datos",true);
pparse("pagina");
die;
}

if (mysql_query("UPDATE link_tipo set
                  nombre = '$vf_nombre',
                  descripcion = '$vf_descri'
                  WHERE id_catedra = '$vs_id_catedra'
                  AND   id_link_tipo = '$idi'")){
                                                        $vl_mensaje="Se modificó el tipo de link exitosamente";

                                                        }
else{
        $vl_mensaje="No se pudo modificar un tipo de link ";
}

header("Location:link_tipo_listado.php?PHPSESSID=$PHPSESSID&mensaje=$vl_mensaje");
?>