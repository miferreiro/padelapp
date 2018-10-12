<?php
/*  
	Autor: 	Alejandro Vila
	Fecha de creación: 9/10/2017 
	Función: esta vista sirve para qa un usuario evalue a otros
*/
//Clase Evaluación_usuario_evaluar que almacena la vista para que el usuario pueda evaluar
class EVALUACION_USUARIO_EVALUAR {
	//Constructor de Evaluacion_usuario_evaluar
	function __construct( $lista, $datos) {
		$this->lista = $lista;//Variable que almacena el array de atributos a mostrar en esta vista
		$this->datos = $datos;//Variable que almacena el contenido del recorsed de la evaluacion del usuario
		$this->render($this->lista,$this->datos);//Metodo que llama a la función render que tiene todo el código de la vista
	}
	//Funcion que contiene todo el código necesario para mostrar la vista
	function render($lista,$datos){
		$this->lista = $lista;//Variable que almacena el array de atributos a mostrar en esta vista
		$this->datos = $datos;//Variable que almacena el contenido del recorsed de la evaluacion del usuario
		include '../Locales/Strings_' . $_SESSION[ 'idioma' ] . '.php';//Incluye el contenido de strings necesario para el multiidioma
		include_once '../Functions/permisosAcc.php';//Incluye la funcion permisosAcc
		include '../Views/Header.php';//Incluye el contenido del header
?>
		<div class="seccion">
			<h2>
				<?php echo $strings['Tabla de datos'];?>
			</h2>
			<table>
				<tr>
<?php
					//Bucle que recorre todo  el array de atributos a mostrar
					foreach ( $lista as $atributo ) {
?>
					<th>
						<?php echo $strings[$atributo]?>
					</th>
<?php
					}
		//Si el usuario tiene los permisos necesarios habilita la opción de editar 
		if(permisosAcc($_SESSION['login'],12,12)==true){
?>
					<th colspan="3" >
						<?php echo $strings['Opciones']?>
					</th>
<?php } ?>
				</tr>
				<tr><td></td></tr>
				<tr></tr>
<?php
				//Variable que almacena el idHistoria en cada momento para saber cuando cambia y mostrar el nuevo texto historia, se inicializa a un valor que no tendra el id historia
				$his = -100000;
				//Bucle que recorre todo el recordset de la base de datos pasandolo a $fila que almacena ese recordset en forma de array
				while ( $fila = mysqli_fetch_array( $this->datos ) ) {
?>
				<tr>
<?php
					//Cuando la historia cambia muestra el nuevo texto historia
					if ($fila['IdHistoria'] != $his) {
?>
						<td bgcolor="#b59438" colspan="6"><?php echo $fila['IdHistoria'] . ". " . $fila['TextoHistoria']; ?></td>
						<tr></tr>
<?php
					}
					$his = $fila['IdHistoria'];//actualizamos el valor de $his con el id de la sig historia
					//Bucle que recorre todos los atributos indicados para que se muestren
					foreach ( $lista as $atributo ) {
?>
					<td>
<?php 
							//muestra el contenido del array asociativo correspondiente al atributo en ese momento
							echo $fila[ $atributo ];

?>
					</td>
<?php
					}
?>
					<td>
						<form action="../Controllers/EVALUACION_CONTROLLER.php" method="get" style="display:inline" >
							<input type="hidden" name="IdTrabajo" value="<?php echo $fila['IdTrabajo']; ?>">
                            <input type="hidden" name="LoginEvaluador" value="<?php echo $fila['LoginEvaluador']; ?>">
                            <input type="hidden" name="AliasEvaluado" value="<?php echo $fila['AliasEvaluado']; ?>">
                            <input type="hidden" name="IdHistoria" value="<?php echo $fila['IdHistoria']; ?>">
                            <td>
                            <!-- Si tiene permisos habilita el icono para poder editar -->
							<?php if(permisosAcc($_SESSION['login'],12,12)==true){ ?>
								<button type="submit" name="action" value="EDITUSU" ><img src="../Views/icon/modificar.png" alt="<?php echo $strings['Modificar']?>" width="20" height="20" /></button>
			                <?php } ?>
				            </td>
						</form>

				</tr>
<?php
				}
?>
			</table>
			<form action='../Controllers/EVALUACION_CONTROLLER.php' method="get">
				<button type="submit" name="action" value="EVALUACION_HISTORIAS_ASIGNADAS"><img src="../Views/icon/atras.png" alt="<?php echo $strings['Atras']?>" /></button>
			</form>
		</div>
<?php
		include '../Views/Footer.php';
		}
		}
?>