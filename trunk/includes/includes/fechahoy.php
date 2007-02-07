<? #Establece el dia de la fecha, o sea hoy
$meses = explode(",", "enero,febrero,marzo,abril,mayo,junio,julio,agosto,setiembre,octubre,noviembre,diciembre"); 
$dias = explode(",", "Domingo,Lunes,Martes,Mi&eacute;rcoles,Jueves,Viernes,S&aacute;bado");
# $dias = explode(",", "domingo,lunes,martes,mi&eacute;rcoles,jueves,viernes,s&aacute;bado");
$dia = date("d");
$mes = date("m");
$anio = date("Y");
$wkday = date("w", mktime(0,0,0,$mes,$dia,$anio));
echo $dias[0 + $wkday], " ", $dia, " de ", 
$meses[0 + $mes - 1], " de ", $anio, "\n";
?>
