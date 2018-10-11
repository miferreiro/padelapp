<?php
/*  Archivo php
	Nombre: GRUPO_SHOWCURRENT_View.php
	Autor: 	Alejandro Vila
	Fecha de creación: 21/11/2017 
	Función: vista de la tabla de vista en detalle(showcurrent) realizada con una clase donde se muestran todos los datos de un grupo
*/
//Clase Grupo_showcurrent que contiene la vista para ver una tupla de grupo en detalle
class GRUPO_SHOWCURRENT {

	//Constructor de la clase
	function __construct( $lista, $datos, $datos2) {
		$this->lista = $lista;//Variable que contiene el array de los atributos a mostrar en la vista
		$this->datos = $datos;//Variable que contiene la información de la tupla a ver
		$this->datos2 = $datos2;//Variable que contiene la información de la tupla a ver
		$this->render($this->lista,$this->datos,$this->datos2);
	}
	//metodo que llama a la función render que contiene todo el código de la vist
	function render($lista,$datos,$datos2){
		$this->lista = $lista;//Variable que contiene el array de los atributos a mostrar en la vista
		$this->datos = $datos;//Variable que contiene la información de la tupla a ver
		$this->datos2 = $datos2;//Variable que contiene la información de la tupla a ver
		include '../Locales/Strings_' . $_SESSION[ 'idioma' ] . '.php';//Incluye el contenido de los strings necesarios para el multiidioma
		include '../Views/Header.php';//Incluye el contenido del header
?>
		<div class="seccion">
			<h2>
				<?php echo $strings['Tabla de datos'];?>
			</h2>
			<table>
				<tr>
					<th>
						<?php echo $strings['IdGrupo'];?>
					</th>
					<td>
						<?php echo $this->datos2['IdGrupo']?>
					</td>
				</tr>
				<tr>
					<th>
						<?php echo $strings['NombreGrupo'];?>
					</th>
					<td>
						<?php echo $this->datos2['NombreGrupo']?>
					</td>
				</tr>
				<tr>
					<th>
						<?php echo $strings['DescripGrupo'];?>
					</th>
					<td>
						<?php echo $this->datos2['DescripGrupo']?>
					</td>
				</tr>
	
			</table>
			<br>
			<br>
			
			<table>

				<tr>
<?php
					//bucle que recorre el array de los atributos 
					foreach ( $lista as $atributo ) {
?>
					<th>
						<?php echo $strings[$atributo]?>
					</th>
<?php
					}
?>
				</tr>
<?php
				//Bucle que recorre la info de los datos y pasa estos valores a array y los muestra
				while ( $fila = mysqli_fetch_array( $datos ) ) {
?>
				<tr>
<?php
					
					//bucle que recorre el array de los atributos 
					foreach ( $lista as $atributo ) {
?>
					<td>
<?php 
							//Muestra el valor del array para cada atributo
							echo $fila[ $atributo ];

?>
					</td>
<?php
					}
?>

				</tr>
<?php
				}
?>
			</table>
			<form action='../Controllers/GRUPO_CONTROLLER.php' method="post">
				<button type="submit"><img src="../Views/icon/atras.png" alt="<?php echo $strings['Atras']?>" /></button>
			</form>
		</div>
<?php
		include '../Views/Footer.php';
		}
		}
?>