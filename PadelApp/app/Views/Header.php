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
	
	<meta charset="UTF-8">
	<script type="text/javascript" src="../Views/js/md5.js"></script>
	<link rel="stylesheet" type="text/css" media="screen" href="../Views/css/bootstrap-4.0.0.css" hreflang="es">
	<link rel="stylesheet" type="text/css" media="screen" href="../Views/js/tcal/tcal.css" hreflang="es">
	<script language="JavaScript" type="text/javascript" src="../Views/js/tcal/tcal.js"></script>
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	  <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="../Views/js/jquery-3.2.1.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="../Views/js/popper.min.js"></script>
    <script src="../Views/js/bootstrap-4.0.0.js"></script>
	
	<?php include '../Views/js/validaciones.js' ?>
  <head>
 
    <!-- Bootstrap -->

  </head>
  <body>
	  <header>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
      <div class="container">
		<?php	if (IsAuthenticated()){ //miramos si el usuario esta autenticado ?> 
		<?php 	echo $strings['Usuario'] . ' : ' . $_SESSION['login'] . '<br>'; ?>	
		   </li>
			  <li class="nav-item">
              <a class="nav-link disabled" href="../Functions/Desconectar.php" alt="<?php echo $strings['Desconectarse']?>"/> </a>
            </li>
		  <?php
	} else { //si no esta autenticado se muestra en un mensaje indicandolo
		
			echo $strings['Usuario no identificado'];
?>	  
		  <!--<font color="white">El usuario no está registrado</font> -->
		  
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
          <ul class="navbar-nav mr-auto">
            <li class="nav-item active">
				
				
            	<a class="nav-link" href="../Controllers/Login_Controller.php" /><?php echo $strings['Conectarse']?>
				<!--<span class="sr-only">(current)</span>--></a>
				
            </li>
            <li class="nav-item">
              <a class="nav-link" href="../Controllers/Registro_Controller.php"/><?php echo $strings['Registro']?></a>
            </li>
			  <li class="nav-item">
              <a class="nav-link disabled" href="../Controllers/DEFAULT_CONTROLLER.php"/><?php echo $strings['Atras']?></a>
            </li>
<?php		
	}
?>			<li>
			<nav>
	
		<!-- Si hay un usuario logeado (Variable de sesion login con valor) ejecuta el código dento del if
que comprueba permisos para cada una de las acciones -->
	<?php if (isset($_SESSION['login'])) { 
//Si el usuario tiene permisos de showall en gestión de usuarios se muestra la opción ?>
		<li>
			<a href="../Controllers/USUARIO_CONTROLLER.php" class="primerNivel"/><?php echo $strings['Gestion de usuarios']?></a>
		</li>

		<?php } ?>
				<?php if (isset($_SESSION['login']) & isset($_SESSION['tipo'])) { 
//Si el usuario tiene permisos de showall en gestión de usuarios se muestra la opción ?>
		<?php if($_SESSION['tipo'] == 'Admin'){ ?>
		<li>
			<a href="../Controllers/PISTA_CONTROLLER.php" class="primerNivel"/><?php echo $strings['Gestión de pistas'] ?></a>
		</li>
		<?php }
 ?>
		<?php } ?>
	
			</nav>
				</li>
            <li class="nav-item dropdown">
			<form name='idiomform' action="../Functions/CambioIdioma.php" method="post">
              <a class="nav-link dropdown-toggle" href="<?php echo $strings['idioma']; ?>" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Idiomas</a>
              <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                <button type="submit"  name="idioma" value="SPANISH" ><a class="dropdown-item"/> <?php echo $strings['Cambiar idioma a español']?></a></button>
				
				  <div class="dropdown-divider"></div>
				
                <button type="submit"  name="idioma" value="ENGLISH" ><a class="dropdown-item"/><?php echo $strings['Cambiar idioma a inglés']?></a></button>

                <div class="dropdown-divider"></div>

                <button type="submit"  name="idioma" value="GALLEGO" ><a class="dropdown-item"/><?php echo $strings['Cambiar idioma a gallego']?></a></button>
              </div>
			</form>
            </li>
          </ul>
          <!--<form class="form-inline my-2 my-lg-0">
            <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search">
            <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
          </form>-->
        </div>
      </div>
</nav>






	  <hr>
	  	<!-- <?php echo $strings['Portal de Gestión']; ?>-->
	  	<div class="titulo"><h1>PADEL APP</h1></div>
	</header>