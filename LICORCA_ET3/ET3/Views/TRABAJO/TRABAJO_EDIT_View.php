<?php
/*  Archivo php
	Nombre: TRABAJO_EDIT_View.php
	Autor: 	Brais Rodríguez Martínez
	Fecha de creación: 27/11/2017  
	Función: vista de el formulario de editar(edit) realizada con una clase donde se muestran todos los campos posibles a modificar para cambiar los datos de un trabajo n en la base de datos
*/
//es la clase EDIT de TRABAJO que nos permite mostrar el formulario de editar
class TRABAJO_EDIT {
	//es el constructor de la clase TRABAJO_EDIT
	function __construct( $valores ) {
		$this->valores = $valores;//pasamos los valores de cada uno de los campos
		$this->render( $this->valores );//llamamos a la función render donde se mostrará el formulario EDIT con los campos correspondientes y sus valores
	}
	//funcion que mostrará el formulario EDIT con los campos correspondientes y sus valores
	function render( $valores ) {
		$this->valores = $valores;
		include '../Locales/Strings_' . $_SESSION[ 'idioma' ] . '.php';//incluimos los strings de idiomas, para que la página pueda estar en español,inglés y galego
		include '../Views/Header.php';//incluimos la cabecera
		?>
		<div class="seccion">
			<h2>
				<?php echo $strings['Formulario de modificación'];?>
			</h2>
			<form name="EDIT" action="../Controllers/TRABAJO_CONTROLLER.php" method="post" enctype="multipart/form-data" onsubmit="return comprobarEditTrabajo()">
				<table>
					<tr>
						<th class="formThTd">
							<?php echo $strings['IdTrabajo'];?>
						</th>
						<td class="formThTd"><input type="text" id="IdTrabajo" name="IdTrabajo" placeholder="<?php echo $strings['Escriba aqui...']?>" value="<?php echo $this->valores['IdTrabajo']?>" maxlength="6" size="20"  readonly onBlur="comprobarVacio(this) && comprobarLongitud(this,'6') && comprobarTexto(this,'6')" required/>
					</tr>

					<tr>
						<th class="formThTd">
							<?php echo $strings['NombreTrabajo'];?>
						</th>
						<td class="formThTd"><input type="text" id="NombreTrabajo" name="NombreTrabajo" placeholder="<?php echo $strings['Escriba aqui...']?>" value="<?php echo $this->valores['NombreTrabajo']?>" maxlength="60" size="34" required onBlur="comprobarVacio(this) && comprobarLongitud(this,'60') && comprobarTexto(this,'60')"/>
					</tr>
					<tr>
						<th class="formThTd">
							<?php echo $strings['FechaIniTrabajo'];?>
						</th>
						<td class="formThTd"><input type="text" id="FechaIniTrabajo" name="FechaIniTrabajo" placeholder="<?php echo $strings['Escriba aqui...']?>" value="<?php echo $this->valores['FechaIniTrabajo']?>"  size="20" required  class="tcal" readonly onBlur=""/>
					</tr>
                    
                    <tr>
						<th class="formThTd">
							<?php echo $strings['FechaFinTrabajo'];?>
						</th>
						<td class="formThTd"><input type="text" id="FechaFinTrabajo" name="FechaFinTrabajo" placeholder="<?php echo $strings['Escriba aqui...']?>" value="<?php echo $this->valores['FechaFinTrabajo']?>" size="20" required  class="tcal" readonly onBlur=""/>
					</tr>
                    
                    <tr>
						<th class="formThTd">
							<?php echo $strings['PorcentajeNota'];?>
						</th>
						<td class="formThTd"><input type="text" id="PorcentajeNota" name="PorcentajeNota" placeholder="<?php echo $strings['Escriba aqui...']?>" value="<?php echo $this->valores['PorcentajeNota']?>" maxlength="2" size="2" required onBlur="comprobarVacio(document.forms['EDIT'].elements[2]) && comprobarVacio(document.forms['EDIT'].elements[3]) && comprobarVacio(this) && comprobarLongitud(this,'2') && comprobarTexto(this,'2') && comprobarEntero(this,0,100)"/>
					</tr>
                    
                    
					
					<tr>
						<td colspan="2">
							<button type="submit" name="action" value="EDIT"><img src="../Views/icon/modificar.png" alt="<?php echo $strings['Confirmar formulario']?>" /></button>
			</form>
			<form action='../Controllers/TRABAJO_CONTROLLER.php' style="display: inline">
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