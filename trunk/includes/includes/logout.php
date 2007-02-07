<?
	// Cargamos variables
	require ("/domain/web/w/w/l/i/www.litoral.com.ar/htdocs/pruebas/autentificator/aut_config.inc.php");

	// iniciamos sesiones
	session_start();
	// destruimos la session de usuarios y variables usadas.
	session_name($usuarios_sesion);
	session_unset();
	session_destroy();
?>

<html>
<head>
<title>intitulado</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
</head>
Ud. ha salido del &aacute;rea de administración <br>
</body>
</html>
