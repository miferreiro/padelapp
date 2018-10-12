<?php
//Función: vista que sirve para buscar una entrega mediante un formulario en el que se insertan los valores de la busqueda deseados.
//Fecha de creación:28/11/2017
//Autor:Brais Santos


//es la clase SEARCH de ENTREGA que nos permite buscar una entrega
class ENTREGA_SEARCH {
	//es el constructor de la clase ENTREGA_SEARCH
	function __construct() {    
		$this->render();//llamamos a la función render donde se mostrará el formulario SEARCH con los campos correspondientes
	}
//funcion render que mostrará el formulario SEARCH con los campos correspondientes
	function render() { 
		include '../Locales/Strings_' . $_SESSION[ 'idioma' ] . '.php';//incluimos los strings de idiomas, para que la página pueda estar en español,inglés y galego
		include '../Views/Header.php';//incluimos la cabecera
?>
		<div class="seccion">
			<h2>
				<?php echo $strings['Formulario de búsqueda'];?>
			</h2>
			<form id="SEARCH" name="SEARCH" action="../Controllers/ENTREGA_CONTROLLER.php" method="post"  enctype="multipart/form-data"  onsubmit="return comprobarSearchEntrega()">
				<table>
				<tr>
						<th class="formThTd">
							<?php echo $strings['login'];?><!--se muestra el campo login-->
						</th>
						<td class="formThTd"><input type="text" id="login" name="login" placeholder="<?php echo $strings['Escriba aqui...']?>" value="" maxlength="9" size="9"  onBlur="comprobarLongitud(this,'9') && comprobarTexto(this,'9')"/>
					</tr>
					<tr>
						<th class="formThTd">
							<?php echo $strings['IdTrabajo'];?><!--se muestra el campo IdTrabajo-->
						</th>
						<td class="formThTd"><input type="text" id="IdTrabajo" name="IdTrabajo" placeholder="<?php echo $strings['Escriba aqui...']?>" value="" maxlength="6" size="6"  onBlur="comprobarLongitud(this,'6') && comprobarTexto(this,'6')"/>
					</tr>
					<tr>
						<th class="formThTd">
							<?php echo $strings['Alias'];?><!--se muestra el campo Alias-->
						</th>
						<td class="formThTd"><input type="text" id="Alias" name="Alias" placeholder="<?php echo $strings['Escriba aqui...']?>" value="" maxlength="6" size="6"  onBlur="comprobarLongitud(this,'6') && comprobarTexto(this,'6')"/>
					</tr>
                    
                    <tr>
						<th class="formThTd">
							<?php echo $strings['Horas'];?><!--se muestra el campo Horas-->
						</th>
						<td class="formThTd"><input type="text" id="Horas" name="Horas" placeholder="<?php echo $strings['Escriba aqui...']?>" value="" maxlength="2" size="2"  onBlur="comprobarCampoNumFormSearch(Horas, 2, 0, 99)"/>
					</tr>
                    
                    <tr>
						<th class="formThTd">
							<?php echo $strings['Ruta'];?><!--se muestra el campo Ruta-->
						</th>
						<td class="formThTd"><input type="file" id="Ruta" name="Ruta" placeholder="<?php echo $strings['Escriba aqui...']?>" value="" maxlength="60" size="60"  onBlur="comprobarLongitud(this,'60') && comprobarTexto(this,'60')"/>
					</tr>
					
					<tr>
						<td colspan="2">
							<button type="submit" name="action" value="SEARCH"><img src="../Views/icon/buscar.png" alt="<?php echo $strings['Confirmar formulario']?>" /></button><!--este boton confirma la busqueda del formualrio-->
			</form>
						<form action='../Controllers/ENTREGA_CONTROLLER.php' method="post" style="display: inline">
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