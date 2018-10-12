<?php
/*  Archivo php
	Nombre: USUARIOS_SEARCH_View.php
	Autor: 	Jonatan Couto
	Fecha de creación: 22/11/2017 
	Función: vista de el formulario de búsqueda(search) realizada con una clase donde se muestran todos los campos a rellenar para buscar a un usuario e la base de datos
*/


//es la clase SEARCH de USUARIO que nos permite buscar un usuario
class USUARIO_SEARCH {

    //es el constructor de la clase USUARIO_SEARCH
	function __construct() {
		$this->render();//llamamos a la función render donde se mostrará el formulario SEARCH con los campos correspondientes
	}

    //funcion que  mostrará el formulario SEARCH con los campos correspondientes
	function render() {

		include '../Locales/Strings_' . $_SESSION[ 'idioma' ] . '.php';//incluimos los strings de idiomas, para que la página pueda estar en español,inglés y galego
		include '../Views/Header.php';//incluimos la cabecera
?>
		<div class="seccion">
			<h2>
				<?php echo $strings['Formulario de búsqueda'];?>
			</h2>
			<form id="SEARCH" name="SEARCH" action="../Controllers/USUARIO_CONTROLLER.php" method="post" enctype="multipart/form-data" onsubmit="return comprobarSearchUsuario()">
				<table>
					<tr>
						<th class="formThTd">
							<?php echo $strings['Usuario'];?>
						</th>
						<td class="formThTd"><input type="text" id="login" name="login" placeholder="<?php echo $strings['Escriba aqui...']?>" value="" maxlength="9" size="11" onBlur="comprobarLongitud(this,'9') && comprobarTexto(this,'9')"/>
					</tr>
					<tr>
						<th class="formThTd">
							<?php echo $strings['Contraseña'];?>
						</th>
						<td class="formThTd"><input type="text" id="password" name="password" placeholder="<?php echo $strings['Escriba aqui...']?>" value="" maxlength="128" size="128" onBlur="comprobarLongitud(this,'128') && comprobarTexto(this,'128')"/>
					</tr>
					<tr>
						<th class="formThTd">
							<?php echo $strings['DNI'];?>
						</th>
						<td class="formThTd"><input type="text" id="DNI" name="DNI" placeholder="<?php echo $strings['Escriba aqui...']?>" value="" maxlength="9" size="11" onBlur="comprobarLongitud(this,'9') && comprobarTexto(this,'9')"/>
					</tr>
					<tr>
						<th class="formThTd">
							<?php echo $strings['nombre'];?>
						</th>
						<td class="formThTd"><input type="text" id="nombre" name="nombre" placeholder="<?php echo $strings['Escriba aqui...']?>" value="" maxlength="30" size="34" onBlur="comprobarLongitud(this,'30') && comprobarTexto(this,'30') && comprobarAlfabetico(this,'30')"/>
					</tr>
					<tr>
						<th class="formThTd">
							<?php echo $strings['Apellidos'];?>
						</th>
						<td class="formThTd"><input type="text" id="apellidos" name="apellidos" placeholder="<?php echo $strings['Escriba aqui...']?>" value="" maxlength="50" size="60" onBlur="comprobarLongitud(this,'50') && comprobarTexto(this,'50') && comprobarAlfabetico(this,'50')"/>
					</tr>

					<tr>
						<th class="formThTd">
							<?php echo $strings['Correo electrónico'];?>
						</th>
						<td class="formThTd"><input type="text" id="email" name="email" placeholder="<?php echo $strings['Escriba aqui...']?>" value="" maxlength="40" size="50" onBlur="comprobarLongitud(this,'40') && comprobarTexto(this,'40')"/>
					</tr>
					<tr>
						<th class="formThTd">
							<?php echo $strings['Direccion'];?>
						</th>
						<td class="formThTd"><input type="text" id="direc" name="direc" placeholder="<?php echo $strings['Escriba aqui...']?>" value="" maxlength="60" size="70" onBlur="comprobarLongitud(this,'60') && comprobarTexto(this,'60')"/>
					</tr>
					<tr>
						<th class="formThTd">
							<?php echo $strings['Teléfono'];?>
						</th>
						<td class="formThTd"><input type="text" id="telefono" name="telefono" placeholder="<?php echo $strings['Escriba aqui...']?>" value="" maxlength="11" size="13" onBlur="comprobarLongitud(this,'11') && comprobarTexto(this,'11')"/>
					</tr>
					<tr>
						<td colspan="2">
							<button type="submit" name="action" value="SEARCH"><img src="../Views/icon/buscar.png" alt="<?php echo $strings['Buscar formulario']?>" /></button>
			</form>
						<form action='../Controllers/USUARIO_CONTROLLER.php' method="post" style="display:inline">
							<button type="submit"><img src="../Views/icon/atras.png" alt="<?php echo $strings['Atras']?>" /></button>
						</form>
						</td>
					</tr>
				</table>

		</div>
<?php
		include '../Views/Footer.php';//incluimos el pie de página
		}
		}
?>