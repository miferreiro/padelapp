<?php
/*  Archivo php
	Nombre: USUARIOS_SHOWALL_View.php
	Autor: 	Alejandro Vila
	Fecha de creación: 29/11/2017 
	Función:se muestra una vista por defecto que no tiene nada
*/

//es la clase donde se muestra una vista por defecto
class USUARIO_DEFAULT {
//es el constructor de la clase
	function __construct( ) { 

		$this->render();//llamamos a esta función para mostrar la vista
	}
	//función para mostrar la vista
	function render(){
	if (!isset($_SESSION['idioma'])) { //miramos si existe algún idioma
		$_SESSION['idioma'] = 'SPANISH';//si no existe ponemos por defecto el español

	}
		
		include '../Locales/Strings_' . $_SESSION[ 'idioma' ] . '.php';//incluimos los strings de idiomas, para que la página pueda estar en español,inglés y galego
		include '../Views/Header.php';//incluimos la cabecera
		
?>
		<div class="seccion">	
			<h2>
				<?php echo "PAGINA DEFAULT"; ?>
				
			</h2>
		</div>
<?php
		include '../Views/Footer.php';//incluimos el pie de la página
		}
		}
?>