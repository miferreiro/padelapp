<?php
/*  Archivo php
	Nombre: EVALUACION_DELETE_View.php
	Autor: 	Brais Rodríguez
	Fecha de creación: 28/11/2017 
	Función: vista de la tabla de borrado(delete) realizada con una clase donde se muestran todos los datos de una evaluacion y da la opción de borrarlos
*/


//es la clase DELETE de EVALUACION que nos permite borrar una evaluacion
class EVALUACION_DELETE {
//es el constructor de la clase EVALUACION_DELETE
	function __construct( $valores ) { 
		$this->valores = $valores;//Variable que almacena el recordset de la base de datos
		$this->render( $this->valores );//llamamos a la función render donde se mostrará el formulario DELETE con los campos correspondientes
	}
//funcion que  mostrará el formulario DELETE con los campos correspondientes
	function render( $valores ) { 
		$this->valores = $valores;//Variable que almacena el recordset de la base de datos
		include '../Locales/Strings_' . $_SESSION[ 'idioma' ] . '.php';//incluimos los strings de idiomas, para que la página pueda estar en español,inglés y galego
		include '../Views/Header.php';//incluimos la cabecera
?>
		<div class="seccion">
			<h2>
				<?php echo $strings['Tabla de borrado'];?>
			</h2>
			<table>
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
						<p class="ajustar"><?php echo $this->valores['ComentIncorrectoP'];?></p>
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
                
				
			</table>
			<p style="text-align:center;">
				<?php echo $strings['¿Está seguro de que quiere borrar esta tupla de la tabla?'];?>
			</p>
			<form action="../Controllers/EVALUACION_CONTROLLER.php" method="post" style="display: inline">
				<input type="hidden" name="IdTrabajo" value="<?php echo $this->valores['IdTrabajo'] ?>" />
				<input type="hidden" name="LoginEvaluador" value="<?php echo $this->valores['LoginEvaluador'] ?>" />
				<input type="hidden" name="AliasEvaluado" value="<?php echo $this->valores['AliasEvaluado'] ?>" />
                <input type="hidden" name="IdHistoria" value="<?php echo $this->valores['IdHistoria'] ?>" />
				<input type="hidden" name="CorrectoA" value="<?php echo $this->valores['CorrectoA'] ?>" />
				<input type="hidden" name="ComenIncorrectoA" value="<?php echo $this->valores['ComenIncorrectoA'] ?>" />
                <input type="hidden" name="CorrectoP" value="<?php echo $this->valores['CorrectoP'] ?>" />
				<input type="hidden" name="ComentIncorrectoP" value="<?php echo $this->valores['ComentIncorrectoP'] ?>" />
				<input type="hidden" name="OK" value="<?php echo $this->valores['OK'] ?>" />
				
                
                <button type="submit" name="action" value="DELETE"><img src="../Views/icon/confirmar.png" alt="<?php echo $strings['Confirmar'] ?>"/></button>
                
			</form>
			<form action='../Controllers/EVALUACION_CONTROLLER.php' method="post" style="display: inline">
				<button type="submit"><img src="../Views/icon/cancelar.png" alt="<?php echo $strings['Atras'] ?>"/></button>
			</form>
		</div>
<?php
		include '../Views/Footer.php';//incluimos el pie de la página
	}
}

?>