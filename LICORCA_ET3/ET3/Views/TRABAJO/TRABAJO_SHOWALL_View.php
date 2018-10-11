<?php
/*  Archivo php
	Nombre: TRABAJO_SHOWALL_View.php
	Autor: 	Brais Rodríguez Martínez
	Fecha de creación: 27/11/2017 
	Función: vista de tabla de datos(showall) realizada con una clase donde se muestran datos caracteristicos y permite seleccionar el trbajo que se desea realizar en la aplicación
*/
//es la clase SHOWALL de TRABAJO que nos permite mostrar todos los trabajos
class TRABAJO_SHOWALL {
	//es el constructor de la clase TRABAJO_SHOWALL
	function __construct( $lista, $datos) {
		$this->lista = $lista;//pasamos cada uno de los campos de la tabla
		$this->datos = $datos;//pasamos los valores de cada uno de los campos
		$this->render($this->lista,$this->datos);//llamamos a la función render donde se mostrará el formulario SHOWALL con los campos correspondientes y sus valores
	}
	//funcion que mostrará la vista SHOWALL con los campos correspondientes y sus valores
	function render($lista,$datos){
		$this->lista = $lista;//pasamos cada uno de los campos de la tabla
		$this->datos = $datos;//pasamos los valores de cada uno de los campos
		include '../Locales/Strings_' . $_SESSION[ 'idioma' ] . '.php';//incluimos los strings de idiomas, para que la página pueda estar en español,inglés y galego
		include '../Views/Header.php';//incluimos la cabecera
        include_once '../Functions/permisosAcc.php';//incluimos la funcion de autentificacion
?>
		<div class="seccion">
			<h2>
				<?php echo $strings['Tabla de datos'];?>
			</h2>
			<table>
				<caption style="margin-bottom:10px;">
					<form action='../Controllers/TRABAJO_CONTROLLER.php'>
				
<?php if(permisosAcc($_SESSION['login'],11,3)==true){ //Si tiene los permisos,mostramos la accion?>
						<button type="submit" name="action" value="SEARCH"><img src="../Views/icon/buscar.png" alt="BUSCAR" /></button>
<?php }
	  if(permisosAcc($_SESSION['login'],11,0)==true){ //Si tiene los permisos,mostramos la accion
		?>
						<button type="submit" name="action" value="ADD"><img src="../Views/icon/añadir.png" alt="AÑADIR" /></button>
<?php } ?>
					</form>
				</caption>
				<tr>
<?php
					foreach ( $lista as $atributo ) {//muestra el nombre de cada uno de los campos
?>
					<th>
						<?php echo $strings[$atributo]?>
					</th>
<?php
					}
		if((permisosAcc($_SESSION['login'],11,1)==true)||(permisosAcc($_SESSION['login'],11,2)==true)||        (permisosAcc($_SESSION['login'],11,4)==true) || (permisosAcc($_SESSION['login'],8,10)==true)){//Si tiene los permisos,mostramos la accion 
?>
					<th colspan="3" >
						<?php echo $strings['Opciones']?>
					</th>
<?php } ?>
				</tr>
<?php
				while ( $fila = mysqli_fetch_array( $this->datos ) ) {//este bucle se va a repetir mientras no se muestren todos los datos
?>
				<tr>
<?php
					foreach ( $lista as $atributo ) {//este bucle sacará los valores de cada uno de los campos de una tupla
?>
					<td>
<?php 				if ( $atributo == 'FechaIniTrabajo' ) {//Si es la fecha inicial del trabajo, cambiamos el formato de la fecha
						$fila[ $atributo ] = date( "d/m/Y", strtotime( $fila[ $atributo ] ) );
					} 
					if ( $atributo == 'FechaFinTrabajo' ) {//Si es la fecha inicial del trabajo, cambiamos el formato de la fecha
							$fila[ $atributo ] = date( "d/m/Y", strtotime( $fila[ $atributo ] ) );
					} 
					
						echo $fila[ $atributo ];
			
?>
					</td>

<?php
					}
?>
					<td>
						<form action="../Controllers/TRABAJO_CONTROLLER.php" method="get" style="display:inline" >
							<input type="hidden" name="IdTrabajo" value="<?php echo $fila['IdTrabajo']; ?>">
<?php         if(permisosAcc($_SESSION['login'],11,2)==true){ //Si tiene los permisos,mostramos la accion?>
								<button type="submit" name="action" value="EDIT" ><img src="../Views/icon/modificar.png" alt="<?php echo $strings['Modificar']?>" width="20" height="20" /></button>
<?php } ?>
					<td>
<?php         if(permisosAcc($_SESSION['login'],11,1)==true){ //Si tiene los permisos,mostramos la accion?>
								<button type="submit" name="action" value="DELETE" ><img src="../Views/icon/eliminar.png" alt="<?php echo $strings['Eliminar']?>" width="20" height="20" /></button>
<?php } ?>
					<td>
<?php         if(permisosAcc($_SESSION['login'],11,4)==true){ //Si tiene los permisos,mostramos la accion?>
								<button type="submit" name="action" value="SHOWCURRENT" ><img src="../Views/icon/verDetalles.png" alt="<?php echo $strings['Ver en detalle']?>" width="20" height="20"/></button>
<?php } ?>
						</form>

				</tr>
<?php
				}
?>
			</table>
			<form action='../Controllers/TRABAJO_CONTROLLER.php' method="post">
				<button type="submit"><img src="../Views/icon/atras.png" alt="<?php echo $strings['Atras']?>" /></button>
			</form>
		</div>
<?php
		include '../Views/Footer.php';//incluimos el pie de la página
		}
		}
?>