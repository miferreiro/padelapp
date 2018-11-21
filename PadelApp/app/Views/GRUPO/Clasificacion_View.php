<?php

class CLASIFICACION_SHOWALL {

	function __construct( $lista, $datos) {
		$this->lista = $lista;
		$this->datos = $datos;
		$this->render($this->lista,$this->datos);
	}
	
	function render($lista,$datos){
		$this->lista = $lista;
		$this->datos = $datos;

		include '../Locales/Strings_' . $_SESSION[ 'idioma' ] . '.php';
  
	include '../Views/Header.php';		
?>

		<div class="seccion" align="center">
			<h2>
				<?php echo $strings['Tabla de clasificación'];?>
			</h2>
			<div class="col-md-3">
			<table class="table">
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
?>
					<td>
<?php 	
							$IdCampeonato = $fila['IdCampeonato'];
							$Tipo = $fila['Tipo'];
							$Nivel = $fila['Nivel'];
							$Letra = $fila['Letra'];
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
<?php			
			if($_SESSION['tipo'] == 'Admin'){
				?>
				<form action='../Controllers/GRUPO_CONTROLLER.php' method="post">
				<input type="hidden" name="IdCampeonato" value="<?php echo $IdCampeonato; ?>">		
				<input type="hidden" name="Tipo" value="<?php echo $Tipo; ?>">		
				<input type="hidden" name="Nivel" value="<?php echo $Nivel; ?>">					
				<input type="hidden" name="Letra" value="<?php echo $Letra; ?>">
				<button id ="buttonBien" type="submit"><img src="../Views/icon/back_big2.png" alt="<?php echo $strings['Atras']?>" /></button>
			</form>
			<?php }			
			if($_SESSION['tipo'] == 'Deportista'){
				?>
			<form action='../Controllers/CALENDARIO_CONTROLLER.php' method="post">
					<button id ="buttonBien" type="submit"><img src="../Views/icon/back_big2.png" alt="<?php echo $strings['Atras'] ?>" /></button>
				</form>
			<?php 		
					}	
				?>
		</div>
<?php
		include '../Views/Footer.php';
		}
	}
?>