<?php
/*  
	Autor: 	Brais Santos
	Fecha de creación: 14/12/2017 
	Función: muestra todos los alias que has evaluado en una misma QA
*/
	//Clase Correcion_qa_resultado que contiene la vista para ver los resultados de las correciones qa
class CORRECION_QA_RESULTADO {
	//Constructor de la clase
	function __construct( $lista, $datos) {
		$this->lista = $lista;//Variable que contiene el array de los atributos a mostrar en la vista
		$this->datos = $datos;//Variable que almacena el recordset de la base de datos con la info de los resultados de correción
		$this->render($this->lista,$this->datos);//metodo que llama a la función render que contiene todo el código de la vista
	}
	//Función que contiene el código de la vista
	function render($lista,$datos){
		$this->lista = $lista;//Variable que contiene el array de los atributos a mostrar en la vista
		$this->datos = $datos;//Variable que almacena el recordset de la base de datos con la info de los resultados de correción
		include '../Locales/Strings_' . $_SESSION[ 'idioma' ] . '.php';//Incluye el contenido de los strings necesarios para el multiidioma
		include '../Views/Header.php'; //Incluye el contenido del header
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
					//Bucle que recorre todo  el array de atributos a mostrar
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
                             <input type="hidden" name="LoginEvaluador" value="<?php echo $fila['LoginEvaluador']; ?>">
                             <input type="hidden" name="AliasEvaluado" value="<?php echo $fila['AliasEvaluado']; ?>">
                             <input type="hidden" name="IdTrabajo" value="<?php echo $fila['IdTrabajo']; ?>">
                            
							<td>
                                <button type="submit" name="action" value="RESULTADOS_QAS" ><img src="../Views/icon/flecha.png" alt="<?php echo $strings['Ver en detalle']?>" width="20" height="20"/></button>
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