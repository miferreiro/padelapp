<?php
/* 
	Fecha de creación: 2/12/2017 
	Función: vista de la tabla de vista en detalle(showcurrent) realizada con una clase donde se muestran todos los datos de una historia
    Autor:Brais Santos
*/



//es la clase SHOWCURRENT de HISTORIA que nos permite mostrar la vista en detalle de una historia
class HISTORIA_SHOWCURRENT {
//es el constructor de la clase HISTORIA_SHOWCURRENT
	function __construct( $lista ) { 
		$this->lista = $lista;//pasamos cada uno de los campos de la tabla
		$this->render( $this->lista );//llamamos a la función render donde se mostrará el formulario SHOWALL con los campos correspondientes y sus valores correspondientes
	}
 //funcion que  mostrará el formulario SHOWALL con los campos correspondientes y sus valores correspondientes
	function render( $lista ) {
		$this->lista = $lista;//pasamos cada uno de los campos de la tabla
		include '../Locales/Strings_' . $_SESSION[ 'idioma' ] . '.php';//incluimos los strings de idiomas, para que la página pueda estar en español,inglés y galego
		include '../Views/Header.php';//incluimos la cabecera
?>
		<h2>
			<?php echo $strings['Vista detallada'];?>
		</h2>
		<table class="tablaDatos">
			<tr>
				<th>
					<?php echo $strings['IdTrabajo'];?>
				</th>
				<td>
					<?php echo $this->lista['IdTrabajo'] ?>
				</td>
			</tr>
			<tr>
				<th>
					<?php echo $strings['IdHistoria'];?>
				</th>
				<td>
					<?php echo $this->lista['IdHistoria'] ?>
				</td>
			</tr>
            
            <tr>
				<th>
					<?php echo $strings['TextoHistoria'];?>
				</th>
				<td>
					<?php echo $this->lista['TextoHistoria'] ?>
				</td>
			</tr>

		
			<caption style="margin-top:10px;" align="bottom">
				<form action='../Controllers/HISTORIA_CONTROLLER.php' method="post">
					<button type="submit"><img src="../Views/icon/atras.png" alt="<?php echo $strings['Atras'] ?>" /></button>
				</form>
			</caption>
		</table>

<?php
		include '../Views/Footer.php';//incluimos el pie de la página
	}
}
?>