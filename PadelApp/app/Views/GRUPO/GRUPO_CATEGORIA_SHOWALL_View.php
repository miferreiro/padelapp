<?php

class GRUPO_CATEGORIA_SHOWALL {

	function __construct( $lista, $datos,$vuelta) {
		$this->lista = $lista;
		$this->datos = $datos;
		$this->vuelta = $vuelta;
		$this->render($this->lista,$this->datos,$this->vuelta);
	}
	
	function render($lista,$datos,$vuelta){
		$this->lista = $lista;
		$this->datos = $datos;
		$this->vuelta = $vuelta;
		include '../Locales/Strings_' . $_SESSION[ 'idioma' ] . '.php';
		include '../Views/Header.php';
      
?>
		<div class="seccion" align="center" >
			<h2>
				<?php echo $strings['Tabla de grupos del campeonato'];?>
			</h2>
			<div class="col-md-5" style="text-align: center">
			<table class="table ">
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
					<th colspan="3" >
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
					<td colspan="3">
						<form action="../Controllers/GRUPO_CONTROLLER.php" method="get" style="display:inline" >
							<input type="hidden" name="IdCampeonato" value="<?php echo $fila['IdCampeonato']; ?>">		
							<input type="hidden" name="Tipo" value="<?php echo $fila['Tipo']; ?>">		
							<input type="hidden" name="Nivel" value="<?php echo $fila['Nivel']; ?>">	
							<input type="hidden" name="Letra" value="<?php echo $fila['Letra']; ?>">
								<button id ="buttonBien" type="submit" name="action" value="PAREJAS" ><img src="../Views/icon/verdetalles_2.jpg" alt="<?php echo $strings['Ver en detalle']?>" width="20" height="20"/></button>			
	
						</form>
						<form action="../Controllers/GRUPO_CONTROLLER.php" method="get" style="display:inline" >
							<input type="hidden" name="IdCampeonato" value="<?php echo $fila['IdCampeonato']; ?>">		
							<input type="hidden" name="Tipo" value="<?php echo $fila['Tipo']; ?>">		
							<input type="hidden" name="Nivel" value="<?php echo $fila['Nivel']; ?>">	
							<input type="hidden" name="Letra" value="<?php echo $fila['Letra']; ?>">
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
			<form action='../Controllers/CAMPEONATO_CATEGORIA_CONTROLLER.php' method="post">
			<input type="hidden" name="IdCampeonato" value="<?php echo $vuelta['IdCampeonato']; ?>">		
				<input type="hidden" name="Tipo" value="<?php echo $vuelta['Tipo']; ?>">		
				<input type="hidden" name="Nivel" value="<?php echo $vuelta['Nivel']; ?>">
				<button id ="buttonBien" type="submit"><img src="../Views/icon/back_big2.png" alt="<?php echo $strings['Atras']?>" /></button>
			</form>
		</div>
<?php
		include '../Views/Footer.php';
		}
		}
?>