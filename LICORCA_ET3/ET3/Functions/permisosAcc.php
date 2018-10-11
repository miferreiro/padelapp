<?php

/*	Archivo php
	Nombre: permisosAcc.php
	Autor:	Alejandro Vila
	Fecha de creación: 6/12/2017 
	Función: Esta función valida si existen los permisos para la accion de la funcionalidad indicada.
*/
include_once '../Functions/BdAdmin.php';//permite conexión a la base de datos
include_once '../Models/USU_GRUPO_MODEL.php';//incluye el contenido del modelo USU_GRUPO
include_once '../Models/PERMISO_MODEL.php';//incluye el contenido  de PERMISO_MODEL

//Esta función nos permite saber que dado un login,funcionalidad y accion que permisos tiene.
function permisosAcc( $login, $funcionalidad, $accion ) {
	$ADMIN = new USU_GRUPO( $login, '' );//instanciamos un objeto del modelo USU_GRUPO

	if ( !$ADMIN->comprobarAdmin() ) {//mira si no es administrador el login pasado
		$PERMISO = new PERMISO_MODEL( '', $funcionalidad, $accion,'','','' );//instanciamos un objeto del modelo PERMISO_MODEL
		return $PERMISO->comprobarPermisos( $login );//devolvemos los permisos que tiene ese login

	} else {//si es administrador devolvemos true
		return true;
	}
} //end of function permisosAcc()
?>