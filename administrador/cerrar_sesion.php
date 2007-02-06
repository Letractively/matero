<?php
include ("seguridad_intranet.php");
session_unset();
session_destroy();
header("Location:index.php");
die();
?>