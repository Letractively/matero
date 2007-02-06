<?php
//Valido que venga el id_final
if(empty($id_final)){
    set_file('pagina','error_grave.html');
    set_var('mensaje','Error de parámetros');
    set_var('donde','error_grave.php');
    parse("bloque","bloque",true);
    pparse("pagina");
    die();
    }

set_file("pagina","ver_notas.html");

//Incluyo el codigo para que se genere el menu y la informacion del encabezado


//Obtengo las notas del final
$consulta=mysql_query("select examen_final_notas.*, alumno.*
                       from examen_final_notas, alumno, examen_final
                       where examen_final_notas.id_examen_final=$id_final
                       and examen_final.id_examen_final=examen_final_notas.id_examen_final
                       and examen_final.id_catedra=$id_catedra
                       and alumno.lib_univ=examen_final_notas.id_alumno
                       order by alumno.apellido, alumno.nombre");

//Si no encuentran notas, vuelve a la pagina de examenes
if(!mysql_num_rows($consulta)||!$modulo6Activado){
    set_file('pagina','error.html');
    //Incluyo el codigo para que se genere el menu y la informacion del encabezado
    
    set_var('mensaje','No se cargaron las notas.');
    parse("bloque","bloque",true);
    pparse("pagina");
    die();
    }

//Muestro las notas
while($nota=mysql_fetch_array($consulta)){
       set_var('lu',$nota['lib_univ']);
    //   set_var('dni',$nota['dni']);	   
       set_var('alumno',$nota['apellido'].', '.$nota['nombre']);

       if($nota['nota']!=''){
           set_var('nota',$nota['nota']);
       }else{
           set_var('nota','&nbsp;');
       }
       if($nota['comentario']!=''){
           set_var('comentario',$nota['comentario']);
       }else{
           set_var('comentario','&nbsp;');
       }
       parse("bloquealumno","bloquealumno",true);
       }


//Obtengo los datos del examen
$consulta2=mysql_query("select * from examen_final where id_examen_final=$id_final and id_catedra=$id_catedra");
$elfinal=mysql_fetch_array($consulta2);

//Seteo del encabezado
set_var('titulo',$elfinal['nombre']);
set_var('comentario',$elfinal['descripcion']);
set_var('fecha',convertir_fecha($elfinal['fecha_examen']));
//set_var('comentario2',$elfinal['descripcion']);
parse('bloque2','bloque2',true);
set_var("firma",firma_web());
pparse("pagina");
?>