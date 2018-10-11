<?php
/*  Archivo php
	Nombre: FUNCIONALIDAD_DELETE_View.php
	Autor: 	Brais Rodríguez
	Fecha de creación: 22/11/2017 
	Función: vista de la tabla de borrado(delete) realizada con una clase donde se muestran todos los datos de una Funcionalidad y da la opción de borrarlos
*/

//es la clase DELETE de FUNCIONALIDAD que nos permite borrar una funcionalidad
class FUNCIONALIDAD_DELETE {
 //es el constructor de la clase FUNCIONALIDAD_DELETE
	function __construct( $valores, $dependencias ){ 
		$this->valores = $valores;//pasamos el valor de los campos
		$this->dependencias = $dependencias;//pasamos las dependencias de la tabla FUNCIONALIDAD a la hora de borrar
		$this->render( $this->valores, $this->dependencias);//llamamos a la función render donde se mostrará el formulario DELETE con los campos correspondientes
	}

//función render donde se mostrará el formulario DELETE con los campos correspondientes
	function render( $valores, $dependencias ) {
		$this->valores = $valores;//pasamos el valor de los campos
		$this->dependencias = $dependencias;//pasamos las dependencias de la tabla FUNCIONALIDAD a la hora de borrar
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
						<?php echo $strings['IdFuncionalidad'];?>
					</th>
					<td>
						<?php echo $this->valores['IdFuncionalidad']?>
					</td>
				</tr>

				<tr>
					<th>
						<?php echo $strings['NombreFuncionalidad'];?>
					</th>
					<td>
						<?php echo $this->valores['NombreFuncionalidad']?>
					</td>
				</tr>
				
				<tr>
					<th>
						<?php echo $strings['DescripFuncionalidad'];?>
					</th>
					<td>
						<?php echo $this->valores['DescripFuncionalidad']?>
					</td>
				</tr>
				
			</table>
            <br>
            <br>
              <?php
            
            if($dependencias != null){//miramis si la tabla FUNCIONALIDAD tiene dependencias 
                
                echo $strings['Debe eliminar antes todas las dependencias para poder borrar este dato.'];
               ?>
                <br>
                <br>
            <table>
                    <th>
                        <?php echo $strings['NombreFunc'];?>
                    </th>
                    <th>
                        <?php echo $strings['NombreAc'];?>
                    </th>
            <?php
            
				while ( $fila = mysqli_fetch_array( $dependencias ) ) {//este bucle se va a repetir mientras haya dependencias
            ?>
			
            <tr>

				    <td>
                        <?php 
				        echo $fila['NombreFuncionalidad'];
                            
                        ?>
					</td>
                    <td>
                        <?php 
							
                        echo $fila['NombreAccion'];

                        ?>
					</td>

				</tr>
                
                <?php
				}
                ?>
                </table>
                
            <form action='../Controllers/FUNCIONALIDAD_CONTROLLER.php' method="post" style="display: inline">
				<button type="submit"><img src="../Views/icon/atras.png" alt="<?php echo $strings['Atras'] ?>"/></button>
			</form>
            
            <?php
            }
                
                
                
            
            
        
            else{//si la tabla FUNCIONALIDAD no tiene dependencias
                ?>
            <br>   
			<p style="text-align:center;">
				<?php echo $strings['¿Está seguro de que quiere borrar esta tupla de la tabla?'];?>
			</p>
			<form action="../Controllers/FUNCIONALIDAD_CONTROLLER.php" method="post" style="display: inline">
				<input type="hidden" name="IdFuncionalidad" value=<?php echo $this->valores['IdFuncionalidad'] ?> />
				<input type="hidden" name="NombreFuncionalidad" value=<?php echo $this->valores['NombreFuncionalidad'] ?> />
				<input type="hidden" name="DescripFuncionalidad" value=<?php echo $this->valores['DescripFuncionalidad'] ?> />
				<button type="submit" name="action" value="DELETE" ><img src="../Views/icon/confirmar.png" alt="<?php echo $strings['Confirmar'] ?>"/></button>
			</form>
			<form action='../Controllers/FUNCIONALIDAD_CONTROLLER.php' method="post" style="display: inline">
				<button type="submit"><img src="../Views/icon/cancelar.png" alt="<?php echo $strings['Atras'] ?>"/></button>
			</form>
		</div>
<?php
            }
		include '../Views/Footer.php';//incluimos el pie de la página
            
	}
}

?>