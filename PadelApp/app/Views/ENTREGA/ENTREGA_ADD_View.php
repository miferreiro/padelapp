<?php
//Función: es la vista que sirve para añadir una entrega(añade una tupla a la tabla).
//Autor:Brais Santos
//Fecha de creación:27/11/2017

//es la clase ADD de ENTREGA que nos permite añadir una entrega
class ENTREGA_ADD {
//es el constructor de la clase ENTREGA_ADD
	function __construct($datos,$trabajos) { 
		$this->datos = $datos;//Variable que almacena todos los login
		$this->trabajos = $trabajos;//Variable que almacena todos los trabajos
		$this->render($this->datos,$this->trabajos);//llamamos a la función render donde se mostrará el formulario ADD con los campos correspondientes

	}
//funcion que mostrará el formulario ADD con los campos correspondientes
	function render($datos,$trabajos) {
		$this->datos = $datos;//Variable que almacena todos los login
		$this->trabajos = $trabajos;//Variable que almacena todos los trabajos
		include '../Locales/Strings_' . $_SESSION[ 'idioma' ] . '.php';//incluimos los strings de idiomas, para que la página pueda estar en español,inglés y galego
		include '../Views/Header.php';//incluimos la cabecera
?>
		<div class="seccion">
			<h2>
				<?php echo $strings['Formulario de inserción'];?>
			</h2>
			<form id="ADD" name="ADD" action="../Controllers/ENTREGA_CONTROLLER.php" method="post"  enctype="multipart/form-data"  onsubmit="return comprobarAddEntrega()"><!--Formulario para añadir una entrega -->
				<table>
					<tr>
						<th class="formThTd">
							<?php echo $strings['login'];?>
						</th>
                  <td class="formThTd">
                   <select id="login" name="login" required>
<?php
				while ( $fila = mysqli_fetch_array( $this->datos ) ) { //este bucle va a sacar todos los login qu están almacenados
?>
				<option value="<?php echo $fila[ 'login' ]?>">

<?php 
			
					echo $fila['login'];
?>		
               							

               </option>
	
<?php } ?>					
					</select>
				</td>
					</tr>
					<tr>
						<th class="formThTd">
							<?php echo $strings['NombreTrabajo'];?>
						</th>
                  <td class="formThTd">
                   <select id="IdTrabajo" name="IdTrabajo" required>
<?php
				while ( $fila = mysqli_fetch_array( $this->trabajos ) ) { //este bucle va a sacar todos los IdTrabajo que están almacenados
?>
				<option value="<?php echo $fila[ 'IdTrabajo' ]?>">

<?php 
			
					echo $fila['NombreTrabajo'];
?>		
               							

               </option>
	
<?php } ?>					
					</select>
				</td>
					</tr>
                    <tr>
						<th class="formThTd">
							<?php echo $strings['Horas'];?><!--se muestra el campo Horas-->
						</th>
						<td class="formThTd"><input type="text" id="Horas" name="Horas" placeholder="<?php echo $strings['Escriba aqui...']?>" value="" maxlength="2" size="2" required onBlur="comprobarVacio(this) && comprobarLongitud(this,'2') && comprobarTexto(this,'2') && comprobarEntero(this,0,99)"/>
					</tr>
                    
                    <tr>
						<th class="formThTd">
							<?php echo $strings['Ruta'];?><!--se muestra el campo Ruta-->
						</th>
						<td class="formThTd"><input type="file" id="Ruta" name="Ruta" placeholder="<?php echo $strings['Escriba aqui...']?>" value="" maxlength="60" size="60" required  />
					</tr>
					
					<tr>
						<td colspan="2">
							<button type="submit" name="action" value="ADD" onfocus="comprobarVacio(document.forms['ADD'].elements[3])"><img src="../Views/icon/añadir.png" alt="<?php echo $strings['Confirmar formulario']?>" /></button><!--boton para confirmar el añadido de la entrega -->
			</form>
						<form action='../Controllers/ENTREGA_CONTROLLER.php' method="post" style="display: inline"><!--formulario para volver atra-->
							<button type="submit"><img src="../Views/icon/atras.png" alt="<?php echo $strings['Atras']?>" /></button>
                            <!--boton para volver atras -->
						</form>
					</tr>
				</table>
		</div>
<?php
		include '../Views/Footer.php';//incluimos el pie de la página 
		}
		}
?>