<?php
/* 
	Archivo php
	Fecha de creación: 27/11/2017 
	Autor: Jonatan Couto
	Función: vista de tabla de datos(showall) realizada con una clase donde se muestran datos caracteristicos y permite seleccionar mostrar los permisos que existen
*/
//Es la clase ASSIGN de PERMISO que nos permite mostrar asignar/desasignar permisos a grupos
class PERMISO_ASSIGN {
	//es el constructor de la clase PERMISO_ASSIGN
	function __construct( $lista, $datos, $DatosGrupo) {
		$this->lista = $lista;//pasamos una array con los campos a mostrar
		$this->datos = $datos;//pasamos el valor de los datos que queremos mostrar
		$this->render($this->lista,$this->datos,$DatosGrupo);//llamamos a la función render donde se mostrará la vista de asig/desasig con los campos correspondientes
	}
	//función render donde se mostrará la vista ASIG/DESASIG con los campos correspondientes
	function render($lista,$datos,$DatosGrupo){
		$this->lista = $lista;//pasamos una array con los campos a mostrar
		$this->datos = $datos;//pasamos el valor de los datos que queremos mostrar
		include '../Locales/Strings_' . $_SESSION[ 'idioma' ] . '.php';//incluimos los strings de idiomas, para que la página pueda estar en español,inglés y galego
		include '../Views/Header.php';//incluimos la cabecera
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
					<th >
						<?php echo $strings['Opciones']?>
					</th>
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
					<td>
						<form action="../Controllers/PERMISO_CONTROLLER.php" method="get" style="display:inline" >
							<input type="hidden" name="IdGrupo" value="<?php echo $fila['IdGrupo']; ?>">
							<input type="hidden" name="IdFuncionalidad" value="<?php echo $fila['IdFuncionalidad']; ?>">
							<input type="hidden" name="IdAccion" value="<?php echo $fila['IdAccion']; ?>">
								<button type="submit" name="action" value="DELETE" ><img src="../Views/icon/eliminar.png" alt="<?php echo $strings['Modificar']?>" width="20" height="20" /></button>
						</form>
				</tr>
<?php
				}
?>
			<caption style="margin-bottom:10px;">
					<form action='../Controllers/PERMISO_CONTROLLER.php'>
						<input type="hidden" name="IdGrupo" value="<?php echo $DatosGrupo[0][0]?>">
						<input type="hidden" name="NombreGrupo" value="<?php echo $DatosGrupo[0][1]?>">
						<button type="submit" name="action" value="ADD"><img src="../Views/icon/añadir.png" alt="<?php echo $strings['Atras']?>" /></button>
					</form>
				</caption>
			</table>
			<form action='../Controllers/GRUPO_CONTROLLER.php' method="post">
				<button type="submit"><img src="../Views/icon/atras.png" alt="<?php echo $strings['Atras']?>" /></button>
			</form>
		</div>
<?php
		include '../Views/Footer.php';//incluimos el footer
		}
		}
?>