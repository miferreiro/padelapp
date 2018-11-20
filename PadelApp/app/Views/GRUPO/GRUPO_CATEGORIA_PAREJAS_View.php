<?php

class GRUPO_CATEGORIA_PAREJAS {

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
		$this->aux =0;
		$this->aux2 = 0;
		include '../Locales/Strings_' . $_SESSION[ 'idioma' ] . '.php';
		include '../Views/Header.php';
      
?>

		<div class="seccion" align="center">
			<h2>
				<?php echo $strings['Tabla de parejas en la categoría'];?>
			</h2>
			<div class="col-md-4">
			<table class="table table-sm">
				<thead class="thead-light">

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
<?php
				while ( $fila = mysqli_fetch_array( $this->datos ) ) {
			
?>
				<tr>
<?php

				foreach ( $lista as $atributo ) {
					if($atributo == 'NumPareja'){if($this->aux%2 == 0){ $this->aux = 0; }else{ $this->aux = 1;}}
					if($this->aux == 0 && $atributo == 'NumPareja'){
						if($this->aux2%2 == 1){
?>
					 <td style="border-bottom: 2px solid #000;"> 
<?php		
						}else{
?>
						<td>
<?php
						}
						echo $fila[ $atributo ];			
?>
					</td>
					
<?php
					$this->aux=1;
					}else{
						if($this->aux2%2 == 0){
?>
					 <td > 
<?php		
						}else{
?>
						<td style="border-bottom: 2px solid #000;">
<?php
						}
						if($atributo != 'NumPareja'){
							echo $fila[ $atributo ];	
						}
?>
					</td>
<?php
						if($atributo == 'NumPareja' && $this->aux == 1){$this->aux = 0;}
					}
			
				}
?>
				</tr>
<?php
					$this->aux2++;}
?>
				</thead>
			</table>
			</div>
			<form action='../Controllers/GRUPO_CONTROLLER.php' method="get">
				<input type="hidden" name="IdCampeonato" value="<?php echo $vuelta['IdCampeonato']; ?>">		
				<input type="hidden" name="Tipo" value="<?php echo $vuelta['Tipo']; ?>">		
				<input type="hidden" name="Nivel" value="<?php echo $vuelta['Nivel']; ?>">					
				<input type="hidden" name="Letra" value="<?php echo $vuelta['Letra']; ?>">	
				<button id ="buttonBien" type="submit"><img src="../Views/icon/back_big2.png" alt="<?php echo $strings['Atras']?>" /></button>
			</form>
		</div>
<?php
		include '../Views/Footer.php';//incluimos el pie de la página
		}
		}
?>