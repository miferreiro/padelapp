<?php


function ConectarBD() 
{
		
	    $mysqli = new mysqli("localhost", "user", "pass", "abpbase"); 
		
		if ($mysqli->connect_errno) {
			echo "Fallo al conectar a MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
			return false;
		}
		
		return $mysqli;
}
?>