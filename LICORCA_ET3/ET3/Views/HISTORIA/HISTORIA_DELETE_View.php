<?php
/* 
	Fecha de creación: 2/12/2017 
	Función: vista de la tabla de borrado(delete) realizada con una clase donde se muestran todos los valores de una historia y da la opción de borrarlos
    Autor:Brais Santos
*/


//es la clase DELETE de HISTORIA que nos permite borrar una historia
class HISTORIA_DELETE {
//es el constructor de la clase HISTORIA_DELETE
	function __construct( $valores, $dependencias) { 
		$this->valores = $valores;//pasamos los valores de cada campo de la tupla que fue seleccionada en el showall
		$this->dependencias = $dependencias;//pasamos las dependencias de la tabla HISTORIA a la hora de borrar
		
		$this->render( $this->valores, $this->dependencias);//llamamos a la función render donde se mostrará el formulario DELETE con los campos correspondientes
	}
//funcion que mostrará el formulario DELETE con los campos correspondientes
	function render( $valores, $dependencias) { 
		$this->valores = $valores;//pasamos los valores de cada campo de la tupla que fue seleccionada en el showall
		$this->dependencias = $dependencias;//pasamos las dependencias de la tabla HISTORIA a la hora de borrar
		
		include '../Locales/Strings_' . $_SESSION[ 'idioma' ] . '.php';//incluimos los strings de idiomas, para que la página pueda estar en español,inglés y galego
		include '../Views/Header.php';//incluimos la cabecera
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
						<?php echo $strings['IdHistoria'];?>
					</th>
					<td>
						<?php echo $this->valores['IdHistoria']?>
					</td>
				</tr>
				<tr>
					<th>
						<?php echo $strings['TextoHistoria'];?>
					</th>
					<td>
						<?php echo $this->valores['TextoHistoria']?>
					</td>
				</tr>
	
			</table>
			<br>
			<br>
            
            <?php
       
            
            if($dependencias != null){//miramos si hay dependencias
            
            
            echo $strings['Debe eliminar antes todas las dependencias para poder borrar este dato.'];
                ?>
                <br>
                <br>
            
            
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
				while ( $fila = mysqli_fetch_array( $dependencias ) ) { //este bucle se va a repetir mientras haya dependencias a la hora de borrar
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
            
         
                ?>
           
            
            <form action='../Controllers/HISTORIA_CONTROLLER.php' method="post" style="display: inline">
				<button type="submit"><img src="../Views/icon/atras.png" alt="<?php echo $strings['Atras'] ?>"/></button>
			</form>
            <?php
    }
        
                
               else{ //si no hay dependencias
                    
              ?>  


			<p style="text-align:center;">
				<?php echo $strings['¿Está seguro de que quiere borrar esta tupla de la tabla?'];?>
			</p>
			<form action="../Controllers/HISTORIA_CONTROLLER.php"  method="post" style="display: inline">
				<input type="hidden" name="IdTrabajo" value="<?php echo $valores['IdTrabajo'] ?>" />
				<input type="hidden" name="IdHistoria" value="<?php echo $valores['IdHistoria'] ?>" />
				<input type="hidden" name="TextoHistoria" value="<?php echo $valores['TextoHistoria'] ?>" />
                
				
                
                <button type="submit" name="action" value="DELETE"><img src="../Views/icon/confirmar.png" alt="<?php echo $strings['Confirmar'] ?>"/></button>
                
			</form>
			<form action='../Controllers/HISTORIA_CONTROLLER.php' method="post" style="display: inline">
				<button type="submit"><img src="../Views/icon/cancelar.png" alt="<?php echo $strings['Atras'] ?>"/></button>
			</form>
		</div>
<?php
               }
		include '../Views/Footer.php';//incluimos el pie de la página
            
	}
}

?>