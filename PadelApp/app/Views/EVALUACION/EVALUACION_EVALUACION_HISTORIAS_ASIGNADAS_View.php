<?php
    //Función:Esta vista hace posible que el usuario pueda evaluar a otros usuarios
    //Fecha de creación:30/11/2017
   // Autor: Alejandro Vila
	


//esta clase es de la tabla Selecion QA necesaria para elegir la qa a evaluar
class EVALUACION_SELECT_QA {

    //es el constructor de la clase EVALUACION_SELECT_QA
	function __construct( $lista, $datos) { 
		$this->lista = $lista;//Variable que almacena el array de atributos a mostrar en la vista
		$this->datos = $datos;//Variable que almacena el recordset de la base de datos
		$this->render($this->lista,$this->datos);//llamamos a la función render donde se mostrará un formulario para evaluar historias asignadas con los campos correspondientes
	}
	//funcion que  mostrará un formulario para evaluar historias asignadas con los campos correspondientes
	function render($lista,$datos){
		$this->lista = $lista;//Variable que almacena el array de atributos a mostrar en la vista
		$this->datos = $datos;//Variable que almacena el recordset de la base de datos
		include '../Locales/Strings_' . $_SESSION[ 'idioma' ] . '.php';//incluimos los strings de idiomas, para que la página pueda estar en español,inglés y galego
		include '../Views/Header.php';//incluimos la cabecera
		include_once '../Functions/permisosAcc.php';//incluimos el fichero permisosAcc.php para saber que usuarios tienen que permisos
		include_once '../Functions/comprobarAdministrador.php';//incluimos el fichero  comprobarAdministrador.php para saber que usuarios son administradores
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
				while ( $fila = mysqli_fetch_array( $this->datos ) ) { //este bucle devolverá todas las tuplas de la base de datos
?>
				<tr>
<?php
					//Bucle que recorre el array asociativo y mostrando los valores correspondientes a los atributos
					foreach ( $lista as $atributo ) {//este bucle mostrará eñ valor de cada uno de los campos que hay en una tupla
?>
					<td>
<?php 
                            if($atributo == 'Ruta'){ //si el campo es igual a la ruta para subir el archivo
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
								<button type="submit" name="action" value="EVALUARUSU" ><img src="../Views/icon/evaluar.png" alt="<?php echo $strings['Ver en detalle']?>" width="32" height="32"/></button>                             
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

    






















