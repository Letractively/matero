<?php
set_file("pagina","horarios.html");

//Obtengo el objetivo
$consulta=mysql_query("select * from horarios where id_catedra=$id_catedra");

//Si no encuentra horarios, vuelve a la pagina principal
if(!mysql_num_rows($consulta)||!$modulo7Activado){
    set_file('pagina','error.html');
    //Incluyo el codigo para que se genere el menu y la informacion del encabezado
    
    set_var('mensaje','No existen horarios.');
    parse("bloque","bloque",true);
    pparse("pagina");
    die();
    }

//Muestro el objetivo
$hor=mysql_fetch_array($consulta);
set_var('contenido',$hor['horarios']);

parse('bloque','bloque',true);
set_var("firma",firma_web());
pparse("pagina");
?>