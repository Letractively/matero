<?php
/************************************************************************
*                 Nombre Sistema:   Matero.
*                  Nombre Script:   catedras_mostrar.php
*                          Autor:   A.U.S. Sánchez, Guido S. - Angeletti, Mariano R.
*                 Fecha Creacion:   18-10-03.
*            Ultima Modificacion:   18-10-03.
*           Campos que lee en BD:   tabla catedra,carrera
*      Campos que Modifica en BD:   ninguna
*  Descripcion de funcionamiento:   - inicializa el template.
*              Funciones que usa:
*                Que falta Hacer:
*       Validaciones que realiza:
************************************************************************/
include("seguridad_intranet.php");

set_file("pagina","catedras_mostrar.html");

set_var("mensaje","");
$vl_consulta_catedra=mysql_query("SELECT * FROM catedra where id_catedra=$vf_id_catedra");

if (mysql_num_rows($vl_consulta_catedra)){
    $vl_fila_catedra=mysql_fetch_array($vl_consulta_catedra);
    set_var("nombre_catedra","$vl_fila_catedra[nombre]");
    set_var("email","$vl_fila_catedra[email]");
    parse("bloque_datos_catedra","bloque_datos_catedra");
    // busco las carreras a las que pertenece
    $vl_consulta_carrera=mysql_query("SELECT * FROM carrera, catedra_carrera 
										WHERE catedra_carrera.id_catedra=$vf_id_catedra
												and carrera.id_carrera=catedra_carrera.id_carrera");
    while($vl_fila_carrera=mysql_fetch_array($vl_consulta_carrera)){
		set_var("nombre_carrera",$vl_fila_carrera[nombre]);
        parse("bloque_listado_carreras","bloque_listado_carreras",true);
    }
}
else{
    set_var("nombre_catedra","");
    set_var("email","");
    set_var("nombre_carrera","");
    parse("bloque_catedra","bloque_catedra",true);
    set_var("mensaje","No existen cátedras cargadas");

}

set_var("firma",firma());
pparse("pagina");

?>