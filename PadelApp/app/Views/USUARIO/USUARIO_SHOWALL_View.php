<?php
/*  Archivo php
	Nombre: USUARIOS_SHOWALL_View.php
	Autor: 	Alejandro Vila
	Fecha de creación: 29/11/2017 
	Función: vista de tabla de datos(showall) realizada con una clase donde se muestran datos caracteristicos y permite seleccionar el usuario desado en la tupla.
*/

//es la clase SHOWALL de USUARIO que nos permite mostrar todos los usuarios
class USUARIO_SHOWALL {

    //es el constructor de la clase USUARIO_SHOWALL
	function __construct( $lista, $datos, $PERMISO, $admin) {
		$this->lista = $lista;//pasamos los campos de la tabla USUARIO
		$this->datos = $datos;//pasamos los valores de cada campo
		$this->PERMISO = $PERMISO;//pasamos los permisos
		$this->admin = $admin;//pasamos un variable booleana, true es administrador, false no es administrador
		$this->render($this->lista,$this->datos,$this->PERMISO,$this->admin);//llamamos a la función render donde se mostrará el formulario SHOWALL con los campos correspondientes
	}
	
    
    //funcion que mostrará el formulario SHOWALL con los campos correspondientes
	function render($lista,$datos,$PERMISO,$admin){
		$this->lista = $lista;//pasamos los campos de la tabla USUARIO
		$this->datos = $datos;//pasamos los valores de cada campo
		$this->PERMISO = $PERMISO;//pasamos los permisos
		$this->admin = $admin;//pasamos un variable booleana, true es administrador, false no es administrador
		include '../Locales/Strings_' . $_SESSION[ 'idioma' ] . '.php';//incluimos los strings de idiomas, para que la página pueda estar en español,inglés y galego

        
//metemos a todas las variables(acciones) el valor false si no es administrador
$ADD=false;	//pasamos a la variable el valor false porque no tiene dicho permiso
$EDIT=false;	//pasamos a la variable el valor false porque no tiene dicho permiso
$SEARCH=false;//pasamos a la variable el valor false porque no tiene dicho permiso	
$DELETE=false;//pasamos a la variable el valor false porque no tiene dicho permiso	
$SHOW=false;//pasamos a la variable el valor false porque no tiene dicho permiso
$ASIGN=false;//pasamos a la variable el valor false porque no tiene dicho permiso
$GESTUSU=false;//pasamos a la variable el valor false porque no tiene dicho permiso
		
		
	if($admin==true){//miramos si es administrador, si es así todas las acciones van a tener el valor true
			    $ADD=true;//pasamos a la variable el valor true porque  tiene dicho permiso	
			    $DELETE=true;//pasamos a la variable el valor true porque  tiene dicho permiso					   
			    $EDIT=true;	//pasamos a la variable el valor true porque  tiene dicho permiso	
			    $SEARCH=true;//pasamos a la variable el valor true porque  tiene dicho permiso		
			    $SHOW=true;//pasamos a la variable el valor true porque  tiene dicho permiso		
			    $ASIGN=true;//pasamos a la variable el valor true porque  tiene dicho permiso		
	}	
	while ( $fila = mysqli_fetch_array( $PERMISO ) ) {//este bucle se va a repetir mientras haya permisos

	 if($fila['IdFuncionalidad']=='1'){//miramos si tiene la funcionalidad de gestion de usuarios
				$GESTUSU=true;
		 if($fila['IdAccion']=='0'){//miramos si tiene la accion de añadir
			    $ADD=true;	
			   }
		 if($fila['IdAccion']=='1'){//miramos si tiene la accion de borrar
			    $DELETE=true;	
			   }
		 if($fila['IdAccion']=='2'){//miramos si tiene la accion de editar
			    $EDIT=true;	
			   }
		 if($fila['IdAccion']=='3'){//miramos si tiene la accion de buscar
			    $SEARCH=true;	
			   }
		 if($fila['IdAccion']=='4'){//miramos si tenemos la accion de showcurrent
			    $SHOW=true;	
			   }
		 if($fila['IdAccion']=='6'){//miramos si tenemos la accion de asignar
			    $ASIGN=true;	
			   }
			   }
			}
	include '../Views/Header.php';//incluimos la cabecera			
?>

		<div class="seccion">
			<h2>
				<?php echo $strings['Tabla de datos'];?>
			</h2>
			<table>
				<caption style="margin-bottom:10px;">
					<form action='../Controllers/USUARIO_CONTROLLER.php'>

<?php if($SEARCH==true){ //miramos si tiene la accion search  ?>
						<button type="submit" name="action" value="SEARCH"><img src="../Views/icon/buscar.png" alt="BUSCAR" /></button>	
<?php }
		if($ADD==true){ //miramos si tiene la accion showall  ?>
						<button type="submit" name="action" value="ADD"><img src="../Views/icon/añadir.png" alt="AÑADIR" /></button>
<?php } ?>
					</form>
				</caption>
				<tr>
<?php
					foreach ( $lista as $atributo ) { //este bucle devolverá cada uno de los campos de la tabla USUARIO
?>
					<th>
						<?php echo $strings[$atributo]?>
					</th>
<?php
					}
		if($EDIT==true || $SHOW==true || $DELETE==true || $ASIGN==true){ //miramos si el usuario tiene permiso para:editar,showcurrent,borrar y asignar
?>
					<th colspan="4" >
						<?php echo $strings['Opciones']?>
					</th>
<?php } ?>
				</tr>
<?php
				while ( $fila = mysqli_fetch_array( $this->datos ) ) { //este bucle va a devolver todas las tuplas de la tabla USUARIO de la base de datos
?>
				<tr>
<?php
					foreach ( $lista as $atributo ) { //este bucle va a ir devolviendo el valor de cada campo de la tabal usuario
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
						<form action="../Controllers/USUARIO_CONTROLLER.php" method="get" style="display:inline" >
							<input type="hidden" name="login" value="<?php echo $fila['login']; ?>">
							<?php if($EDIT==true){ //miramos si el usuario tiene el permiso para editar ?>
								<button type="submit" name="action" value="EDIT" ><img src="../Views/icon/modificar.png" alt="<?php echo $strings['Modificar']?>" width="20" height="20" /></button>
						    <?php } ?>
					<td>
							<?php if($DELETE==true){ //miramos si el usuario tiene el permiso para borrar ?>
								<button type="submit" name="action" value="DELETE" ><img src="../Views/icon/eliminar.png" alt="<?php echo $strings['Eliminar']?>" width="20" height="20" /></button>
							<?php } ?>
					<td>
							<?php if($SHOW==true){ //miramos si el usuario tiene el permiso para ver en detalle?>
								<button type="submit" name="action" value="SHOWCURRENT" ><img src="../Views/icon/verDetalles.png" alt="<?php echo $strings['Ver en detalle']?>" width="20" height="20"/></button>
							<?php } ?>
						</form>
				    <td>
							<?php if($ASIGN==true){ //miramos si el usuario tiene el permiso para asignar?>
						<form action="../Controllers/USU_GRUPO_CONTROLLER.php" method="get" style="display:inline" >
							<input type="hidden" name="login" value="<?php echo $fila['login']; ?>">
							<button type="submit" ><img src="../Views/icon/cambioGrupo.png" width="20" height="20"/></button>
						</form>
							<?php } ?>
				</tr>
<?php
				}
?>
			</table>
			<form action='../Controllers/USUARIO_CONTROLLER.php' method="post">
				<button type="submit"><img src="../Views/icon/atras.png" alt="<?php echo $strings['Atras']?>" /></button>
			</form>
		</div>
<?php
		include '../Views/Footer.php';//incluimos el pie de la página
		}
		}
?>