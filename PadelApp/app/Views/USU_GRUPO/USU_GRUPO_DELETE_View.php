<?php
/*  Archivo php
	Nombre: USUARIOS_GRUPO_DELETE_View.php
	Autor: 	Alejandro Vila
	Fecha de creación: 20/11/2017
	Función: vista de la tabla de borrado(delete) realizada con una clase donde se puede borrar un usuario de un grupo
*/

//es la clase DELETE de USU_GRUPO que nos permite borrar un usuario a un grupo
class USU_GRUPO_DELETE {
//es el constructor de la clase USU_GRUPO_DELETE
	function __construct( $valores ) { 
		$this->valores = $valores;//pasamos los valores de cada uno de los campos
		$this->render( $this->valores );//llamamos a la función render donde se mostrará el formulario DELETE con los campos correspondientes
	}
//se mostrará el formulario DELETE con los campos correspondientes
	function render( $valores ) { 
		$this->valores = $valores;//pasamos los valores de cada uno de los campos
		include '../Locales/Strings_' . $_SESSION[ 'idioma' ] . '.php';//incluimos los strings de idiomas, para que la página pueda estar en español,inglés y galego
		include '../Views/Header.php';//incluimos la cabecera
?>
		<div class="seccion">
			<h2>
				<?php echo $strings['Tabla de borrado'];?>
			</h2>
			<table>
				<tr>
					<th>
						<?php echo $strings['Usuario'];?>
					</th>
					<td>
						<?php echo $this->valores['login']?>
					</td>
				</tr>
				<tr>
					<th>
						<?php echo $strings['NombreGrupo'];?>
					</th>
					<td>
						<?php echo $this->valores['NombreGrupo']?>
					</td>
				</tr>
			</table>
			<p style="text-align:center;">
				<?php echo $strings['¿Está seguro de que quiere borrar esta tupla de la tabla?'];?>
			</p>
			<form action="../Controllers/USU_GRUPO_CONTROLLER.php" method="post" style="display: inline">
				<input type="hidden" name="login" value="<?php echo $this->valores['login'] ?>" />
				<input type="hidden" name="IdGrupo" value="<?php echo $this->valores['IdGrupo'] ?>" />
				<button type="submit" name="action" value="DELETE" ><img src="../Views/icon/confirmar.png" alt="<?php echo $strings['Confirmar'] ?>"/></button>
			</form>
			<form action='../Controllers/USU_GRUPO_CONTROLLER.php' method="post" style="display: inline">
				<input type="hidden" name="login" value="<?php echo $this->valores['login'] ?>">
				<button type="submit"><img src="../Views/icon/cancelar.png" alt="<?php echo $strings['Atras'] ?>"/></button>
			</form>
		</div>
<?php
		include '../Views/Footer.php';//incluimos el pie de la página
	}
}

?>