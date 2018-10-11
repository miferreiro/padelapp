<?php
/*  
	Autor: 	Brais Santos
	Fecha de creación: 6/12/2017 
	Función: muestra la correción de la QA de un usuario
*/
//Clase Correcion_qa_resultados que contiene la vista para ver los resultados de las evaluaciones qa	
class CORRECION_QA_RESULTADOS {
	//Constructor de la clase
	function __construct( $lista, $datos) {
		$this->lista = $lista;//Variable que contiene el array de los atributos a mostrar en la vista
		$this->datos = $datos;//Variable que almacena el recordset de la base de datos con la info de los resultados de las evaluaciones
		$this->render($this->lista,$this->datos);//metodo que llama a la función render que contiene todo el código de la vista
	}
	//Función que contiene el código de la vista
	function render($lista,$datos){
		$this->lista = $lista;//Variable que contiene el array de los atributos a mostrar en la vista
		$this->datos = $datos;//Variable que almacena el recordset de la base de datos con la info de los resultados de las evaluaciones
		include '../Locales/Strings_' . $_SESSION[ 'idioma' ] . '.php';//Incluye el contenido de los strings necesarios para el multiidioma
		include '../Views/Header.php';//Incluye el contenido del header
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
					
				</tr>
                <tr><td></td></tr>
                <tr></tr>
<?php
		$cont=0;//Variable que almacena las pasadas que se van realizando, para quedarnos con el valor del primer idTrabajo
		$Id;//Inicializacion de la variable Id que contendrá el primer valor de IdTrabajo
        $his = -100000;//Variable que almacena el id de historia en cada momento para ver si cambia de historia
                //Bucle que recorre todo el recordset de datos y pasa estos valores a array y los muestra
        		//Bucle que recorre todo el recordset de datos y pasa estos valores a array y los muestra
				while ( $fila = mysqli_fetch_array( $this->datos ) ) {
?>
				
                <tr>
<?php
				//Si el id historia siguiente es distinto, muestra el texto de la historia
                 if($his != $fila['IdHistoria']){
?>
                        <td bgcolor="#b59438" colspan="6"><?php echo $fila['IdHistoria'] . '. ' . $fila['TextoHistoria'] ?></td>
                        <tr></tr>
<?php
                    }
                    $his = $fila['IdHistoria'];//Actualiza el valor de la historia 
                    //Muestra el valor del array para cada atributo
					foreach ( $lista as $atributo ) {
?>

<?php                
					//Si el atributo es igual a comentIncorrectoA se muestra un td con el texto adptado a la celda
                    if($atributo == 'ComenIncorrectoA'){
?>
                        <td><p class="ajustar">
<?php                    
                            //Se muestra el valor de comentarioIncorrectoA
                           echo $fila[ $atributo ]; 
                         //Si contador es igual a 1 guarda el Idtrabajo
						if($cont==1){
							$Id= $fila[ 'IdTrabajo' ];
						}
?>                       
                        </p></td>
<?php                       
                    }
                     //Si el atributo es distinto de comentIncorrecto A, comprobamos el atributo ok  
                    else{
                        //Si el valor de ok es igual a 1 se muestra el valor en una celda verde
                        if($atributo == 'OK' && $fila[$atributo] == '1'){
                            ?>
                                <td bgcolor="#4e8726">
                                        <?php echo $fila[$atributo]; ?>
                                </td>
 <?php                           
                        }
                        //Si el valor de ok es 0 muestra el valor en una celda roja 
                        else if($atributo == 'OK' && $fila[$atributo] == '0'){
                            ?>
                                <td bgcolor="#ff3700">
                                         <?php echo $fila[$atributo]; ?>
                                </td>
                            
 <?php                           
                        }
                        //si el atributo es corrcto del alumno y valor es 1 se pone de color verde
                        else if($atributo == 'CorrectoA' && $fila[$atributo] == '1'){
                            ?>
                                  <td bgcolor="#4e8726">
                                      <?php echo $fila[$atributo]; ?>
 
                                </td>
                       
<?php                  
                    }
                         //si el atributo es corrcto del alumno y valor es 0 se pone de color rojo
                        else if($atributo == 'CorrectoA' && $fila[$atributo] == '0'){
                            ?>
                                 <td bgcolor="#ff3700">
                                         <?php echo $fila[$atributo]; ?>
                                </td>
                
<?php                
                        }
                        
                        
                        //Si el valor de ok no es 0 ni 1 muestra la celda sin color
                        else{
                            
?>
                  
                    
					<td>
<?php                   
							//Si el atributo es distinto de comentIcorrectoP 
							if($atributo != "ComentIncorrectoP"){
							//Muestra el contenido del array para ese atributo
							echo $fila[ $atributo ];
							//Si contador es igual a 1 almacenamos el IdTrabajo
						    if($cont==1){
						    	//Actualizamos la variable $Id
							$Id= $fila[ 'IdTrabajo' ];
						}
                    }
?>                      
					</td>
                    
<?php
                        
                        }
                        }
					}
?>
					<td>

				</tr>
<?php
				$cont++;//Incrementamos el contador
				}
?>
			</table>
			<form action='../Controllers/EVALUACION_CONTROLLER.php' method="post">
                <input type="hidden" name="IdTrabajo" value="<?php echo $Id; ?>">
				<button type="submit" name="action" value="RESULTADO_QA" ><img src="../Views/icon/atras.png" alt="<?php echo $strings['Atras']?>" /></button>
			</form>
		</div>
<?php
		include '../Views/Footer.php';//incluimos el footer
		}
		}
?>