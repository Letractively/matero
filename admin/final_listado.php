<?php
/************************************************************************
*                 Nombre Sistema:   Matero.
*                  Nombre Script:   final_listado.php
*                          Autor:   Mariano Angeletti
*                 Fecha Creacion:   27-01-04.
*            Ultima Modificacion:   27-01-04.
*           Campos que lee en BD:
*      Campos que Modifica en BD:   ninguna
*  Descripcion de funcionamiento:   inicializa el template de alta de alumnos
*              Funciones que usa:
*                Que falta Hacer:
*       Validaciones que realiza:
************************************************************************/
include("seguridad_intranet.php");
include("../includes/fecha.php");

if ($orden==""){    $vl_orden=2;
                                        $vl_ordenar=" order by fecha_examen desc";}

if ($orden==1){    $vl_orden=2;
                                        $vl_ordenar=" order by fecha_examen desc";}

if ($orden==2){    $vl_orden=1;
                                        $vl_ordenar=" order by fecha_examen asc";}

$vl_query=mysql_query("Select * from examen_final where id_catedra='$vs_id_catedra' $vl_ordenar");

if (!mysql_num_rows($vl_query)) {
                                                                $vl_mensaje="No hay exámenes para la cátedra";
                                                                header("Location:menu.php?PHPSESSID=$PHPSESSID&mensaje=$vl_mensaje");
                                                                die;
                                                                }
else {

set_file("pagina","final_listado.html");

set_var("orden",$vl_orden);


while ($vl_fila=mysql_fetch_array($vl_query)){
        set_var("fecha",convertir_fecha($vl_fila[fecha_examen]));
        set_var("idf",$vl_fila[id_examen_final]);
        $f=$vl_fila[hora];
        $vl_hora="$f[0]$f[1]$f[2]$f[3]$f[4]";
        set_var("hora",$vl_hora);
        set_var("nombre",$vl_fila[nombre]);
        parse("final","final",true);
        }

set_var("firma",firma());
set_var("PHPSESSID",$PHPSESSID);
set_var("mensaje",$mensaje);

parse("datos","datos",true);
pparse("pagina");
}
?>