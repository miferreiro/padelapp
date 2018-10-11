<?php
/*  Archivo php
	Nombre: ASIGNAC_QA_GENERAR_View.php
	Autor: 	Jonatan Couto Riádigos
	Fecha de creación: 29/11/2017 
	Función: vista de el formulario que permite generar qas
*/
//Clase Adignac_qa_generar que contiene la vista para ver los resultados de las correciones qa
class ASIGNAC_QA_GENERAR {
	//Constructor de la clase
	function __construct($valores) {
		//$valores variable que almacena un array con la info de todas las Ets existentes para poder generar la qa
		$this->render($valores);//metodo que llama a la función render que contiene todo el código de la vista
	}
	//Función que contiene el código de la vista
	function render($ET) {
		//$ET variable que almacena un array con la info de todas las Ets existentes para poder generar la qa
		include '../Locales/Strings_' . $_SESSION[ 'idioma' ] . '.php';//Incluye el contenido de los strings necesarios para el multiidioma
		include '../Views/Header.php';//Incluye el contenido del header
?>
		<div class="seccion">
			<h2>
				<?php echo $strings['GENERACIÓN AUTOMÁTICA DE QAs'];?>
			</h2>
			<form name="ASIGNAC_QA" action="../Controllers/ASIGNAC_QA_CONTROLLER.php" method="post" enctype="multipart/form-data" onSubmit="return comprobarGenerarAsignQa()">
				<table>
					<tr>
						<th class="formThTd">
							<?php echo $strings['ET'];?>
						</th>
						<td class="formThTd">
							<select name="IdTrabajo" required>						        
								<?php
								//Bucle que recorre el array de las posibles et para generer qas
								for ($i=0; $i < count($ET); $i++) { 
								?>
								<option value="<?php echo $ET[$i][0] ?>"><?php echo $ET[$i][1] ?></option>
						        <?php
						        }
						        ?>
							</select>
					</tr>
					<tr>
						<th class="formThTd">
							<?php echo $strings['Número de QAs'];?>
						</th>
						<td class="formThTd">
						<input type="text" id="num" name="num" placeholder="<?php echo $strings['Escriba aqui...']?>" value="5" maxlength="3" size="3" required onBlur="comprobarVacio(this) && comprobarLongitud(this, 3) && comprobarTexto(this, 3) && comprobarEntero(this, 0, 999) "/>
					</tr>

					<tr>
						<td colspan="2">
							<button type="submit" name="action" value="GENERAR"><img src="../Views/icon/generar.png" width="32" height="32" /></button>
			</form>
						<form action='../Controllers/ASIGNAC_QA_CONTROLLER.php' method="post" style="display: inline">
							<button type="submit"><img src="../Views/icon/atras.png" alt="<?php echo $strings['Atras']?>" /></button>
						</form>
					</tr>
				</table>
		</div>
<?php
		include '../Views/Footer.php';//Incluye el contenido del pie
		}
		}
?>