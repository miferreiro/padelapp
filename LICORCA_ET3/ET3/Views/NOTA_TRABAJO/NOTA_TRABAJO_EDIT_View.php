<?php
/* 
	Fecha de creación: 4/12/2017 
	Función: vista de el formulario de editar(edit) realizada con una clase donde se muestran todos los campos posibles a modificar para cambiar la nota del trabajo
    Autor:Brais Santos
*/


 //es la clase EDIT de NOTA_TRABAJO que nos permite editar una nota
class NOTA_TRABAJO_EDIT {
//es el constructor de la clase  NOTA_TRABAJO_EDIT
	function __construct($valores) { 
		$this->valores = $valores;//pasamos los valores de cada uno de los campos de la tupla que eligimos en el showall
		$this->render($this->valores);//funcion que mostrará el formulario EDIT con los campos correspondientes
	}
//funcion que mostrará el formulario EDIT con los campos correspondientes
	function render($valores) { 
 		$this->valores = $valores;//pasamos los valores de cada uno de los campos de la tupla que eligimos en el showall
		
		include '../Locales/Strings_' . $_SESSION[ 'idioma' ] . '.php';//incluimos los strings de idiomas, para que la página pueda estar en español,inglés y galego
		include '../Views/Header.php';//incluimos la cabecera
		?>
		<div class="seccion">
			<h2>
				<?php echo $strings['Formulario de modificación'];?>
			</h2>
			<form id="EDIT" name="EDIT" action="../Controllers/NOTA_TRABAJO_CONTROLLER.php" method="post" enctype="multipart/form-data" onsubmit="return comprobarEditNotas()">
				<table>
					<tr>
						<th class="formThTd">
							<?php echo $strings['Usuario'];?>
						</th>
						<td class="formThTd"><input type="text" id="login" name="login" placeholder="<?php echo $strings['Escriba aqui...']?>" value="<?php echo $this->valores['login']?>" maxlength="9" size="9"  readonly onBlur="comprobarVacio(this)  && comprobarLongitud(this,'9') && comprobarTexto(this,'9')" required/>
					</tr>
					<tr>
						<th class="formThTd">
							<?php echo $strings['IdTrabajo'];?>
						</th>
						<td class="formThTd"><input type="text" id="IdTrabajo" name="IdTrabajo" placeholder="<?php echo $strings['Escriba aqui...']?>" value="<?php echo $this->valores['IdTrabajo']?>" maxlength="6" size="6" onBlur="comprobarVacio(this) &&  comprobarLongitud(this,6) && comprobarTexto(this,6)" readonly required/>
					</tr>
					<tr>
						<th class="formThTd">
							<?php echo $strings['Nota del Trabajo'];?>
						</th>
						<td class="formThTd"><input type="text" id="NotaTrabajo" name="NotaTrabajo" placeholder="<?php echo $strings['Escriba aqui...']?>" value="<?php echo $this->valores['NotaTrabajo']?>" maxlength="4" size="4" onBlur="comprobarVacio(this) && comprobarLongitud(this,'4') && comprobarTexto(this,'4') && comprobarReal(this,2,0,10) " required/>
					</tr>
					
					
					<tr>
						<td colspan="2">
							<button type="submit" name="action" value="EDIT"><img src="../Views/icon/modificar.png" alt="<?php echo $strings['Confirmar formulario']?>" /></button>
			</form>
			<form action='../Controllers/NOTA_TRABAJO_CONTROLLER.php' style="display: inline">
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