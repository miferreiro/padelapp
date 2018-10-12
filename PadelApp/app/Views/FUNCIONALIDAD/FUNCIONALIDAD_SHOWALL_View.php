<?php
/*  Archivo php
	Nombre: FUNCIONALIDAD_SHOWALL_View.php
	Autor: 	Brais Rodríguez
	Fecha de creación: 22/11/2017 
	Función: vista de tabla de datos(showall) realizada con una clase donde se muestran datos caracteristicos y permite seleccionar la funcionalidad que se desea realizar en la aplicación
*/


//es la clase SHOWALL de FUNCIONALIDAD que nos permite mostrar todas funcionalidades
class FUNCIONALIDAD_SHOWALL {
//es el constructor de la clase FUNCIONALIDAD_SHOWALL
	function __construct( $lista, $datos, $PERMISO,$admin) { 
		$this->lista = $lista;//pasamos los campos de la tabla FUNCIONALIDAD
		$this->datos = $datos;//pasamos cada una de las tuplas de la tabla FUNCIONALIDAD
		$this->PERMISO = $PERMISO;//pasamos los permisos
		$this->admin = $admin;//pasamos una variable boolena, true si es administrador, false en caso contrario
		$this->render($this->lista,$this->datos,$this->PERMISO,$this->admin);//llamamos a la función render donde se mostrará el formulario showall con los campos correspondientes
	}
	
