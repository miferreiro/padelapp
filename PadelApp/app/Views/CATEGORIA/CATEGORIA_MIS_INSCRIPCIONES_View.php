<?php

class CATEGORIA_MIS_INSCRIPCIONES {

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
				<?php echo $strings['Tabla de grupos del campeonato'];?>
			</h2>
			<div class="col-md-4">
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
					<td>
					
					
						<form action="../Controllers/CATEGORIA_CONTROLLER.php" method="get" style="display:inline" >
							<input type="hidden" name="IdCampeonato" value="<?php echo $fila['IdCampeonato']; ?>">		
							<input type="hidden" name="Tipo" value="<?php echo $fila['Tipo']; ?>">		
							<input type="hidden" name="Nivel" value="<?php echo $fila['Nivel']; ?>">	
							<input type="hidden" name="NumPareja" value="<?php echo $fila['NumPareja']; ?>">
<?php 
					if((($fila['FechaIni'] < date("Y-m-d")) && ($fila['FechaFin'] >= date("Y-m-d")) ))
					{
						
						if(($fila['FechaFin'] == date("Y-m-d")) && ($fila['HoraFin'] > date("H:i:s"))){
?>
								<button id ="buttonBien" type="submit" name="action" value="DESINSCRIBIRSE" ><img src="../Views/icon/delete_big.png" width="20" height="20"/></button>	
<?php	
							  }else{
								if(($fila['FechaFin'] > date("Y-m-d"))){									
?>
									<button id ="buttonBien" type="submit" name="action" value="DESINSCRIBIRSE" ><img src="../Views/icon/delete_big.png"  width="20" height="20"/></button>	
<?php																			
								}	
							}
					}else{
						if((($fila['FechaIni'] == date("Y-m-d")) && ($fila['HoraIni'] < date("H:i:s"))) && ($fila['FechaFin'] >= date("Y-m-d"))){
							if(($fila['FechaFin'] == date("Y-m-d")) &&  ($fila['HoraFin'] > date("H:i:s"))){
?>
								<button id ="buttonBien" type="submit" name="action" value="DESINSCRIBIRSE" ><img src="../Views/icon/delete_big.png"  width="20" height="20"/></button>	
<?php	
							  }else{
								if(($fila['FechaFin'] > date("Y-m-d"))){									
?>
									<button id ="buttonBien" type="submit" name="action" value="DESINSCRIBIRSE" ><img src="../Views/icon/delete_big.png"  width="20" height="20"/></button>	
<?php																			
								}	
							}
						}				
					}
?>
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
		include '../Views/Footer.php';//incluimos el pie de la página
		}
		}
?>