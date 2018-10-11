<?php
/*  Archivo php
	Nombre: ASIGNAC_QA_ADD_View.php
	Autor: 	Jonatan Couto Riádigos
	Fecha de creación: 29/11/2017 
	Función: vista de el formulario de añadir(add) realizada con una clase donde se muestran todos los campos a rellenar para añadir una asignación de qa a la base de datos
*/
//Clase Asignac_qa_dd que contiene la vista de formulario para añadir una qa
class ASIGNAC_QA_ADD {
	//Constructor de la clase
	function __construct($datos,$trabajos) {
		$this->datos = $datos;//Variable que almacena un recordset con la info de todos los trabajos
		$this->trabajos = $trabajos;//Variable que almacena un recordset con la info de todos los usuarios
		$this->render($this->datos,$this->trabajos);//metodo que llama a la función render que contiene todo el código de la vista

	}
	//Función que contiene el código de la vista
	function render($datos,$trabajos) {
		$this->datos = $datos;//Variable que almacena un recordset con la info de todos los trabajos
		$this->trabajos = $trabajos;//Variable que almacena un recordset con la info de todos los usuarios
		include '../Locales/Strings_' . $_SESSION[ 'idioma' ] . '.php';//Incluye el contenido de los strings necesarios para el multiidioma
		include '../Views/Header.php';//Incluye el contenido del header
?>
		<div class="seccion">
			<h2>
				<?php echo $strings['Formulario de inserción'];?>
			</h2>
			<form id="ADD"name="ADD" action="../Controllers/ASIGNAC_QA_CONTROLLER.php" method="post" enctype="multipart/form-data" onsubmit="return comprobarAddAsignQa()">
				<table>
					<tr>
						<th class="formThTd">
							<?php echo $strings['NombreTrabajo'];?>
						</th>
                  <td class="formThTd">
                   <select id="IdTrabajo" name="IdTrabajo" required>
<?php
				//Bucle que recorre todo el recordset de trabajos y pasa estos valores a array y los muestra
				while ( $fila = mysqli_fetch_array( $this->datos ) ) {
?>
				<option value="<?php echo $fila[ 'IdTrabajo' ]?>">

<?php 
					//Muestra el valor del array para cada atributo
					echo $fila['NombreTrabajo'];
?>		
               							

               </option>
	
<?php } ?>					
					</select>
				</td>
					</tr>
					<tr>
						<th class="formThTd">
							<?php echo $strings['LoginEvaluador'];?>
						</th>
                  <td class="formThTd">
				<select id="LoginEvaluador" name="LoginEvaluador"  required>
<?php
				//Bucle que recorre todo el recordset de los usuarios y pasa estos valores a array y los muestra
				for($i = 0 ;$i < count($this->trabajos); $i++) {
?>
				<option value="<?php echo $this->trabajos[$i][0] ?>">

<?php 
					//Muestra el valor del array para cada atributo
					echo $this->trabajos[$i][0];
?>		
               							

               </option>
	
<?php } ?>					
				</select>
				</td>
					</tr>		
					<tr>
						<th class="formThTd">
							<?php echo $strings['LoginEvaluado'];?>
						</th>
						<td class="formThTd">
						<select id="LoginEvaluado" name="LoginEvaluado"  required>
<?php
				//Bucle que recorre todo el recordset de los usuarios y pasa estos valores a array y los muestra
				for($i = 0 ;$i < count($this->trabajos); $i++) {
?>
				<option value="<?php echo $this->trabajos[$i][0] ?>">

<?php 
					//Muestra el valor del array para cada atributo
					echo $this->trabajos[$i][0];
?>		
               							

               </option>
	
<?php } ?>					
				</select>
					</tr>

					<tr>
						<th class="formThTd">
							<?php echo $strings['AliasEvaluado'];?>
						</th>
						<td class="formThTd">
				<select id="AliasEvaluado" name="AliasEvaluado"  required>
<?php
				//Bucle que recorre todo el recordset de los usuarios y pasa estos valores a array y los muestra
				for($i = 0 ;$i < count($this->trabajos); $i++) {
?>
				<option value="<?php echo $this->trabajos[$i][1] ?>">

<?php 
					//Muestra el valor del array para cada atributo
					echo $this->trabajos[$i][1];
?>		
               							

               </option>
	
<?php } ?>					
				</select>
					</tr>

					<tr>
						<td colspan="2">
							<button type="submit" name="action" value="ADD"><img src="../Views/icon/añadir.png" alt="<?php echo $strings['Confirmar formulario']?>" /></button>
			</form>
						<form action='../Controllers/ASIGNAC_QA_CONTROLLER.php' method="post" style="display: inline">
							<button type="submit"><img src="../Views/icon/atras.png" alt="<?php echo $strings['Atras']?>" /></button>
						</form>
					</tr>
				</table>
		</div>
<?php
		//Incluye el contenido del pie
		include '../Views/Footer.php';
		}
		}
?>