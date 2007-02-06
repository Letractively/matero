<?php

/************************************************************************
*                 Nombre Sistema:   Matero
*                  Nombre Script:   pas_hacer_modif.php
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

$vl_error=0;

//Valido los datos

//Valido que la password nueva y la confirmacion sean iguales
if ($vf_passnueva!=$vf_confirmacion)
   {$vl_mensaje_error="ERROR: La password nueva y la confirmacion no coinciden";
   $vl_error=1;
   }

//Valido que la password nueva sea correcta
if (!is_alphanumeric($vf_passnueva,6,60))
   {$vl_mensaje_error="ERROR: Se ha ingresado una password nueva incorrecta";
   $vl_error=1;
   }

//Acá entra si hubo algún error
if ($vl_error){
        set_file("pagina","pass_modif.html");
        set_var("mensaje","$vl_mensaje_error");
        set_var("vf_passactual","");
        set_var("vf_passnueva","");
        set_var("vf_confirmacion","");
        set_var("idu",$idu);
        set_var("firma",firma());
        parse("datos","datos",true);
        pparse("pagina");
        die();
}

//Acá entra si todos los datos fueron correctos
mysql_query("update usuario set pass=password('$vf_passnueva')
                                    where id_usuario=$idu");

//Mensaje de exito

$vl_mensaje="La password se modificó satisfactoriamente";
header("Location:usuarios_administrador.php?mensaje=$vl_mensaje");
?>