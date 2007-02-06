<?php
set_file("pagina","objetivos.html");

//Obtengo el objetivo
$consulta=mysql_query("select * from objetivos where id_catedra='$id_catedra'");

//Si no encuentra objetivos, vuelve a la pagina principal
if(!mysql_num_rows($consulta)||!$modulo2Activado){
    set_file('pagina','error.html');
    //Incluyo el codigo para que se genere el menu y la informacion del encabezado
    
    set_var('mensaje','No existen objetivos.');
    parse("bloque","bloque",true);
    pparse("pagina");
    die();
    }

//Muestro el objetivo
$obj=mysql_fetch_array($consulta);
set_var('contenido',$obj['contenido']);
if($obj['nombre_archivo']!=''){
    set_var('bajar',"<img src='img/down.gif' width='10' height='10'>&nbsp;<a href='bajar_objetivos.php?id_catedra=$id_catedra'>Bajar objetivos</a>");
    }else{
    set_var('bajar','');
    }

parse('bloque','bloque',true);
set_var("firma",firma_web());
pparse("pagina");
?>