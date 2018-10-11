<?php
/* 
	Fecha de creación: 7/12/2017 
    Autor:Brais Santos
	Función: muestra todas las QAs de un usuario
*/
//Clase Correcion_qa que almacena el contenido de la vista de correcion qa
class CORRECION_QA {
	//Constructor de la clase
	function __construct( $lista, $datos) {
		$this->lista = $lista;//Variable que almacena el array de atributos a mostrar en la vista
		$this->datos = $datos;//Variable que almacena un recordset de la base datos con info de las correciones
		$this->render($this->lista,$this->datos);//Método que llama a la función render que contiene todo el código de la vista
	}
	//Funcion que contiene el código de la vista
	function render($lista,$datos){
		$this->lista = $lista;//Variable que almacena el array de atributos a mostrar en la vista
		$this->datos = $datos;//Variable que almacena un recordset de la base datos con info de las correciones
		include '../Locales/Strings_' . $_SESSION[ 'idioma' ] . '.php';//Incluye el contenido de los strings necesario para el multiidioma
		include '../Views/Header.php';//incluye el contenido del header
?>
		<div class="seccion">
			<h2>
				<?php echo $strings['Ver los resultados de las QAs'];?>
			</h2>
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
					<th colspan="3" >
						<?php echo $strings['Opciones']?>
					</th>
				</tr>
<?php
				//Bucle que recorre todo el recordset de datos y pasa estos valores a array y los muestra
				while ( $fila = mysqli_fetch_array( $this->datos ) ) {
?>
				<tr>
<?php
					//Bucle que recorre los atributos que estan en el array lista
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
					<td>
						<form action="../Controllers/EVALUACION_CONTROLLER.php" method="get" style="display:inline" >
                            <input type="hidden" name="IdTrabajo" value="<?php echo $fila['IdTrabajo']; ?>">
							<td>
                                <button type="submit" name="action" value="RESULTADO_QA" ><img src="../Views/icon/flecha.png" alt="<?php echo $strings['Ver en detalle']?>" width="20" height="20"/></button>
                            </td>
						</form>

				</tr>
<?php
				}
?>
			</table>
			<form action='../Controllers/EVALUACION_CONTROLLER.php?action=MOSTRAR_CORRECCION_QA' method="post">
				<button type="submit"><img src="../Views/icon/atras.png" alt="<?php echo $strings['Atras']?>" /></button>
			</form>
		</div>
<?php
		include '../Views/Footer.php';
		}
		}
?>