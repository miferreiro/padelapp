<?php
/* 
	Fecha de creación: 2/12/2017 
	Autor: Brais Santos Negreira
	Función: vista de tabla de datos(showall) realizada con una clase donde se muestran datos caracteristicos y permite seleccionar la historia deseada
    
*/


//es la clase SHOWALL de HISTORIA que nos permite mostrar todas las historias
class HISTORIA_SHOWALL {
//es el constructor de la clase HISTORIA_SHOWALL
	function __construct( $lista, $datos) { 
		$this->lista = $lista;//pasamos cada uno de los campos de la tabla
		$this->datos = $datos;//pasamos los valores de cada uno de los campos
		$this->render($this->lista,$this->datos);//llamamos a la función render donde se mostrará el formulario SHOWALL con los campos correspondientes y sus valores
	}
	//funcion que mostrará el formulario SHOWALL con los campos correspondientes y sus valores
	function render($lista,$datos){
		$this->lista = $lista;//pasamos cada uno de los campos de la tabla
		$this->datos = $datos;//pasamos los valores de cada uno de los campos
		include '../Locales/Strings_' . $_SESSION[ 'idioma' ] . '.php';//incluimos los strings de idiomas, para que la página pueda estar en español,inglés y galego
		include '../Views/Header.php';//incluimos la cabecera
?>
		<div class="seccion">
			<h2>
				<?php echo $strings['Tabla de datos'];?>
			</h2>
			<table>
				<caption style="margin-bottom:10px;">
					<form action='../Controllers/HISTORIA_CONTROLLER.php'>
<?php if(permisosAcc($_SESSION['login'],10,3)==true){ //mira si el usuario tiene permiso para buscar ?>
						<button type="submit" name="action" value="SEARCH"><img src="../Views/icon/buscar.png" alt="BUSCAR" /></button>
<?php }
	  if(permisosAcc($_SESSION['login'],10,0)==true){  //mira si el usuario tiene permiso para añadir
		?>
						<button type="submit" name="action" value="ADD"><img src="../Views/icon/añadir.png" alt="AÑADIR" /></button>
<?php } ?>
					</form>
				</caption>
				<tr>
<?php
					foreach ( $lista as $atributo ) { //este bucle recorre  los nombres de cada uno de los campos de una tupla
?>
					<th>
						<?php echo $strings[$atributo]?>
					</th>
<?php
					}
		if((permisosAcc($_SESSION['login'],10,1)==true)||(permisosAcc($_SESSION['login'],10,2)==true)||        (permisosAcc($_SESSION['login'],10,4)==true)){ //mira si el usuario tiene permiso para:añadir,borrar,ver en detalle
?>
					<th colspan="3" >
						<?php echo $strings['Opciones']?>
					</th>
<?php } ?>
				</tr>
<?php
				while ( $fila = mysqli_fetch_array( $this->datos ) ) { //este bucle va sacar cada una de las tuplas de historia que hay en la base de datos
?>
				<tr>
<?php
					foreach ( $lista as $atributo ) { //este bucle sacará los valores de cada uno de los campos de una tupla
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
						<form action="../Controllers/HISTORIA_CONTROLLER.php" method="get" style="display:inline" >
							<input type="hidden" name="IdTrabajo" value="<?php echo $fila['IdTrabajo']; ?>">
                            <input type="hidden" name="IdHistoria" value="<?php echo $fila['IdHistoria']; ?>">
<?php         if(permisosAcc($_SESSION['login'],10,2)==true){ //miramos si el usuario tiene permiso para editar ?>
								<button type="submit" name="action" value="EDIT" ><img src="../Views/icon/modificar.png" alt="<?php echo $strings['Modificar']?>" width="20" height="20" /></button>
<?php } ?>
					<td>
<?php         if(permisosAcc($_SESSION['login'],10,1)==true){ //miramos si el usuario tiene permiso para borrar ?>
								<button type="submit" name="action" value="DELETE" ><img src="../Views/icon/eliminar.png" alt="<?php echo $strings['Eliminar']?>" width="20" height="20" /></button>
<?php } ?>
					<td>
<?php         if(permisosAcc($_SESSION['login'],10,4)==true){ //miramos si el usuario tiene permiso para ver en detalle ?>
								<button type="submit" name="action" value="SHOWCURRENT" ><img src="../Views/icon/verDetalles.png" alt="<?php echo $strings['Ver en detalle']?>" width="20" height="20"/></button>
<?php } ?>
						</form>

				</tr>
<?php
				}
?>
			</table>
			<form action='../Controllers/HISTORIA_CONTROLLER.php' method="post">
				<button type="submit"><img src="../Views/icon/atras.png" alt="<?php echo $strings['Atras']?>" /></button>
			</form>
		</div>
<?php
		include '../Views/Footer.php'; //incluimos el pie de la página
		}
		}
?>