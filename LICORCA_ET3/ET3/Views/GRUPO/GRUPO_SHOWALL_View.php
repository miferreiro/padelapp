<?php
/*  Archivo php
	Nombre: GRUPO_SHOWALL_View.php
	Autor: 	Alejandro Vila
	Fecha de creación: 21/11/2017 
	Función: vista de tabla de datos(showall) realizada con una clase donde se muestran datos caracteristicos y permite seleccionar el grupo deseado
*/
//Clase Grupo_showall que contiene la vista para ver todos los grupos
class GRUPO_SHOWALL {
	//Constructor de la clase
	function __construct( $lista, $datos, $PERMISO, $admin) {
		$this->lista = $lista;//Variable que contiene el array de los atributos a mostrar en la vista
		$this->datos = $datos;//Variable que contiene el recordset con la info de los grupos
		$this->PERMISO = $PERMISO;//Variable que almacena un array con los permisos
		$this->admin = $admin;//Variable que almacena un booleano para saber si es admin
		$this->render($this->lista,$this->datos,$this->PERMISO,$this->admin);//metodo que llama a la función render que contiene todo el código de la vista
	}
	//Función que contiene el código de la vista
	function render($lista,$datos,$PERMISO,$admin){
		$this->lista = $lista;//Variable que contiene el array de los atributos a mostrar en la vista
		$this->datos = $datos;//Variable que contiene el recordset con la info de los grupos
		$this->PERMISO = $PERMISO;//Variable que almacena un array con los permisos
		$this->admin = $admin;//Variable que almacena un booleano para saber si es admin
		include '../Locales/Strings_' . $_SESSION[ 'idioma' ] . '.php';//Incluye el contenido de los strings necesarios para el multiidioma

$ADD=false;//Variable que almacena un boleano que indica si tiene el permiso ADD	
$EDIT=false;//Variable que almacena un boleano que indica si tiene el permiso EDIT	
$SEARCH=false;//Variable que almacena un boleano que indica si tiene el permiso SEARCH	
$DELETE=false;//Variable que almacena un boleano que indica si tiene el permiso DELETE
$SHOW=false;//Variable que almacena un boleano que indica si tiene el permiso SHOWALL
$ASIGN=false;//Variable que almacena un boleano que indica si tiene el permiso ASIGNAR GRUPO
$GESTUSU=false;//Variable que almacena un boleano que indica si tiene el permiso GESTIONUSU
$GESTGRUP=false;//Variable que almacena un boleano que indica si tiene el permiso GESTGRUP
$GESTFUNC=false;//Variable que almacena un boleano que indica si tiene el permiso GESTFUNC
$GESTACC=false;//Variable que almacena un boleano que indica si tiene el permiso GESTACC
$GESTPERM=false;//Variable que almacena un boleano que indica si tiene el permiso GESTPERM
$GESTQAS=false;	//Variable que almacena un boleano que indica si tiene el permiso GESTQAS
$GESTENTR=false;//Variable que almacena un boleano que indica si tiene el permiso GESTENTR
$GESTHIST=false;//Variable que almacena un boleano que indica si tiene el permiso GESTHIST
$GESTTRAB=false;//Variable que almacena un boleano que indica si tiene el permiso GESTRAB		
$GESTEVAL=false;//Variable que almacena un boleano que indica si tiene el permiso GESTEVAL		
	//Si es admin pone los permisos ADD,DELETE,EDIT,SEARCH,SHOWALL,ASIGN a 'true',habilitandole esos permisos
	if($admin==true){
			    $ADD=true;//La variable $ADD pasa a true	
			    $DELETE=true;//La variable $DELETE pasa a true			   
			    $EDIT=true;//La variable $EDIT pasa a true
			    $SEARCH=true;//La variable $SEARCH pasa a true
			    $SHOW=true;//La variable $SHOW pasa a true
			    $ASIGN=true;//La variable $ASIGN pasa a true
	}
	//Bucle que recorre todo el recordset de permiso  	
	while ( $fila = mysqli_fetch_array( $PERMISO ) ) {
	//Si el valor de funcionalida es 1 se activa el permiso GESTUSU
	 if($fila['IdFuncionalidad']=='1'){
				$GESTUSU=true;//La variable $GESTUSU pasa a true
			   }
	 //Si el valor de funcionalida es 2 se activa el permiso GESTUSU y comprueba las acciones
	 if($fila['IdFuncionalidad']=='2'){
				$GESTGRUP=true;//La variable $GESTGRUP pasa a true
		//Si el valor de funcionalida es 0 se activa el permiso ADD
		 if($fila['IdAccion']=='0'){
			    $ADD=true;//La variable $ADD pasa a true
			   }
		//Si el valor de funcionalida es 1 se activa el permiso DELETE
		 if($fila['IdAccion']=='1'){
			    $DELETE=true;//La variable $DELETE pasa a true	
			   }
		//Si el valor de funcionalida es 2 se activa el permiso EDIT
		 if($fila['IdAccion']=='2'){
			    $EDIT=true;//La variable $EDIT pasa a true
			   }
		//Si el valor de funcionalida es 3 se activa el permiso SEARCH
		 if($fila['IdAccion']=='3'){
			    $SEARCH=true;//La variable $SEARCH pasa a true
			   }
		//Si el valor de funcionalida es 4 se activa el permiso SHOWALL
		 if($fila['IdAccion']=='4'){
			    $SHOW=true;//La variable $SHOW pasa a true
			   }
		//Si el valor de funcionalida es 6 se activa el permiso ASIGN
		 if($fila['IdAccion']=='6'){
			    $ASIGN=true;//La variable $ASING pasa a true	
			   }
	 }
	 //Si el valor de funcionalida es 5 se activa el permiso GESTPERM
	 if($fila['IdFuncionalidad']=='5'){
				$GESTPERM=true;//La variable $GESTPERM pasa a true
			   }
	 //Si el valor de funcionalida es 6 se activa el permiso GESTFUNC
	 if($fila['IdFuncionalidad']=='3'){
				$GESTFUNC=true;//La variable $GESTFUNC pasa a true
			   }
	//Si el valor de funcionalida es 6 se activa el permiso GESTACC
	 if($fila['IdFuncionalidad']=='4'){
				$GESTACC=true;//La variable $GESTACC pasa a true
			   }

			}
	include '../Views/Header.php';	//Incluye el contenido del header		
?>
		<div class="seccion">
			<h2>
				<?php echo $strings['Tabla de datos'];?>
			</h2>
			<table>
				<caption style="margin-bottom:10px;">
					<form action='../Controllers/GRUPO_CONTROLLER.php'>
<!-- Si tiene permiso para buscar se habilita el icono -->
<?php if($SEARCH==true){  ?>
						<button type="submit" name="action" value="SEARCH"><img src="../Views/icon/buscar.png" alt="BUSCAR" /></button>
<!-- Si tiene permiso para añadir se habilita el icono -->							
<?php }	if($ADD==true){  ?>
						<button type="submit" name="action" value="ADD"><img src="../Views/icon/añadir.png" alt="AÑADIR" /></button>
<?php } ?>
					</form>
				</caption>
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
		//Si tiene alguno de los permisos de editar showcurrent borrar o asignar permisos muestra la tabla
		if($EDIT==true || $SHOW==true || $DELETE==true || $ASIGN==true){
?>
					<th colspan="4" >
						<?php echo $strings['Opciones']?>
					</th>
<?php } ?>
				</tr>
<?php
				//Bucle que recorre todo el recordset de datos y pasa estos valores a array y los muestra
				while ( $fila = mysqli_fetch_array( $this->datos ) ) {
?>
				<tr>
<?php
					//bucle que recorre el array de los atributos 
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
					<td>
						<form action="../Controllers/GRUPO_CONTROLLER.php" method="get" style="display:inline" >
							<input type="hidden" name="IdGrupo" value="<?php echo $fila['IdGrupo']; ?>">
							<!-- Si tiene permiso de editar se muestra el icono -->
							<?php if($EDIT==true){ ?>
								<button type="submit" name="action" value="EDIT" ><img src="../Views/icon/modificar.png" alt="<?php echo $strings['Modificar']?>" width="20" height="20" /></button>
						    <?php } ?>
					<td>
							<!-- Si tiene permiso de borrar se muestra el icono -->
							<?php if($DELETE==true){ ?>
								<button type="submit" name="action" value="DELETE" ><img src="../Views/icon/eliminar.png" alt="<?php echo $strings['Eliminar']?>" width="20" height="20" /></button>
							<?php } ?>
					<td>	
							<!-- Si tiene permiso de ver showcurrent se muestra el icono -->
							<?php if($SHOW==true){ ?>
								<button type="submit" name="action" value="SHOWCURRENT" ><img src="../Views/icon/verDetalles.png" alt="<?php echo $strings['Ver en detalle']?>" width="20" height="20"/></button>
							<?php } ?>
						</form>
							<!-- Si tiene permiso de asignar o desasignar permisos se muestra el icono -->
							<?php if($ASIGN==true){ ?>
						<form action="../Controllers/PERMISO_CONTROLLER.php" method="get" style="display:inline" >
							<input type="hidden" name="IdGrupo" value="<?php echo $fila['IdGrupo']; ?>">
								<button type="submit" name="action" value="ASSIGN" ><img src="../Views/icon/permiso.png" alt="<?php echo $strings['Ver en detalle']?>" width="20" height="20" /></button>
						</form>
							<?php } ?>
					<td>

				</tr>
<?php
				}
?>
			</table>
			<form action='../Controllers/GRUPO_CONTROLLER.php' method="post">
				<button type="submit"><img src="../Views/icon/atras.png" alt="<?php echo $strings['Atras']?>" /></button>
			</form>
		</div>
<?php
		include '../Views/Footer.php';
		}
		}
?>