    //función render donde se mostrará el formulario showall con los campos correspondientes
	function render($lista,$datos,$PERMISO,$admin){
		$this->lista = $lista;//pasamos los campos de la tabla FUNCIONALIDAD
		$this->datos = $datos;//pasamos cada una de las tuplas de la tabla FUNCIONALIDAD
		$this->PERMISO = $PERMISO;//pasamos los permisos
		$this->admin = $admin;//pasamos una variable boolena, true si es administrador, false en caso contrario
		include '../Locales/Strings_' . $_SESSION[ 'idioma' ] . '.php';//incluimos los strings de idiomas, para que la página pueda estar en español,inglés y galego
	
        
//pasamos a todas las variables el valor false porque no tienen dicho permiso        
$ADD=false;//pasamos a la  variable  el valor false porque no tiene dicho permiso
$EDIT=false;	//pasamos a la  variable  el valor false porque no tiene dicho permiso
$SEARCH=false;//pasamos a la  variable  el valor false porque no tiene dicho permiso	
$DELETE=false;//pasamos a la  variable  el valor false porque no tiene dicho permiso	
$SHOW=false;//pasamos a la  variable  el valor false porque no tiene dicho permiso
$ASIGN=false;//pasamos a la  variable  el valor false porque no tiene dicho permiso
$GESTUSU=false;//pasamos a la  variable  el valor false porque no tiene dicho permiso
$GESTGRUP=false;//pasamos a la  variable  el valor false porque no tiene dicho permiso
$GESTFUNC=false;//pasamos a la  variable  el valor false porque no tiene dicho permiso
$GESTACC=false;//pasamos a la  variable  el valor false porque no tiene dicho permiso
$GESTPERM=false;//pasamos a la  variable  el valor false porque no tiene dicho permiso		
$GESTQAS=false;//pasamos a la  variable  el valor false porque no tiene dicho permiso		
$GESTENTR=false;//pasamos a la  variable  el valor false porque no tiene dicho permiso		
$GESTHIST=false;//pasamos a la  variable  el valor false porque no tiene dicho permiso
$GESTTRAB=false;//pasamos a la  variable  el valor false porque no tiene dicho permiso		
$GESTEVAL=false;//pasamos a la  variable  el valor false porque no tiene dicho permiso		
		
	if($admin==true){ //si es administrador, tiene todos los permisos, por eso le pasamos el valor true a todas las variables
			    $ADD=true;	//pasamos el valor true a la variable
			    $DELETE=true;//pasamos el valor true a la variable				   
			    $EDIT=true;	//pasamos el valor true a la variable
			    $SEARCH=true;//pasamos el valor true a la variable	
			    $SHOW=true;	//pasamos el valor true a la variable
			    $ASIGN=true;//pasamos el valor true a la variable	
	}	
	while ( $fila = mysqli_fetch_array( $PERMISO ) ) { //este bucle se va a repetir mientras haya permisos

	 if($fila['IdFuncionalidad']=='1'){ //si se tiene el permiso de gestión de usuario se pone la variable a true
				$GESTUSU=true;
			   }
	 if($fila['IdFuncionalidad']=='2'){ //si se tiene el permiso de gestión de grupo se pone la variable a true
				$GESTGRUP=true;
			   }
	 if($fila['IdFuncionalidad']=='5'){ //si se tiene el permiso de gestión de permisos se pone la variable a true
				$GESTPERM=true;
			   }
	 if($fila['IdFuncionalidad']=='3'){ //si se tiene el permiso de gestión de funcionalidad se pone la variable a true
				$GESTFUNC=true;
		 if($fila['IdAccion']=='0'){ //si se tiene la acción de añadir se pone la variable a true
			    $ADD=true;	
			   }
		 if($fila['IdAccion']=='1'){ //si se tiene la acción de borrar se pone la variable a true
			    $DELETE=true;	
			   }
		 if($fila['IdAccion']=='2'){ //si se tiene la acción de editar se pone la variable a true
			    $EDIT=true;	
			   }
		 if($fila['IdAccion']=='3'){ //si se tiene la acción de buscar se pone la variable a true
			    $SEARCH=true;	
			   }
		 if($fila['IdAccion']=='4'){ //si se tiene la acción de showall se pone la variable a true
			    $SHOW=true;	
			   }
		 if($fila['IdAccion']=='6'){ //si se tiene la acción de asignar se pone la variable a true
			    $ASIGN=true;	
			   }
			   }
	 if($fila['IdFuncionalidad']=='4'){ //si se tiene el permiso de gestión de accion se pone la variable a true
				$GESTACC=true;
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
					<form action='../Controllers/FUNCIONALIDAD_CONTROLLER.php'>

<?php if($SEARCH==true){ //miramos se tiene la accion de buscar  ?>
						<button type="submit" name="action" value="SEARCH"><img src="../Views/icon/buscar.png" alt="BUSCAR" /></button>	
<?php
	 }

		if($ADD == true){   //miramos se tiene la accion de añadir
?>
						<button type="submit" name="action" value="ADD"><img src="../Views/icon/añadir.png" alt="AÑADIR" /></button>
<?php 
		}
?>
					</form>
				</caption>
				<tr>
<?php
					foreach ( $lista as $atributo ) { //este bucle se va a recorrer mientres queden campos por mostrar
?>
					<th>
						<?php echo $strings[$atributo]?>
					</th>
<?php
					}
		if($EDIT==true || $SHOW==true || $DELETE==true || $ASIGN==true){ //miramos si tiene la accion de editar,borrar y showall
?>
					<th colspan="4" >
						<?php echo $strings['Opciones']?>
					</th>
<?php } ?>
				</tr>
<?php
				while ( $fila = mysqli_fetch_array( $this->datos ) ) { //este bucle se va a repetir mientras no se muestren todos los datos
?>
				<tr>
<?php
					foreach ( $lista as $atributo ) { //este bucle se va a repetir mientras se muestre todos los campos
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
						<form action="../Controllers/FUNCIONALIDAD_CONTROLLER.php" method="get" style="display:inline" >
							
							<input type="hidden" name="IdFuncionalidad" value="<?php echo $fila['IdFuncionalidad']; ?>">
							<?php if($EDIT==true){ //miramos si tiene la accion de editar ?>
								<button type="submit" name="action" value="EDIT" ><img src="../Views/icon/modificar.png" alt="<?php echo $strings['Modificar']?>" width="20" height="20" /></button>
						    <?php } ?>
					<td>
							<?php if($DELETE==true){ //miramos si tiene la accion de borrar?>
								<button type="submit" name="action" value="DELETE" ><img src="../Views/icon/eliminar.png" alt="<?php echo $strings['Eliminar']?>" width="20" height="20" /></button>
							<?php } ?>
					<td>
							<?php if($SHOW==true){ ?>
								<button type="submit" name="action" value="SHOWCURRENT" ><img src="../Views/icon/verDetalles.png" alt="<?php echo $strings['Ver en detalle']?>" width="20" height="20"/></button>
							<?php } ?>
						</form>
				    <td>
							<?php if($ASIGN==true){ //miramos si tiene la accion de showall ?>
						<form action="../Controllers/FUNC_ACCION_CONTROLLER.php" method="get" style="display:inline" >
							<input type="hidden" name="IdFuncionalidad" value="<?php echo $fila['IdFuncionalidad']; ?>">
							<button type="submit" ><img src="../Views/icon/accion.png" width="20" height="20"/></button>
						</form>
							<?php } ?>

				</tr>
<?php
				}
?>
			</table>
			<form action='../Controllers/FUNCIONALIDAD_CONTROLLER.php' method="post">
				<button type="submit"><img src="../Views/icon/atras.png" alt="<?php echo $strings['Atras']?>" /></button>
			</form>
		</div>
<?php
		include '../Views/Footer.php'; //incluimos el pie de la pagina
		}
		}
?>