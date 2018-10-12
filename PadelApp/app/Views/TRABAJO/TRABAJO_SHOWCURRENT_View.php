<?php
/*  Archivo php
	Nombre: TRABAJO_SHOWCURRENT_View.php
	Autor: 	Brais Rodríguez Martínez
	Fecha de creación: 27/11/2017 
	Función: vista de la tabla de vista en detalle(showcurrent) realizada con una clase donde se muestran todos los datos de un trabajo
*/

//es la clase SHOWCURRENT de TRABAJO que nos permite mostrar una vista detallada de un trabajo
class TRABAJO_SHOWCURRENT {
	//es el constructor de la clase TRABAJO_SHOWCURRENT
	function __construct( $lista ) {
		$this->lista = $lista;//pasamos los valores de cada uno de los campos
		$this->render( $this->lista );//llamamos a la función render donde se mostrará el formulario SHOWCURRENT con los campos correspondientes y sus valores
	}
	//funcion que mostrará la vista SHOWCURRENT con los campos correspondientes y sus valores
	function render( $lista ) {
		$this->lista = $lista;
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
					<?php echo $strings['NombreTrabajo'];?>
				</th>
				<td>
					<?php echo $this->lista['NombreTrabajo'] ?>
				</td>
			</tr>
			<tr>
				<th>
					<?php echo $strings['FechaIniTrabajo'];?>
				</th>
				<td>
					<?php echo $this->lista['FechaIniTrabajo'] ?>
				</td>
			</tr>
            
            <tr>
				<th>
					<?php echo $strings['FechaFinTrabajo'];?>
				</th>
				<td>
					<?php echo $this->lista['FechaFinTrabajo'] ?>
				</td>
			</tr>
            
            
             <tr>
				<th>
					<?php echo $strings['PorcentajeNota'];?>
				</th>
				<td>
					<?php echo $this->lista['PorcentajeNota'] ?>
				</td>
			</tr>
			
			<caption style="margin-top:10px;" align="bottom">
				<form action='../Controllers/TRABAJO_CONTROLLER.php' method="post">
					<button type="submit"><img src="../Views/icon/atras.png" alt="<?php echo $strings['Atras'] ?>" /></button>
				</form>
			</caption>
		</table>

<?php
		include '../Views/Footer.php';//incluimos el pie de la página
	}
}
?>