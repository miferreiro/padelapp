<?php

class NOTIFICACIONES_SHOWALL {

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
				<?php echo $strings['Tabla de NOTIFICACIONESs'];?>
			</h2>
			<div class="col-md-6">
			<table class="table" id="mydatatableusuarios">
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
					<th>
						<?php echo $strings['Opciones']?>
					</th>

				</tr>
				</thead>
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
						<form action="../Controllers/NOTIFICACIONES_CONTROLLER.php" method="get" style="display:inline" >
							<input type="hidden" name="IdNotificacion" value="<?php echo $fila['IdNotificacion']; ?>">
							
								<button id ="buttonBien" type="submit" name="action" value="EDIT" ><img src="../Views/icon/edit_big.png" alt="<?php echo $strings['Modificar']?>" width="20" height="20" /></button>
										
								<button id ="buttonBien" type="submit" name="action" value="DELETE" ><img src="../Views/icon/delete_big.png" alt="<?php echo $strings['Eliminar']?>" width="20" height="20" /></button>				
										
								<button id ="buttonBien" type="submit" name="action" value="SHOWCURRENT" ><img src="../Views/icon/verdetalles_2.jpg" alt="<?php echo $strings['Ver en detalle']?>" width="20" height="20"/></button>
						</form>						
					</td>								
				</tr>
<?php
				}
?>
				
				
			</table>
			</div>
			<form action='../Controllers/DEFAULT_CONTROLLER.php' method="post">
				<button id ="buttonBien" type="submit"><img src="../Views/icon/back_big2.png" alt="<?php echo $strings['Atras']?>" /></button>
			</form>
		</div>
<?php
		include '../Views/Footer.php';
		}
	}
?>