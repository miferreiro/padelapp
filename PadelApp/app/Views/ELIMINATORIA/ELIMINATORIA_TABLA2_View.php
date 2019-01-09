<?php

class ELIMINATORIA_TABLA{

	function __construct($datos,$capitan) {
		$this->datos = $datos;
		$this->capitan = $capitan;
		$this->render($this->datos , $this->capitan);
	}
	
	function render($datos,$capitan){
		$this->datos = $datos;
		$this->capitan = $capitan;
		include '../Locales/Strings_' . $_SESSION[ 'idioma' ] . '.php';
		include '../Views/Header.php';
		
		
$ParejasCuartos=array();
$NumEnfrentamientosCuartos=array();		
$ParejasSemis=array();	
$NumEnfrentamientosSemis=array();	
$ParejasFinal=array();
$Cuartos=0;
$Semis=0;
$Finalistas=0;
		
$x=0;
$i=0;
$j=0;
$h=0;
$n=0;
$p=0;
$m=0;
  while ( $fila = mysqli_fetch_array( $this->datos ) ) {
	  if($fila['Fase']=="Cuartos"){
		  $Cuartos=1;
		  $ParejasCuartos[$x]=$fila['NumPareja'];
		  if($p==0){
			$NumEnfrentamientosCuartos[$h]=$fila['NumEnfrentamiento'];
			 $h++;
			 $p++;
		  }else{
			$p=0;  
		  }
		  $IdCampeonato=$fila['IdCampeonato'];
		  $Tipo=$fila['Tipo'];
		  $Nivel=$fila['Nivel'];
		  $Letra=$fila['Letra'];
		  $x++;
	  }
	  if($fila['Fase']=="Semifinales"){
		  $Semis=1;
		  $ParejasSemis[$i]=$fila['NumPareja'];
		  if($m==0){
		  $NumEnfrentamientosSemis[$n]=$fila['NumEnfrentamiento'];
			 $n++;
			 $m++;
		  }else{
			$m=0;  
		  }
		  $i++;		    
	  }
	  if($fila['Fase']=="Final"){
		  $Finalistas=1;
		  $ParejasFinal[$j]=$fila['NumPareja'];
		  $NumEnfrentamientoFinal=$fila['NumEnfrentamiento'];
		  $j++;		  
	  }	  
  }    
?>
			<h2  align="center"> 
				<?php echo $strings['Tabla de enfrentamientos'];?>
			</h2>
	

		<div class="seccion" align="center"  style="float:left;width:100%;transform: translate(15%, 0%)">

			<div class="col-md-3"  style="width: 33%;float:left;position:relative;" >
			<h2>Cuartos</h2>
			<table class="table table-sm" style="text-align:center" >
				<thead class="thead-light">
				   <tr style="height: 33px">
						<th>Pareja 1</th> <th>Pareja 2</th> <th>Opciones</th>
					</tr>
			<?php if($Cuartos == 1){ ?>
					<tr style="height: 33px">
						<td><?php echo $ParejasCuartos[0] ?></td> 
						<td><?php echo $ParejasCuartos[1] ?></td> 
						<td>
						<form action='../Controllers/ELIMINATORIA_CONTROLLER.php' method="get" align="center">
							<input type="hidden" name="IdCampeonato" value="<?php echo $IdCampeonato?>" />
							<input type="hidden" name="Tipo" value="<?php echo $Tipo?>" />
							<input type="hidden" name="Nivel" value="<?php echo $Nivel?>" />
							<input type="hidden" name="Letra" value="<?php echo $Letra?>" />
							<input type="hidden" name="NumEnfrentamiento" value="<?php echo $NumEnfrentamientosCuartos[0]?>" />
							<input type="hidden" name="pareja1" value="<?php echo $ParejasCuartos[0]?>" />
							<button id ="buttonBien" type="submit" id="EDITAR" name="action" value="EDITAR" >
							<img src="../Views/icon/edit_big.png" alt="<?php echo $strings['Modificar']?>" width="20" height="20" />
							</button>
						</form>	
						</td>
					</tr>
					<tr style="height: 33px">
						<td><?php echo $ParejasCuartos[2] ?></td> 
						<td><?php echo $ParejasCuartos[3] ?></td> 
						<td>
						<form action='../Controllers/ELIMINATORIA_CONTROLLER.php' method="get" align="center">
							<input type="hidden" name="IdCampeonato" value="<?php echo $IdCampeonato?>" />
							<input type="hidden" name="Tipo" value="<?php echo $Tipo?>" />
							<input type="hidden" name="Nivel" value="<?php echo $Nivel?>" />
							<input type="hidden" name="Letra" value="<?php echo $Letra?>" />
							<input type="hidden" name="NumEnfrentamiento" value="<?php echo $NumEnfrentamientosCuartos[1]?>" />
							<input type="hidden" name="pareja1" value="<?php echo $ParejasCuartos[2]?>" />
							<button id ="buttonBien" type="submit" id="EDITAR" name="action" value="EDITAR" >
							<img src="../Views/icon/edit_big.png" alt="<?php echo $strings['Modificar']?>" width="20" height="20" />
							</button>
						</form>	
						</td>
					</tr>
					<tr style="height: 33px">
						<td><?php echo $ParejasCuartos[4] ?></td> 
						<td><?php echo $ParejasCuartos[5] ?></td> 
						<td>
						<form action='../Controllers/ELIMINATORIA_CONTROLLER.php' method="get" align="center">
							<input type="hidden" name="IdCampeonato" value="<?php echo $IdCampeonato?>" />
							<input type="hidden" name="Tipo" value="<?php echo $Tipo?>" />
							<input type="hidden" name="Nivel" value="<?php echo $Nivel?>" />
							<input type="hidden" name="Letra" value="<?php echo $Letra?>" />
							<input type="hidden" name="NumEnfrentamiento" value="<?php echo $NumEnfrentamientosCuartos[2]?>" />
							<input type="hidden" name="pareja1" value="<?php echo $ParejasCuartos[4]?>" />
							<button id ="buttonBien" type="submit" id="EDITAR" name="action" value="EDITAR" >
							<img src="../Views/icon/edit_big.png" alt="<?php echo $strings['Modificar']?>" width="20" height="20" />
							</button>
						</form>	
						</td>
					</tr >	
					<tr style="height: 33px" >
						<td><?php echo $ParejasCuartos[6] ?></td> 
						<td><?php echo $ParejasCuartos[7] ?></td> 
						<td>
						<form action='../Controllers/ELIMINATORIA_CONTROLLER.php' method="get" align="center">
							<input type="hidden" name="IdCampeonato" value="<?php echo $IdCampeonato?>" />
							<input type="hidden" name="Tipo" value="<?php echo $Tipo?>" />
							<input type="hidden" name="Nivel" value="<?php echo $Nivel?>" />
							<input type="hidden" name="Letra" value="<?php echo $Letra?>" />
							<input type="hidden" name="NumEnfrentamiento" value="<?php echo $NumEnfrentamientosCuartos[3]?>" />
							<input type="hidden" name="pareja1" value="<?php echo $ParejasCuartos[6]?>" />
							<button id ="buttonBien" type="submit" id="EDITAR" name="action" value="EDITAR" >
							<img src="../Views/icon/edit_big.png" alt="<?php echo $strings['Modificar']?>" width="20" height="20" />
							</button>
						</form>	
						</td>
					</tr>
			<?php  } ?>
				</thead>
			</table>
			</div>


			<div class="col-md-3"    style="width: 33%;float:left;position:relative;">
			<h2>Semifinales</h2>
			<table class="table table-sm" style="text-align:center" >
				<thead class="thead-light">
					<tr style="height: 33px">
						<th>Pareja 1</th> <th>Pareja 2</th> <th>Opciones</th>
					</tr>
				<?php if($Semis == 1){ ?>
					<tr style="height: 33px">
						<td><?php echo $ParejasSemis[0] ?></td> 
						<td><?php echo $ParejasSemis[1] ?></td> 
						<td>
						<form action='../Controllers/CALENDARIO_CONTROLLER.php' method="get" align="center">
							<input type="hidden" name="IdCampeonato" value="<?php echo $IdCampeonato?>" />
							<input type="hidden" name="Tipo" value="<?php echo $Tipo?>" />
							<input type="hidden" name="Nivel" value="<?php echo $Nivel?>" />
							<input type="hidden" name="Letra" value="<?php echo $Letra?>" />
							<input type="hidden" name="NumEnfrentamiento" value="<?php echo $NumEnfrentamientosSemis[0]?>" />
							<input type="hidden" name="pareja1" value="<?php echo $ParejasSemis[0]?>" />
							<button id ="buttonBien" type="submit" id="EDITAR" name="action" value="INFORMACION" >
							<img src="../Views/icon/edit_big.png" alt="<?php echo $strings['Modificar']?>" width="20" height="20" />
							</button>
						</form>	
						</td>
					</tr>
					<tr style="height: 33px">
						<td><?php echo $ParejasSemis[2] ?></td> 
						<td><?php echo $ParejasSemis[3] ?></td> 
						<td>
						<form action='../Controllers/CALENDARIO_CONTROLLER.php' method="get" align="center">
							<input type="hidden" name="IdCampeonato" value="<?php echo $IdCampeonato?>" />
							<input type="hidden" name="Tipo" value="<?php echo $Tipo?>" />
							<input type="hidden" name="Nivel" value="<?php echo $Nivel?>" />
							<input type="hidden" name="Letra" value="<?php echo $Letra?>" />
							<input type="hidden" name="NumEnfrentamiento" value="<?php echo $NumEnfrentamientosSemis[1]?>" />
							<input type="hidden" name="pareja1" value="<?php echo $ParejasSemis[2]?>" />
							<button id ="buttonBien" type="submit" id="EDITAR" name="action" value="INFORMACION" >
							<img src="../Views/icon/edit_big.png" alt="<?php echo $strings['Modificar']?>" width="20" height="20" />
							</button>
						</form>	
						</td>
					</tr>	
				<?php } ?>
				</thead>
			</table>
			</div>
			
			<div class="col-md-3"   style="width: 33%;float:left;position:relative;">
			<h2>Finales</h2>
			<table class="table table-sm" style="text-align:center" >
				<thead class="thead-light">
					<tr style="height: 33px">
						<th>Pareja 1</th> <th>Pareja 2</th> <th>Opciones</th>
					</tr>
				<?php if($Finalistas == 1){ ?>
					<tr style="height: 33px" >
					
						<td><?php echo $ParejasFinal[0] ?></td> 
						<td><?php echo $ParejasFinal[1] ?></td> 

						<td>
						<form action='../Controllers/CALENDARIO_CONTROLLER.php' method="get" align="center">
							<input type="hidden" name="IdCampeonato" value="<?php echo $IdCampeonato?>" />
							<input type="hidden" name="Tipo" value="<?php echo $Tipo?>" />
							<input type="hidden" name="Nivel" value="<?php echo $Nivel?>" />
							<input type="hidden" name="Letra" value="<?php echo $Letra?>" />
							<input type="hidden" name="NumEnfrentamiento" value="<?php echo $NumEnfrentamientoFinal?>" />
							<input type="hidden" name="pareja1" value="<?php echo $ParejasFinal[0]?>" />
							<button id ="buttonBien" type="submit" id="EDITAR" name="action" value="INFORMACION" >
							<img src="../Views/icon/edit_big.png" alt="<?php echo $strings['Modificar']?>" width="20" height="20" />
							</button>
						</form>	
						</td>
					</tr>
				<?php } ?>
				</thead>
			</table>
			</div>
			
		</div>
		<div class="seccion" align="center">
		<form action='../Controllers/CALENDARIO_CONTROLLER.php' method="get" align="center">
							<input type="hidden" name="IdCampeonato" value="<?php echo $IdCampeonato?>" />
							<input type="hidden" name="Tipo" value="<?php echo $Tipo?>" />
							<input type="hidden" name="Nivel" value="<?php echo $Nivel?>" />
				<button id ="buttonBien" type="submit"><img src="../Views/icon/back_big2.png" alt="<?php echo $strings['Atras']?>" /></button>
			</form>
			</div>
<?php
		include '../Views/Footer.php';//incluimos el pie de la página
		}
		}
?>