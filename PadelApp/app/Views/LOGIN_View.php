<?php

class Login {
	
	function __construct() {
		$this->render();
	}

	function render() {

		include '../Views/Header.php';
		?>
		<div class="seccion" align="center">
		<h1>
			<?php echo  $strings['Login']; ?>
		</h1>
		<form name='Form' action='../Controllers/Login_Controller.php' method='post' onsubmit="return comprobarLogin()">
			<div class="col-md-4">
			<table class="table">
				<thead class="thead-light">
				<tr>
					<th class="formThTd">
						<?php echo $strings['Usuario'];?>: </th>

					<td class="formThTd"><input type='text' id="login" name='login' placeholder="<?php echo $strings['Escriba aqui...'] ?>" maxlength='25' size='25' value='' required ><br>
				</tr>
				<tr>
					<th class="formThTd">
						<?php echo $strings['Contraseña'];?>: </th>
					<td class="formThTd"><input type='password' id="password" name='password' placeholder="<?php echo $strings['Escriba aqui...'] ?>" maxlength='20' size='20' value='' required ><br>
				</tr>
				<tr align="center">
					<td colspan="2">
						<button id ="buttonBien" type="submit" name="action" value="Login"><img src="../Views/icon/conectarse.png" alt="<?php echo $strings['Conectarse'] ?>" /></button>
				</tr>
					</head>
			</table>
			</div>
		</form>
	</div>

<?php
		include '../Views/Footer.php';
	} 

	} 

?>