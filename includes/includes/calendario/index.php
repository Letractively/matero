<?
///////////////////////////////////////////////////////////////////////////////////////////////
//
// Libreria para mostrar un calendario y obtener una fecha
//
// La p�gina que llame a esta libreria debe contener un formulario con tres campos donde se introducir� el d�a el mes y el a�o que se desee
// Para que este calendario pueda actualizar los campos de formulario correctos debe recibir varios datos (por GET)
// formulario (con el nombre del formulario donde estan los campos
// dia (con el nombre del campo donde se colocar� el d�a)
// mes (con el nombre del campo donde se colocar� el mes)
// ano (con el nombre del campo donde se colocar� el a�o)
//
///////////////////////////////////////////////////////////////////////////////////////////////
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<html>
<head>
	<title>Calendario PHP</title>
	<link rel="STYLESHEET" type="text/css" href="estilo.css">
	<script>
		function devuelveFecha(dia,mes,ano){
			// Se encarga de escribir en el formulario adecuado los valores seleccionados
			// tambi�n debe cerrar la ventana del calendario
			// var formulario_destino = '<?echo $_GET["formulario"]?>';
			var formulario_destino = '<?php echo $formulario_destino ?>';
			var dia_destino =        '<?php echo $dia_destino; ?>';
			var mes_destino =        '<?php echo $mes_destino; ?>';
			var ano_destino =        '<?php echo $ano_destino; ?>';
					
			//meto el dia
			//alert(formulario);
			// form y variables deben obtenerse por parametro!!!!
			elDia = "window.opener.document." + formulario_destino + "." + dia_destino + ".value="+dia;
			elMes = "window.opener.document." + formulario_destino + "." + mes_destino + ".value="+mes;
			elAno = "window.opener.document." + formulario_destino + "." + ano_destino + ".value="+ano;
			
			eval(elDia);
			eval(elMes);
			eval(elAno);
			
			window.close()
		}
	</script>
</head>

<body>

<?
// TOMO LOS DATOS QUE RECIBO POR LA url Y LOS COMPONGO PARA PASARLOS EN SUCESIVAS EJECUCIONES DEL CALENDARIO
$parametros_formulario = "formulario=" . $_GET["formulario"] . "&dia_destino=" . $_GET["dia_destino"] . "&mes_destino=" . $_GET["mes_destino"] . "&ano_destino=" . $_GET["ano_destino"];
?>

<div al	ign="center">
<?
require ("calendario.php");
$tiempo_actual = time();
$dia_solo_hoy = date("d",$tiempo_actual);

if (!$_POST && !isset($nuevo_mes) && !isset($nuevo_ano)){
	$mes = date("n", $tiempo_actual);
	$ano = date("Y", $tiempo_actual);
}elseif ($_POST){
	$mes = $nuevo_mes;
	$ano = $nuevo_ano;
}else{
	$mes = $nuevo_mes;
	$ano = $nuevo_ano;
}

/*
 *
 *		if (!$_POST && !isset($_GET["nuevo_mes"]) && !isset($_GET["nuevo_ano"])){
 *			$mes = date("n", $tiempo_actual);
 *			$ano = date("Y", $tiempo_actual);
 *		}elseif ($_POST) {
 *			$mes = $_POST["nuevo_mes"];
 *			$ano = $_POST["nuevo_ano"];
 *		}else{
 *			$mes = $_GET["nuevo_mes"];
 *			$ano = $_GET["nuevo_ano"];
 *		}
 *
 */	

mostrar_calendario($mes,$ano);
formularioCalendario($mes,$ano);
?>
</div>
</body>
</html>