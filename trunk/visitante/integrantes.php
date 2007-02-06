<?php
set_file("pagina","profesores.html");

//Obtengo los profesores de la materia
$consulta=mysql_query("select * from profesor where id_catedra=$id_catedra order by posicion asc");

//Si no encuentra profesores, vuelve a la pagina principal
if(!mysql_num_rows($consulta)||!$modulo3Activado){
    set_file('pagina','error.html');
    //Incluyo el codigo para que se genere el menu y la informacion del encabezado
    
    set_var('mensaje','No existen docentes.');
    parse("bloque","bloque",true);
    pparse("pagina");
    die();
    }

//Muestro los profesores
while($prof=mysql_fetch_array($consulta)){
       set_var('apellido',$prof['apellido']);
       set_var('nombre',$prof['nombre']);
       set_var('cargo',$prof['cargo']);
       if($prof['email']!=''){
           set_var('email',"<a href='mailto:".$prof['email']."'>".$prof['email']."</a>");
       }else{
           set_var('email','&nbsp;');
       }
       parse("bloqueprofesor","bloqueprofesor",true);
       }
set_var("firma",firma_web());
pparse("pagina");
?>