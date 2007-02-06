<?php
/************************************************************************
*                 Nombre Sistema:   Matero.
*                  Nombre Script:   catedras_alta.php
*                          Autor:   A.U.S. Sánchez, Guido S. - Angeletti, Mariano R.
*                 Fecha Creacion:   11-10-03.
*            Ultima Modificacion:   11-10-03.
*           Campos que lee en BD:   tabla catedra,carrera
*      Campos que Modifica en BD:   ninguna
*  Descripcion de funcionamiento:   -inicializa el template, crea el listado de carreras.
*              Funciones que usa:
*                Que falta Hacer:
*       Validaciones que realiza:
************************************************************************/
include("seguridad_intranet.php");

set_file("pagina","catedras_alta.html");

set_var("mensaje","");
set_var("nombre","");
set_var("email","");
parse("bloque_datos_catedra","bloque_datos_catedra",true);
$vl_consulta_carreras=mysql_query("SELECT * FROM carrera order by nombre asc");
while ($vl_fila_carreras=mysql_fetch_array($vl_consulta_carreras)){
        set_var("id_carrera","$vl_fila_carreras[id_carrera]");
        set_var("carrera","$vl_fila_carreras[nombre]");
        set_var("selected$vl_fila_carreras[id_carrera]","");
        parse("bloque_carreras","bloque_carreras",true);
}


set_var("firma",firma());
pparse("pagina");

?>