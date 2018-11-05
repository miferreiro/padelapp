
<?php
	session_start();

	include '../Views/DEFAULT_View.php';
	include '../Functions/ActualizarPistas.php';
    ActualizarPistas();
	$USUARIO_DEFAULT = new USUARIO_DEFAULT();
		
?>