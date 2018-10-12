<?php
/*  
	Fecha de creación: 2/12/2017 
    Autor:Brais Santos
	Función: vista de el formulario de añadir(add) realizada con una clase donde se muestran todos los campos a rellenar para añadir una historia a la base de datos
*/

//es la clase ADD de HISTORIA que nos permite añadir una historia
class HISTORIA_ADD {
//es el constructor de la clase HISTORIA_ADD
	function __construct($datos) { 
		$this->datos = $datos;//pasamos los valores de cada uno de los campos
		$this->render($this->datos);//llamamos a la función render donde se mostrará el formulario ADD con los campos correspondientes

	}
//funcion que mostrará el formulario ADD con los campos correspondientes
	function render($datos) { 
		$this->datos = $datos;//pasamos los valores de cada uno de los campos
		include '../Locales/Strings_' . $_SESSION[ 'idioma' ] . '.php';//incluimos los strings de idiomas, para que la página pueda estar en español,inglés y galego
		include '../Views/Header.php';//incluimos la cabecera
?>
		<div class="seccion">
			<h2>
				<?php echo $strings['Formulario de inserción'];?>
			</h2>
			<form name="ADD" action="../Controllers/HISTORIA_CONTROLLER.php" method="post" enctype="multipart/form-data" onsubmit="return comprobarAddHistoria()">
				<table>
					<tr>
						<th class="formThTd">
							<?php echo $strings['NombreTrabajo'];?>
						</th>
                  <td class="formThTd">
                   <select id="IdTrabajo" name="IdTrabajo" required>
<?php
				while ( $fila = mysqli_fetch_array( $this->datos ) ) { //este bucle muestra en un select todos los IdTrabajo que hay
?>
				<option value="<?php echo $fila[ 'IdTrabajo' ]?>">

<?php 
			//echo $fila[ 'NombreGrupo' ].'_'.$fila['IdGrupo'];
					echo $fila['NombreTrabajo'];
?>		
               							

               </option>
	
<?php } ?>					
					</select>
				</td>
					</tr>
					<tr>
						<th class="formThTd">
							<?php echo $strings['IdHistoria'];?>
						</th>
						<td class="formThTd"><input type="text" id="IdHistoria" name="IdHistoria" placeholder="<?php echo $strings['Escriba aqui...']?>" value="" maxlength="2" size="2" required onBlur="comprobarVacio(this) && comprobarLongitud(this,'2') && comprobarTexto(this,'2') && comprobarEntero(this,0,99)"/>
					</tr>
					<tr>
						<th class="formThTd">
							<?php echo $strings['TextoHistoria'];?>
						</th>
						<td class="formThTd"><textarea id="TextoHistoria" name="TextoHistoria" placeholder="<?php echo $strings['Escriba aqui...']?>" value="" maxlength="300" cols="50" rows="7"  required onBlur="comprobarVacio(this) && comprobarLongitud(this,'300') && comprobarTexto(this,'300')"></textarea>
					</tr>
					
					<tr>
						<td colspan="2">
							<button type="submit" name="action" value="ADD"><img src="../Views/icon/añadir.png" alt="<?php echo $strings['Confirmar formulario']?>" /></button>
			</form>
						<form action='../Controllers/HISTORIA_CONTROLLER.php' method="post" style="display: inline">
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