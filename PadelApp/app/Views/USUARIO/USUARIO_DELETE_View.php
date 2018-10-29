<?php

class USUARIO_DELETE {

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
						<?php echo $strings['Dni'];?>
					</th>
					<td>
						<?php echo $this->valores['Dni']?>
					</td>
				</tr>			
				<tr>
					<th>
						<?php echo $strings['Usuario'];?>
					</th>
					<td>
						<?php echo $this->valores['Login']?>
					</td>
				</tr>
				<tr>
					<th>
						<?php echo $strings['Contraseña'];?>
					</th>
					<td>
						<?php echo $this->valores['Password']?>
					</td>
				</tr>
				<tr>
					<th>
						<?php echo $strings['Nombre'];?>
					</th>
					<td>
						<?php echo $this->valores['Nombre']?>
					</td>
				</tr>
				<tr>
					<th>
						<?php echo $strings['Apellidos'];?>
					</th>
					<td>
						<?php echo $this->valores['Apellidos']?>
					</td>
				</tr>
				<tr>
					<th>
						<?php echo $strings['Sexo'];?>
					</th>
					<td>
						<?php echo $this->valores['Sexo']?>
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
						<?php echo $strings['Teléfono'];?>
					</th>
					<td>
						<?php echo $this->valores['Telefono']?>
					</td>
				</tr>
				</thead>
			</table>
			</div>	
<?php 
			echo $strings['¿Está seguro de que quiere borrar esta tupla de la tabla?'];
?>
			<div>
			<form action="../Controllers/USUARIO_CONTROLLER.php" method="post" style="display: inline" >
				<input type="hidden" name="login" value=<?php echo $this->valores['Login'] ?> />
				<input type="hidden" name="password" value=<?php echo $this->valores['Password'] ?> />
				<input type="hidden" name="Dni" value=<?php echo $this->valores['Dni'] ?> />
				<input type="hidden" name="nombre" value=<?php echo $this->valores['Nombre'] ?> />
				<input type="hidden" name="apellidos" value=<?php echo $this->valores['Apellidos'] ?> />
				<input type="hidden" name="telefono" value=<?php echo $this->valores['Telefono'] ?> />
				<input type="hidden" name="sexo" value=<?php echo $this->valores['Sexo'] ?> />
				<input type="hidden" name="Tipo" value=<?php echo $this->valores['Tipo'] ?> />
				<button id ="buttonBien" type="submit" name="action" value="DELETE" ><img src="../Views/icon/confirmar.png" alt="<?php echo $strings['Confirmar'] ?>"/></button>
			</form>
			<form action='../Controllers/USUARIO_CONTROLLER.php' method="post" style="display: inline">
				<button id ="buttonBien" type="submit"><img src="../Views/icon/cancelar.png" alt="<?php echo $strings['Atras'] ?>"/></button>
			</form>
			</div>
		</div>
<?php           
		include '../Views/Footer.php';               
         }   
	}
?>