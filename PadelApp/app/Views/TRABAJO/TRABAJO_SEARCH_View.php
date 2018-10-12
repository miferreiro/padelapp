<?php
/*  Archivo php
	Nombre: TRABAJO_SEARCH_View.php
	Autor: 	Brais Rodríguez Martínez
	Fecha de creación: 27/11/2017 
	Función: vista de el formulario de búsqueda(search) realizada con una clase donde se muestran todos los campos a rellenar para buscar un trabjo de la base de datos
*/
//es la clase SEARCH de TRABAJO que nos permite mostrar el formulario de buscar
class TRABAJO_SEARCH {
	//es el constructor de la clase TRABAJO_SEARCH
	function __construct() {
		$this->render();//llamamos a la función render donde se mostrará el formulario SEARCH con los campos correspondientes y sus valores
	}
	//funcion que mostrará el formulario SEARCH con los campos correspondientes y sus valores
	function render() {

		include '../Locales/Strings_' . $_SESSION[ 'idioma' ] . '.php';//incluimos los strings de idiomas, para que la página pueda estar en español,inglés y galego
		include '../Views/Header.php';//incluimos la cabecera
?>
		<div class="seccion">
			<h2>
				<?php echo $strings['Formulario de búsqueda'];?>
			</h2>
			<form id="SEARCH"name="SEARCH" action="../Controllers/TRABAJO_CONTROLLER.php" method="post" enctype="multipart/form-data" onsubmit="return comprobarSearchTrabajo()">
				<table>
					<tr>
						<th class="formThTd">
							<?php echo $strings['IdTrabajo'];?>
						</th>
						<td class="formThTd"><input type="text" id="IdTrabajo" name="IdTrabajo" placeholder="<?php echo $strings['Escriba aqui...']?>" value="" maxlength="6" size="6" onBlur="comprobarLongitud(this,'6') && comprobarTexto(this,'6')"/>
					</tr>

					<tr>
						<th class="formThTd">
							<?php echo $strings['NombreTrabajo'];?>
						</th>
						<td class="formThTd"><input type="text" id="NombreTrabajo" name="NombreTrabajo" placeholder="<?php echo $strings['Escriba aqui...']?>" value="" maxlength="60" size="60" onBlur="comprobarLongitud(this,'60') && comprobarTexto(this,'60')"/>
					</tr>
					<tr>
						<th class="formThTd">
							<?php echo $strings['FechaIniTrabajo'];?>
						</th>
						<td class="formThTd"><input type="text" id="FechaIniTrabajo" class="tcal" name="FechaIniTrabajo" placeholder="<?php echo $strings['Escriba aqui...']?>" value="" size="20" onBlur="" readonly/>
					</tr>
                    
                    <tr>
						<th class="formThTd">
							<?php echo $strings['FechaFinTrabajo'];?>
						</th>
						<td class="formThTd"><input type="text" id="FechaFinTrabajo" class="tcal" name="FechaFinTrabajo" placeholder="<?php echo $strings['Escriba aqui...']?>" value="" size="20" onBlur="" readonly/>
					</tr>
                    
                      <tr>
						<th class="formThTd">
							<?php echo $strings['PorcentajeNota'];?>
						</th>
						<td class="formThTd"><input type="text" id="PorcentajeNota" name="PorcentajeNota" placeholder="<?php echo $strings['Escriba aqui...']?>" value="" maxlength="2" size="2" onBlur="comprobarCampoNumFormSearch(this,2,0,100)"/>
					</tr>
                 		<tr>
						<td colspan="2">
							<button type="submit" name="action" value="SEARCH"><img src="../Views/icon/buscar.png" alt="<?php echo $strings['Buscar formulario']?>" /></button>
			</form>
						<form action='../Controllers/TRABAJO_CONTROLLER.php' method="post" style="display:inline">
							<button type="submit"><img src="../Views/icon/atras.png" alt="<?php echo $strings['Atras']?>" /></button>
						</form>
						</td>
					</tr>
				</table>

		</div>
<?php
		include '../Views/Footer.php';//incluimos el pie de la página
		}
		}
?>