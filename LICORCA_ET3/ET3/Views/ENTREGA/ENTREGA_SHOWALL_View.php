<?php
/*  Archivo php
	
	Autor: 	Brais Santos
	Fecha de creación: 29/11/2017 
	Función: vista de tabla de datos(showall) realizada con una clase donde se muestran datos caracteristicos y permite seleccionar la entrega deseada
*/


//es la clase SHOWALL de ENTREGA que nos permite editar una entrega
class ENTREGA_SHOWALL {
	//es el constructor de ENTREGA_SHOWALL
	function __construct( $lista, $datos) { 
		$this->lista = $lista;//Variable que almacena los atributos a mostrar de la tabla ENTREGA
		$this->datos = $datos;//Variable que almacena los valores de cada uno de los campos
		$this->render($this->lista,$this->datos/*,$this->PERMISO,$this->admin*/);//llamamos a la función render donde se mostrará el formulario SHOWALL con los campos correspondientes
	}
	//llamamos a la función render donde se mostrará el formulario SHOWALL con los campos correspondientes
	function render($lista,$datos){
		$this->lista = $lista;//Variable que almacena cada uno de los atributos a mostrar de la tabla ENTREGA
		$this->datos = $datos;//Variable que almacena los valores de cada uno de los campos
		include '../Locales/Strings_' . $_SESSION[ 'idioma' ] . '.php';//incluimos los strings de idiomas, para que la página pueda estar en español,inglés y galego
        include_once '../Functions/permisosAcc.php';//incluimos este fichero para saber que permisos tiene el usuario
		include_once '../Functions/comprobarAdministrador.php';//incluimos este fichero para saber si un usuario es administrador

	include '../Views/Header.php';		//incluimos la cabecera	
?>

		<div class="seccion">
			<h2>
				<?php echo $strings['Tabla de datos'];?>
			</h2>
			<table>
				<caption style="margin-bottom:10px;">
					<form action='../Controllers/ENTREGA_CONTROLLER.php'>

<?php if(permisosAcc($_SESSION['login'],8,3)==true){ //miramos si el usuario tiene permiso para buscar ?>
						<button type="submit" name="action" value="SEARCH"><img src="../Views/icon/buscar.png" alt="BUSCAR" /></button>	
<?php }
	  if(permisosAcc($_SESSION['login'],8,0)==true){ //miramos si el usuario tiene permiso para añadir
		?>
						<button type="submit" name="action" value="ADD"><img src="../Views/icon/añadir.png" alt="AÑADIR" /></button>
<?php } ?>
					</form>
				</caption>
				<tr>
<?php
					//bucle que recorre todos los atributos de la tabla a mostrar
					foreach ( $lista as $atributo ) {
?>
					<th>
						<?php echo $strings[$atributo]?>
					</th>
<?php
					}
		if((permisosAcc($_SESSION['login'],8,1)==true)||(permisosAcc($_SESSION['login'],8,2)==true)||        (permisosAcc($_SESSION['login'],8,4)==true)){ //miramos si el usuario tiene los permisos pertinentes 
?>
					<th colspan="4" >
						<?php echo $strings['Opciones']?>
					</th>
<?php } ?>
				</tr>
<?php
				while ( $fila = mysqli_fetch_array( $this->datos ) ) { //este bucle sacará todos valores de cada uno de los campos
?>
				<tr>
<?php
					foreach ( $lista as $atributo ) { //este bucle sacará el valor de cada  campo
?>
					<td>
<?php 
						  if($atributo == 'Ruta'){ //miramos si el campo es la ruta para subir el archivo
                                ?>
                        
                                <a href="<?php echo $fila[$atributo] ?>"><?php echo $fila[$atributo] ?></a>
                        
                                <?php
                            }
                        else //si el campo no es la ruta
							echo $fila[ $atributo ];//mostramos el valor de un campo

?>
					</td>
<?php
					}
?>
					<td>
						<form action="../Controllers/ENTREGA_CONTROLLER.php" method="get" style="display:inline" >
				            <input type="hidden" name="login" value="<?php echo $fila['login']; ?>">
                            <input type="hidden" name="IdTrabajo" value="<?php echo $fila['IdTrabajo']; ?>">
                            
<?php         if(permisosAcc($_SESSION['login'],8,2)==true){ //miramos si el usuario tiene el permiso para editar ?>
								<button type="submit" name="action" value="EDIT" ><img src="../Views/icon/modificar.png" alt="<?php echo $strings['Modificar']?>" width="20" height="20" /></button><!--con este boton pulsas para ver la vista EDIT-->
<?php } ?>
					<td>
<?php         if(permisosAcc($_SESSION['login'],8,1)==true){ //miramos si el usuario tiene el permiso para borrar ?>
								<button type="submit" name="action" value="DELETE" ><img src="../Views/icon/eliminar.png" alt="<?php echo $strings['Eliminar']?>" width="20" height="20" /></button>
                                <!--si pulsas este boton ves la vista DELETE-->
<?php } ?>
					<td>
<?php         if(permisosAcc($_SESSION['login'],8,4)==true){ //miramos si el usuario tiene el permiso para ver en detalle ?>
									<button type="submit" name="action" value="SHOWCURRENT" ><img src="../Views/icon/verDetalles.png" alt="<?php echo $strings['Ver en detalle']?>" width="20" height="20"/></button>
                                <!--si pulsas este boton ves la vista SHOWCURRENT-->
<?php } ?>
						</form>
				    <td>
							
				</tr>
<?php
				}
?>
			</table>
			<!-- Si tiene permisos el usuario al realizar una vuelta atras la realiza a la accion SUBIRET -->
<?php if((permisosAcc($_SESSION['login'],8,5)==false) && (permisosAcc($_SESSION['login'],8,10)==true)){ ?>
			<form action='../Controllers/ENTREGA_CONTROLLER.php?action=SUBIRET' method="post">
				<button type="submit"><img src="../Views/icon/atras.png" alt="<?php echo $strings['Atras']?>" /></button>
			</form>
			<!-- Si no tiene permisos la vuelta atras la realiza a la accion por defecto del usuario  -->
<?php }else{ ?>
			<form action='../Controllers/ENTREGA_CONTROLLER.php' method="post">
				<button type="submit" ><img src="../Views/icon/atras.png" alt="<?php echo $strings['Atras']?>" /></button>
			</form>
<?php } ?>
		</div>
<?php
		include '../Views/Footer.php';//incluimos el pie de la página 
		}
		}
?>























