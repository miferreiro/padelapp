<?php
/*  Archivo php
	Nombre: EVALUACION_SHOWCURRENT_View.php
	Autor: 	Brais Rodriguez
	Fecha de creación: 9/10/2017 
	Función: vista de la tabla de vista en detalle(showcurrent) realizada con una clase donde se muestran todos los datos de una evaluacion
*/
//Clase Evaluación_Showcurrent que contiene la vista para ver una tupla en detalle evaluación
class EVALUACION_SHOWCURRENT {
	//Constructor de la clase
	function __construct( $valores ) {
		//metodo que llama a la función render que contiene todo el código de la vista
		$this->render($valores);
		
	}
	//Función que contiene el código de la vista
	function render( $valores) {
		$this->valores = $valores;
		include '../Locales/Strings_' . $_SESSION[ 'idioma' ] . '.php';//Incluye el contenido de los strings necesarios para el multiidioma
		include '../Views/Header.php';//Incluye el contenido del header
?>
		<h2>
			<?php echo $strings['Vista detallada'];?>
		</h2>
		<table class="tablaDatos">
			<tr>
					<th>
						<?php echo $strings['IdTrabajo'];?>
					</th>
					<td>
						<?php echo $this->valores['IdTrabajo']?>
					</td>
				</tr>

				<tr>
					<th>
						<?php echo $strings['LoginEvaluador'];?>
					</th>
					<td>
						<?php echo $this->valores['LoginEvaluador']?>
					</td>
				</tr>
				
				<tr>
					<th>
						<?php echo $strings['AliasEvaluado'];?>
					</th>
					<td>
						<?php echo $this->valores['AliasEvaluado']?>
					</td>
				</tr>
                
                <tr>
					<th>
						<?php echo $strings['IdHistoria'];?>
					</th>
					<td>
						<?php echo $this->valores['IdHistoria']?>
					</td>
				</tr>
                
                <tr>
					<th>
						<?php echo $strings['CorrectoA'];?>
					</th>
					<td>
						<?php echo $this->valores['CorrectoA']?>
					</td>
				</tr>
                
                <tr>
					<th>
						<?php echo $strings['ComenIncorrectoA'];?>
					</th>
					<td>
						<p class="ajustar"><?php echo $this->valores['ComenIncorrectoA']?></p>
					</td>
				</tr>
                
                <tr>
					<th>
						<?php echo $strings['CorrectoP'];?>
					</th>
					<td>
						<?php echo $this->valores['CorrectoP']?>
					</td>
				</tr>
                
                <tr>
					<th>
						<?php echo $strings['ComentIncorrectoP'];?>
					</th>
					<td>
						<p class="ajustar"><?php echo $this->valores['ComentIncorrectoP']?></p>
					</td>
				</tr>
                
                <tr>
					<th>
						<?php echo $strings['OK'];?>
					</th>
					<td>
						<?php echo $this->valores['OK']?>
					</td>
				</tr>
			
			<caption style="margin-top:10px;" align="bottom">
				<form action='../Controllers/EVALUACION_CONTROLLER.php' method="post">
					<button type="submit"><img src="../Views/icon/atras.png" alt="<?php echo $strings['Atras'] ?>" /></button>
				</form>
			</caption>
		</table>

<?php
		include '../Views/Footer.php';
	}
}
?>