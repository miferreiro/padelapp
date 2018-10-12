<?php
/*  Archivo php
	Nombre: LOGIN_View.php
	Autor: 	Miguel Ferreiro
	Fecha de creación: 23/10/2017 
	Función: vista de logearse(login) realizada con una clase donde se muestran los campos necesarios para logearse en nuestra aplicación
*/
//Es la clase Login que nos permite mostrar la vista para logearse
class Login {
	//es el constructor de la clase Login
	function __construct() {
		$this->render();//Llamada a la función dónde se encuentra el formulario de logeo
	}
	//función render donde se mostrará el formulario login con los campos correspondientes
	function render() {

		include '../Views/Header.php';//incluimos la cabecera
		?>

		<h1>
			<?php echo  $strings['Login']; ?>
		</h1>
		<form name='Form' action='../Controllers/Login_Controller.php' method='post' onsubmit="return comprobarLogin()">
			<table>
				<tr>
					<th class="formThTd">
						<?php echo $strings['Usuario'];?>: </th>

					<td class="formThTd"><input type='text' id="login" name='login' placeholder="<?php echo $strings['Escriba aqui...'] ?>" maxlength='15' size='15' value='' required onBlur="comprobarVacio(this) && comprobarLongitud(this,'15') && comprobarTexto(this,'15')"><br>
				</tr>
				<tr>
					<th class="formThTd">
						<?php echo $strings['Contraseña'];?>: </th>
					<td class="formThTd"><input type='password' id="password" name='password' placeholder="<?php echo $strings['Escriba aqui...'] ?>" maxlength='20' size='20' value='' required onBlur="comprobarVacio(this) && comprobarLongitud(this,'20') && comprobarTexto(this,'20')"><br>
				</tr>
				<tr>
					<td colspan="2">
						<button type="submit" name="action" value="Login"><img src="../Views/icon/conectarse.png" alt="<?php echo $strings['Conectarse'] ?>" /></button>
				</tr>
			</table>
		</form>

<?php
		include '../Views/Footer.php';//incluimos el footer
	} //fin metodo render

	} //fin Login

?>