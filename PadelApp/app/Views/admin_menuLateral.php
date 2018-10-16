<!--
Archivo php
Nombre: users_menuLateral . php
Autor: Alejandro Vila Cid
Fecha de creación: 23 / 11 / 2017
Función: contiene todas las características del menú lateral
	-->
	<?php


?>
<nav>
	<ul class="menu">
		<!-- Si hay un usuario logeado (Variable de sesion login con valor) ejecuta el código dento del if
que comprueba permisos para cada una de las acciones -->
		<?php if (isset($_SESSION['login']) & isset($_SESSION['grupo'])) { 
//Si el usuario tiene permisos de showall en gestión de usuarios se muestra la opción ?>
		<?php if($_SESSION['grupo'] == 'Admin'){ ?>
		<li>
			<a href="../Controllers/USUARIO_CONTROLLER.php" class="primerNivel"><?php echo $strings['Gestion de usuarios']; ?></a>
		</li>

		<?php }
//Si el usuario tiene permisos de showall en gestión de grupos se muestra la opción
	if($_SESSION['grupo'] == 'Admin'){ ?>
		<li>
			<a href="../Controllers/GRUPO_CONTROLLER.php" class="primerNivel"><?php echo $strings['Gestion de grupo']; ?></a>
		</li>
		<?php }


 ?>

		<?php } ?>
	</ul>
</nav>