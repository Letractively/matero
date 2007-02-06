<?php
/************************************************************************
*                 Nombre Sistema:   Matero.
*                  Nombre Script:   catedras_modificar.php
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

set_file("pagina","catedras_modificar.html");

$vl_consulta_catedra=mysql_query("SELECT * FROM catedra WHERE id_catedra=$vf_id_catedra");
$vl_fila_catedra=mysql_fetch_array($vl_consulta_catedra);
set_var("mensaje","");
set_var("id_catedra","$vl_fila_catedra[id_catedra]");
set_var("nombre",$vl_fila_catedra[nombre]);
set_var("email",$vl_fila_catedra[email]);
parse("bloque_datos_catedra","bloque_datos_catedra",true);

$vl_consulta_carreras_catedra=mysql_query("SELECT * FROM catedra_carrera where id_catedra=$vf_id_catedra");


$vl_consulta_carreras=mysql_query("SELECT * FROM carrera");
while ($vl_fila_carreras=mysql_fetch_array($vl_consulta_carreras)){
		mysql_data_seek($vl_consulta_carreras_catedra,0);
        set_var("id_carrera","$vl_fila_carreras[id_carrera]");
        set_var("carrera","$vl_fila_carreras[nombre]");
		while($vl_fila_carreras_catedra=mysql_fetch_array($vl_consulta_carreras_catedra)){
			if ($vl_fila_carreras_catedra[id_carrera]==$vl_fila_carreras[id_carrera]) set_var("selected$vl_fila_carreras[id_carrera]","selected");
		}
        parse("bloque_carreras","bloque_carreras",true);
}
set_var("firma",firma());
pparse("pagina");

?>