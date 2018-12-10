<?php

class NOTICIA_DELETE {

	function __construct( $valores,$lista) { 
		$this->valores = $valores;
		$this->lista = $lista;


		$this->render( $this->valores,$this->lista);
	}

	function render( $valores) { 
		$this->valores = $valores;


		include '../Locales/Strings_' . $_SESSION[ 'idioma' ] . '.php';
		include '../Views/Header.php';
?>
		<div class="seccion" align="center">
			<h2>
				<?php echo $strings['Tabla de borrado de noticia'];?>
			</h2>
			<div class="col-sm-4">
			<table class="table table-sm">
				<thead class="thead-light">
				<tr>
					<th>
						<?php echo $strings['Titulo'];?>
					</th>
					<td>
						<?php echo $this->valores['Titulo']?>
					</td>
				</tr>			
				<tr>
					<th>
						<?php echo $strings['Contenido'];?>
					</th>
					<td>
						<?php echo $this->valores['Contenido']?>
					</td>
				</tr>
					
	<?php if($this->valores['fotopersonal'] <> '')	{ ?>		
				<tr>
					<th>
						<?php echo $strings['fotopersonal'];?>
					</th>
					<td>
						<img src="<?php echo $this->valores['fotopersonal']?>">
					</td>
				</tr>
	<?php } ?>		
				</thead>
			</table>
			</div>	

<?php 
			echo $strings['¿Está seguro de que quiere borrar esta tupla de la tabla?'];
?>
			<div>
			<form action="../Controllers/NOTICIA_CONTROLLER.php" method="post" style="display: inline" >
				<input type="hidden" name="Titulo" value=<?php echo $this->valores['Titulo'] ?> />
				<button id ="buttonBien" type="submit" name="action" value="DELETE" ><img src="../Views/icon/accept_big.png" alt="<?php echo $strings['Confirmar'] ?>"/></button>
			</form>
			<form action='../Controllers/USUARIO_CONTROLLER.php' method="post" style="display: inline">
				<button id ="buttonBien" type="submit"><img src="../Views/icon/cancel_big.png" alt="<?php echo $strings['Atras'] ?>"/></button>
			</form>
			</div>
		</div>
<?php           
		include '../Views/Footer.php';               
         }   
	}
?>