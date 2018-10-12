<?php
/*
	Archivo php
	Nombre: Header.php
	Autor: 	Miguel Ferreiro
	Fecha de creación: 23/10/2017 
	Función: contiene todas las características del header
*/
	include_once '../Functions/Authentication.php';//incluimos este fichero para mirar si el usuario esta auteneticado
	if (!isset($_SESSION['idioma'])) { //miramos si existe algún idioma
		$_SESSION['idioma'] = 'SPANISH';//si no existe ponemos por defecto el español

	}
	include '../Locales/Strings_' . $_SESSION['idioma'] . '.php';//incluimos todos los strings de los idiomas:ingles,español y galego
?>
<!doctype html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<script type="text/javascript" src="../Views/js/md5.js"></script>
	<link rel="stylesheet" type="text/css" media="screen" href="../Views/css/estilos.css" hreflang="es">
	<link rel="stylesheet" type="text/css" media="screen" href="../Views/js/tcal/tcal.css" hreflang="es">
	<script language="JavaScript" type="text/javascript" src="../Views/js/tcal/tcal.js"></script>
	<?php include '../Views/js/validaciones.js' ?>
	<title>ET3</title>
</head>
<body>
 <header>
	<p style="text-align:center">
		<h1>
<?php
			echo $strings['Portal de Gestión'];
?>
		</h1>
	</p>
<?php	
	if (IsAuthenticated()){ //miramos si el usuario esta autenticado
?>
		<p style="font-size:20px; ">
<?php
			echo $strings['Usuario'] . ' : ' . $_SESSION['login'] . '<br>';
?>	
			<a href="../Functions/Desconectar.php" style="text-decoration:none"> <img src="../Views/icon/desconexion.png" width="32" height="32" alt="<?php echo $strings['Desconectarse']?>" style="float:right;"></a>
	
		</p>
<?php
	} else { //si no esta autenticado se muestra en un mensaje indicandolo
		
			echo $strings['Usuario no identificado'];
?> 
		<a href = '../Controllers/Registro_Controller.php' ><img src="../Views/icon/registrarse.png" alt="<?php echo $strings['Registrar']?>" /></a>
<?php		
	}
?>
		
	<form name='idiomform' action="../Functions/CambioIdioma.php" method="post">
		<?php echo $strings['idioma']; ?>
		<button type="submit"  name="idioma" value="SPANISH" ><img src="../Views/icon/banderaEspaña.jpg" alt="<?php echo $strings['Cambiar idioma a español']?>" width="32" height="20" style="display: block;"/></button>
		<button type="submit"  name="idioma" value="ENGLISH" ><img src="../Views/icon/banderaReinoUnido.png" alt="<?php echo $strings['Cambiar idioma a inglés']?>" width="32" height="20" style="display: block;"/></button>
		<button type="submit"  name="idioma" value="GALLEGO" ><img src="../Views/icon/banderaGalicia.png" alt="<?php echo $strings['Cambiar idioma a gallego']?>" width="32" height="20" style="display: block;"/></button>
	</form>	
</header>
<div id = 'main'>   
<?php
		include '../Views/admin_menuLateral.php';//incluimos el footer
?>  
<article>

     