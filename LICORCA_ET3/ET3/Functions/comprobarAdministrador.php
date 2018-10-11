<?php

/*	
	Autor:	Alejandro Vila
	Fecha de creación: 22/11/2017 
	Este fichero lo que hace es comprobar si es administrador un login que se pasa
*/
include_once '../Functions/BdAdmin.php';//permite conexión a la base de datos
include_once '../Models/USU_GRUPO_MODEL.php';//incluye el contenido del modelo USU_GRUPO

//Esta función comprueba  si el login que se pasa como parámetro es administrador
function comprobarAdministrador($login){
	
	
	$ADMIN = new USU_GRUPO($login,'');//instanciamos un objeto del modelo USU_GRUPO.
	
	return $ADMIN->comprobarAdmin();//comprobamos si ese login es administrador llamando a la función comprobarAdmin del modelo USU_GRUPO
} //end of function comprobarAdministrador()
?>