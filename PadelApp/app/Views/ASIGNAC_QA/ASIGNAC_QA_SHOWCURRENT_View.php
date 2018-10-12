<?php
/*  Archivo php
	Nombre: ASIGNAC_QA_SHOWCURRENT_View.php
	Autor: 	Jonatan Couto Riádigos
	Fecha de creación: 29/11/2017 
	Función: vista de la tabla de borrado(delete) realizada con una clase donde se muestran todos los datos de un qa y da la opción de borrarlos
*/


	  //Clase ASIGNAC_QA_SHOWCURRENT que contiene la vista para una tupla de la tabla ASIGNAC_QA
      class ASIGNAC_QA_SHOWCURRENT{
        
        //Constructor de la clase
        function __construct($valores){
            //$valores  variable que almacena la informacion de una tupla de la tabla ASIGNAC_QA
            $this->mostrar($valores);//metodo que llama a la función mostrar que contiene todo el código de la vista
            
            
        }
        //Función que contiene el código de la vista
        public function mostrar($valores){
  			//variable que almacena la informacion de una tupla de la tabla ASIGNAC_QA
            $this->valores = $valores;
		    include '../Locales/Strings_' . $_SESSION[ 'idioma' ] . '.php';//Incluye el contenido de los strings necesarios para el multiidioma
		    include '../Views/Header.php';//Incluye el contenido del header
                
        ?>
    <div class="seccion">
			<h2>
				<?php echo $strings['Vista detallada'];?>
			</h2>
			<table>
				<tr>
					<th>
						<?php echo $strings['IdTrabajo'];?><!--se muestra el campo login -->
					</th>
					<td>
						<?php echo $this->valores['IdTrabajo']?><!--se muestran  el valor del campo login -->
					</td>
				</tr>

				<tr>
					<th>
						<?php echo $strings['LoginEvaluador'];?><!--se muestra el campo IdTrabajo -->
					</th>
					<td>
						<?php echo $this->valores['LoginEvaluador']?><!--se muestra elvalor del campo idTrabajo -->
					</td>
				</tr>
				
				<tr>
					<th>
						<?php echo $strings['LoginEvaluado'];?><!--se muestra el campo Alias -->
					</th>
					<td>
						<?php echo $this->valores['LoginEvaluado']?><!--se muestra el valor del campo Alias -->
					</td>
                    
				</tr>
                
                <tr>
					<th>
						<?php echo $strings['AliasEvaluado'];?><!--se muestra el campo Horas -->
					</th>
					<td>
						<?php echo $this->valores['AliasEvaluado']?><!--se muestra el valor del campo Horas -->
					</td>
				</tr>
                	
			</table>
			<form action='../Controllers/ASIGNAC_QA_CONTROLLER.php' method="post" style="display: inline">
				<button type="submit"><img src="../Views/icon/atras.png" alt="<?php echo $strings['Atras'] ?>"/></button><!--con este boton se vuelve atras -->
			</form>
		</div>
<?php
		include '../Views/Footer.php';//Incluye el contenido del pie
	}
}

?>