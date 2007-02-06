<?php
set_file("pagina","consultas_alta.html");

//Me aseguro de setear la comision que venga el id_comision


//Selecciono todas las comisiones de la catedra
$cons=mysql_query("select * from consultas_tema where id_catedra='$id_catedra'");


//Muestro los temas
while($tema=mysql_fetch_array($cons)){
		set_var('mensaje',$mensaje);
        set_var('valoropcion',$tema['id_tema']);
        set_var('nombreopcion',$tema['nombre']);
        if($vf_tema==$tema['id_tema']){
            set_var('selected','selected');
            }else{
            set_var('selected','');
            }
        parse("bloquetema","bloquetema",true);
        }



set_var('idc',$id_catedra);
set_var("firma",firma_web());
set_var("consulta", "");
set_var('catedra',$id_catedra);
parse("datos","datos");
pparse("pagina");
?>