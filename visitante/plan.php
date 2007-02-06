<?php
set_file("pagina","plan.html");

//Obtengo el objetivo
$consulta=mysql_query("select * from catedra_plan where id_catedra='$id_catedra'");

//Si no encuentra plan, vuelve a la pagina principal
if(!mysql_num_rows($consulta)||!$modulo1Activado){
    set_file('pagina','error.html');
    //Incluyo el codigo para que se genere el menu y la informacion del encabezado

    set_var('mensaje','No existe el plan.');
    parse("bloque","bloque",true);
    pparse("pagina");
    die();
    }

//Muestro el plan
$plan=mysql_fetch_array($consulta);
set_var('contenido',$plan['contenido']);
if($plan['nombre_archivo']!=''){
    set_var('bajar',"<img src='img/down.gif' width='10' height='10'>&nbsp;<a href='bajar_plan.php?id_catedra=".$id_catedra."'>Bajar plan</a>");
    }else{
    set_var('bajar','');
    }

//Seteo para el boton volver
set_var('idc',$id_catedra);
parse('bloque','bloque',true);
set_var("firma",firma_web());
pparse("pagina");
?>