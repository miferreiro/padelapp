<?php
/*  Archivo php
	Nombre: GRUPO_DELETE_View.php
	Autor: 	Alejandro Vila
	Fecha de creación: 20/11/2017 
	Función: vista de la tabla de borrado(delete) realizada con una clase donde se muestran todos los valores de un grupo y da la opción de borrarlos
*/
//Creamos la clase GRUPO_DELETE
class GRUPO_DELETE {
	//Constructor de la clase
	function __construct( $valores, $valores2 , $lista, $dependencias, $dependencias2) {
		$this->valores = $valores;//Variable que almacena el contenido de la tupla grupo que se desea borrar  
		$this->valores2 = $valores2;//Variable que almacena los datos de grupo
		$this->lista = $lista;//Variable que contiene el array de los atributos a mostrar en la vista
		$this->dependencias = $dependencias;//Variable que almacena todas las dependencias de la tabla GRUPO a la hora de borrar
		$this->dependencias2 = $dependencias2;//Variable que almacena todas las dependencias de la tabla GRUPO a la hora de borrar
		$this->render( $this->valores, $this->valores2, $this->lista , $this->dependencias, $this->dependencias2 );
	}
	//Función que contiene el código de la vista
	function render( $valores, $valores2, $lista, $dependencias, $dependencias2 ) {
		$this->valores = $valores;//Variable que almacena el contenido de la tupla grupo que se desea borrar 
		$this->valores2 = $valores2;//Variable que almacena los datos de grupo
		$this->lista = $lista;//Variable que contiene el array de los atributos a mostrar en la vista
		$this->dependencias = $dependencias;//Variable que almacena todas las dependencias de la tabla GRUPO a la hora de borrar
		$this->dependencias2 = $dependencias2;//Variable que almacena todas las dependencias de la tabla GRUPO a la hora de borrar
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
						<?php echo $strings['IdGrupo'];?>
					</th>
					<td>
						<?php echo $this->valores2['IdGrupo']?>
					</td>
				</tr>
				<tr>
					<th>
						<?php echo $strings['NombreGrupo'];?>
					</th>
					<td>
						<?php echo $this->valores2['NombreGrupo']?>
					</td>
				</tr>
				<tr>
					<th>
						<?php echo $strings['DescripGrupo'];?>
					</th>
					<td>
						<?php echo $this->valores2['DescripGrupo']?>
					</td>
				</tr>
	
			</table>
			<br>
			<br>
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
<?php
				//Bucle que recorre todo el recordset de datos y pasa estos valores a array y los muestra
				while ( $fila = mysqli_fetch_array( $valores ) ) {
?>
				<tr>
<?php
					//Bucle que recorre todo el recordset de datos y pasa estos valores a array y los muestra
					foreach ( $lista as $atributo ) {
?>
					<td>
<?php 
							//Muestra el valor del array para cada atributo
							echo $fila[ $atributo ];
?>
					</td>
<?php
					}
?>
						

				</tr>
<?php
				}
?>
				
			</table>
            <br>
            
             <?php
        //Si hay dependencias a la hora de borrar un grupo mostrar un mensaje y la información que se tiene que borrar de la que dependen los datos
        if($dependencias != null || $dependencias2 !=null){
            
            echo $strings['Debe eliminar antes todas las dependencias para poder borrar este dato.'];
            echo "<br>";
            ?>
            
            <?php
            //Comprobamos si dependencias es distinto de null, si es distinto muestra las dependencias en una tabla
            if($dependencias != null){
                ?>
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
            	//Bucle que recorre todo el recordset de datos y pasa estos valores a array y los muestra
				while ( $fila = mysqli_fetch_array( $dependencias) ) {
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
            }
            ?>
            </table>
            <?php
             //if redundante para que verifique que dependencias 2 es realmente distinto de null
            if($dependencias2 != null){
                
            }
            ?>
            <form action='../Controllers/GRUPO_CONTROLLER.php' method="post" style="display: inline">
				<button type="submit"><img src="../Views/icon/atras.png" alt="<?php echo $strings['Atras'] ?>"/></button>
			</form>
            <?php
           
    }
    		//Si no hay dependencias deja bojar la tupla sin problema
            if($dependencias == null && $dependencias2 ==null){

                ?>
			<p style="text-align:center;">
				<?php echo $strings['¿Está seguro de que quiere borrar este grupo de la tabla?'];?>
			</p>
			<form action="../Controllers/GRUPO_CONTROLLER.php" method="post" style="display: inline">
				<input type="hidden" name="IdGrupo" value=<?php echo $valores2['IdGrupo'] ?> />
				<input type="hidden" name="NombreGrupo" value=<?php echo $valores2['NombreGrupo'] ?> />
				<input type="hidden" name="DescripGrupo" value=<?php echo $valores2['DescripGrupo'] ?> />
				<button type="submit" name="action" value="DELETE" ><img src="../Views/icon/confirmar.png" alt="<?php echo $strings['Confirmar'] ?>"/></button>
			</form>
			<form action='../Controllers/GRUPO_CONTROLLER.php' method="post" style="display: inline">
				<button type="submit"><img src="../Views/icon/cancelar.png" alt="<?php echo $strings['Atras'] ?>"/></button>
			</form>
		</div>
<?php
            }
		include '../Views/Footer.php';
         
     }
	}

?>