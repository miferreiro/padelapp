<?php
/*  Archivo php
	Nombre: ASIGNAC_QA_HISTORIAS_View.php
	Autor: 	Jonatan Couto Riádigos
	Fecha de creación: 29/11/2017 
	Función: vista de el formulario que asigna historias de usuario a qas
*/
//Clase Asignac_qa_historias que contiene la vista para poder generar las historias por cada qa	
class ASIGNAC_QA_HISTORIAS {
	//Constructor de la clase
	function __construct($valores) {
		//$valores variable que almacena un array con la informacion de las qas existentes para asignar las historias
		$this->render($valores);
	}
	//Función que muestra la vista para generar automáticamente las historias
	function render($QA) {
		include '../Locales/Strings_' . $_SESSION[ 'idioma' ] . '.php';//Incluye el contenido de los strings necesarios para el multiidioma
		include '../Views/Header.php';//Incluye el contenido del header
?>
		<div class="seccion">
			<h2>
				<?php echo $strings['GENERACIÓN AUTOMÁTICA DE HISTORIAS'];?>
			</h2>
			<form name="ASIGNAC_QA" action="../Controllers/ASIGNAC_QA_CONTROLLER.php" method="post" enctype="multipart/form-data">
				<table>
					<tr>
						<th class="formThTd">
							<?php echo $strings['QA'];?>
						</th>
						<td class="formThTd">
							<select name="IdTrabajo" required>						        
								<?php
								//Bucle que recorre el array las posibles QA para generer las historias
								for ($i=0; $i < count($QA); $i++) { 
								?>
								<option value="<?php echo $QA[$i][0] ?>"><?php echo $QA[$i][1] ?></option>
						        <?php
						        }
						        ?>
							</select>
					</tr>

					<tr>
						<td colspan="2">
							<button type="submit" name="action" value="HISTORIAS"><img src="../Views/icon/generar.png" alt="<?php echo $strings['Confirmar formulario']?>" width="32" height="32" /></button>
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