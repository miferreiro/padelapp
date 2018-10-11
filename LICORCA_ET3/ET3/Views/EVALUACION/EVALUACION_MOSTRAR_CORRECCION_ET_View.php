<?php
/* 
	Fecha de creación: 7/12/2017 
    Autor:Brais Santos
	Función: Esta función sirve para mostrar todas las entregas de un usuario
*/
//Clase Correcion_entrega que almacena el contenido de la vista entrega necesaria para que el usuario suba la entrega
class CORRECION_ENTREGA {
	//Contrutor de la clase
	function __construct( $lista, $datos) {
		$this->lista = $lista;//Variable que almacena el array de atributos a mostrar
		$this->datos = $datos;//Variable que almacena el recordset de la base de datos con la info de las correciones
		$this->render($this->lista,$this->datos);//Metodo que llama a la función render que contiene todo el código de la vista
	}
	//Funcion que contiene el códido de la vista
	function render($lista,$datos){
		$this->lista = $lista;//Variable que almacena el array de atributos a mostrar
		$this->datos = $datos;//Variable que almacena el recordset de la base de datos con la info de las correciones
		include '../Locales/Strings_' . $_SESSION[ 'idioma' ] . '.php';//Incluye el contenido de los strings necesario para multiidioma
		include '../Views/Header.php';//Incluye el contenido del header
?>
		<div class="seccion">
			<h2>
				<?php echo $strings['Ver los resultados de las entregas'];?>
			</h2>
			<table>
				<tr>
<?php
					
?>
					<th>
						<?php echo $strings['login']?>
					</th>
                    
					<th>
						<?php echo $strings['NombreTrabajo']?>
					</th>
<?php
					
?>
					<th colspan="3" >
						<?php echo $strings['Opciones']?>
					</th>
				</tr>
<?php
				//Bucle que recorre todo el recordset y pasa el recordset a un array para mostrar sus valores
				while ( $fila = mysqli_fetch_array( $this->datos ) ) {
?>
				<tr>
<?php
			
?>
                    <!-- Muestra los valores de login -->
				    <td><?php echo $fila[0] ?></td>
				     <!-- Muestra los valores de IdTrabajo -->
                    <td><?php echo $fila[2] ?></td>
                    
						<form action="../Controllers/EVALUACION_CONTROLLER.php" method="get" style="display:inline" >
                            <input type="hidden" name="IdTrabajo" value="<?php echo $fila['IdTrabajo']; ?>">
                            <input type="hidden" name="Entrega" value="<?php echo $fila[2]; ?>">
                            <input type="hidden" name="login" value="<?php echo $fila['login']; ?>">
							<td>
                                <button type="submit" name="action" value="RESULTADOS_ENTREGAS" ><img src="../Views/icon/flecha.png" alt="<?php echo $strings['Ver en detalle']?>" width="20" height="20"/></button>
                            </td>
						</form>

				</tr>
<?php
				}
?>
			</table>
			<form action='../Controllers/EVALUACION_CONTROLLER.php?action=MOSTRAR_CORRECCION_ET' method="post">
				<button type="submit" ><img src="../Views/icon/atras.png" alt="<?php echo $strings['Atras']?>" /></button>
			</form>
		</div>
<?php
		include '../Views/Footer.php';
		}
		}
?>