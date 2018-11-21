<?php

class CALENDARIO_SHOWALL {

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
				<?php echo $strings['Calendario '] . ' 1 ' ;?>
			</h2>
			<div class="col-md-5">
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
					<th colspan="2" >
						<?php echo $strings['Opciones']?>
					</th>

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
							echo $fila[ $atributo ];
?>
					</td>
<?php
					}
?>
					<td>
						<form action="../Controllers/CALENDARIO_CONTROLLER.php" method="get" style="display:inline" >
							<input type="hidden" name="IdCampeonato" value="<?php echo $fila['IdCampeonato']; ?>">		
							<input type="hidden" name="Tipo" value="<?php echo $fila['Tipo']; ?>">		
							<input type="hidden" name="Nivel" value="<?php echo $fila['Nivel']; ?>">						
							<input type="hidden" name="Letra" value="<?php echo $fila['Letra']; ?>">
								<button id ="buttonBien" type="submit" name="action" value="SHOWCURRENT" ><img src="../Views/icon/verdetalles_2.jpg" alt="<?php echo $strings['Ver en detalle']?>" width="20" height="20"/></button>			
								<button id ="buttonBien" type="submit" name="action" value="TABLA" ><img src="../Views/icon/tabla.png" alt="<?php echo $strings['Ver en detalle']?>" width="20" height="20"/></button>			
						</form>
						<form action="../Controllers/GRUPO_CONTROLLER.php" method="get" style="display:inline" >
							<input type="hidden" name="IdCampeonato" value="<?php echo $fila['IdCampeonato']; ?>">		
							<input type="hidden" name="Tipo" value="<?php echo $fila['Tipo']; ?>">		
							<input type="hidden" name="Nivel" value="<?php echo $fila['Nivel']; ?>">	
							<input type="hidden" name="Letra" value="<?php echo $fila['Letra']; ?>">
								<button id ="buttonBien" type="submit" name="action" value="CLASIFICACION" ><img src="../Views/icon/exito.png" alt="<?php echo $strings['Ver clasificación']?>" width="20" height="20"/></button>			
	
						</form>
				</tr>
<?php
				}
?>
			</thead>
			</table>
			</div>
			<form action='../Controllers/USUARIO_CONTROLLER.php' method="post">
				<button id ="buttonBien" type="submit"><img src="../Views/icon/back_big2.png" alt="<?php echo $strings['Atras']?>" /></button>
			</form>
		</div>
<?php
		include '../Views/Footer.php';
		}
		}
?>