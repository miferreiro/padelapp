<?php
/* 
	Fecha de creación: 4/12/2017 
	Función: vista de tabla de datos(showall) realizada con una clase donde se muestran datos caracteristicos y permite seleccionar la nota deseada
    Autor:Brais Santos
*/


//es la clase SHOWALL de NOTA_TRABAJO que nos permite mostrar todas las notas
class NOTA_TRABAJO_SHOWALL {
        //es el constructor de la clase  NOTA_TRABAJO_SHOWALL
	function __construct( $lista, $datos,$bol) { 
		$this->lista = $lista;//pasamos cada uno de los campos de la tabla
		$this->datos = $datos;//pasamos los valores de cada uno de los campos
        $this->bol=$bol;//pasamos una variable booleana para saber si es un alumno para mostrar la nota o un profesor
		$this->render($this->lista,$this->datos,$this->bol);//funcion que mostrará el formulario SHOWALL con los campos correspondientes
	}
	//funcion que mostrará el formulario SHOWALL con los campos correspondientes
	function render($lista,$datos,$bol){ 
		$this->lista = $lista;//pasamos cada uno de los campos de la tabla
		$this->datos = $datos;//pasamos los valores de cada uno de los campos
        $this->bol=$bol;//pasamos una variable booleana para saber si es un alumno para mostrar la nota o un profesor
		include '../Locales/Strings_' . $_SESSION[ 'idioma' ] . '.php';//incluimos los strings de idiomas, para que la página pueda estar en español,inglés y galego
		include '../Views/Header.php';//incluimos la cabecera
		include_once '../Functions/permisosAcc.php';//incluimos este fichero para saber los permisos del usuario
?>
		<div class="seccion">
			<h2>
				<?php echo $strings['Tabla de datos'];?>
			</h2>
			<table>
				<caption style="margin-bottom:10px;">
					<form action='../Controllers/NOTA_TRABAJO_CONTROLLER.php'>
<?php if(permisosAcc($_SESSION['login'],7,3)==true){ //mira si el usuario tiene permiso para buscar ?>
						<button type="submit" name="action" value="SEARCH"><img src="../Views/icon/buscar.png" alt="BUSCAR" /></button>
<?php }
	  if(permisosAcc($_SESSION['login'],7,0)==true){ //mira si el usuario tiene permiso para añadir
		?>
						<button type="submit" name="action" value="ADD"><img src="../Views/icon/añadir.png" alt="AÑADIR" /></button>
<?php } ?>
					</form>
				</caption>
				<tr>
<?php
					foreach ( $lista as $atributo ) { //muestra el nombre de cada uno de los campos
?>
					<th>
						<?php echo $strings[$atributo]?>
					</th>
                    
<?php
					}
                    
                ?>
                    
                    <?php
		if((permisosAcc($_SESSION['login'],7,1)==true)||(permisosAcc($_SESSION['login'],7,2)==true)||        (permisosAcc($_SESSION['login'],7,4)==true)){  //mira si el usuario tiene permiso para:añadir,borrar,ver en detalle
?>
					<th colspan="4" >
						<?php echo $strings['Opciones']?>
					</th>
<?php } ?>
				</tr>
<?php           
                $suma=0;//esta variable va a devolver la nota final
				while ( $fila = mysqli_fetch_array( $this->datos ) ) { //este bucle va sacar cada una de las tuplas de historia que hay en la base de datos
?>
				<tr>
<?php
					foreach ( $lista as $atributo ) { //este bucle sacará los valores de cada uno de los campos de una tupla
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
                    <?php
                    $suma = $suma + $fila['NotaTrabajo'];//variable que almacena la nota final
            
                    ?>
                    </td>
                    

					<td>
						<form action="../Controllers/NOTA_TRABAJO_CONTROLLER.php" method="get" style="display:inline" >
							<input type="hidden" name="login" value="<?php echo $fila['login']; ?>">
                            <input type="hidden" name=IdTrabajo value="<?php echo $fila['IdTrabajo']; ?>">
<?php         if(permisosAcc($_SESSION['login'],7,2)==true){ //miramos si el usuario tiene permiso para editar ?>
								<button type="submit" name="action" value="EDIT" ><img src="../Views/icon/modificar.png" alt="<?php echo $strings['Modificar']?>" width="20" height="20" /></button>
<?php } ?>
					<td>
<?php         if(permisosAcc($_SESSION['login'],7,1)==true){ //miramos si el usuario tiene permiso para borrar ?>
								<button type="submit" name="action" value="DELETE" ><img src="../Views/icon/eliminar.png" alt="<?php echo $strings['Eliminar']?>" width="20" height="20" /></button>
<?php } ?>
					<td>
<?php         if(permisosAcc($_SESSION['login'],7,4)==true){ //miramos si el usuario tiene permiso para ver en detalle ?>
								<button type="submit" name="action" value="SHOWCURRENT" ><img src="../Views/icon/verDetalles.png" alt="<?php echo $strings['Ver en detalle']?>" width="20" height="20"/></button>
<?php } ?>
						</form>

				
<?php
				}
        ?>
                
                
                    </tr>
			</table>

<?php
        echo '<br>';
        
                if($this->bol ==true){ //si la variable booleana es true, es decir, si es alumno 
                    echo "Nota final:".$suma;//devolvemos la nota final
                }
        
?>
            
            
			<form action='../Controllers/NOTA_TRABAJO_CONTROLLER.php' method="post">
				<button type="submit"><img src="../Views/icon/atras.png" alt="<?php echo $strings['Atras']?>" /></button>
			</form>
		</div>
<?php
		include '../Views/Footer.php';//mostamos el pie de la página
		}
		}
?>