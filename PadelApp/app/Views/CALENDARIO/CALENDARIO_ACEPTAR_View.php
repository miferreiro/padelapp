<?php

class CALENDARIO_ACEPTAR {

	function __construct( $valores) { 
		$this->valores = $valores;



		$this->render( $this->valores);
	}

	function render( $valores) { 
		$this->valores = $valores;
	

		include '../Locales/Strings_' . $_SESSION[ 'idioma' ] . '.php';
		include '../Views/Header.php';
?>
		<div class="seccion" align="center">
			<h2>
				<?php echo $strings['Tabla de borrado'];?>
			</h2>
			<div class="col-sm-4">
			<table class="table table-sm">
				<thead class="thead-light">
			<tr>
				<th>
					<?php echo $strings['IdCampeonato'];?>
				</th>
				<td>
					<?php echo $this->valores['IdCampeonato']?>
				</td>
			</tr>
			<tr>
				<th>
					<?php echo $strings['Tipo'];?>
				</th>
				<td>
					<?php echo $this->valores['Tipo']?>
				</td>
			</tr>
			<tr>
				<th>
					<?php echo $strings['Nivel'];?>
				</th>
				<td>
					<?php echo $this->valores['Nivel']?>
				</td>
			</tr>
			<tr>
				<th>
					<?php echo $strings['Letra'];?>
				</th>
				<td>
					<?php echo $this->valores['Grupo_Letra']?>
				</td>
			</tr>
			<tr>
				<th>
					<?php echo $strings['NumEnfrentamiento'];?>
				</th>
				<td>
					<?php echo $this->valores['NumEnfrentamiento']?>
				</td>
			</tr>
			<tr>
				<th>
					<?php echo $strings['Fecha'];?>
				</th>
				<td>
					<?php echo $this->valores['Fecha']?>
				</td>
			</tr>
			<tr>
				<th>
					<?php echo $strings['Hora'];?>
				</th>
				<td>
					<?php echo $this->valores['Hora']?>
				</td>
			</tr>
			<tr>
				<th>
					<?php echo $strings['Pareja'] . "1";?>
				</th>
				<td>
					<?php echo $this->valores['pareja1']?>
				</td>
			</tr>
			<tr>
				<th>
					<?php echo $strings['Pareja'] . "2";?>
				</th>
				<td>
					<?php echo $this->valores['pareja2']?>
				</td>
			</tr>
				</thead>
			</table>
			</div>	

<?php 
			echo $strings['¿Quieres aceptar el horario de este partido propuesto por la otra pareja?'];
?>
			<div>
			<form action="../Controllers/CALENDARIO_CONTROLLER.php" method="post" style="display: inline" >
					<input type="hidden" name="IdCampeonato" value="<?php echo $this->valores['IdCampeonato']; ?>">		
					<input type="hidden" name="Tipo" value="<?php echo $this->valores['Tipo']; ?>">		
					<input type="hidden" name="Nivel" value="<?php echo $this->valores['Nivel']; ?>">
					<input type="hidden" name="Letra" value="<?php echo $this->valores['Grupo_Letra']; ?>">				
					<input type="hidden" name="NumEnfrentamiento" value="<?php echo $this->valores['NumEnfrentamiento']; ?>">	
					<input type="hidden" name="Fecha" value="<?php echo $this->valores['Fecha']; ?>">
					<input type="hidden" name="Hora" value="<?php echo $this->valores['Hora']; ?>">
					<input type="hidden" name="pareja1" value="<?php echo $this->valores['pareja1']; ?>">
					<input type="hidden" name="pareja2" value="<?php echo $this->valores['pareja2']; ?>">
										
					
				<button id ="buttonBien" type="submit" name="action" value="ACEPTAR" ><img src="../Views/icon/accept_big.png" alt="<?php echo $strings['Confirmar'] ?>"/></button>
				<button id ="buttonBien" type="submit" name="action" value="DENEGAR" ><img src="../Views/icon/cancel_big.png" alt="<?php echo $strings['Cancelar'] ?>"/></button>
			</form>

			</div>
						<form action='../Controllers/CALENDARIO_CONTROLLER.php' method="post" style="display: inline">
				<input type="hidden" name="IdCampeonato" value="<?php echo $this->valores['IdCampeonato']; ?>">		
					<input type="hidden" name="Tipo" value="<?php echo $this->valores['Tipo']; ?>">		
					<input type="hidden" name="Nivel" value="<?php echo $this->valores['Nivel']; ?>">
					<input type="hidden" name="Letra" value="<?php echo $this->valores['Grupo_Letra']; ?>">
				<button id ="buttonBien" name="action" type="submit" value="TABLA"><img src="../Views/icon/back_big2.png" alt="<?php echo $strings['Atras'] ?>"/></button>
			</form>
		</div>
<?php           
		include '../Views/Footer.php';               
         }   
	}
?>