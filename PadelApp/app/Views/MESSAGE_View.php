<?php



class MESSAGE { 

    
	function __construct( $text, $ruta ) { 
		$this->text = $text;
		$this->ruta = $ruta;
		$this->render();
	}
	function render() {

		include '../Locales/Strings_' . $_SESSION[ 'idioma' ] . '.php';
		include '../Views/Header.php';
?>
	<div class="seccion" align="center">
	<div class="col-md-2">
	<thead class="thead-light">
		<br>
		<br>
		<br>
		<?php
			echo $strings[$this->text];?>

		
		<br>
		<br>
		<br>

		<form action='<?php echo $this->ruta?>' method="post">
			<button id ="buttonBien" type="submit"><img src="../Views/icon/back_big2.png" alt="<?php echo $strings['Atras']?>"/></button>
		</form>
	</thead>
	</div>
	</div>
<?php
	include '../Views/Footer.php';
	}
}
?>