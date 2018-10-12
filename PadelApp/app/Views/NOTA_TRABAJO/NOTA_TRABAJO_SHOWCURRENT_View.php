<?php
/* 
	Fecha de creación: 4/12/2017 
	Función: vista de la tabla de vista en detalle(showcurrent) realizada con una clase donde se muestran todos los datos de  la nota de un trabajo
    Autor:Brais Santos
    
*/

//es la clase SHOWCURRENT  de NOTA_TRABAJO que nos permite ver en detalle una nota
class NOTA_TRABAJO_SHOWCURRENT {
//es el constructor de la clase  NOTA_TRABAJO_SHOWCURRENT
	function __construct( $lista ) { 
		$this->lista = $lista;//pasamos cada uno de los campos de la tabla
		$this->render( $this->lista );//funcion que mostrará el formulario SHOWCURRENT con los campos correspondientes
	}
//funcion que mostrará el formulario SHOWCURRENT con los campos correspondientes
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
					<?php echo $strings['Usuario'];?>
				</th>
				<td>
					<?php echo $this->lista['login'] ?>
				</td>
			</tr>
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
					<?php echo $strings['Nota del Trabajo'];?>
				</th>
				<td>
					<?php echo $this->lista['NotaTrabajo'] ?>
				</td>
			</tr>
			

			<caption style="margin-top:10px;" align="bottom">
				<form action='../Controllers/NOTA_TRABAJO_CONTROLLER.php' method="post">
					<button type="submit"><img src="../Views/icon/atras.png" alt="<?php echo $strings['Atras'] ?>" /></button>
				</form>
			</caption>
		</table>

<?php
		include '../Views/Footer.php';//incluimos el pie de la página
	}
}
?>