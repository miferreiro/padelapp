<?php

class USUARIO_SHOWALL {

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
				<?php echo $strings['Tabla de usuarios'];?>
			</h2>
			<div class="col-md-6">
			<table class="table" id="mydatatableUsuarios">
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
						<form action="../Controllers/USUARIO_CONTROLLER.php" method="get" style="display:inline" >
							<input type="hidden" name="Dni" value="<?php echo $fila['Dni']; ?>">
							
								<button id ="buttonBien" type="submit" name="action" value="EDIT" ><img src="../Views/icon/edit_big.png" alt="<?php echo $strings['Modificar']?>" width="20" height="20" /></button>
										
								<button id ="buttonBien" type="submit" name="action" value="DELETE" ><img src="../Views/icon/delete_big.png" alt="<?php echo $strings['Eliminar']?>" width="20" height="20" /></button>				
										
								<button id ="buttonBien" type="submit" name="action" value="SHOWCURRENT" ><img src="../Views/icon/verdetalles_2.jpg" alt="<?php echo $strings['Ver en detalle']?>" width="20" height="20"/></button>
						</form>
					<form action="../Controllers/NOTIFICACIONES_CONTROLLER.php" method="get" style="display:inline" >
								<input type="hidden" name="Dni" value="<?php echo $fila['Dni']; ?>">
								<button id ="buttonBien"  type="submit" name="action" value="ADD"><img src="../Views/icon/add_big.png" alt="AÑADIR" /></button>						
					</form>
					</td>								
				</tr>
<?php
				}
?>
				
				
			</table>
				
				<tr align="center">
						<td colspan="2">
					<form action='../Controllers/USUARIO_CONTROLLER.php'>

						<button id ="buttonBien"  type="submit" name="action" value="SEARCH"><img src="../Views/icon/search_big.png" alt="BUSCAR" /></button>	

						<button id ="buttonBien"  type="submit" name="action" value="ADD"><img src="../Views/icon/add_big.png" alt="AÑADIR" /></button>
					</form>
					</td>
				</tr>
			
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