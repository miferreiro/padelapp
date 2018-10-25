<?php
/*  Archivo php
	Nombre: USUARIOS_EDIT_View.php
	Autor: 	Jonatan Couto
	Fecha de creación: 22/11/2017
	Función: vista de el formulario de editar(edit) realizada con una clase donde se muestran todos los campos posibles a modificar para cambiar los datos de un usuario en la base de datos
*/

//es la clase EDIT de USUARIO que nos permite editar un usuario
class USUARIO_EDIT {

    //es el constructor de la clase USUARIO_EDIT
	function __construct( $valores ) { 
		$this->valores = $valores;//pasamos los valores de cada uno de los campos
		$this->render( $this->valores );//llamamos a la función render donde se mostrará el formulario EDIT con los campos correspondientes
	}
 
    //funcion que mostrará el formulario EDIT con los campos correspondientes
	function render( $valores ) {
		$this->valores = $valores;//pasamos los valores de cada uno de los campos
		include '../Locales/Strings_' . $_SESSION[ 'idioma' ] . '.php';//incluimos los strings de idiomas, para que la página pueda estar en español,inglés y galego
		include '../Views/Header.php';//incluimos la cabecera
		?>
		<div class="seccion">
			<h2>
				<?php echo $strings['Formulario de modificación'];?>
			</h2>
			<form name="EDIT" action="../Controllers/USUARIO_CONTROLLER.php" method="post" enctype="multipart/form-data" onsubmit="return comprobarEditUsuario()">
				<table>
					<tr>
						<th class="formThTd">
							<?php echo $strings['Usuario'];?>
						</th>
						<td class="formThTd"><input type="text" id="login" name="login" placeholder="<?php echo $strings['Escriba aqui...']?>" value="<?php echo $this->valores['login']?>" maxlength="25" size="25" readonly onBlur="comprobarVacio(this) && sinEspacio(this) && comprobarLongitud(this,'25') && comprobarTexto(this,'25')" required/>
					</tr>
					<tr>
						<th class="formThTd">
							<?php echo $strings['Contraseña'];?>
						</th>
						<td class="formThTd"><input type="text" id="password" name="password" placeholder="<?php echo $strings['Escriba aqui...']?>" value="<?php echo $this->valores['password']?>" maxlength="128" size="128" onBlur="comprobarVacio(this) && sinEspacio(this) && comprobarLongitud(this,128) && comprobarTexto(this,128)" required/>
					</tr>
					<tr>
						<th class="formThTd">
							<?php echo $strings['DNI'];?>
						</th>
						<td class="formThTd"><input type="text" id="DNI" name="DNI" placeholder="<?php echo $strings['Escriba aqui...']?>" value="<?php echo $this->valores['DNI']?>" maxlength="12" size="12" onBlur="comprobarVacio(this) && comprobarLongitud(this,'12') && comprobarTexto(this,'12') && comprobarDni(this)" required/>
					</tr>
					<tr>
						<th class="formThTd">
							<?php echo $strings['Nombre'];?>
						</th>
						<td class="formThTd"><input type="text" id="nombre" name="nombre" placeholder="<?php echo $strings['Escriba aqui...']?>" value="<?php echo $this->valores['Nombre']?>" maxlength="30" size="31" required onBlur="comprobarVacio(this) && comprobarLongitud(this,'30') && comprobarTexto(this,'30') && comprobarAlfabetico(this,'30')"/>
					</tr>
					<tr>
						<th class="formThTd">
							<?php echo $strings['Apellidos'];?>
						</th>
						<td class="formThTd"><input type="text" id="apellidos" name="apellidos" placeholder="<?php echo $strings['Escriba aqui...']?>" value="<?php echo $this->valores['Apellidos']?>" maxlength="45" size="45" required onBlur="comprobarVacio(this) && comprobarLongitud(this,'45') && comprobarTexto(this,'45') && comprobarAlfabetico(this,'45')"/>
					</tr>
					<tr>
						<th class="formThTd">
							<?php echo "Sexo"?>
						</th>
						<td class="formThTd"><input type="text" id="sexo" name="sexo" placeholder="<?php echo $strings['Escriba aqui...']?>" value="<?php echo $this->valores['sexo']?>" maxlength="6" size="7" onBlur=" comprobarVacio(this) && comprobarLongitud(this,'6') && comprobarTexto(this,'6')" required/>
					</tr>
					<tr>
						<th class="formThTd">
							<?php echo $strings['Teléfono'];?>
						</th>
						<td class="formThTd"><input type="text" id="telefono" name="telefono" placeholder="<?php echo $strings['Escriba aqui...']?>" value="<?php echo $this->valores['telefono']?>" maxlength="14" size="14" required onBlur="comprobarVacio(this) && comprobarLongitud(this,'14') && comprobarTexto(this,'14') && comprobarTelf(this)"/>
					</tr>
					<tr>
						<th class="formThTd">
							<?php echo $strings['Tipo'];?>
						</th>
						<td class="formThTd"><input type="text" id="tipo" name="tipo" placeholder="<?php echo $strings['Escriba aqui...']?>" value="<?php echo $this->valores['tipo']?>" maxlength="12" size="12" required readonly onBlur="comprobarVacio(this) && comprobarLongitud(this,'12') && comprobarTexto(this,'12') "/>
					</tr>
					<tr>
						<td colspan="2">
							<button type="submit" name="action" value="EDIT"><img src="../Views/icon/modificar.png" alt="<?php echo $strings['Confirmar formulario']?>" /></button>
			</form>
			<form action='../Controllers/USUARIO_CONTROLLER.php' style="display: inline">
				<button type="submit"><img src="../Views/icon/atras.png" alt="<?php echo $strings['Atras']?>" /></button>
			</form>
			</tr>

			</table>
		</div>

		<?php
		include '../Views/Footer.php';//incluimos el pie de página
		}
		}
		?>