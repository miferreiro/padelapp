<!--
Archivo php
Nombre: users_menuLateral . php
Autor: Alejandro Vila Cid
Fecha de creación: 23 / 11 / 2017
Función: contiene todas las características del menú lateral
	-->
	<?php
include_once '../Functions/permisosAcc.php';//incluye la función permisosAcc
include_once '../Functions/comprobarAdministrador.php';//incluye la funcion comprobarAdministrador

?>
<nav>
	<ul class="menu">
		<!-- Si hay un usuario logeado (Variable de sesion login con valor) ejecuta el código dento del if
que comprueba permisos para cada una de las acciones -->
		<?php if (isset($_SESSION['login'])) { 
//Si el usuario tiene permisos de showall en gestión de usuarios se muestra la opción ?>
		<?php if((permisosAcc($_SESSION['login'],1,5)==true)){ ?>
		<li>
			<a href="../Controllers/USUARIO_CONTROLLER.php" class="primerNivel"><?php echo $strings['Gestion de usuarios']; ?></a>
		</li>

		<?php }
//Si el usuario tiene permisos de showall en gestión de grupos se muestra la opción
	if((permisosAcc($_SESSION['login'],2,5)==true)){ ?>
		<li>
			<a href="../Controllers/GRUPO_CONTROLLER.php" class="primerNivel"><?php echo $strings['Gestion de grupo']; ?></a>
		</li>
		<?php }
//Si el usuario tiene permisos de showall en gestión de permisos se muestra la opción
	if((permisosAcc($_SESSION['login'],5,5)==true)){ ?>
		<li>
			<a href="../Controllers/PERMISO_CONTROLLER.php" class="primerNivel"><?php echo $strings['Gestión de permisos']; ?></a>
		</li>
		<?php }
//Si el usuario tiene permisos de showall en gestión de ufuncionalidades se muestra la opción
	if((permisosAcc($_SESSION['login'],3,5)==true)){ ?>
		<li>
			<a href="../Controllers/FUNCIONALIDAD_CONTROLLER.php" class="primerNivel"><?php echo $strings['Gestion de funcionalidades']; ?></a>
		</li>
		<?php }
//Si el usuario tiene permisos de showall en gestión de acciones se muestra la opción
	if((permisosAcc($_SESSION['login'],4,5)==true)){ ?>
		<li>
			<a href="../Controllers/ACCION_CONTROLLER.php" class="primerNivel"><?php echo $strings['Gestion de acciones']; ?></a>
		</li>
		<?php }

 ?>

		<?php } ?>
	</ul>
</nav>