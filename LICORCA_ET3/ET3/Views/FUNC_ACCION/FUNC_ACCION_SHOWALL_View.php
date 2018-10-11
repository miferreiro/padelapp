<?php
/*  Archivo php
	Nombre: FUNC_ACCION_SHOWALL_View.php
    Autor: Brais Rodríguez
	Fecha de creación: 26/11/2017  
	Función: vista de tabla de datos(showall) realizada con una clase donde se muestran datos caracteristicos y permite seleccionar la accion de una funcionalidad que se desea realizar en la aplicación
*/

//es la clase SHOWALL de FUNC_ACCION que nos permite mostrar todas las acciones de una funcionalidad
class FUNC_ACCION_SHOWALL {
//es el constructor de la clase FUNC_ACCION_SHOWALL
	function __construct( $lista, $datos, $name) {  
		$this->lista = $lista;//pasamos cada uno de los campos a mostrar
		$this->datos = $datos; //pasamos los valores de cada uno de los campos
		$this->render($this->lista,$this->datos,$name);//llamamos a la función render donde se mostrará el formulario showall con los campos correspondientes
	}
	// funcion  que mostrará el formulario showall con los campos correspondientes
	function render($lista,$datos,$name){ 
		$this->lista = $lista;//pasamos cada uno de los campos a mostrar
		$this->datos = $datos;//pasamos los valores de cada uno de los campos
		include '../Locales/Strings_' . $_SESSION[ 'idioma' ] . '.php';//incluimos los strings de idiomas, para que la página pueda estar en español,inglés y galego
		include '../Views/Header.php';//incluimos la cabecera
?>
		<div class="seccion">
			<h2>
				<?php echo $strings['Tabla de datos'];?>
			</h2>
			<table>
				<tr>
<?php
					foreach ( $lista as $atributo ) { //este bucle se repite hasta que no devuelva todos los campos
?>
					<th>
						<?php echo $strings[$atributo]?>
					</th>
<?php
					}
?>
					<th colspan="3" >
						<?php echo $strings['Opciones']?>
					</th>
				</tr>
<?php
				while ( $fila = mysqli_fetch_array( $this->datos ) ) { //este bucle se repite hasta que no se devuelvan todos los datos de FUNC_ACCION que hay en la base de datos
?>
				<tr>
<?php
					foreach ( $lista as $atributo ) { //este bucle se repite hasta que no se muestre todos los valores de cada uno de los campos
?>
					<td>
<?php 
							echo $fila[ $atributo ];
							$log=$fila['IdFuncionalidad'];
							
?>						
					</td>
<?php
					}
?>
					<td>
						<form action="../Controllers/FUNC_ACCION_CONTROLLER.php" method="get" style="display:inline" >
						    <input type="hidden" name="IdFuncionalidad" value="<?php echo $fila['IdFuncionalidad']; ?>">
							<input type="hidden" name="IdAccion" value="<?php echo $fila['IdAccion']; ?>">
								<button type="submit" name="action" value="DELETE" ><img src="../Views/icon/eliminar.png" alt="<?php echo $strings['Eliminar']?>" width="20" height="20" /></button>
					
						</form>

				</tr>
<?php
				}
?>
			<caption style="margin-bottom:10px;">
					<form action='../Controllers/FUNC_ACCION_CONTROLLER.php'>
						<input type="hidden" name="IdFuncionalidad" value="<?php echo $name[0][0];?>">
						<input type="hidden" name="NombreFuncionalidad" value="<?php echo $name[0][1];?>">
						<button type="submit" name="action" value="ADD"><img src="../Views/icon/añadir.png" alt="AÑADIR" /></button>
					</form>
				</caption>
			</table>
			<form action='../Controllers/FUNCIONALIDAD_CONTROLLER.php' method="post">
				<button type="submit"><img src="../Views/icon/atras.png" alt="<?php echo $strings['Atras']?>" /></button>
			</form>
		</div>
<?php
		include '../Views/Footer.php';//incluimos el pie de la página
		}
		}
?>