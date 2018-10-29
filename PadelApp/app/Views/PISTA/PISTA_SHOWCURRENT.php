<?php

class PISTA_SHOWCURRENT{
	
    //es el constructor de la clase Pista_Showall
	function __construct( $lista, $valores) {
		$this->lista = $lista;//pasamos los campos de la tabla PISTAS
		$this->valores = $valores;//pasamos los valores de cada campo

		$this->render($this->lista,$this->valores);//llamamos a la función render donde se mostrará el formulario SHOWALL con los campos correspondientes
	}
	function render($lista,$valores){
		$this->lista = $lista;//pasamos los campos de la tabla PISTAS
		$this->valores = $valores;//pasamos los valores de cada campo

		include '../Locales/Strings_' . $_SESSION[ 'idioma' ] . '.php';//incluimos los strings de idiomas, para que la página pueda estar en español,inglés y galego

  
	include '../Views/Header.php';//incluimos la cabecera
	

?>
<div class="seccion">
			<h2>
				<?php echo $strings['Vista detallada'];?>
			</h2>
			<table>

				<tr>
<?php
					foreach ( $lista as $atributo ) { 
?>
						<th>
							<?php echo $strings[$atributo]?>
						</th>
<?php
					}
?>

				</tr>
				<tr>
					<?php
						while ( $fila = mysqli_fetch_array( $this->valores ) ) {
?>
				<tr>
<?php
					foreach ( $lista as $atributo ) { 
?>
					<td>
<?php 
							echo $fila[ $atributo ];
?>
					</td>
<?php
					}
?>
														
				</tr>
<?php
					}
?>
		
			</table>
			<form action='../Controllers/PISTA_CONTROLLER.php' method="post">
				<button id ="buttonBien" type="submit"><img src="../Views/icon/atras.png" alt="<?php echo $strings['Atras']?>" /></button>
			</form>
		</div>
<?php
		include '../Views/Footer.php';//incluimos el pie de la página
		}
		}
?>