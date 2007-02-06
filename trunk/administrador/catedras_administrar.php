<?php
/************************************************************************
*                 Nombre Sistema:   Matero.
*                  Nombre Script:   catedras_administrar.php
*                          Autor:   A.U.S. Sánchez, Guido S. - Angeletti, Mariano R.
*                 Fecha Creacion:   17-10-03.
*            Ultima Modificacion:   17-10-03.
*           Campos que lee en BD:   tabla catedra,carrera
*      Campos que Modifica en BD:   ninguna
*  Descripcion de funcionamiento:   -inicializa el template.
*              Funciones que usa:
*                Que falta Hacer:
*       Validaciones que realiza:
************************************************************************/
include("seguridad_intranet.php");

set_file("pagina","catedras_administrar.html");
set_var("mensaje","$mensaje");

$vl_consulta_catedras=mysql_query("SELECT * FROM catedra order by nombre asc");
if (mysql_num_rows($vl_consulta_catedras)){
    $vl_renglon = 0;    //renglon se usa para controlar el estilo de cada renglon
    while($vl_fila_catedra=mysql_fetch_array($vl_consulta_catedras)){
       if ($vl_renglon % 2) set_var("estilo", "tabla_cuerpo2");
       else set_var("estilo", "tabla_cuerpo");
       $vl_renglon ++;
       set_var("id_catedra","$vl_fila_catedra[id_catedra]");
       set_var("nombre_catedra","$vl_fila_catedra[nombre]");
       set_var("email_catedra","$vl_fila_catedra[email]");
       parse("bloque_catedra","bloque_catedra",true);

    }
}
else{
    set_var("nombre_catedra","");
    set_var("email_catedra","");
    set_var("listado_carreras","");
    parse("bloque_catedra","bloque_catedra",true);
    set_var("mensaje","No existen cátedras cargadas");

}

set_var("firma",firma());
pparse("pagina");

?>