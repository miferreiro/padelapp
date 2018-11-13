<?php

session_start();
if(!isset($_REQUEST['login']) && !(isset($_REQUEST['password']))){
	
	include '../Views/LOGIN_View.php';
	$login = new Login();
}
else{
	include '../Functions/BdAdmin.php';

	include '../Models/USUARIO_MODEL.php';
	$usuario = new USUARIO_MODEL($_REQUEST['login'],$_REQUEST['password'], '', '', '', '', '', '','');
	$respuesta = $usuario->login();

	if ($respuesta == 'true'){
		$_SESSION['login'] = $_REQUEST['login'];	
		$_SESSION['tipo'] = $usuario->obtenerTipo();
		$_SESSION['dni'] = $usuario->obtenerDni();
		header('Location:../Controllers/DEFAULT_CONTROLLER.php');
	}
	else{
	
		//Incluye la vista de mensaje
		include '../Views/MESSAGE_View.php';
		//Vista de mensaje con la respuesta y ruta de vuelta atras
		new MESSAGE($respuesta, '../Controllers/Login_Controller.php');
	}

}

?>

