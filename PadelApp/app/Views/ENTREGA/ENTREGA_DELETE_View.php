<?php
    //Función: vista que muestra una tabla con todos los atributos de la clase ENTREGA a borrar de una tupla.
    //Fecha de creación:28/11/2017
    //Autor:Brais Santos

//es la clase DELETE de ENTREGA que nos permite borrar una entrega
    class ENTREGA_DELETE{
        
        //es el constructor de la clase ENTREGA_DELETE
        function __construct($valores, $dependencias, $dependencias2){  
            
            $this->mostrar($valores, $dependencias, $dependencias2);//llamamos a la función mostrar donde se mostrará el formulario DELETE con los campos correspondientes

            
            
        }
        // funcion que mostrará el formulario DELETE con los campos correspondientes
        function mostrar($valores, $dependencias, $dependencias2){
            $this->valores = $valores;//Variable que almacena el valor de cada uno de los campos
            $this->dependencias = $dependencias;//Variable que almacena las depencias a la hora de borrar
            $this->dependencias2 = $dependencias2;//Variable que almacena las dependencias a la hora de borrar
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
						<?php echo $strings['login'];?><!--se muestra el campo login-->
					</th>
					<td>
						<?php echo $this->valores['login']?><!--se muestra el valor del campo login-->
					</td>
				</tr>

				<tr>
					<th>
						<?php echo $strings['IdTrabajo'];?><!--se muestra el campo IdTrabajo-->
					</th>
					<td>
						<?php echo $this->valores['IdTrabajo']?><!--se muestra el valor del campo IdTrabajo-->
					</td>
				</tr>
				
				<tr>
					<th>
						<?php echo $strings['Alias'];?><!--se muestra el campo Alias-->
					</th>
					<td>
						<?php echo $this->valores['Alias']?><!--se muestra el valor del campo Alias-->
					</td>
                    
				</tr>
                
                <tr>
					<th>
						<?php echo $strings['Horas'];?><!--se muestra el campo Horas-->
					</th>
					<td>
						<?php echo $this->valores['Horas']?><!--se muestra el valor del campo Horas-->
					</td>
				</tr>
                
                <tr>
					<th>
						<?php echo $strings['Ruta'];?><!--se muestra el campo Ruta-->
					</th>
					<td>
                        <a href="<?php echo $this->valores['Ruta']?>"><?php echo $this->valores['Ruta']?></a><!--se muestra el valor delcampo Ruta-->
					</td>
				</tr>
                
                
				
			</table>
        <br>
            <br>
        
            <?php
            
            if($dependencias != null || $dependencias2 != null  ){ //miramos si hay dependencias a la hora de borrar
                
                echo $strings['Debe eliminar antes todas las dependencias para poder borrar este dato.'];
                ?>
                <br>
                <br>
            <?php
            
            
                
            
            if($dependencias != null){//si hay dependencias a la hora de borrar
            ?>
            
            <table>
                    <th>
                        <?php echo $strings['NombreTrabajo'];?>
                    </th>
                
                    <th>
                        <?php echo $strings['LoginEvaluador'];?>
                    </th>
                
                    <th>
                        <?php echo $strings['LoginEvaluado'];?>
                    </th>
                
                    <th>
                        <?php echo $strings['AliasEvaluado'];?>
                    </th>
            <?php
				while ( $fila = mysqli_fetch_array( $dependencias ) ) {//este bucle sacará todas las dependencias a la hora de borrar
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
				        echo $fila['LoginEvaluado'];
                            
                        ?>
					</td>
                    <td>
                        <?php 
							
                        echo $fila['AliasEvaluado'];

                        ?>
					</td>

				</tr>
                
                <?php
				}
                ?>
                </table>
            
            <?php
                    
            }
                
            
            if($dependencias2 != null){//si hay dependencias a la hora de borrar
            ?>
            
            <table>
                    <th>
                        <?php echo $strings['NombreTrabajo'];?>
                    </th>
                
                    <th>
                        <?php echo $strings['LoginEvaluador'];?>
                    </th>
                
                    <th>
                        <?php echo $strings['LoginEvaluado'];?>
                    </th>
                
                    <th>
                        <?php echo $strings['AliasEvaluado'];?>
                    </th>
            <?php
				while ( $fila = mysqli_fetch_array( $dependencias2 ) ) {//este bucle sacará todas las dependencias a la hora de borrar
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
				        echo $fila['LoginEvaluado'];
                            
                        ?>
					</td>
                    <td>
                        <?php 
							
                        echo $fila['AliasEvaluado'];

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
            
            <form action='../Controllers/ENTREGA_CONTROLLER.php' method="post" style="display: inline">
				<button type="submit"><img src="../Views/icon/atras.png" alt="<?php echo $strings['Atras'] ?>"/></button>
			</form>
            <?php
    }
        
                
               if($dependencias == null && $dependencias2 == null ){//si no hay dependencias
                    
              ?>  
			<p style="text-align:center;">
				<?php echo $strings['¿Está seguro de que quiere borrar esta tupla de la tabla?'];?>
			</p>
			<form action="../Controllers/ENTREGA_CONTROLLER.php" method="post" style="display: inline">
				<input type="hidden" name="login" value="<?php echo $this->valores['login'] ?>" />
                
                <input type="hidden" name="IdTrabajo" value="<?php echo $this->valores['IdTrabajo'] ?>" />
                <input type="hidden" name="Alias" value="<?php echo $this->valores['Alias'] ?>" />
                
            
                
                <input type="hidden" name="Horas" value="<?php echo $this->valores['Horas'] ?>" />
                
                <button type="submit" name="action" value="DELETE" ><img src="../Views/icon/confirmar.png" alt="<?php echo $strings['Confirmar'] ?>"/></button>
				
			</form>
			<form action='../Controllers/ENTREGA_CONTROLLER.php' method="post" style="display: inline">
				<button type="submit"><img src="../Views/icon/cancelar.png" alt="<?php echo $strings['Atras'] ?>"/></button>
			</form>
		</div>
<?php
               }
		include '../Views/Footer.php';//incluimos el pie de la página 
	}
}

?>