<?php
/*  Archivo php
	Nombre: USUARIOS_GRUPO_SHOWALL_View.php
	Autor: 	Alejandro Vila
	Fecha de creación: 20/11/2017
	Función: vista de tabla de datos(showall) realizada con una clase donde se muestran datos caracteristicos y permite seleccionar el usuario y el grupo al que pertenecen
*/

//es la clase SHOWALL de USU_GRUPO que nos permite mostrar todos los usuarios asociasdos a grupos
class USU_GRUPO_SHOWALL {
 //es el constructor de la clase USU_GRUPO_SHOWALL
	function __construct( $lista, $datos,$login) {
		$this->lista = $lista;//pasamos los campos que queremos mostrar
		$this->datos = $datos;//pasamos cada una de las tuplas de USU_GRUPO que queremos mostrar
		$this->login = $login;//pasamos el login
		$this->render($this->lista,$this->datos,$this->login);//llamamos a la función render donde se mostrará el formulario SHOWALL con los campos correspondientes
		
	}
	//Función que  mostrará el formulario SHOWALL con los campos correspondientes
	function render($lista,$datos,$login){ 
		$this->lista = $lista;//pasamos los campos que queremos mostrar
		$this->datos = $datos;//pasamos cada una de las tuplas de USU_GRUPO que queremos mostrar
		$this->login = $login;//pasamos el login
		include '../Locales/Strings_' . $_SESSION[ 'idioma' ] . '.php';//incluimos los strings de idiomas, para que la página pueda estar en español,inglés y galego
		include '../Views/Header.php';//incluimos la cabecera
?>
		<div class="seccion">
			<h2>
				<?php echo $strings['Tabla de datos'];?>
			</h2>
			<table>
				<tr>
<?php
					foreach ( $lista as $atributo ) { //este bucle se va a repetir mientras no se muestren todos los campos
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
				while ( $fila = mysqli_fetch_array( $this->datos ) ) { //este bucle se va a repetir mientras devuelva cada tupla de la tabla USU_GRUPO
?>
				<tr>
<?php
					foreach ( $lista as $atributo ) { //este bucle se repite mientras devuelva cada uno de los campos de la tabla USU_GRUPO
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
						<form action="../Controllers/USU_GRUPO_CONTROLLER.php" method="get" style="display:inline" >
							<input type="hidden" name="login" value="<?php echo $fila['login']; ?>">
							<input type="hidden" name="IdGrupo" value="<?php echo $fila['IdGrupo']; ?>">

								<button type="submit" name="action" value="DELETE" ><img src="../Views/icon/eliminar.png" alt="<?php echo $strings['Eliminar']?>" width="20" height="20" /></button>
	
						</form>

				</tr>
<?php
				}
?>
				<caption style="margin-bottom:10px;"><form action='../Controllers/USU_GRUPO_CONTROLLER.php' method="get">
				<input type="hidden" name="login" value="<?php echo $this->login;?>">
				<button type="submit" name="action" value="ADD"><img src="../Views/icon/añadir.png" alt="<?php echo $strings['Confirmar formulario']?>" /></button>				
				
			</form></table>
			
			<form action='../Controllers/USUARIO_CONTROLLER.php' method="post">
				<button type="submit"><img src="../Views/icon/atras.png" alt="<?php echo $strings['Atras']?>" /></button>
			</form>
		</div>
<?php
		include '../Views/Footer.php';//incluimos el pie de la página
		}
		}
?>