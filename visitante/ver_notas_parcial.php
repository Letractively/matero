<?php



//Valido que venga el id_parcial y el id_comision
if((empty($id_parcial))||(empty($id_comision))){
    set_file('pagina','error_grave.html');
    set_var('mensaje','Error de parámetros');
    set_var('donde','error_grave.php');
    parse("bloque","bloque",true);
    pparse("pagina");
    die();
    }

set_file("pagina","ver_notas_parcial.html");

//Incluyo el codigo para que se genere el menu y la informacion del encabezado


//Obtengo las notas del parcial
$consulta=mysql_query("select examen_parcial_notas.*, alumno.*
                       from examen_parcial_notas, alumno, alumno_comision, examen_parcial, comision, examen_parcial_comision
                       where examen_parcial_notas.id_examen_parcial=$id_parcial
                       and examen_parcial.id_examen_parcial=examen_parcial_notas.id_examen_parcial
                       and examen_parcial.id_examen_parcial=examen_parcial_comision.id_examen_parcial
                       and examen_parcial_comision.id_comision=comision.id_comision
                       and alumno_comision.id_alumno=alumno.lib_univ
                       and alumno_comision.id_comision=comision.id_comision
                       and comision.id_comision=$id_comision
                       and comision.id_catedra=$id_catedra
                       and alumno.lib_univ=examen_parcial_notas.id_alumno
                       order by alumno.apellido, alumno.nombre");

//Si no encuentran notas, vuelve a la pagina de parciales
if(!mysql_num_rows($consulta)||!$modulo11Activado){
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
     //  set_var('dni',$nota['dni']);	   
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


//Obtengo los datos del parcial
$consulta2=mysql_query("select examen_parcial.* from examen_parcial, examen_parcial_comision, comision
                        where examen_parcial.id_examen_parcial=$id_parcial
                        and examen_parcial.id_examen_parcial=examen_parcial_comision.id_examen_parcial
                        and examen_parcial_comision.id_comision=comision.id_comision
                        and comision.id_catedra=$id_catedra");
$elparcial=mysql_fetch_array($consulta2);

//Seteo del encabezado
set_var('titulo',$elparcial['nombre']);
set_var('fecha',convertir_fecha($elparcial['fecha']));
set_var('comentario2',$elparcial['comentario']);
parse('bloque2','bloque2',true);

//Seteo para el boton volver
set_var('idc',$id_catedra);
set_var('idcomision',$id_comision);
parse('bloque','bloque',true);
set_var("firma",firma_web());
pparse("pagina");
?>