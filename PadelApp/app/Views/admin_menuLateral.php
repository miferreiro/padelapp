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
		<?php if (isset($_SESSION['login']) & isset($_SESSION['tipo'])) { 
//Si el usuario tiene permisos de showall en gestión de usuarios se muestra la opción ?>
		<?php if($_SESSION['tipo'] == 'Admin'){ ?>
		<li>
			<a href="../Controllers/USUARIO_CONTROLLER.php" class="primerNivel"><?php echo $strings['Gestion de usuarios']; ?></a>
		</li>
		<?php }
 ?>
		<?php } ?>
				<?php if (isset($_SESSION['login']) & isset($_SESSION['tipo'])) { 
//Si el usuario tiene permisos de showall en gestión de usuarios se muestra la opción ?>
		<?php if($_SESSION['tipo'] == 'Admin'){ ?>
		<li>
			<a href="../Controllers/PISTA_CONTROLLER.php" class="primerNivel"><?php echo 'Gestion de pistas' ?></a>
		</li>
		<?php }
 ?>
		<?php } ?>
	</ul>
</nav>