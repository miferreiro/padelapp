 <?php

session_start();

include './Functions/Authentication.php';

if (!IsAuthenticated()){
	header('Location:./Controllers/DEFAULT_Controller.php');
}
else{
	header('Location:./Controllers/Index_Controller.php');
}

?>  