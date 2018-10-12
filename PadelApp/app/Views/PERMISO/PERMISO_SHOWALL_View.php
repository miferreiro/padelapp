<?php
/* 
	Archivo php
	Fecha de creación: 27/11/2017 
	Autor: Jonatan Couto
	Función: vista de tabla de datos(showall) realizada con una clase donde se muestran datos caracteristicos y permite mostrar los permisos que existen
*/
//Es la clase SHOWALL de PERMISO que nos permite mostrar todas los permisos
class PERMISO_SHOWALL {
	//es el constructor de la clase PERMISO_SHOWALL
	function __construct( $lista, $datos,$PERMISO,$admin) {
		$this->lista = $lista;//pasamos una array con los campos a mostrar
		$this->datos = $datos;//pasamos el valor de los datos que queremos mostrar
		$this->PERMISO = $PERMISO;
		$this->admin = $admin;
		$this->render($this->lista,$this->datos,$this->PERMISO,$this->admin);
	}
	//función render donde se mostrará la vista SHOWALL con los campos correspondientes
	function render($lista,$datos,$PERMISO,$admin){
		$this->lista = $lista;//pasamos una array con los campos a mostrar
		$this->datos = $datos;//pasamos el valor de los datos que queremos mostrar
		$this->PERMISO = $PERMISO;//pasamos los permisos
		$this->admin = $admin;//pasamos una variable booleana: true si es administrador y false si no es administrador
		include '../Locales/Strings_' . $_SESSION[ 'idioma' ] . '.php';//incluimos los strings de idiomas, para que la página pueda estar en español,inglés y galego

//pasamos a todas las variables el valor false porque no tienen dicho permiso	
$SEARCH=false;	//pasamos a la variable el valor false porque no tiene dicho permiso
$GESTUSU=false;//pasamos a la variable el valor false porque no tiene dicho permiso
$GESTGRUP=false;//pasamos a la variable el valor false porque no tiene dicho permiso
$GESTFUNC=false;//pasamos a la variable el valor false porque no tiene dicho permiso
$GESTACC=false;//pasamos a la variable el valor false porque no tiene dicho permiso
$GESTPERM=false;//pasamos a la variable el valor false porque no tiene dicho permiso		
$GESTQAS=false;	//pasamos a la variable el valor false porque no tiene dicho permiso	
$GESTENTR=false;//pasamos a la variable el valor false porque no tiene dicho permiso		
$GESTHIST=false;//pasamos a la variable el valor false porque no tiene dicho permiso
$GESTTRAB=false;//pasamos a la variable el valor false porque no tiene dicho permiso		
$GESTEVAL=false;//pasamos a la variable el valor false porque no tiene dicho permiso		
		
	if($admin==true){//si es administrador, tiene todos los permisos, por eso le pasamos el valor true a todas las variables

			    $SEARCH=true;			
	}	
	while ( $fila = mysqli_fetch_array( $PERMISO ) ) {//este bucle se va a repetir mientras haya permisos

	 if($fila['IdFuncionalidad']=='1'){//si se tiene el permiso de gestión de usuario se pone la variable a true
				$GESTUSU=true;
			   }
	 if($fila['IdFuncionalidad']=='2'){//si se tiene el permiso de gestión de grupo se pone la variable a true
				$GESTGRUP=true;
			   }
	 if($fila['IdFuncionalidad']=='5'){//si se tiene el permiso de gestión de permisos se pone la variable a true
				$GESTPERM=true;

		 if($fila['IdAccion']=='3'){//si se tiene la acción de buscar se pone la variable a true
			    $SEARCH=true;	
			   }

			   }
	 if($fila['IdFuncionalidad']=='3'){//si se tiene el permiso de gestión de funcionalidad se pone la variable a true
				$GESTFUNC=true;
			   }
	 if($fila['IdFuncionalidad']=='4'){//si se tiene el permiso de gestión de accion se pone la variable a true
				$GESTACC=true;
			   }

			}
	include '../Views/Header.php';		//incluimos la cabecera	
?>
		<div class="seccion">
			<h2>
				<?php echo $strings['Gestión de permisos'];?>
			</h2>
			<table>
				<tr>
<?php
					foreach ( $lista as $atributo ) {//este bucle se va a recorrer mientres queden campos por mostrar
?>
					<th>
						<?php echo $strings[$atributo]?>
					</th>
<?php
					}
?>
				</tr>
<?php
				while ( $fila = mysqli_fetch_array( $this->datos ) ) {//este bucle se va a repetir mientras no se muestren todos los datos
?>
				<tr>
<?php
					foreach ( $lista as $atributo ) {//este bucle se va a recorrer mientres queden campos por mostrar
?>
					<td>
<?php 
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
			<caption style="margin-bottom:10px;">
					<form action='../Controllers/PERMISO_CONTROLLER.php'>
<?php if($SEARCH==true){  //miramos si tiene la accion de search?>
						<button type="submit" name="action" value="SEARCH"><img src="../Views/icon/buscar.png" alt="BUSCAR" /></button>	
<?php } ?>
					</form>
				</caption>
			</table>
			<form action='../Controllers/PERMISO_CONTROLLER.php' method="post">
				<button type="submit"><img src="../Views/icon/atras.png" alt="<?php echo $strings['Atras']?>" /></button>
			</form>
		</div>
<?php
		include '../Views/Footer.php';//incluimos el footer
		}
		}
?>