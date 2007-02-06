<?php
include ("seguridad_intranet.php");
session_unregister ("vs_id_catedra");
session_unset();
session_destroy();
header("Location:index.php");
die();
?>