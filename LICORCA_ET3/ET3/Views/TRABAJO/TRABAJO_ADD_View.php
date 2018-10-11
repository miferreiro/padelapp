<?php
/*  Archivo php
	Nombre: TRABAJO_ADD_View.php
	Autor: 	Brais Rodríguez Martínez
	Fecha de creación: 27/11/2017 
	Función: vista de el formulario de añadir(add) realizada con una clase donde se muestran todos los campos a rellenar para añadir un trabajo a la base de datos
*/
//es la clase ADD de TRABAJO que nos permite mostrar el formulario de añadir
class TRABAJO_ADD {
	//es el constructor de la clase TRABAJO_ADD
	function __construct() {
		$this->render();//llamamos a la función render donde se mostrará el formulario ADD con los campos correspondientes y sus valores
	}
	//funcion que mostrará el formulario ADD con los campos correspondientes y sus valores
	function render() {
		include '../Locales/Strings_' . $_SESSION[ 'idioma' ] . '.php';//incluimos los strings de idiomas, para que la página pueda estar en español,inglés y galego
		include '../Views/Header.php';//incluimos la cabecera
?>
		<div class="seccion">
			<h2>
				<?php echo $strings['Formulario de inserción'];?>
			</h2>
			<form name="ADD" action="../Controllers/TRABAJO_CONTROLLER.php" method="post" enctype="multipart/form-data" onsubmit="return comprobarAddTrabajo()">
				<table>
					<tr>
						<th class="formThTd">
							<?php echo $strings['IdTrabajo'];?>
						</th>
						<td class="formThTd"><input type="text" id="IdTrabajo" name="IdTrabajo" placeholder="<?php echo $strings['Escriba aqui...']?>" value="" maxlength="6" size="6" required onBlur="comprobarVacio(this) && comprobarLongitud(this,'6') && comprobarTexto(this,'6')"/>
					</tr>
					<tr>
						<th class="formThTd">
							<?php echo $strings['NombreTrabajo'];?>
						</th>
						<td class="formThTd"><input type="text" id="NombreTrabajo" name="NombreTrabajo" placeholder="<?php echo $strings['Escriba aqui...']?>" value="" maxlength="60" size="60" required onBlur="comprobarVacio(this) && comprobarLongitud(this,'60') && comprobarTexto(this,'60')"/>
					</tr>
					<tr>
						<th class="formThTd">
							<?php echo $strings['FechaIniTrabajo'];?>
						</th>
						<td class="formThTd"><input type="text" id="FechaIniTrabajo" name="FechaIniTrabajo" placeholder="<?php echo $strings['Escriba aqui...']?>" value=""  size="20" class="tcal" readonly required onBlur=""/>
					</tr>
                    
                    <tr>
						<th class="formThTd">
							<?php echo $strings['FechaFinTrabajo'];?>
						</th>
						<td class="formThTd"><input type="text" id="FechaFinTrabajo" name="FechaFinTrabajo" placeholder="<?php echo $strings['Escriba aqui...']?>" value=""  size="20" class="tcal" readonly required onBlur=""/>
					</tr>
					
                      <tr>
						<th class="formThTd">
							<?php echo $strings['PorcentajeNota'];?>
						</th>
						<td class="formThTd"><input type="text" id="PorcentajeNota" name="PorcentajeNota" placeholder="<?php echo $strings['Escriba aqui...']?>" value="" maxlength="2" size="2" required onBlur="comprobarVacio(document.forms['ADD'].elements[2]) && comprobarVacio(document.forms['ADD'].elements[3]) && comprobarVacio(this) && comprobarLongitud(this,'2') && comprobarTexto(this,'2') && comprobarEntero(this,0,100)"/>
					</tr>
                    
                    
                    
                    
					<tr>
						<td colspan="2">
							<button type="submit" name="action" value="ADD"><img src="../Views/icon/añadir.png" alt="<?php echo $strings['Confirmar formulario']?>" /></button>
			</form>
						<form action='../Controllers/TRABAJO_CONTROLLER.php' method="post" style="display: inline">
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