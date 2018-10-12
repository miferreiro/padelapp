<?php
/*  Archivo php
	Nombre: INFO_GRUPO_ET.php
	Autor: 	Jonatan Couto
	Fecha de creación: 2/12/2017 
	Función: vista de la tabla de vista en detalle(showcurrent) realizada con una clase donde se muestran todos los datos de un usuario
*/
    session_start();//inicamos la sesion
    include '../Functions/Authentication.php'; //incluye el contenido de la función de autentificación
	
	if (!IsAuthenticated()){//Si no esta autenticado se redirecciona al index
		
 		header('Location:../index.php');//Redireción al index
	}
    	include '../Views/Header.php';//incluimos la cabecera de lapágina
		include '../Locales/Strings_' . $_SESSION[ 'idioma' ] . '.php';//incluimos todos los strings de los idiomas:ingles,español y galego
		
?>
		<h2>
			<?php echo $strings['INFORMACIÓN GRUPO'];?>
		</h2>
		<table class="tablaDatos">
			<tr>
				<th>
					<?php echo $strings['Nombre'];?>
				</th>
			</tr>
			<tr>
				<td colspan="2">LICORCA</td>
			</tr>
			<tr>
				<td bgcolor="#b59438" colspan="2"><?php echo $strings['Integrantes'];?></td>
			</tr>
			
			<tr>
				<td colspan="2"><?php echo "MIGUEL FERREIRO DIAZ(".$strings['Lider'].")" ?></td>
			</tr>
			<tr>
				<td colspan="2">ALEJANDRO VILA CID</td>
			</tr>
			<tr>
				<td colspan="2">JONATAN COUTO RIÁDIGOS</td>
			</tr>
			<tr>
				<td colspan="2">BRAIS SANTOS NEGREIRA</td>
			</tr>
			<tr>
				<td colspan="2">BRAIS RODRÍGUEZ MARTINEZ</td>
			</tr>
			<caption style="margin-top:10px;" align="bottom">
			</caption>
		</table>

<?php
		include '../Views/Footer.php';//incluimos el footer
?>