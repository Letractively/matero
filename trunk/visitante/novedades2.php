<?php

set_file("pagina","novedades.html");

//Obtengo las novedades de la materia
$consulta=mysql_query("select * from novedades where id_catedra=$id_catedra order by fecha desc");

//Este codigo esta comentado, ya que se esta utilizando el script de novedades como pagina principal
//de la catedra. Por ello, si no hay novedades, no hay que tirar error, sino que igualmente hay que enviar
//el mensaje de bienvenida. Si despues hacemos un script de inicio, esto hay que descomentarlo.

/*
//Si no encuentra novedades, vuelve a la pagina principal
if(!mysql_num_rows($consulta)){
    set_file('pagina','error.html');
    //Incluyo el codigo para que se genere el menu y la informacion del encabezado
    include('include_menu.php');
    set_var('mensaje','No existen novedades.');
    parse("bloque","bloque",true);
    pparse("pagina");
    die();
    }
*/

//Muestro el nombre de la materia en el mensaje de bienvenida
set_var('materia',strtoupper($lacatedra['nombre']));

//Si no encuentra mensajes oculto las tablas de novedades, si encuentra las muestro
if(!mysql_num_rows($consulta)||!$modulo5Activado){
    set_var('tit','');
    set_var('coment1','<!-- ');
    set_var('coment2',' -->');
    }else{
    set_var('tit','Novedades');
    set_var('coment1','');
    set_var('coment2','');
    //Muestro las novedades
    while($novedad=mysql_fetch_array($consulta)){
       set_var('titulo',$novedad['titulo']);
       set_var('contenido',$novedad['contenido']);
       set_var('fecha',convertir_fecha($novedad['fecha']));
       parse("bloquenovedad","bloquenovedad",true);
       }
    }

parse("bloquecomentario1","bloquecomentario1",true);
parse("bloquecomentario2","bloquecomentario2",true);
parse("bloquetitulo","bloquetitulo",true);

set_var("firma",firma_web());
pparse("pagina");
?>