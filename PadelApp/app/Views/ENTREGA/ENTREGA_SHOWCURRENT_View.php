<?php
//Función: Esta clase sirve para mostrar una tupla del SHOWALL de ENTREGA, en detalle con todos los atributos
//Fecha de creación:28/11/2017
//Autor:Brais Santos


//es la clase SHOWCURRENT de ENTREGA que nos permite ver en detalle una entrega
      class ENTREGA_SHOWCURRENT{ 
        
         //es el constructor de ENTREGA_SHOWCURRENT
        function __construct($valores){ 
            
            $this->mostrar($valores); //llamamos a la función mostrar donde se mostrará el formulario SHOWCURRENT con los campos correspondientes
            
            
        }
        //funcion que mostrará el formulario SHOWCURRENT con los campos correspondientes
        function mostrar($valores){
            $this->valores = $valores;//pasamos los valores de cada campo
		    include '../Locales/Strings_' . $_SESSION[ 'idioma' ] . '.php';//incluimos los strings de idiomas, para que la página pueda estar en español,inglés y galego
		    include '../Views/Header.php';//incluimos la cabecera
                
        ?>
    <div class="seccion">
			<h2>
				<?php echo $strings['Vista detallada'];?>
			</h2>
			<table>
				<tr>
					<th>
						<?php echo $strings['login'];?><!--se muestra el campo login -->
					</th>
					<td>
						<?php echo $this->valores['login']?><!--se muestran  el valor del campo login -->
					</td>
				</tr>

				<tr>
					<th>
						<?php echo $strings['IdTrabajo'];?><!--se muestra el campo IdTrabajo -->
					</th>
					<td>
						<?php echo $this->valores['IdTrabajo']?><!--se muestra elvalor del campo idTrabajo -->
					</td>
				</tr>
				
				<tr>
					<th>
						<?php echo $strings['Alias'];?><!--se muestra el campo Alias -->
					</th>
					<td>
						<?php echo $this->valores['Alias']?><!--se muestra el valor del campo Alias -->
					</td>
                    
				</tr>
                
                <tr>
					<th>
						<?php echo $strings['Horas'];?><!--se muestra el campo Horas -->
					</th>
					<td>
						<?php echo $this->valores['Horas']?><!--se muestra el valor del campo Horas -->
					</td>
				</tr>
                
                <tr>
					<th>
						<?php echo $strings['Ruta'];?><!--se muestra el campo Ruta -->
					</th>
					<td>
						<a href="<?php echo $this->valores['Ruta']?>"><?php echo $this->valores['Ruta']?></a><!--se muestra el valor del campo Ruta -->
					</td>
				</tr>
                
                
				
			</table>
			<form action='../Controllers/ENTREGA_CONTROLLER.php' method="post" style="display: inline">
				<button type="submit"><img src="../Views/icon/atras.png" alt="<?php echo $strings['Atras'] ?>"/></button><!--con este boton se vuelve atras -->
			</form>
		</div>
<?php
		include '../Views/Footer.php';//incluimos el pie de la página 
	}
}

?>