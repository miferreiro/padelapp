<?php
/*  
	Autor: 	Brais Santos
	Fecha de creación: 6/12/2017 
	Función: muestra todas las correciones de una entrega de un usuario
*/
	//Clase Correcion_entrega_resultado que contiene la vista para ver los resultados de las correciones de las ET
class CORRECION_ENTREGA_RESULTADO {
	//Constructor de la clase
	function __construct( $lista, $datos) {
		$this->lista = $lista;//Variable que contiene el array de los atributos a mostrar en la vista
		$this->datos = $datos;//Variable que almacena el recordset de la base de datos con la info de los resultados de entrega
		$this->render($this->lista,$this->datos);//metodo que llama a la función render que contiene todo el código de la vista
	}
	//Función que contiene el código de la vista
	function render($lista,$datos){
		$this->lista = $lista;//Variable que contiene el array de los atributos a mostrar en la vista
		$this->datos = $datos;//Variable que almacena el recordset de la base de datos con la info de los resultados de entrega
		include '../Locales/Strings_' . $_SESSION[ 'idioma' ] . '.php';//Incluye el contenido de los strings necesarios para el multiidioma
		include '../Views/Header.php';//Incluye el contenido del header
?>
		<div class="seccion">
			<h2>
				<?php echo $strings['Ver los resultados de las entregas'];?>
			</h2>
			<table border>
				
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
                $his = -10000;//Variable que almacena el id de historia en cada momento para ver si cambia de historia
                //Bucle que recorre todo el recordset de datos y pasa estos valores a array y los muestra
				while ( $fila = mysqli_fetch_array( $this->datos ) ) {
?>
				
                <tr>
                   
                    
<?php
					//Si el valor de id historia es diferente al siguiente muestra el texto historia
                    if($his != $fila['IdHistoria']){
?>
                    <td bgcolor="#b59438" colspan="3"><?php echo $fila['IdHistoria'] . '. ' . $fila['TextoHistoria'] ?></td>
                    <tr></tr>
<?php
                    }
                    $his = $fila['IdHistoria'];//Actualizamos el id de historia
                    //Muestra el valor del array para cada atributo
					foreach ( $lista as $atributo ) {
?>
                    
<?php               
					//Si el atributo es igual al del comentario profesor se pone una celda que muestre el texto sin salirse de la celda
                    if($atributo == 'ComentIncorrectoP'){
?>
            
                        <td><p class="ajustar">
<?php                    
                            //Muestra el valor del array para cada atributo
                           echo $fila[ $atributo ]; 
                          	//Si el contador es igual a 1 actualizamos el valor de $id
							if($cont==1){
							$Id= $fila[ 'IdTrabajo' ];
						  }
?>                       
                        </p></td>
<?php                       
                    }
                    //Si el atributo es igual a textohistoria muestra el texto historia            
                    if($atributo == 'TextoHistoria'){
                        
                        ?>
                            <td>
                            <?php
                            //Muestra el valor del array para cada atributo
                                echo $fila[ $atributo ]; 
                        ?>
                                
                                </td>
  <?php                  
                    }    
                        
                        
                    //Si es diferente comprobamos que el valor del atributo correcto p sea 1 o 0 o ninguno de estos
                    else{
                        //Si el valor del atributo correcto P es igual a 1 muestra la celda verde
                        if($atributo == 'CorrectoP' && $fila[$atributo] == '1'){
                            ?>
                                <td bgcolor="#4e8726">
                                <?php echo $fila[ $atributo ]; ?>
                                </td>
<?php                            
                        }
                        //Si el valor del atributo es igual a 0 muestra la celda en rojo
                        else if($atributo == 'CorrectoP' && $fila[$atributo] == '0' ){
                            ?>
                             <td bgcolor="#ff3700">
                             <?php echo $fila[$atributo]; ?>
                            </td> 
<?php                
                        }
                        //Si el valor de correcto p no es ni 0 ni 1 no se pone color a la celda
                        else{                      
?>
                                
<?php
                                                      
?>                 
                  
                    
					<td>
<?php 
					//Si el atributo es diferente a comentario incorrecto profesor muestra el atributo
	              if($atributo != "ComentIncorrectoP"){
							echo $fila[ $atributo ];
						    //Si contador es igual a 1 actualiza el contenido de $Id
						    if($cont==1){
						    	//Actualizacion de la variable $Id
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
				$cont++;//Incrementamos la variable cont
				}
?>
			</table>
			<form action='../Controllers/EVALUACION_CONTROLLER.php?action=MOSTRAR_CORRECCION_ET' method="post">
			    <input type="hidden" name="IdTrabajo" value="<?php echo $Id; ?>">
				<button type="submit" ><img src="../Views/icon/atras.png" alt="<?php echo $strings['Atras']?>" /></button>
			</form>
		</div>
<?php
		include '../Views/Footer.php';
		}
		}
?>