<?php

class CATEGORIA_INSCRITOS {

	function __construct( $lista, $datos,$vuelta) {
		$this->lista = $lista;
		$this->datos = $datos;
		$this->vuelta = $vuelta;
		$this->render($this->lista,$this->datos,$vuelta);
	}
	
	function render($lista,$datos,$vuelta){
		$this->lista = $lista;
		$this->datos = $datos;
		$this->vuelta = $vuelta;
		include '../Locales/Strings_' . $_SESSION[ 'idioma' ] . '.php';
		include '../Views/Header.php';
      
?>

		<div class="seccion" align="center">
			<h2>
				<?php echo $strings['Tabla de datos'];?>
			</h2>
			<div class="col-md-4">
			<table class="table table-sm">
				<thead class="thead-light">

				<tr>
<?php
					foreach ( $lista as $atributo ) {//muestra el nombre de cada uno de los campos
?>
					<th>
						<?php echo $strings[$atributo]?>
					</th>
<?php
					}
?>
					<th colspan="4" >
						<?php echo $strings['Opciones']?>
					</th>
				</tr>
<?php
				while ( $fila = mysqli_fetch_array( $this->datos ) ) {//este bucle se va a repetir mientras no se muestren todos los datos
?>
				<tr>
<?php
					foreach ( $lista as $atributo ) {//este bucle sacará los valores de cada uno de los campos de una tupla
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
				</thead>
			</table>
			</div>
			<form action='../Controllers/CAMPEONATO_CATEGORIA_CONTROLLER.php' method="get">
				<input type="hidden" name="IdCampeonato" value="<?php echo $vuelta['IdCampeonato']; ?>">		
				<input type="hidden" name="Tipo" value="<?php echo $vuelta['Tipo']; ?>">		
				<input type="hidden" name="Nivel" value="<?php echo $vuelta['Nivel']; ?>">					
				<button id ="buttonBien" type="submit"><img src="../Views/icon/atras.png" alt="<?php echo $strings['Atras']?>" /></button>
			</form>
		</div>
<?php
		include '../Views/Footer.php';//incluimos el pie de la página
		}
		}
?>