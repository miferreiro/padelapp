<?php

session_start();
include_once '../Locales/Strings_'.$_SESSION['idioma'].'.php';

if(!isset($_POST['login'])){
	include '../Views/REGISTRO_View.php';
	$register = new Register();
}
else{
		
	include '../Models/USUARIO_MODEL.php';
	
	$usuario = new USUARIO_MODEL($_REQUEST['login'],$_REQUEST['password'],$_REQUEST['Dni'],$_REQUEST['nombre'],$_REQUEST['apellidos'],$_REQUEST['telefono'],$_REQUEST['sexo'],$_REQUEST['email'],'Deportista');
	
	$respuesta = $usuario->Register();

	if ($respuesta == 'true'){
			$respuesta = $usuario->ADD();

		include '../Views/MESSAGE_View.php';
		new MESSAGE($respuesta, '../index.php');
	}
	else{

		include '../Views/MESSAGE_View.php';
		new MESSAGE($respuesta, '../index.php');
	}

}

?>

