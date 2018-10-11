<?php
/* 
	Fecha de creación: 16/12/2017 
	Función: vista que muestra las notas de un alumno 
    Autor:Alejandro Vila
*/

//esta clase muestra las notas de un alumno
class NOTA_TRABAJO_SHOWMISNOTAS {
        //es el constructor de la clase  NOTA_TRABAJO_SHOWMISNOTAS
	function __construct( $lista, $datos) { 
		$this->lista = $lista;//pasamos cada uno de los campos de la tabla
		$this->datos = $datos;//pasamos los valores de cada campo
		$this->render($this->lista,$this->datos);//funcion que mostrará un formulario SHOWALL con los campos correspondientes
	}
	//funcion que mostrará un formulario SHOWALL con los campos correspondientes
	function render($lista,$datos){
		$this->lista = $lista;//pasamos cada uno de los campos de la tabla
		$this->datos = $datos;//pasamos los valores de cada campo
		include '../Locales/Strings_' . $_SESSION[ 'idioma' ] . '.php';//incluimos los strings de idiomas, para que la página pueda estar en español,inglés y galego
		include '../Views/Header.php';//incluimos la cabecera
		include_once '../Functions/permisosAcc.php';//incluimos este fichero para saber los permisos del usuario
?>
		<div class="seccion">
			<h2>
				<?php echo $strings['Tabla de datos'];?>
			</h2>
			<table>
				<caption style="margin-bottom:10px;">
					<form action='../Controllers/NOTA_TRABAJO_CONTROLLER.php'>
<?php if(permisosAcc($_SESSION['login'],7,0)==true){  //miramos si el usuario tiene permiso para añadir
		?>
						<button type="submit" name="action" value="ADD"><img src="../Views/icon/añadir.png" alt="AÑADIR" /></button>
<?php } ?>
					</form>
				</caption>
				<tr>
<?php
					foreach ( $lista as $atributo ) { //este bucle mostrará cada uno de los campos correspondientes a las notas
?>
					<th>
						<?php echo $strings[$atributo]?>
					</th>
                    
<?php
					}
                    
                ?>
                    
                    <?php
		if((permisosAcc($_SESSION['login'],7,1)==true)||(permisosAcc($_SESSION['login'],7,2)==true)||        (permisosAcc($_SESSION['login'],7,4)==true)){ //mirmaos si el usuario tiene permiso: edit,search,delete.
?>
					<th colspan="3" >
						<?php echo $strings['Opciones']?>
					</th>
<?php } ?>
				</tr>
<?php           
                $suma=0;//Variable que almacena la suma que será la nota final de un alumno
				while ( $fila = mysqli_fetch_array( $this->datos ) ) { //este bucle devolverá las tuplas de la tabla NOTA_TRABAJO
?>
				<tr>
<?php
					foreach ( $lista as $atributo ) { //este bucle devolverá los valores de una tupla
?>
					<td>
<?php 
							echo $fila[ $atributo ];

?>
					</td>
                  
                    
                   
<?php
					}
                    ?>
                    
                    <td>
                    <?php
                    $suma = $suma + $fila['NotaTrabajo'];//Variable que almacena la nota final
            
                    ?>
                    </td>
                    

					<td>
						<form action="../Controllers/NOTA_TRABAJO_CONTROLLER.php" method="get" style="display:inline" >
							<input type="hidden" name="login" value="<?php echo $fila['login']; ?>">
                            <input type="hidden" name=IdTrabajo value="<?php echo $fila['IdTrabajo']; ?>">
<?php         if(permisosAcc($_SESSION['login'],7,2)==true){ //miramos si el usuario tiene permiso para editar ?>
								<button type="submit" name="action" value="EDIT" ><img src="../Views/icon/modificar.png" alt="<?php echo $strings['Modificar']?>" width="20" height="20" /></button>
<?php } ?>
					<td>
<?php         if(permisosAcc($_SESSION['login'],7,1)==true){ //miramos si el usuario tiene permiso para borrar ?>
								<button type="submit" name="action" value="DELETE" ><img src="../Views/icon/eliminar.png" alt="<?php echo $strings['Eliminar']?>" width="20" height="20" /></button>
<?php } ?>
					<td>
<?php         if(permisosAcc($_SESSION['login'],7,4)==true){ //miramos si el usuario tiene permiso para ver en detalle ?>
								<button type="submit" name="action" value="SHOWCURRENT" ><img src="../Views/icon/verDetalles.png" alt="<?php echo $strings['Ver en detalle']?>" width="20" height="20"/></button>
<?php } ?>
						</form>

				
<?php
				}
        ?>
                
                
                    </tr>
			</table>

<?php
        echo '<br>';

                    echo "Nota final:".$suma;//devolvemos la nota final
        
?>
            
            
			<form action='../Controllers/NOTA_TRABAJO_CONTROLLER.php' method="post">
				<button type="submit"  name="action" value="SHOWMISNOTAS" ><img src="../Views/icon/atras.png" alt="<?php echo $strings['Atras']?>" /></button>
			</form>
		</div>
<?php
		include '../Views/Footer.php';//mostamos el pie de la página
		}
		}
?>