<?php
/* 
	Fecha de creación: 4/12/2017 
    Autor:Brais Santos
	Función: vista de el formulario de añadir(add) realizada con una clase donde se muestran todos los campos a rellenar para añadir una nota de trabajo a la base de datos
*/


//es la clase ADD de NOTA_TRABAJO que nos permite añadir una nota
class NOTA_TRABAJO_ADD {
	//es el constructor de la clase  NOTA_TRABAJO_ADD
	function __construct($datos,$trabajos) { 
		$this->datos = $datos;//pasamos los login
		$this->trabajos = $trabajos;//pasamos los IdTrabajo
		$this->render($this->datos,$this->trabajos);//funcion que mostrará el formulario ADD con los campos correspondientes

	}
//funcion que mostrará el formulario ADD con los campos correspondientes
	function render($datos,$trabajos) {
		$this->datos = $datos;//pasamos los login
		$this->trabajos = $trabajos;//pasamos los IdTrabajo
		include '../Locales/Strings_' . $_SESSION[ 'idioma' ] . '.php';//incluimos los strings de idiomas, para que la página pueda estar en español,inglés y galego
		include '../Views/Header.php';//incluimos la cabecera
?>
		<div class="seccion">
			<h2>
				<?php echo $strings['Formulario de inserción'];?>
			</h2>
			<form id="ADD" name="ADD" action="../Controllers/NOTA_TRABAJO_CONTROLLER.php" method="post" enctype="multipart/form-data" onsubmit="return comprobarAddNotas()">
				<table>
					<tr>
						<th class="formThTd">
							<?php echo $strings['login'];?>
						</th>
                  <td class="formThTd">
                   <select id="login" name="login" required>
<?php
				while ( $fila = mysqli_fetch_array( $this->datos ) ) { //este bucle se repetirá hasta que no se recorran todos los login
?>
				<option value="<?php echo $fila[ 'login' ]?>">

<?php 
		
					echo $fila['login'];
?>		
               							

               </option>
	
<?php } ?>					
					</select>
				</td>
					</tr>
					<tr>
						<th class="formThTd">
							<?php echo $strings['NombreTrabajo'];?>
						</th>
                  <td class="formThTd">
                   <select id="IdTrabajo" name="IdTrabajo" required>
<?php
				while ( $fila = mysqli_fetch_array( $this->trabajos ) ) { //este bucle se repetirá hasta que no se recorran todos los IdTrabajo
?>
				<option value="<?php echo $fila[ 'IdTrabajo' ]?>">

<?php 
			
					echo $fila['NombreTrabajo'];
?>		
               							

               </option>
	
<?php } ?>					
					</select>
				</td>
					</tr>
					<tr>
						<th class="formThTd">
							<?php echo $strings['Nota del Trabajo'];?>
						</th>
						<td class="formThTd"><input type="text" id="NotaTrabajo" name="NotaTrabajo" placeholder="<?php echo $strings['Escriba aqui...']?>" value="" maxlength="4" size="4" required onBlur="comprobarVacio(this) && comprobarLongitud(this,'4') && comprobarReal(this,2,0,10)"/>
					</tr>
					<tr>
						<td colspan="2">
							<button type="submit" name="action" value="ADD"><img src="../Views/icon/añadir.png" alt="<?php echo $strings['Confirmar formulario']?>" /></button>
			</form>
						<form action='../Controllers/NOTA_TRABAJO_CONTROLLER.php' method="post" style="display: inline">
							<button type="submit"><img src="../Views/icon/atras.png" alt="<?php echo $strings['Atras']?>" /></button>
						</form>
					</tr>
				</table>
		</div>
<?php
		include '../Views/Footer.php';//incluimos el pie de la página
		}
		}
?>