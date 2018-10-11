<?php
/*  Archivo php
	Nombre: ACCION_SHOWCURRENT_View.php
    Autor: Alejandro Vila
	Fecha de creación: 23/11/2017 
	Función: vista de la tabla de vista en detalle(showcurrent) realizada con una clase donde se muestran todos los datos de una acción
*/


//Es la clase SHOWCURRENT de ACCION que nos permite ver en detalle una accion
class ACCION_SHOWCURRENT {
	//es el constructor de la clase ACCION_SHOWCURRENT
	function __construct( $lista ) { 
		$this->lista = $lista;//pasamos una array con los campos a mostrar
		$this->render( $this->lista );//llamamos a la función render donde se mostrará el formulario SHOWCURRENT con los campos correspondientes
	}
//Función render donde se mostrará el formulario SHOWCURRENT con los campos correspondientes
	function render( $lista ) {
		$this->lista = $lista;//pasamos una array con los campos a mostrar
		include '../Locales/Strings_' . $_SESSION[ 'idioma' ] . '.php';//incluimos los strings de idiomas, para que la página pueda estar en español,inglés y galego
		include '../Views/Header.php';//incluimos la cabecera
?>
		<h2>
			<?php echo $strings['Vista detallada'];?>
		</h2>
		<table class="tablaDatos">
			<tr>
				<th>
					<?php echo $strings['IdAccion'];?>
				</th>
				<td>
					<?php echo $this->lista['IdAccion'] ?>
				</td>
			</tr>
	
			<tr>
				<th>
					<?php echo $strings['NombreAccion'];?>
				</th>
				<td>
					<?php echo $this->lista['NombreAccion'] ?>
				</td>
			</tr>
			<tr>
				<th>
					<?php echo $strings['DescripAccion'];?>
				</th>
				<td>
					<?php echo $this->lista['DescripAccion'] ?>
				</td>
			</tr>
			
			<caption style="margin-top:10px;" align="bottom">
				<form action='../Controllers/ACCION_CONTROLLER.php' method="post">
					<button type="submit"><img src="../Views/icon/atras.png" alt="<?php echo $strings['Atras'] ?>" /></button>
				</form>
			</caption>
		</table>

<?php
		include '../Views/Footer.php';//incluimos el pie de la pagina
	}
}
?>