<?php
/*  Archivo php
	Nombre: ASIGNAC_QA_DELETE_View.php
	Autor: 	Jonatan Couto Riádigos
	Fecha de creación: 29/11/2017 
	Función: vista de la tabla de borrado(delete) realizada con una clase donde se muestran todos los datos de una qa y da la opcion de borrarlos
*/
//Clase Asignac_qa_delete que contiene la vista para poder borrar una tupla de ASIGNAC_QA
class ASIGNAC_QA_DELETE {
    //Constructor de la clase
	function __construct( $valores, $dependencias, $dependencias2 ) {
		$this->valores = $valores;//Variable que almacena un recordset con la info de una tupla
		$this->dependencias = $dependencias;//Variable que almacena un recordset con las dependencias de borrar una tupla
		$this->dependencias2 = $dependencias2;//Variable que almacena un recordset con las dependencias de borrar una tupla
		$this->render( $this->valores, $this->dependencias, $this->dependencias2 );//metodo que llama a la función render que contiene todo el código de la vista
	}
    //Función que contiene el código de la vista
	function render( $valores, $dependencias, $dependencias2 ) {
		$this->valores = $valores;//Variable que almacena un recordset con la info de una tupla
		$this->dependencias = $dependencias;//Variable que almacena un recordset con las dependencias de borrar una tupla
		$this->dependencias2 = $dependencias2;//Variable que almacena un recordset con las dependencias de borrar una tupla
		include '../Locales/Strings_' . $_SESSION[ 'idioma' ] . '.php';//Incluye el contenido de los strings necesarios para el multiidioma
		include '../Views/Header.php';//Incluye el contenido del header

?>
		<div class="seccion">
			<h2>
				<?php echo $strings['Tabla de borrado'];?>
			</h2>
			<table>
				<tr>
					<th>
						<?php echo $strings['IdTrabajo'];?>
					</th>
					<td>
						<?php echo $this->valores['IdTrabajo']?>
					</td>
				</tr>
				<tr>
					<th>
						<?php echo $strings['LoginEvaluador'];?>
					</th>
					<td>
						<?php echo $this->valores['LoginEvaluador']?>
					</td>
				</tr>
				<tr>
					<th>
						<?php echo $strings['LoginEvaluado'];?>
					</th>
					<td>
						<?php echo $this->valores['LoginEvaluado']?>
					</td>
				</tr>
				<tr>
					<th>
						<?php echo $strings['AliasEvaluado'];?>
					</th>
					<td>
						<?php echo $this->valores['AliasEvaluado']?>
					</td>
				</tr>
			</table>
            <br>
            <br>
            
            <?php
            //Si hay dependencias, mostramos un mensaje y informamos de las dependencias que evitan que se pueda borrar una tupla
            if($dependencias != null || $dependencias2 !=null){
                
                echo $strings['Debe eliminar antes todas las dependencias para poder borrar este dato.'];
                ?>
                <br>
                <br>
            <?php
            //Si hay dependencias mostramos la columnas con el nombre del atributo
            if($dependencias != null){
            ?>
            
            <table>
                    <th>
                        <?php echo $strings['NombreTrabajo'];?>
                    </th>
                
                    <th>
                        <?php echo $strings['LoginEvaluador'];?>
                    </th>
                
                    <th>
                        <?php echo $strings['AliasEvaluado'];?>
                    </th>
                
                    <th>
                        <?php echo $strings['IdHistoria'];?>
                    </th>
                
                    <th>
                        <?php echo $strings['CorrectoA'];?>
                    </th>
                
                    <th>
                        <?php echo $strings['ComenIncorrectoA'];?>
                    </th>
                
                    <th>
                        <?php echo $strings['CorrectoP'];?>
                    </th>
                
                    <th>
                        <?php echo $strings['ComentIncorrectoP'];?>
                    </th>
                
                     <th>
                        <?php echo $strings['OK'];?>
                    </th>
            <?php
                //Bucle que recorre todo el recordset de dependencias y pasa estos valores a array y los muestra
				while ( $fila = mysqli_fetch_array( $dependencias ) ) {
            ?>
			
            <tr>

				    <td>
                        <?php 
				        echo $fila['NombreTrabajo'];
                            
                        ?>
					</td>
                    <td>
                        <?php 
							
                        echo $fila['LoginEvaluador'];

                        ?>
					</td>
                    <td>
                        <?php 
							
                        echo $fila['AliasEvaluado'];

                        ?>
					</td>
                
                    <td>
                        <?php 
				        echo $fila['IdHistoria'];
                            
                        ?>
					</td>
                
                    <td>
                        <?php 
				        echo $fila['CorrectoA'];
                            
                        ?>
					</td>
                
                    <td>
                        <?php 
				        echo $fila['ComenIncorrectoA'];
                            
                        ?>
					</td>
                    <td>
                        <?php 
				        echo $fila['CorrectoP'];
                            
                        ?>
					</td>
                    <td>
                        <?php 
				        echo $fila['ComentIncorrectoP'];
                            
                        ?>
					</td>
                    <td>
                        <?php 
				        echo $fila['OK'];
                            
                        ?>
					</td>

				</tr>
                
                <?php
				}
                ?>
                </table>
            <?php
            }
        
        
            //Si hay dependencias mostrara el valor de cada atributo del recordset de dependencias
            if($dependencias2 != null){
            ?>
            
            <table>
                    <th>
                        <?php echo $strings['NombreTrabajo'];?>
                    </th>
                
                    <th>
                        <?php echo $strings['LoginEvaluador'];?>
                    </th>
                
                    <th>
                        <?php echo $strings['AliasEvaluado'];?>
                    </th>
                
                    <th>
                        <?php echo $strings['IdHistoria'];?>
                    </th>
                
                    <th>
                        <?php echo $strings['CorrectoA'];?>
                    </th>
                
                    <th>
                        <?php echo $strings['ComenIncorrectoA'];?>
                    </th>
                
                    <th>
                        <?php echo $strings['CorrectoP'];?>
                    </th>
                
                    <th>
                        <?php echo $strings['ComentIncorrectoP'];?>
                    </th>
                
                     <th>
                        <?php echo $strings['OK'];?>
                    </th>
                
            <?php
                //Bucle que recorre todo el recordset de dependencias y pasa estos valores a array y los muestra
				while ( $fila = mysqli_fetch_array( $dependencias2 ) ) {
            ?>
			
            <tr>

				    <td>
                        <?php 
				        echo $fila['NombreTrabajo'];
                            
                        ?>
					</td>
                    <td>
                        <?php 
							
                        echo $fila['LoginEvaluador'];

                        ?>
					</td>
                    <td>
                        <?php 
							
                        echo $fila['AliasEvaluado'];

                        ?>
					</td>
                
                    <td>
                        <?php 
				        echo $fila['IdHistoria'];
                            
                        ?>
					</td>
                
                    <td>
                        <?php 
				        echo $fila['CorrectoA'];
                            
                        ?>
					</td>
                
                    <td>
                        <?php 
				        echo $fila['ComenIncorrectoA'];
                            
                        ?>
					</td>
                    <td>
                        <?php 
				        echo $fila['CorrectoP'];
                            
                        ?>
					</td>
                    <td>
                        <?php 
				        echo $fila['ComentIncorrectoP'];
                            
                        ?>
					</td>
                    <td>
                        <?php 
				        echo $fila['OK'];
                            
                        ?>
					</td>

				</tr>
                
                <?php
				}
                ?>
                </table>
            <?php
            }
                ?>
            <form action='../Controllers/ASIGNAC_QA_CONTROLLER.php' method="post" style="display: inline">
				<button type="submit"><img src="../Views/icon/atras.png" alt="<?php echo $strings['Atras'] ?>"/></button>
			</form>
            <?php
    }
            
            //Si no hay dependencias muestra un mensaje y permite el borrado de la tupla
            if($dependencias == null && $dependencias2 == null){
                
            ?>
			<p style="text-align:center;">
				<?php echo $strings['¿Está seguro de que quiere borrar esta tupla de la tabla?'];?>
			</p>
			<form action="../Controllers/ASIGNAC_QA_CONTROLLER.php" method="post" style="display: inline">
				<input type="hidden" name="IdTrabajo" value=<?php echo $this->valores['IdTrabajo'] ?> />
				<input type="hidden" name="LoginEvaluador" value=<?php echo $this->valores['LoginEvaluador'] ?> />
				<input type="hidden" name="LoginEvaluado" value=<?php echo $this->valores['LoginEvaluado'] ?> />
				<input type="hidden" name="AliasEvaluado" value=<?php echo $this->valores['AliasEvaluado'] ?> />
				
				<button type="submit" name="action" value="DELETE"><img src="../Views/icon/confirmar.png" alt="<?php echo $strings['Confirmar'] ?>"/></button>

			</form>
			<form action='../Controllers/ASIGNAC_QA_CONTROLLER.php' method="post" style="display: inline">
				<button type="submit"><img src="../Views/icon/cancelar.png" alt="<?php echo $strings['Atras'] ?>"/></button>
			</form>
		</div>
<?php
            }
		include '../Views/Footer.php';//Incluye el contenido del pie
                
            }
        
	}


?>