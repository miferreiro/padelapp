<?php
/*  
	Archivo php
	Fecha de creación: 27/11/2017 
	Autor: Jonatan Couto
	Función: vista de el formulario de añadir(add) realizada con una clase donde se muestran todos los campos a rellenar para añadir un permiso a la base de datos
*/
//Es la clase ADD de PERMISO que nos permite añadir permisos
class PERMISO_ADD {
	//es el constructor de la clase PERMISO_ADD
	function __construct($valores,$acciones) {
		$this->render($valores,$acciones);//llamamos a la función render donde se mostrará el formulario ADD con los campos correspondientes
	}
	//función render donde se mostrará el formulario ADD con los campos correspondientes
	function render($valores,$acciones) {
		include '../Locales/Strings_' . $_SESSION[ 'idioma' ] . '.php';//incluimos los strings de idiomas, para que la página pueda estar en español,inglés y galego
		include '../Views/Header.php';//incluimos la cabecera
?>
		<div class="seccion">
			<h2>
				<?php echo $strings['Formulario de inserción'];?>
			</h2>
			<form name="ADD" action="../Controllers/PERMISO_CONTROLLER.php" method="post" enctype="multipart/form-data" >
				<table>
					<tr>
						<th class="formThTd">
							<?php echo $strings['NombreGrupo'];?>
						</th>
						<td class="formThTd"><input type="text" id="NombreGrupo" name="NombreGrupo" placeholder="<?php echo $strings['Escriba aqui...']?>" value="<?php echo $valores[0][1]?>" maxlength="60" size="60" onBlur="comprobarVacio(this) && comprobarLongitud(this,'60') && comprobarTexto(this,'6')" readonly/>
						<input type="hidden" name="IdGrupo" value="<?php echo $valores[0][0];?>">
					</tr>
					<tr>
						<th class="formThTd">
							<?php echo $strings['NombreFuncionalidad'];?>
						</th>
						<td class="formThTd">
							<select name="IdFuncionalidad" required>						        
								<?php
								//Bucle que recorre los posibles permisos 
								for ($i=0; $i < count($acciones); $i++) { 
								?>
								<option value="<?php echo $acciones[$i][0] . ',' . $acciones[$i][2] ?>"><?php echo $acciones[$i][1] . "_" . $acciones[$i][3] ?></option>
						        <?php
						        }
						        ?>
							</select>
					</tr>
					<input type="hidden" name="IdGrupo" value="<?php echo $valores[0][0];?>">
					<tr>
						<td colspan="2">
							<button type="submit" name="action" value="ADD"><img src="../Views/icon/añadir.png" alt="<?php echo $strings['Confirmar formulario']?>" /></button>
			</form>
						<form action='../Controllers/PERMISO_CONTROLLER.php' method="post" style="display: inline">
							<input type="hidden" name="IdGrupo" value="<?php echo $valores[0][0];?>">
							<input type="hidden" name="action" value="ASSIGN">
							<button type="submit"><img src="../Views/icon/atras.png" alt="<?php echo $strings['Atras']?>" /></button>
						</form>
					</tr>
				</table>
		</div>
<?php
		include '../Views/Footer.php';//incluimos el footer
		}
		}
?>