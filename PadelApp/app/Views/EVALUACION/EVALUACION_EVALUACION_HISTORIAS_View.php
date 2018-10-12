<?php
    //Se muestra una tabla SHOWALL con todas las evaluaciones y iconos para añadir,insertar,borrar,buscar y buscar en detalle.
    //Fecha de creación:30/11/2017
    // Autor: Alejandro Vila

//Clase que se utiliza para mostrar todas las qa, utilizada por el administrador y los usuarios con el permiso de evaluar_historias_qas
class EVALUACION_SELECT_ALL_QA {
	//Constructor de Evaluacion_select_all_qa
	function __construct( $lista, $datos) {
		$this->lista = $lista;//Variable que almacena un array de atributos para mostrar en esta vista
		$this->datos = $datos;//Variable que almacena el recordset de la base de datos con los datos de todas la qas
		$this->render($this->lista,$this->datos);//metodo que llama a la función render para mostrar el contenido de la vista
	}
	//Función que contiene el código para mostrar el contenido de la vista
	function render($lista,$datos){
		$this->lista = $lista;//Variable que almacena un array de atributos para mostrar en esta vista
		$this->datos = $datos;//Variable que almacena el recordset de la base de datos con los datos de todas la qas
		include '../Locales/Strings_' . $_SESSION[ 'idioma' ] . '.php';//Incluye los strings de los idiomas para poder realizar el cambio de idoma
		include '../Views/Header.php';//Incluye el contenido de header
		include_once '../Functions/permisosAcc.php';//Incluye la funcion permisosAcc
		include_once '../Functions/comprobarAdministrador.php';//Incluye la función comprobarAdministrador
?>
		<div class="seccion">
			<h2>
				<?php echo $strings['Tabla de datos'];?>
			</h2>
			<table>
				<tr>
<?php
					//Bucle que recorre todos los atributos mostrando el nombre de ese atributo
					foreach ( $lista as $atributo ) {
?>
					<th>
						<?php echo $strings[$atributo]?><!--se muestra todos los campos-->
					</th>
<?php
					}
?>
					<th colspan="2" >
						<?php echo $strings['Opciones']?>
					</th>

				</tr>
<?php
				//Bucle que recorre todos los valores del recordset
				while ( $fila = mysqli_fetch_array( $this->datos ) ) {
?>
				<tr>
<?php
					//Bucle que recorre el array asociativo y mostrando los valores correspondientes a los atributos
					foreach ( $lista as $atributo ) {
?>
					<td>
<?php 
							//si el campo es igual a la ruta para subir el archivo
                            if($atributo == 'Ruta'){
                                ?>
                        
                                <a href="<?php echo $fila[$atributo] ?>"><?php echo $fila[$atributo] ?></a><!--ponemos esa ruta como un enlace -->
                        
                                <?php
                            }
                        else //en caso contrario mostramos el valor de los otros campos
							echo $fila[ $atributo ];//se muestra el valor de todos los campos
?>                      
					</td>
<?php
					}
?>
					<td>
						<form action="../Controllers/EVALUACION_CONTROLLER.php" method="get" style="display:inline" >
							<input type="hidden" name="LoginEvaluado" value="<?php echo $fila['login']; ?>">
                            <input type="hidden" name="IdTrabajo" value="<?php echo $fila['IdTrabajo']; ?>">
                            <input type="hidden" name="AliasEvaluado" value="<?php echo $fila['Alias']; ?>">
                        <td>
								<button type="submit" name="action" value="EVALUARADMIN" ><img src="../Views/icon/evaluar.png" alt="<?php echo $strings['Ver en detalle']?>" width="32" height="32"/></button>                             
                                <!--si pulsas este boton ves la vista SHOWCURRENT-->
                        </td>
                            
						</form>

				</tr>
<?php
				}
?>
			</table>
		</div>
<?php
		include '../Views/Footer.php';//incluimos el pie de la página
		}
		}
?>

    
