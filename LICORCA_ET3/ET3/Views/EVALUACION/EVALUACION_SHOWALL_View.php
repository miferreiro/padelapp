<?php
/*  Archivo php
	Nombre: EVALUACION_SHOWALL_View.php
	Autor: 	Brais Rodriguez
	Fecha de creación: 26/11/2017 
	Función: vista de tabla de datos(showall) realizada con una clase donde se muestran datos caracteristicos y permite seleccionar la evaluación que se desea realizar en la aplicación
*/
//Clase Evaluacion_showall que contiene la vista showall para mostrar todos los datos
class EVALUACION_SHOWALL {
	//Constructor de la clase
	function __construct( $lista, $datos) {
		$this->lista = $lista;//Variable que contiene el array de los atributos a mostrar en la vista
		$this->datos = $datos;//Variable que almacena el recordset de toda la tabla evaluación
		//metodo que llama a la función render que contiene todo el código de la vista
		$this->render($this->lista,$this->datos);
	}
	//Función que contiene el código de la vista
	function render($lista,$datos){
		$this->lista = $lista;//Variable que contiene el array de los atributos a mostrar en la vista
		$this->datos = $datos;//Variable que almacena el recordset de toda la tabla evaluación
		include '../Locales/Strings_' . $_SESSION[ 'idioma' ] . '.php';
//Incluye el contenido de los strings necesarios para el multiidioma
		include '../Views/Header.php';//Incluye el contenido del header
        include_once '../Functions/permisosAcc.php';//Incluye la función permisosAcc

?>
		<div class="seccion">
			<h2>
				<?php echo $strings['Tabla de datos'];?>
			</h2>
			<table>

				<tr>
<?php
					//bucle que recorre el array de los atributos
					foreach ( $lista as $atributo ) {
?>
					<th>
						<?php echo $strings[$atributo]?>
					</th>
<?php
					}
					//Comprueba que se tienen los permisos para poder ver el showall
		if((permisosAcc($_SESSION['login'],12,1)==true)||(permisosAcc($_SESSION['login'],12,2)==true)||        (permisosAcc($_SESSION['login'],12,4)==true)){ 
?>
					<th colspan="3" >
						<?php echo $strings['Opciones']?>
					</th>
<?php } ?>
				</tr>
				<tr><td></td></tr>
				<tr></tr>
<?php
				$his = -10000;//Variable que almacena el idHistoria en cada momento para comparar si cambia 
				//Bucle que recorre todo el recordset de datos y pasa estos valores a array y los muestra
				while ( $fila = mysqli_fetch_array( $this->datos ) ) {
?>
				<tr>
<?php
					//Si la historia siguiente es diferente muestra el textohistoria
					if ($fila['IdHistoria'] != $his) {
?>
						<td bgcolor="#b59438" colspan="8"><?php echo $fila['IdHistoria'] . ". " . $fila['TextoHistoria']; ?></td>
						<tr></tr>
<?php
					}
					//Actualiza la variable $his
					$his = $fila['IdHistoria'];
					//bucle que recorre el array de los atributos 
					foreach ( $lista as $atributo ) {
?>
					
<?php 
					//Si el atributo es igual a comentarioIncorrectoA 0 ComentIncorrectoP ajusta la celda para que el texto se quede dentro
					if ($atributo == 'ComenIncorrectoA' || $atributo == 'ComentIncorrectoP') {
					

?>
						<td  >
							<!-- Muestra el valor del atributo ComenIncorrectoA o ComentIncorrectoP -->
							<p class="ajustar"><?php echo $fila[ $atributo ] ?></p>
<?php
					//Si el atributo es diferente a ComenIncorrectoA o ComentIncorrectoP muestra la celda sin modificar
					} else {
                        //Si el valor de CorrectoP es igual a 1 se muestra el valor en una celda verde
                        if($atributo == 'CorrectoP' && $fila[$atributo] == '1'){
                            ?>
                                <td bgcolor="#4e8726">
                                        <?php echo $fila[$atributo]; ?>
                                </td>
 <?php                           
                        }
                        //Si el valor de CorrectoP es 0 muestra el valor en una celda roja 
                        else if($atributo == 'CorrectoP' && $fila[$atributo] == '0'){
                            ?>
                                <td bgcolor="#ff3700">
                                         <?php echo $fila[$atributo]; ?>
                                </td>
                            
 <?php                           
                        }
                        //si el atributo es corrcto del alumno y valor es 1 se pone de color verde
                        else
                        //Si el valor de ok es igual a 1 se muestra el valor en una celda verde
                        if($atributo == 'OK' && $fila[$atributo] == '1'){
                            ?>
                                <td bgcolor="#4e8726">
                                        <?php echo $fila[$atributo]; ?>
                                </td>
 <?php                           
                        }
                        //Si el valor de ok es 0 muestra el valor en una celda roja 
                        else if($atributo == 'OK' && $fila[$atributo] == '0'){
                            ?>
                                <td bgcolor="#ff3700">
                                         <?php echo $fila[$atributo]; ?>
                                </td>
                            
 <?php                           
                        }
                        //si el atributo es corrcto del alumno y valor es 1 se pone de color verde
                        else if($atributo == 'CorrectoA' && $fila[$atributo] == '1'){
                            ?>
                                  <td bgcolor="#4e8726">
                                      <?php echo $fila[$atributo]; ?>
 
                                </td>
                       
<?php                  
                    }
                         //si el atributo es correcto del alumno y valor es 0 se pone de color rojo
                        else if($atributo == 'CorrectoA' && $fila[$atributo] == '0'){
                            ?>
                                 <td bgcolor="#ff3700">
                                         <?php echo $fila[$atributo]; ?>
                                </td>
                
<?php                
                        }
                        
                        
                        //Si el valor de ok no es 0 ni 1 muestra la celda sin color
                        else{
?>
						<td>	
<?php
						//Muestra el valor del array para cada atributo
						echo $fila[ $atributo ];
					}
					}
							//Variable que almacena e IdTrabajo para enviar en un hidden
							$id = $fila['IdTrabajo'];
							//Variable que almacena el AliasEvaluado para enviar en un hidden
							$al = $fila['AliasEvaluado'];

?>
					</td>
<?php
					}
?>
					<td>
						<form action="../Controllers/EVALUACION_CONTROLLER.php" method="get" style="display:inline" >
							<input type="hidden" name="IdTrabajo" value="<?php echo $fila['IdTrabajo']; ?>">
                            <input type="hidden" name="LoginEvaluador" value="<?php echo $fila['LoginEvaluador']; ?>">
                            <input type="hidden" name="AliasEvaluado" value="<?php echo $fila['AliasEvaluado']; ?>">
                            <input type="hidden" name="IdHistoria" value="<?php echo $fila['IdHistoria']; ?>">
               <!-- Comprueba que se tiene el permiso para poder editar -->
<?php         if(permisosAcc($_SESSION['login'],12,2)==true){ ?>
								<button type="submit" name="action" value="EDIT" ><img src="../Views/icon/modificar.png" alt="<?php echo $strings['Modificar']?>" width="20" height="20" /></button>
<?php } ?>
					<td>
				<!-- Comprueba que se tiene el permiso para poder borrar -->
<?php         if(permisosAcc($_SESSION['login'],12,1)==true){ ?>
								<button type="submit" name="action" value="DELETE" ><img src="../Views/icon/eliminar.png" alt="<?php echo $strings['Eliminar']?>" width="20" height="20" /></button>
<?php } ?>
					<td>
			<!-- Comprueba que se tiene el permiso para poder ver el showcurrent -->
<?php         if(permisosAcc($_SESSION['login'],12,4)==true){ ?>
								<button type="submit" name="action" value="SHOWCURRENT" ><img src="../Views/icon/verDetalles.png" alt="<?php echo $strings['Ver en detalle']?>" width="20" height="20"/></button>
<?php } ?>
						</form>

				</tr>
<?php
				}
?>
							<caption style="margin-bottom:10px;">
					<form action='../Controllers/EVALUACION_CONTROLLER.php' method="get">
					<input type="hidden" name="IdTrabajo" value="<?php echo $id ?>">
					<input type="hidden" name="AliasEvaluado" value="<?php echo $al ?>">
					<!-- Comprueba que se tiene el permiso para poder buscar -->
<?php if(permisosAcc($_SESSION['login'],12,3)==true){ ?>
						<button type="submit" name="action" value="SEARCH"><img src="../Views/icon/buscar.png" alt="BUSCAR" /></button>
<?php 
	  }
	  //Comprueba que se tiene el permiso para poder añadir
	  if(permisosAcc($_SESSION['login'],12,0)==true){
?>
						<button type="submit" name="action" value="ADD"><img src="../Views/icon/añadir.png" alt="AÑADIR" /></button>
<?php
	} 
?>
					</form>
				</caption>
			</table>
			<form action='../Controllers/EVALUACION_CONTROLLER.php' method="post">
				<button type="submit"><img src="../Views/icon/atras.png" alt="<?php echo $strings['Atras']?>" /></button>
			</form>
		</div>
<?php
		include '../Views/Footer.php';//incluimos el footer
		}
		}
?>