<?php
/*  Archivo php
	Nombre: FUNC_ACCION_DELETE_View.php
    Autor: Brais Rodríguez 
	Fecha de creación: 26/11/2017  
	Función: vista de la tabla de borrado(delete) realizada con una clase donde se muestran todos los datos de una accion de una Funcionalidad y da la opción de borrarlos
*/



//es la clase DELETE de FUNC_ACCION que nos permite borrar una accion de una funcionalidad
class FUNC_ACCION_DELETE {
//es el constructor de la clase FUNC_ACCION_DELETE
	function __construct( $valores, $dependencias ) { 
		$this->valores = $valores; //pasamos los valores de cada uno de los campos
		$this->dependencias = $dependencias; //pasamos las dependdencias de la tabla a la hora de borrar
		$this->render( $this->valores, $this->dependencias );//llamamos a la función render donde se mostrará el formulario DELETE con los campos correspondientes
	}
//funcion que mostrará el formulario DELETE con los campos correspondientes
	function render( $valores, $dependencias ) { 
		$this->valores = $valores;//pasamos los valores de cada uno de los campos
		$this->dependencias = $dependencias; //pasamos las dependdencias de la tabla a la hora de borrar
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
						<?php echo $strings['NombreFuncionalidad'];?>
					</th>
					<td>
						<?php echo $this->valores['NombreFuncionalidad']?>
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
				
			</table>
            <br>
            <br>
            
            <?php
            
            if($dependencias != null){ //si hay dependencias a la hora de borrar
                
                echo $strings['Debe eliminar antes todas las dependencias para poder borrar este dato.'];
                ?>
                <br>
                <br>
            <table>
                    <th>
                        <?php echo $strings['NOMBRE_GRUPO'];?>
                    </th>
                
                    <th>
                        <?php echo $strings['NombreFunc'];?>
                    </th>
                
                    <th>
                        <?php echo $strings['NombreAc'];?>
                    </th>
                
            <?php
            
				while ( $fila = mysqli_fetch_array( $dependencias ) ) { //este bucle se repite mientras se devuelven todas las dependencias
            ?>
			
            <tr>

                    <td>
                        <?php 
				        echo $fila['NombreGrupo'];
                            
                        ?>
					</td>
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
            <form action='../Controllers/FUNC_ACCION_CONTROLLER.php' method="post" style="display: inline">
				<input type="hidden" name="IdFuncionalidad" value=<?php echo $this->valores['IdFuncionalidad'] ?> />
				<button type="submit"><img src="../Views/icon/atras.png" alt="<?php echo $strings['Atras'] ?>"/></button>
			</form>
            <?php
                
            }
        
            else{ //si no hay dependencias
                
           
              ?>  
            
            
			<p style="text-align:center;">
				<?php echo $strings['¿Está seguro de que quiere borrar esta tupla de la tabla?']; ?>
			</p>
			<form action="../Controllers/FUNC_ACCION_CONTROLLER.php" method="post" style="display: inline">
				<input type="hidden" name="IdFuncionalidad" value=<?php echo $this->valores['IdFuncionalidad'] ?> />
				<input type="hidden" name="IdAccion" value=<?php echo $this->valores['IdAccion'] ?> />
				
				<button type="submit" name="action" value="DELETE" width="32" height="32"><img src="../Views/icon/confirmar.png" alt="<?php echo $strings['confirmar'] ?>"/></button>
			</form>
			<form action='../Controllers/FUNC_ACCION_CONTROLLER.php' method="post" style="display: inline">
				<input type="hidden" name="IdFuncionalidad" value=<?php echo $this->valores['IdFuncionalidad'] ?> />
				<button type="submit"><img src="../Views/icon/cancelar.png" alt="<?php echo $strings['Atras'] ?>"/></button>
			</form>
		</div>
<?php
            }
		include '../Views/Footer.php';//incluimos el pie de la página
            
	}
}

?>