<?php
/*  Archivo php
	Nombre: ACCION_DELETE_View.php
    Autor: 	Alejandro Vila
	Fecha de creación: 23/11/2017 
	Función: vista de la tabla de borrado(delete) realizada con una clase donde se muestran todos los datos de una acción y da la opción de borrarlos
*/

//Es la clase DELETE de ACCION que nos permite borrar una accion
class ACCION_DELETE {
//es el constructor de la clase ACCION_DELETE
	function __construct( $valores, $dependencias ) { 
		$this->valores = $valores;//le pasamos el valor de los campos de la tabla ACCION
		$this->dependencias = $dependencias;//pasamos todas las dependencias que tiene la tabla a la hora de borrar
		$this->render( $this->valores, $this->dependencias );//llamamos a la función render donde se mostrará el formulario DELETE con los campos correspondientes
	}

    //En está función se mostrará el formulario DELETE con los campos correspondientes
	function render( $valores, $dependencias ) {
		$this->valores = $valores;//le pasamos el valor de los campos de la tabla ACCION
		$this->dependencias = $dependencias;//pasamos todas las dependencias que tiene la tabla a la hora de borrar
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
						<?php echo $strings['IdAccion'];?>
					</th>
					<td>
						<?php echo $this->valores['IdAccion']?>
					</td>
				</tr>

				<tr>
					<th>
						<?php echo $strings['NombreAccion'];?>
					</th>
					<td>
						<?php echo $this->valores['NombreAccion']?>
					</td>
				</tr>
				
				<tr>
					<th>
						<?php echo $strings['DescripAccion'];?>
					</th>
					<td>
						<?php echo $this->valores['DescripAccion']?>
					</td>
				</tr>
				
			</table>
            <br>
            <br>
            
             <?php
            
            if($dependencias != null){//si hay dependencias a la hora de borrar te se muestran todas las tablas de las que depende
                
                 echo $strings['Debe eliminar antes todas las dependencias para poder borrar este dato.'];//se muestra un mensaje indicando que el  usuario debe eliminar todas las dependencias
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
            
				while ( $fila = mysqli_fetch_array( $dependencias ) ) { //este bucle se va a repetir mientras haya dependencias de borrado
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
            <form action='../Controllers/ACCION_CONTROLLER.php' method="post" style="display: inline">
				<button type="submit"><img src="../Views/icon/atras.png" alt="<?php echo $strings['Atras'] ?>"/></button>
			</form>
            <?php
            }
        
            else{
                
           
              ?>  
			<p style="text-align:center;">
				<?php echo $strings['¿Está seguro de que quiere borrar esta tupla de la tabla?'];?>
			</p>
			<form action="../Controllers/ACCION_CONTROLLER.php" method="POST" style="display: inline">
				<input type="hidden" name="IdAccion" value="<?php echo $this->valores['IdAccion'] ?>" />
				<input type="hidden" name="NombreAccion" value="<?php echo $this->valores['NombreAccion'] ?>" />
				<input type="hidden" name="DescripAccion" value="<?php echo $this->valores['DescripAccion'] ?>" />
				
				<button type="submit" id="DELETE" name="action" value="DELETE"><img src="../Views/icon/confirmar.png" alt="<?php echo $strings['confirmar'] ?>"/></button>
			</form>
			<form action='../Controllers/ACCION_CONTROLLER.php' method="post" style="display: inline">
				<button type="submit"><img src="../Views/icon/cancelar.png" alt="<?php echo $strings['Atras'] ?>"/></button>
			</form>
		</div>
<?php
            }
		include '../Views/Footer.php';//incluimos el pie de la pagina
                
	}
}

?>