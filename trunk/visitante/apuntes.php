<?php
set_file("pagina","apuntes.html");

//Obtengo los apuntes de la materia
$consulta=mysql_query("select * from apuntes where id_catedra=$id_catedra and publicar=1 order by posicion asc,fecha desc,titulo asc");

//Si no encuentra apuntes, vuelve a la pagina principal
if(!mysql_num_rows($consulta)||!$modulo4Activado){
    set_file('pagina','error.html');
    //Incluyo el codigo para que se genere el menu y la informacion del encabezado
    
    set_var('mensaje','No existen apuntes.');
    parse("bloque","bloque",true);
    pparse("pagina");
    die();
    }

//Muestro los apuntes
while($apunte=mysql_fetch_array($consulta)){
       set_var('titulo',$apunte['titulo']);
       set_var('descripcion',$apunte['descripcion']);
       set_var('fecha',convertir_fecha($apunte['fecha']));
       if($apunte['nombre_archivo']!=''){
           set_var('bajar',"<img src='img/down.gif' width='10' height='10'>&nbsp;<a href='bajar_apunte.php?id_catedra=".$id_catedra."&id_apunte=".$apunte['id_apuntes']."'>Bajar</a>");
           }else{
           set_var('bajar','&nbsp;');
           }
       parse("bloqueapunte","bloqueapunte",true);
       }

set_var("firma",firma_web());
pparse("pagina");
?>