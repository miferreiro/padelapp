<?php

/*  Archivo php
	Nombre: mensaje.php
	Autor: 	Miguel Ferreiro
	Fecha de creación: 9/10/2017 
	Función: vista de un mensaje(message) realizada con una clase donde se muestra el mensaje deseado
*/

//es la clase que muestra un mensaje y un enlace para volver atras
class MESSAGE { 

    //constructor de la clase
	function __construct( $text, $ruta ) { 
		$this->text = $text;//pasamos el texto a mostrar
		$this->ruta = $ruta;//pasamos la ruta para volver atras
		$this->render();//llamamos a la función para que muestre el mensaje y vuelta atras
	}
//función para que muestre el mensaje y vuelta atras
	function render() {

		include '../Locales/Strings_' . $_SESSION[ 'idioma' ] . '.php';//incluimos todos los strings de los idiomas:ingles,español y galego
		include '../Views/Header.php';//incluimos la cabecera
?>
		<br>
		<br>
		<br>
		<?php
			echo $strings[$this->text]; // se muestra por pantalla el texto?>

		
		<br>
		<br>
		<br>

		<form action='<?php echo $this->ruta?>' method="post">
			<button type="submit"><img src="../Views/icon/atras.png" alt="<?php echo $strings['Atras']?>"/></button>
		</form>


<?php
	include '../Views/Footer.php';//incluimos el footer
	}
}
?>