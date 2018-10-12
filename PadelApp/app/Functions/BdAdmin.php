<?php

/*
	Autor: 	Miguel Ferreiro
	Fecha de creación: 9/10/2017 
	Función: realiza la conexión a la base de datos. Es el único lugar donde se definen los parametros de conexión a la bd
*/

//Esta función es la que se va a conectar y por lo tanto podremos hacer todo tipo de operaciones
function ConectarBD() 
	{
		// se ejecuta la función de conexión mysqli y se recoge el manejador
	    $mysqli = new mysqli("localhost", "userET3", "passET3", "IUET32017"); //maquina, user, pass, bd
		// si hay error en la conexión se muestra el mensaje de error
		if ($mysqli->connect_errno) {
			echo "Fallo al conectar a MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;//muestra mensaje de error
			return false;
		}
		// la función devuelve el manejador
		return $mysqli;
	}
?>