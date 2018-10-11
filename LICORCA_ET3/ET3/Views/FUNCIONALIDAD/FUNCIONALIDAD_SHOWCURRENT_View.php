<?php
/*  Archivo php
	Nombre: FUNCIONALIDAD_SHOWCURRENT_View.php
	Autor: 	Brais Rodríguez
	Fecha de creación: 22/11/2017  
	Función: vista de la tabla de vista en detalle(showcurrent) realizada con una clase donde se muestran todos los datos de una Funcionalidad
*/

//es la clase SHOWCURRENT de FUNCIONALIDAD que nos permite mostrar todas funcionalidades
class FUNCIONALIDAD_SHOWCURRENT {
 //es el constructor de la clase FUNCIONALIDAD_SHOWCURRENT
	function __construct( $lista ) {
		$this->lista = $lista;//pasamos los campos de la tabla FUNCIONALIDAD
		$this->render( $this->lista );//llamamos a la función render donde se mostrará el formulario showcurrent con los campos correspondientes
	}
//funcion donde se mostrará el formulario showcurrent con los campos correspondientes
	function render( $lista ) { 
		$this->lista = $lista;//pasamos los campos de la tabla FUNCIONALIDAD
		include '../Locales/Strings_' . $_SESSION[ 'idioma' ] . '.php';//incluimos los strings de idiomas, para que la página pueda estar en español,inglés y galego
		include '../Views/Header.php';//incluimos la cabecera
?>
		<h2>
			<?php echo $strings['Vista detallada'];?>
		</h2>
		<table class="tablaDatos">
			<tr>
				<th>
					<?php echo $strings['IdFuncionalidad'];?>
				</th>
				<td>
					<?php echo $this->lista['IdFuncionalidad'] ?>
				</td>
			</tr>
	
			<tr>
				<th>
					<?php echo $strings['NombreFuncionalidad'];?>
				</th>
				<td>
					<?php echo $this->lista['NombreFuncionalidad'] ?>
				</td>
			</tr>
			<tr>
				<th>
					<?php echo $strings['DescripFuncionalidad'];?>
				</th>
				<td>
					<?php echo $this->lista['DescripFuncionalidad'] ?>
				</td>
			</tr>
			
			<caption style="margin-top:10px;" align="bottom">
				<form action='../Controllers/FUNCIONALIDAD_CONTROLLER.php' method="post">
					<button type="submit"><img src="../Views/icon/atras.png" alt="<?php echo $strings['Atras'] ?>" /></button>
				</form>
			</caption>
		</table>

<?php
		include '../Views/Footer.php';//incluimos el pie de la página
	}
}
?>