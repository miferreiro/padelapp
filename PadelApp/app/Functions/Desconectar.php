<?php
/*
	
	Autor: 	Miguel Ferreiro
	Fecha de creación: 9/10/2017 
	Función: realiza la desconexión de la sesión
*/
session_start();//iniciamos la sesión
session_destroy();//destruimos la sesión
header('Location:../index.php');//redirigimos al inicio de la página

?>
