<?php
/*  Archivo php
	Nombre: EVALUACION_ADMIN_View.php
	Autor: 	Alejandro Vila
	Fecha de creación: 10/12/2017 
	Función: Esta vista sirve para que el administrador pueda evaluar a otros usuarios
*/
//Clase de Evaluacion_admin_evaluar que contiene la vista de la evaluación del administrador
class EVALUACION_ADMIN_EVALUAR {
	//Constructor de la clase evaluar
	function __construct( $datos) {
		$this->datos = $datos;//Variable que almacena el recordset de los datos de la base de datos con respecto a las qas
		$this->render($this->datos);//Metodo que llama ala funcion render que devuelve el código necesario para generar la vista
	}
	//Función que contiene todo el contenido de la vista
	function render($datos){
		$this->datos = $datos;//Variable que almacena el recordset de los datos de la base de datos con respecto a las qas
		include '../Locales/Strings_' . $_SESSION[ 'idioma' ] . '.php';//Incluye los strings necesarios para el cambio de idioma
		include '../Views/Header.php';//Incluye el contenido del header
?>
		<div class="seccion">
			<!-- Utilizacion de la función substr para quitar las letras QA y que quede el código concatenado con ET -->
			<h2><?php echo $strings['Evaluación resultados de QAs de la entrega '] . "ET" . substr($datos[0][9],2) . $strings[' para el alias '] . $datos[0][8]?></h2>
			<form name="EVALUAR" action="../Controllers/EVALUACION_CONTROLLER.php" method="post"  enctype="multipart/form-data">
			<table>

<?php
				$num = 0;//Variable que almacena el número de qa realizados por cada historia
				$i = 0;//Variable que almacena el indice del array utilizado en el bucle for
				$his = $datos[$i][0];//Variable que almacena un el contenido de una historia, que se utiliza para saber cuantos qa hay por cada historia dado que cada qa tiene 1 historia
				//Bucle que se ejecuta mientras las historias son iguales
				while($his == $datos[$i][0]){
					$his = $datos[$i][0];//Almacena el valor de la historia en cada pasada para saber si estas cambian y cortar el bucle
					$num++;//Se incrementa la variable num
					$i++;//Se incremena la variable i
				}
		
				$comentario = array();//Variable que almacena la inicializacion del array que contendra todos los comentarios de las evaluaciones en cada pasada, necesario reiniciarlo para que no almacena todas
				$cont = 0;//Variable que almacena un contador que se utilizara para saber cuantas pasadas se realizan
				$his = -10000;//Variable que almacena el idHistoria en cada momento para saber si cambia y evitar repetir historias, lo iniciamos con un valor que no estara en la base de datos
				$total = 0;//Variable que almacena un indice por todas la pasadas empezando por la primera
				//Bucle que recorre todos los datos contenidos en el array relacionados con las evaluaciones de qas
				for ($i=0; $i < count($datos); $i++) {
				$cont++;//incrementamos contador

				
?>				
				
<?php
					//Si el id de historia es diferente al id siguiente introduce una historia, para evitar repetir historias iguales
					if ($his != $datos[$i][0]) {
?>
					<tr>
						<td bgcolor="#b59438"  colspan="999999999999"><?php echo $datos[$i][0] . ". " . $datos[$i][6]; ?></td>
						<tr></tr>
<?php
					}
					$his = $datos[$i][0];//actualizamos el valor de la historia actual
?>
<?php
					//Si el comentario correcto del alumno es 1 pone la celda en verde
					if ($datos[$i][1] == 1) {
?>
							<td bgcolor="#4e8726">
<?php
					//Si el correcto del alumno es 0 pone la celda en rojo
					} else if($datos[$i][1] == 0){
?>		
							<td bgcolor="#ff3700">					
<?php
					//Si el correcto del alumno es diferente a 0 y 1 no muestra color en la celda
					} else {
?>
							<td>
<?php

					}
?>
						<!-- Muestra el valor de correcto alumno -->
						<?php echo $datos[$i][1]; ?>
					</td>
<?php
					//Si ok del profesor es 1 muestra la celda en verde
					if ($datos[$i][5] == 1) {
?>
						<td bgcolor="#4e8726">
<?php
					//Si el ok del profesor es 0 muestra la celda en rojo
					} else if($datos[$i][5] == 0) {
?>
						<td bgcolor="#ff3700">
<?php
					//Si el ok es distinto de 0 o 1 no se muestra color en la celda
					} else {
?>
						<td>
<?php

					}
?>
						<!-- Muestra el valor del ok profesor -->
						<?php echo $datos[$i][5]; ?>

					</td>
					<td>
<?php
					//si el valor del ok es 1 muestra un select con el valor 1 predifinido
					if ($datos[$i][5] == 1) {

?>			
						<select name="<?php echo $datos[$i][7] . $datos[$i][0] ?>" required>						        	
								<option selected="selected" value="1">1</option>
						        <option value="0">0</option>
						</select>
<?php
					//Si el valor es distinto a 1 muestra el valor predefinido a 0
					} else {
?>
						<select name="<?php echo $datos[$i][7] . $datos[$i][0] ?>"required>						        	
						        <option value="1">1</option>
						        <option selected="selected" value="0">0</option>
						</select>
<?php
					}
?>
					</td>
				
<?php
				//Guarda en el array el valor de la historia
				$contenido[$total][0] = $datos[$i][0];
				//Gurarda en el array el valor del alias
				$contenido[$total][1] = $datos[$i][7];
				//Guarda en el array el valor del login
				$contenido[$total][2] = $datos[$i][8];


				$total++;// incrementa la variable total
				//Si el número de caracteres es mayor a 0 se guarda el comentario en un array para mostrar despues
				if(strlen(trim($datos[$i][2])) > 0){$comentario[] = $datos[$i][2];}
				//Si la variable $cont llego al número de qas se introducen los comentarios de las qas y se muestra el textareas con el contenido editable del administrador
				if ($cont >= $num) {
?>
				<tr></tr>
<?php
				//Bucle que recorre el array de los comentarios de las qas
				//$j variable que almacena el indice del array en cada pasada
				for ($j=0; $j < count($comentario); $j++) { 
?>
					<tr>
						<td bgcolor="" colspan="15">
<?php
						//Si el número de caracteres supera a 150 corta introduce un salto de linea 
						if (strlen(trim($comentario[$j])) > 150) {
							//Introduce un caracter para simbolizar donde se hara el corte
							//$parte variable que almacena el contenido del texto con el caracter '|'
							$parte = chunk_split(trim($comentario[$j]),150, "|");
    						//Parte el contenido de texto y se almacenan las partes en un array
    						//$parte2 variable que almacena el contenido de las dos partes
    						$parte2 = explode("|",$parte);
?>
								<!-- Se introduce un salto de linea donde estaba el corte y se concatena el texto -->
							<p align="left"><?php echo $parte2[0] . "\n" . $parte2[1]?></p>
<?php
						//Si no supera los 150 caracteres el texto se muestra sin cambios
						} else {
							//la función trim muestra el contenido del comentario sin espacios a la izq y a la der
?>
							<p align="left"><?php echo trim($comentario[$j]); ?></p>
<?php
						}
?>
						</td>
					</tr>
<?php
				} 
?>
				<tr></tr>
				<td colspan="15">
					<textarea id="TextoHistoria" name="<?php echo $datos[$i][0] . $datos[$i][8] ?>" placeholder="<?php echo $strings['Escriba aqui...']?>" maxlength="300" cols="50" rows="7"   onBlur="validarComentIncorrectoP(this,'300')" ><?php echo trim($datos[$i][4])?></textarea>
<?php
				//Si el valor de correcto profesor es 1 muestra la celda verde
				if ($datos[$i][3] == 1) {
?>
					<td bgcolor="#4e8726">
<?php
				//Si el valor de correcto profesor es 0 muestra la celda en rojo
				} else if($datos[$i][3] == 0) {
?>
					<td bgcolor="#ff3700">
<?php
				//Si el valor del correcto profesor es distinto de 0 y 1 muestra la celda sin color
				} else {
?>
					<td>
<?php

				}
?>
					<!-- Muestra el valor de correcto profesor -->
					<?php echo $datos[$i][3] ?>
				<td>
<?php
					//Si el valor correcto profesor es 1 pone el select por defecto a 1
					if ($datos[$i][3] == 1) {
?>
						<select name="<?php echo $datos[$i][0] ?>" required>						        	
								<option selected="selected" value="1">1</option>
						        <option value="0">0</option>
						</select>
						
<?php
					//Si el valor del correcto profesor es distinto a 0 pone el select por defecto a 0
					} else {
?>
						<select name="<?php echo $datos[$i][0] ?>" required>						        	
						        <option value="1">1</option>
						        <option selected="selected" value="0">0</option>
						</select>
						
<?php
					}
?>
				</td>
				</td>
				</td>
				</tr>
<?php
					//reiniciamos el array de comentarios para que este vacio
					$comentario = array();
					$cont = 0;//Reiniciamos la variable cont
				}
				}
				//Variable de sesion que guarda el contenido del array $contenido
				$_SESSION['contenido'] = $contenido;
?>
				
				</table>
				<table>
				<input type="hidden" name="IdTrabajo" value="<?php echo $datos[0][9] ?>">
				<button type="submit" name="action" value="EVALUARADMIN"><img src="../Views/icon/modificar.png" alt="<?php echo $strings['Atras']?>" /></button>
			</form>
			<form action='../Controllers/EVALUACION_CONTROLLER.php' method="get">
				<button type="submit" name="action" value="EVALUACION_HISTORIAS"><img src="../Views/icon/atras.png" alt="<?php echo $strings['Atras']?>" /></button>
			</form>
			</table>
		</div>
<?php
		include '../Views/Footer.php';
		}
		}
?>