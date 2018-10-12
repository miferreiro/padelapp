<?php
/*  Archivo php
	Nombre: ASIGNAC_QA_SHOWALL_View.php
	Autor: 	Jonatan Couto Riádigos
	Fecha de creación: 29/11/2017 
	Función: vista de tabla de datos(showall) realizada con una clase donde se muestran datos caracteristicos y permite seleccionar la Qa deseada
*/
//Clase Asigna_qa_showall que contiene la vista para ver los resultados de la tabla ASIGNAC_QA
class ASIGNAC_QA_SHOWALL {
	//Constructor de la clase
	function __construct( $lista, $datos) {
		$this->lista = $lista;//Variable que contiene el array de los atributos a mostrar en la vista
		$this->datos = $datos;//Variable que almacena un recordset con la informacion de las tuplas de ASIGNAC_QA
		$this->render($this->lista,$this->datos);//metodo que llama a la función render que contiene todo el código de la vista
	}
	//Función que contiene el código de la vista
	function render($lista,$datos){
		$this->lista = $lista;//Variable que contiene el array de los atributos a mostrar en la vista
		$this->datos = $datos;//Variable que almacena un recordset con la informacion de las tuplas de ASIGNAC_QA
		include '../Locales/Strings_' . $_SESSION[ 'idioma' ] . '.php';
//Incluye el contenido de los strings necesarios para el multiidioma
		include '../Views/Header.php';//Incluye el contenido del header
        include_once '../Functions/permisosAcc.php';//Incluye la función permisosACC
?>
		<div class="seccion">
			<h2>
				<?php echo $strings['Tabla de datos'];?>
			</h2>
			<table>
				<caption style="margin-bottom:10px;">
					<form action='../Controllers/ASIGNAC_QA_CONTROLLER.php'>
<!-- Comprueba si tiene los permisos para buscar, si los tiene muestra el icono -->
<?php if(permisosAcc($_SESSION['login'],6,3)==true){ ?>
						<button type="submit" name="action" value="SEARCH"><img src="../Views/icon/buscar.png" alt="BUSCAR" /></button>
<?php }
		//Comprueba si tiene los permisos para añadir, si los tiene muestra el icono
	  if(permisosAcc($_SESSION['login'],6,0)==true){ 
		?>
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
		//Comprueba si tiene los permisos para editar,borrar o mostrar en detalle, si los tiene muestra la columna de opciones con la opcion que le permita el permiso
		if((permisosAcc($_SESSION['login'],6,1)==true)||(permisosAcc($_SESSION['login'],6,2)==true)||        (permisosAcc($_SESSION['login'],6,4)==true)){ 
?>
					<th colspan="3" >
						<?php echo $strings['Opciones']?>
					</th>
<?php } ?>
				</tr>
<?php
				//Bucle que recorre todo el recordset de las tuplas de la tabla y pasa estos valores a array y los muestra
				while ( $fila = mysqli_fetch_array( $this->datos ) ) {
?>
				<tr>
<?php
					//bucle que recorre el array de los atributos 
					foreach ( $lista as $atributo ) {
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
						<form action="../Controllers/ASIGNAC_QA_CONTROLLER.php" method="get" style="display:inline" >
							<input type="hidden" name="IdTrabajo" value="<?php echo $fila['IdTrabajo']; ?>">
							<input type="hidden" name="LoginEvaluador" value="<?php echo $fila['LoginEvaluador']; ?>">
							<input type="hidden" name="AliasEvaluado" value="<?php echo $fila['AliasEvaluado']; ?>">
			<!-- Comprueba si tiene los permisos para editar, si los tiene muestra el icono -->							
<?php         if(permisosAcc($_SESSION['login'],6,2)==true){ ?>
								<button type="submit" name="action" value="EDIT" ><img src="../Views/icon/modificar.png" alt="<?php echo $strings['Modificar']?>" width="20" height="20" /></button>
<?php } ?>
					<td>
			  <!-- Comprueba si tiene los permisos para borrar, si los tiene muestra el icono -->	
<?php         if(permisosAcc($_SESSION['login'],6,1)==true){ ?>
								<button type="submit" name="action" value="DELETE" ><img src="../Views/icon/eliminar.png" alt="<?php echo $strings['Eliminar']?>" width="20" height="20" /></button>
<?php } ?>
					<td>
			<!-- Comprueba si tiene los permisos para ver en detalle, si los tiene muestra el icono -->	
<?php         if(permisosAcc($_SESSION['login'],6,4)==true){ ?>
								<button type="submit" name="action" value="SHOWCURRENT" ><img src="../Views/icon/verDetalles.png" alt="<?php echo $strings['Ver en detalle']?>" width="20" height="20"/></button>
<?php } ?>
						</form>

				</tr>
<?php
				}
?>
			</table>
			<form action='../Controllers/ASIGNAC_QA_CONTROLLER.php' method="post">
				<button type="submit"><img src="../Views/icon/atras.png" alt="<?php echo $strings['Atras']?>" /></button>
			</form>
		</div>
<?php
		include '../Views/Footer.php';//Incluye el contenido del pie
		}
		}
?>