<?php
/*  Archivo php
	Nombre: EVALUACION_ADD_View.php
	Autor: 	Brais Rodríguez
	Fecha de creación: 28/11/2017 
	Función: vista de el formulario de añadir(add) realizada con una clase donde se muestran todos los campos a rellenar para añadir una evaluacion en la base de datos
*/

//es la clase ADD de EVALUACION que nos permite añadir una evaluacion
class EVALUACION_ADD {
	//Constructor de la clase evaluación
	function __construct($datos,$trabajos,$trabajos2,$hists) { 
		$this->datos = $datos;//Variable que almacena todos los trabajos
		$this->trabajos = $trabajos;//Variable que almacena todos los usuarios
		$this->trabajos2 = $trabajos2;//Variable que almacena todos los usuarios
		$this->hists= $hists;//Variable que almacena todas las historias
		$this->render($this->datos,$this->trabajos,$this->trabajos2,$this->hists);//llamamos a la función render donde se mostrará el formulario ADD con los campos correspondientes

	}
//funcion que mostrará el formulario ADD con los campos correspondientes
	function render($datos,$trabajos,$trabajos2,$hists) { 
		$this->datos = $datos;//Variable que almacena todos los trabajos
		$this->trabajos = $trabajos;//Variable que almacena todos los usuarios 
		$this->trabajos2 = $trabajos2;//Variable que almacena todos los usuarios
		$this->hists= $hists;//Variable que almacena todas las historias
		include '../Locales/Strings_' . $_SESSION[ 'idioma' ] . '.php';//incluimos los strings de idiomas, para que la página pueda estar en español,inglés y galego
		include '../Views/Header.php';//incluimos la cabecera
		?>
		<div class="seccion">
			<h2>
				<?php echo $strings['Formulario de inserción'];?>
			</h2>
			<form name="ADD" action="../Controllers/EVALUACION_CONTROLLER.php" method="post" enctype="multipart/form-data" onsubmit="return comprobarAddEvaluacion()">
				<table>
					<tr>
						<th class="formThTd">
							<?php echo $strings['NombreTrabajo'];?>
						</th>
                  <td class="formThTd">
                   <select id="IdTrabajo" name="IdTrabajo" required>
<?php
				//Bucle que recorre los datos recogidos de la base de datos
				//$fila variable que alamacena el array asociativo de los datos de la base de datos 
				while ( $fila = mysqli_fetch_array( $this->datos ) ) { 
?>
				<option value="<?php echo $fila[ 'IdTrabajo' ]?>">

<?php 
					//Se muestra el valor de NombreTrabajo
					echo $fila['NombreTrabajo'];
?>		
               							

               </option>
	
<?php } ?>					
					</select>
				</td>
					</tr>
					
					
					
				<tr>
						<th class="formThTd">
							<!-- Se muestra el valor de NombreTrabajo -->
							<?php echo $strings['LoginEvaluador'];?>
						</th>
                  <td class="formThTd">
                   <select id="LoginEvaluador" name="LoginEvaluador" required>
<?php
				//Bucle que recorre los datos recogidos de la base de datos
				//$fila variable que alamacena el array asociativo de los datos de la base de datos 
				while ( $fila = mysqli_fetch_array( $this->trabajos) ) {
?>
				<option value="<?php echo $fila[ 'login' ]?>">

<?php 
					//Se muestra el valor del login
					echo $fila['login'];
?>		
               							

               </option>
	
<?php } ?>					
					</select>
				</td>
					</tr>

			
				<tr>
						<th class="formThTd">
							<?php echo $strings['AliasEvaluado'];?>
						</th>
                  <td class="formThTd">
                   <select id="AliasEvaluado" name="AliasEvaluado" required>
<?php
				//Bucle que recorre los datos recogidos de la base de datos
				//$fila variable que alamacena el array asociativo de los datos de la base de datos 
				while ( $fila = mysqli_fetch_array( $this->trabajos2) ) { 
?>
				<option value="<?php echo $fila[ 'Alias' ]?>">

<?php 
					//Muestra el valor del Alias
					echo $fila['Alias'];
?>		
               							

               </option>
	
<?php } ?>					
					</select>
				</td>
					</tr>
			
				<tr>
						<th class="formThTd">
							<?php echo $strings['TextoHistoria'];?>
						</th>
                  <td class="formThTd">
                   <select id="IdHistoria" name="IdHistoria" required>
<?php
				//Bucle que recorre los datos recogidos de la base de datos
				//$fila variable que alamacena el array asociativo de los datos de la base de datos 
				while ( $fila = mysqli_fetch_array( $this->hists) ) { 
?>
				<option value="<?php echo $fila[ 'IdHistoria' ]?>">

<?php 
					//Muestra el valor de TextoHistoria
					echo $fila['TextoHistoria'];
?>		
               							

               </option>
	
<?php } ?>					
					</select>
				</td>
					</tr>
					<tr>
						<th class="formThTd">
							<?php echo $strings['CorrectoA'];?>
						</th>
						<td class="formThTd"><input type="text" id="CorrectoA" name="CorrectoA" placeholder="<?php echo $strings['Escriba aqui...']?>" value="" maxlength="1" size="1" onBlur="comprobarVacio(this) && comprobarLongitud(this,'1') && comprobarTexto(this,'1')  && comprobarEntero(this,0,2)"/>
					</tr>
					<tr>
						<th class="formThTd">
							<?php echo $strings['ComenIncorrectoA'];?>
						</th>
						<td class="formThTd"><textarea id="ComenIncorrectoA" name="ComenIncorrectoA" placeholder="<?php echo $strings['Escriba aqui...']?>" value="" maxlength="300" cols="32" rows="8"  onBlur="comprobarLongitud(this,'300') && comprobarTexto(this,'300')"></textarea>

					</tr>

					<tr>
						<th class="formThTd">
							<?php echo $strings['CorrectoP'];?>
						</th>
						<td class="formThTd"><input type="text" id="CorrectoP" name="CorrectoP" placeholder="<?php echo $strings['Escriba aqui...']?>" value="" maxlength="1" size="1" onBlur="comprobarVacio(this) && comprobarLongitud(this,'1') && comprobarTexto(this,'1')  && comprobarEntero(this,0,2)"/>
					</tr>

					<tr>
						<th class="formThTd">
							<?php echo $strings['ComentIncorrectoP'];?>
						</th>
						<td class="formThTd"><textarea id="ComentIncorrectoP" name="ComentIncorrectoP" placeholder="<?php echo $strings['Escriba aqui...']?>" value="" maxlength="300" cols="32" rows="8"  onBlur=" comprobarLongitud(this,'300') && comprobarTexto(this,'300')"></textarea>
					</tr>

					<tr>
						<th class="formThTd">
							<?php echo $strings['OK'];?>
						</th>
						<td class="formThTd"><input type="text" id="OK" name="OK" placeholder="<?php echo $strings['Escriba aqui...']?>" value="" maxlength="1" size="1" onBlur="comprobarVacio(this) && comprobarLongitud(this,'1') && comprobarTexto(this,'1')  && comprobarEntero(this,0,2)"/>
					</tr>


					<tr>
						<td colspan="2">
							<button type="submit" name="action" value="ADD"><img src="../Views/icon/añadir.png" alt="<?php echo $strings['Confirmar formulario']?>" /></button>
			</form>
			<form action='../Controllers/EVALUACION_CONTROLLER.php' method="get" style="display: inline">
				<button type="submit" name="action" value=""><img src="../Views/icon/atras.png" alt="<?php echo $strings['Atras']?>" /></button>
			</form>
			</tr>
			</table>
		</div>
		<?php
		include '../Views/Footer.php';//incluimos el pie de la página
		}
		}
		?>