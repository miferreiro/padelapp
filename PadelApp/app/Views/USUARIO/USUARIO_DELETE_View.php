<?php
/*  Archivo php
	Nombre: USUARIOS_DELETE_View.php
	Autor: 	Jonatan Couto
	Fecha de creación: 22/11/2017 
	Función: vista de la tabla de borrado(delete) realizada con una clase donde se muestran todos los datos de un usuario y da la opción de borrarlos
*/


//es la clase DELETE de USUARIO que nos permite borrar un usuario
class USUARIO_DELETE {
//es el constructor de la clase USUARIO_DELETE
	function __construct( $valores, $dependencias, $dependencias2, $dependencias3, $dependencias4, $dependencias5, $dependencias6, $dependencias7) { 
		$this->valores = $valores;//pasamos los valores de cada uno de los campos
		$this->dependencias = $dependencias;//pasamos las dependencias que tiene a la hora de borrar
		$this->dependencias2 = $dependencias2;//pasamos las dependencias que tiene a la hora de borrar
		$this->dependencias3 = $dependencias3;//pasamos las dependencias que tiene a la hora de borrar
		$this->dependencias4 = $dependencias4;//pasamos las dependencias que tiene a la hora de borrar
		$this->dependencias5 = $dependencias5;//pasamos las dependencias que tiene a la hora de borrar
		$this->dependencias6 = $dependencias6;//pasamos las dependencias que tiene a la hora de borrar
		$this->dependencias7 = $dependencias7;//pasamos las dependencias que tiene a la hora de borrar
		$this->render( $this->valores, $this->dependencias,$this->dependencias2,$this->dependencias3,$this->dependencias4,$this->dependencias5,$this->dependencias6, $this->dependencias7);//llamamos a la función render donde se mostrará el formulario DELETE con los campos correspondientes
	}
//funcion que mostrará el formulario DELETE con los campos correspondientes
	function render( $valores, $dependencias, $dependencias2, $dependencias3, $dependencias4, $dependencias5, $dependencias6, $dependencias7) { 
		$this->valores = $valores;//pasamos los valores de cada uno de los campos
		$this->dependencias = $dependencias;//pasamos las dependencias que tiene a la hora de borrar
		$this->dependencias2 = $dependencias2;//pasamos las dependencias que tiene a la hora de borrar
		$this->dependencias3 = $dependencias3;//pasamos las dependencias que tiene a la hora de borrar
		$this->dependencias4 = $dependencias4;//pasamos las dependencias que tiene a la hora de borrar
		$this->dependencias5 = $dependencias5;//pasamos las dependencias que tiene a la hora de borrar
		$this->dependencias6 = $dependencias6;//pasamos las dependencias que tiene a la hora de borrar
		$this->dependencias7 = $dependencias7;//pasamos las dependencias que tiene a la hora de borrar
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
						<?php echo $strings['Usuario'];?>
					</th>
					<td>
						<?php echo $this->valores['login']?>
					</td>
				</tr>
				<tr>
					<th>
						<?php echo $strings['Contraseña'];?>
					</th>
					<td>
						<?php echo $this->valores['password']?>
					</td>
				</tr>
				<tr>
					<th>
						<?php echo $strings['DNI'];?>
					</th>
					<td>
						<?php echo $this->valores['DNI']?>
					</td>
				</tr>
				<tr>
					<th>
						<?php echo $strings['Nombre'];?>
					</th>
					<td>
						<?php echo $this->valores['Nombre']?>
					</td>
				</tr>
				<tr>
					<th>
						<?php echo $strings['Apellidos'];?>
					</th>
					<td>
						<?php echo $this->valores['Apellidos']?>
					</td>
				</tr>
				<tr>
					<th>
						<?php echo $strings['Teléfono'];?>
					</th>
					<td>
						<?php echo $this->valores['Telefono']?>
					</td>
				</tr>
				<tr>
					<th>
						<?php echo $strings['Correo electrónico'];?>
					</th>
					<td>
						<?php echo $this->valores['Correo']?>
					</td>
				</tr>
				<tr>
					<th>
						<?php echo $strings['Direccion'];?>
					</th>
					<td>
						<?php echo $this->valores['Direccion']?>
					</td>
				</tr>
			</table>
            <br>
            <br>
        
            <?php
            
            if($dependencias != null || $dependencias2 != null || $dependencias3 != null || $dependencias4 != null || $dependencias5 != null || $dependencias6 != null || $dependencias7 != null ){ //miramos si hay alguna dependencia a la hora de borrar
                
                echo $strings['Debe eliminar antes todas las dependencias para poder borrar este dato.'];
                ?>
                <br>
                <br>
            <?php
            
            if($dependencias != null){//si hay dependencias a la hora de borrar
            ?>
            
            <table>
                    <th>
                        <?php echo $strings['USUARIO_GRUPO'];?>
                    </th>
                    <th>
                        <?php echo $strings['NOMBRE_GRUPO'];?>
                    </th>
                
            <?php
				while ( $fila = mysqli_fetch_array( $dependencias ) ) { //este bucle se repite hasta que no nos devuelva todas  las dependencias
            ?>
			
            <tr>
                    

				    <td>
                        <?php 
				        echo $fila['login'];
                            
                        ?>
					</td>
                    <td>
                        <?php 
							
                        echo $fila['NombreGrupo'];

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
                        <?php echo $strings['USUARIO_ENTREGA'];?>
                    </th>
                    <th>
                        <?php echo $strings['NombreTrabajo'];?>
                    </th>
                
                    <th>
                        <?php echo $strings['ALIAS'];?>
                    </th>
                
                    <th>
                        <?php echo $strings['HORAS'];?>
                    </th>
                
                    <th>
                        <?php echo $strings['RUTA'];?>
                    </th>
            <?php
				while ( $fila = mysqli_fetch_array( $dependencias2 ) ) {//este bucle se repite hasta que no nos devuelva todas  las dependencias
            ?>
			
            <tr>
                    
                    
                
				    <td>
                        <?php 
				        echo $fila['login'];
                            
                        ?>
					</td>
                    <td>
                        <?php 
							
                        echo $fila['NombreTrabajo'];

                        ?>
					</td>
                    <td>
                        <?php 
				        echo $fila['Alias'];
                            
                        ?>
					</td>
                    <td>
                        <?php 
							
                        echo $fila['Horas'];

                        ?>
					</td>
                
                    <td>
                        <?php 
							
                        echo $fila['Ruta'];

                        ?>
					</td>


				</tr>
                
                <?php
				}
                ?>
                </table>
            <?php
            }
                
            
            if($dependencias3 != null){//si hay dependencias a la hora de borrar
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
				while ( $fila = mysqli_fetch_array( $dependencias3 ) ) {//este bucle se repite hasta que no nos devuelva todas  las dependencias
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
                
            
            if($dependencias4 != null){//si hay dependencias a la hora de borrar
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
				while ( $fila = mysqli_fetch_array( $dependencias4 ) ) {//este bucle se repite hasta que no nos devuelva todas  las dependencias
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
                
            
            if($dependencias5 != null){//si hay dependencias a la hora de borrar
            ?>
            
            <table>
                
                    <th>
                        <?php echo $strings['NombreTrabajo'];?>
                    </th>
                
                    <th>
                        <?php echo $strings['NotaTrabajo'];?>
                    </th>
                
            <?php
				while ( $fila = mysqli_fetch_array( $dependencias5 ) ) {//este bucle se repite hasta que no nos devuelva todas  las dependencias
            ?>
			
            <tr>
                    
                    <td>
                        <?php 
							
                        echo $fila['NombreTrabajo'];

                        ?>
					</td>
                    <td>
                        <?php 
				        echo $fila['NotaTrabajo'];
                            
                        ?>
					</td>
				</tr>
                
                <?php
				}
                ?>
                </table>
                <?php
            }
                
            
            if($dependencias6 != null){//si hay dependencias a la hora de borrar
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
				while ( $fila = mysqli_fetch_array( $dependencias6 ) ) {//este bucle se repite hasta que no nos devuelva todas  las dependencias
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
                
                if($dependencias7 != null){//si hay dependencias a la hora de borrar
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
				while ( $fila = mysqli_fetch_array( $dependencias7 ) ) {//este bucle se repite hasta que no nos devuelva todas  las dependencias
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
            
            <form action='../Controllers/USUARIO_CONTROLLER.php' method="post" style="display: inline">
				<button type="submit"><img src="../Views/icon/atras.png" alt="<?php echo $strings['Atras'] ?>"/></button>
			</form>
            <?php
    }
        
                
               if($dependencias == null && $dependencias2 == null && $dependencias3 == null && $dependencias4 == null && $dependencias5 == null && $dependencias6 == null && $dependencias7 == null ){ //si ya no hay dependencias a la hora de borrar
                    
              ?>  
            
			<p style="text-align:center;">
				<?php echo $strings['¿Está seguro de que quiere borrar esta tupla de la tabla?'];?>
			</p>
			<form action="../Controllers/USUARIO_CONTROLLER.php" method="post" style="display: inline">
				<input type="hidden" name="login" value=<?php echo $this->valores['login'] ?> />
				<input type="hidden" name="password" value=<?php echo $this->valores['password'] ?> />
				<input type="hidden" name="DNI" value=<?php echo $this->valores['DNI'] ?> />
				<input type="hidden" name="nombre" value=<?php echo $this->valores['Nombre'] ?> />
				<input type="hidden" name="apellidos" value=<?php echo $this->valores['Apellidos'] ?> />
				<input type="hidden" name="telefono" value=<?php echo $this->valores['Telefono'] ?> />
				<input type="hidden" name="email" value=<?php echo $this->valores['Correo'] ?> />
				<input type="hidden" name="direc" value=<?php echo $this->valores['Direccion'] ?> />
				<button type="submit" name="action" value="DELETE" ><img src="../Views/icon/confirmar.png" alt="<?php echo $strings['Confirmar'] ?>"/></button>
			</form>
			<form action='../Controllers/USUARIO_CONTROLLER.php' method="post" style="display: inline">
				<button type="submit"><img src="../Views/icon/cancelar.png" alt="<?php echo $strings['Atras'] ?>"/></button>
			</form>
		</div>
<?php
            }
		include '../Views/Footer.php';//incluimos el pie de página
                
            }
        
	}


?>