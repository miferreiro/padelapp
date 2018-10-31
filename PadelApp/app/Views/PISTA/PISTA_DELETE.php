<?php

class PISTA_DELETE {

	function __construct($valores,$lista,$lista2) { 
		$this->valores = $valores;
		$this->lista = $lista;
		$this->lista2 = $lista2;
		$this->render( $this->valores);
	}

	function render( $valores,$lista,$lista2) { 
		$this->valores = $valores;
		$this->lista = $lista;
		$this->lista2 = $lista2;
	

		include '../Locales/Strings_' . $_SESSION[ 'idioma' ] . '.php';
		include '../Views/Header.php';
?>
		<div class="seccion" align="center">
			<h2>
				<?php echo $strings['Tabla de borrado'];?>
			</h2>
			<div class="col-md-4">
			<table class="table table-sm">
				<thead class="thead-light">
				<tr>
					<th>
						<?php echo $strings['idPista'];?>
					</th>
					<td>
						<?php echo $this->valores['idPista']?>
					</td>
				</tr>			
				</thead>
			</table>
			</div>
<?php 
			echo $strings['¿Está seguro de que quiere borrar esta tupla de la tabla?'];
?>
			<div>
			<form action="../Controllers/PISTA_CONTROLLER.php" method="post" style="display: inline" >
				<input type="hidden" name="idPista" value=<?php echo $this->valores['idPista'] ?> />
				<button id ="buttonBien" type="submit" name="action" value="DELETE" ><img src="../Views/icon/confirmar.png" alt="<?php echo $strings['Confirmar'] ?>"/></button>
			</form>
			<form action='../Controllers/PISTA_CONTROLLER.php' method="post" style="display: inline">
				<button id ="buttonBien" type="submit"><img src="../Views/icon/cancelar.png" alt="<?php echo $strings['Atras'] ?>"/></button>
			</form>
			</div>
		</div>

<?php
					foreach ( $lista as $atributo ) { 
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
				while ( $fila = mysqli_fetch_array( $this->lista2 ) ) { 
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
						<form action="../Controllers/RESERVA_CONTROLLER.php" method="get" style="display:inline" >
							<input type="hidden" name="Usuario_Dni" value="<?php echo $fila['Usuario_Dni']; ?>">
							<input type="hidden" name="Pista_idPista" value="<?php echo $fila['Pista_idPista']; ?>">
							<input type="hidden" name="Pista_Fecha" value="<?php echo $fila['Pista_Fecha']; ?>">
							<input type="hidden" name="Pista_Hora" value="<?php echo $fila['Pista_Hora']; ?>">
				
								<button id ="buttonBien" type="submit" name="action" value="DELETE" ><img src="../Views/icon/eliminar.png" alt="<?php echo $strings['Eliminar']?>" width="20" height="20" /></button>				
					<td>						
								<button id ="buttonBien" type="submit" name="action" value="SHOWCURRENT" ><img src="../Views/icon/verDetalles.png" alt="<?php echo $strings['Ver en detalle']?>" width="20" height="20"/></button>
						</form>
				    <td>								
				</tr>
<?php
				}
?>
<?php           
		include '../Views/Footer.php';               
         }   
	}
?>