<?php
/************************************************************************
*                 Nombre Sistema:   Matero.
*                  Nombre Script:   apunte_listado.php
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
include("../includes/fecha.php");



$vl_consulta=mysql_query("Select *
                            from apuntes
                            where id_catedra='$vs_id_catedra'
                            order by  posicion asc,fecha desc, titulo asc");

if (!mysql_num_rows($vl_consulta)){
                                      $vl_mensaje="ERROR: No existen apuntes cargados";
                                      header("Location:menu.php?PHPSESSID=$PHPSESSID&mensaje=$vl_mensaje");
                                      die;}
else {
        set_file("pagina","apunte_listado.html");
        while ($vl_fila=mysql_fetch_array($vl_consulta)){
        set_var("titulo",$vl_fila[titulo]);
        set_var("fecha",convertir_fecha($vl_fila[fecha]));
		set_var("pos",$vl_fila[posicion]);
        set_var("ida",$vl_fila[id_apuntes]);

                if ($vl_fila[publicar]==1) set_var("chek","checked");
                else set_var("chek","");
        parse("profe","profe",true);
        }
}

set_var("mensaje",$mensaje);
set_var("firma",firma());
parse("datos","datos",true);
pparse("pagina");

?>