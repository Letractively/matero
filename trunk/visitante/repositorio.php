<?php
set_file("pagina","repositorio.html");

//Obtengo los item del repositorio
$consulta=mysql_query("select * from repositorio where id_catedra=$id_catedra and publicar=1 order by fecha desc");

//Si no encuentra items, vuelve a la pagina principal
if(!mysql_num_rows($consulta)||!$modulo8Activado){
    set_file('pagina','error.html');
    //Incluyo el codigo para que se genere el menu y la informacion del encabezado
    
    set_var('mensaje','No existen archivos en el repositorio.');
    parse("bloque","bloque",true);
    pparse("pagina");
    die();
    }

//Muestro los items
while($item=mysql_fetch_array($consulta)){
       set_var('titulo',$item['titulo']);
       set_var('descripcion',nl2br($item['descripcion']));
       set_var('fecha',convertir_fecha($item['fecha']));
       if($item['nombre_archivo']!=''){
           set_var('bajar',"<img src='img/down.gif' width='10' height='10'>&nbsp;<a href='bajar_repositorio.php?id_catedra=".$id_catedra."&id_repositorio=".$item['id_repositorio']."'>Bajar</a>");
           }else{
           set_var('bajar','&nbsp;');
           }
       parse("bloquerepositorio","bloquerepositorio",true);
       }
set_var("firma",firma_web());
pparse("pagina");
?>