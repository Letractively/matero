<?php
/************************************************************************
*                 Nombre Sistema:   Matero.
*                  Nombre Script:   catedras_hacer_alta.php
*                          Autor:   A.U.S. Sánchez, Guido S. - Angeletti, Mariano R.
*                 Fecha Creacion:   11-10-03.
*            Ultima Modificacion:   11-10-03.
*           Campos que lee en BD:   tabla catedra,carrera
*      Campos que Modifica en BD:   ninguna
*  Descripcion de funcionamiento:   -hace el alta de la carrera y la asigna a una o más carreras.
*              Funciones que usa:
*                Que falta Hacer:
*       Validaciones que realiza:
************************************************************************/
include("seguridad_intranet.php");


$vl_error=0;
//Valido los datos

//Valido el email
if ((!is_email($vf_email) && ($vf_email!="")) or ($vf_email==""))
   {$vl_mensaje_error.="ERROR: Se ha ingresado un email incorrecto<br>";
   $vl_error=1;
   }
//Valido el nombre de la catedra
if (!is_alpha($vf_nombre_catedra,2,120))
   {$vl_mensaje_error.="ERROR: Se ha ingresado un nombre de cátedra incorrecto<br>";
   $vl_error=1;
   }

//Valido que el nombre de la càtedra no se repita
$vl_busco=mysql_query("select id_catedra from catedra where nombre='$vf_nick'");
if(mysql_num_rows($vl_busco))
   {$vl_mensaje_error.="Se ha ingresado un nombre de cátedra que ya existe<br>";
   $vl_error=1;
   }

if (!sizeof($vf_list_carreras)){
   $vl_mensaje_error.="ERROR: Debe seleccionar una carrera de la lista<br>";
   $vl_error=1;
}


//Acá entra si hubo algún error
if ($vl_error){
        set_file("pagina","catedras_alta.html");
        set_var("mensaje",$vl_mensaje_error);
        set_var("nombre",$vf_nombre_catedra);
        set_var("email",$vf_email);
        $vl_consulta_carreras=mysql_query("SELECT * FROM carrera");
        while ($vl_fila_carreras=mysql_fetch_array($vl_consulta_carreras)){
                set_var("id_carrera","$vl_fila_carreras[id_carrera]");
                set_var("carrera","$vl_fila_carreras[nombre]");
                if (isset($vf_list_carreras)){
                    foreach( $vf_list_carreras as $key => $value ) {
                          if ($value==$vl_fila_carreras[id_carrera]) set_var("selected$vl_fila_carreras[id_carrera]","selected");
                    }
                }
		parse("bloque_carreras","bloque_carreras",true);
        }
        set_var("firma",firma());
        parse("bloque_datos_catedra","bloque_datos_catedra",true);
        pparse("pagina");
        die();
}

/// acá sigue si no hubo ningùn error
//
mysql_query("INSERT INTO catedra VALUES ('NULL',
                                             '$vf_nombre_catedra',
                                              '1',
                                             '$vf_email',
                                             '',
                                             '')");
$vl_id_catedra=mysql_insert_id();
$vl_tope=count($vc_array_modulos);
///////////// genero las filas para la publicacion de los modulos
//for($i=1; $i<=$vl_tope; $i++)
$vl_keys_modulos = array_keys($vc_array_modulos);
foreach ($vl_keys_modulos as $vl_id)
{
mysql_query("INSERT INTO modulos VALUES ('NULL',
                                             '$vl_id_catedra',
                                              '$vl_id',
                                              '1')");
}



// creo los directorios para la cátedra
mkdir("../archivos/$vl_id_catedra", 0777);
mkdir("../archivos/$vl_id_catedra/plan", 0777);
mkdir("../archivos/$vl_id_catedra/objetivos", 0777);
mkdir("../archivos/$vl_id_catedra/repositorios", 0777);
mkdir("../archivos/$vl_id_catedra/tps", 0777);
mkdir("../archivos/$vl_id_catedra/apuntes", 0777);

foreach( $vf_list_carreras as $key => $value ) {
    mysql_query("INSERT INTO catedra_carrera VALUES ('$vl_id_catedra','$value')");
}

//Mensaje de exito
$texto="Se ha ingresado la cátedra ".negrita($vf_nombre)." satisfactoriamente ";
header("Location:menu.php?PHPSESSID=$PHPSESSID&mensaje=$texto");

?>