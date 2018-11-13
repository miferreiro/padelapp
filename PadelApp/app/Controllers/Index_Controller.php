<?php

session_start();
include '../Functions/Authentication.php';
if (!IsAuthenticated()){
	header('Location: ../index.php');
}
else{
	include '../Views/users_index_View.php';//incluimos esa vista
	new Index();
}

?>