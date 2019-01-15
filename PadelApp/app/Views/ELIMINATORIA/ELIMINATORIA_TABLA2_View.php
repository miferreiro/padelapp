<?php

class ELIMINATORIA_TABLA2{

	function __construct($datos,$capitan,$numParejaActual) {
		$this->datos = $datos;
		$this->capitan = $capitan;
		$this->numParejaActual = $numParejaActual;
		$this->render($this->datos , $this->capitan, $this->numParejaActual);
	}
	
	function render($datos,$capitan,$numParejaActual){
		$this->datos = $datos;
		$this->capitan = $capitan;
		$this->numParejaActual = $numParejaActual;
		include '../Locales/Strings_' . $_SESSION[ 'idioma' ] . '.php';
		include '../Views/Header.php';
		
		
$ParejasCuartos=array();
$NumEnfrentamientosCuartos=array();	
$EstadosProPar1Cuartos=array();
$EstadosProPar2Cuartos=array();
$EstadosProPar1Semis=array();
$EstadosProPar2Semis=array();
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
$l=0;
$s=0;

  while ( $fila = mysqli_fetch_array( $this->datos ) ) {
	  if($fila['Fase']=="Cuartos"){
		  $Cuartos=1;
		  $ParejasCuartos[$x]=$fila['NumPareja'];
		  if($p==0){
			$NumEnfrentamientosCuartos[$h]=$fila['NumEnfrentamiento'];
			$EstadosProPar1Cuartos[$s]=$fila['EstadoPropuesta'];
			$s++;
			 $h++;
			 $p++;
		  }else{
			$EstadosProPar2Cuartos[$s]=$fila['EstadoPropuesta'];
			$s++;
			$p=0;  
		  }
		  $IdCampeonato=$fila['IdCampeonato'];
		  $Tipo=$fila['Tipo'];
		  $Nivel=$fila['Nivel'];
		  $Letra=$fila['Letra'];
		  $x++;
	  }
	  if($fila['Fase']=="Semifinales"){
		  $s=0;
		  $Semis=1;
		  $ParejasSemis[$i]=$fila['NumPareja'];
		  if($m==0){
		  $NumEnfrentamientosSemis[$n]=$fila['NumEnfrentamiento'];
		  $EstadosProPar1Semis[$s]=$fila['EstadoPropuesta'];
			  $s++;
			 $n++;
			 $m++;
		  }else{
			  
			$m=0; 
			$EstadosProPar2Semis[$s]=$fila['EstadoPropuesta'];
			$s++;
		  }
		  $i++;		    
	  }
	  if($fila['Fase']=="Final"){
		  $Finalistas=1;
		  $ParejasFinal[$j]=$fila['NumPareja'];
		  $NumEnfrentamientoFinal=$fila['NumEnfrentamiento'];
		  if($m==0){
		  $EstadosProPar1Final = $fila['EstadoPropuesta'];
		  $m++;
		  }else{
		  $EstadosProPar2Final =$fila['EstadoPropuesta'];
		  }
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
						
							<?php 
									
									if($EstadosProPar1Cuartos[0] == 3){?> 
											<td style ="background-color: #7BB661;">
						<form action='../Controllers/CALENDARIO_CONTROLLER.php' method="get" align="center">
							<input type="hidden" name="IdCampeonato" value="<?php echo $IdCampeonato?>" />
							<input type="hidden" name="Tipo" value="<?php echo $Tipo?>" />
							<input type="hidden" name="Nivel" value="<?php echo $Nivel?>" />
							<input type="hidden" name="Letra" value="<?php echo $Letra?>" />
							<input type="hidden" name="NumEnfrentamiento" value="<?php echo $NumEnfrentamientosCuartos[0]?>" />
							<input type="hidden" name="pareja1" value="<?php echo $ParejasCuartos[0]?>" />
							<input type="hidden" name="pareja2" value="<?php echo $ParejasCuartos[1]?>" />
							<button id ="buttonBien" type="submit" id="INFORMACION2" name="action" value="INFORMACION2" >
							<img src="../Views/icon/calendario.png" alt="<?php echo $strings['Modificar']?>" width="20" height="20" />
							</button>
				
						</form>	
								<?php
								   } else { 
											if(($EstadosProPar1Cuartos[0] == 2 && $ParejasCuartos[0] == $this->numParejaActual) || ( $EstadosProPar2Cuartos[1] == 2 && $ParejasCuartos[1] == $this->numParejaActual)){
	  						?>
							<td style ="background-color: #E49E56;">
							<form action='../Controllers/CALENDARIO_CONTROLLER.php' method="get" align="center">
							<input type="hidden" name="IdCampeonato" value="<?php echo $IdCampeonato?>" />
							<input type="hidden" name="Tipo" value="<?php echo $Tipo?>" />
							<input type="hidden" name="Nivel" value="<?php echo $Nivel?>" />
							<input type="hidden" name="Letra" value="<?php echo $Letra?>" />
							<input type="hidden" name="NumEnfrentamiento" value="<?php echo $NumEnfrentamientosCuartos[0]?>" />
							<input type="hidden" name="pareja1" value="<?php echo $ParejasCuartos[0]?>" />
							<input type="hidden" name="pareja2" value="<?php echo $ParejasCuartos[1]?>" />
							<button id ="buttonBien" type="submit" id="INFORMACION2" name="action" value="INFORMACION2" >
							<img src="../Views/icon/calendario.png" alt="<?php echo $strings['Modificar']?>" width="20" height="20" />
							</button>
							<?php
	  							if($this->capitan == $_SESSION['login'] && (($this->numParejaActual == $ParejasCuartos[0])|| ($this->numParejaActual == $ParejasCuartos[1]) )){
	  						?>
							<button id ="buttonBien" type="submit" id="ACEPTAR2" name="action" value="ACEPTAR2" >
							<img src="../Views/icon/recibido.png" alt="<?php echo $strings['Modificar']?>" width="20" height="20" />
							</button>
							<?php
								   }
	  						?>
						</form>
									<?php
								   } else {
										if(($EstadosProPar1Cuartos[0] == 1 && $ParejasCuartos[0] == $this->numParejaActual) || ( $EstadosProPar2Cuartos[1] == 1 && $ParejasCuartos[1] == $this->numParejaActual)){
											
	  						?>
								<td style ="background-color: #FDFD96;"> 
							<form action='../Controllers/CALENDARIO_CONTROLLER.php' method="get" align="center">
							<input type="hidden" name="IdCampeonato" value="<?php echo $IdCampeonato?>" />
							<input type="hidden" name="Tipo" value="<?php echo $Tipo?>" />
							<input type="hidden" name="Nivel" value="<?php echo $Nivel?>" />
							<input type="hidden" name="Letra" value="<?php echo $Letra?>" />
							<input type="hidden" name="NumEnfrentamiento" value="<?php echo $NumEnfrentamientosCuartos[0]?>" />
							<input type="hidden" name="pareja1" value="<?php echo $ParejasCuartos[0]?>" />
							<input type="hidden" name="pareja2" value="<?php echo $ParejasCuartos[1]?>" />
							<button id ="buttonBien" type="submit" id="INFORMACION2" name="action" value="INFORMACION2" >
							<img src="../Views/icon/calendario.png" alt="<?php echo $strings['Modificar']?>" width="20" height="20" />
							</button>
						</form>
									<?php
								   }else{
									?>
									<td > 
							<form action='../Controllers/CALENDARIO_CONTROLLER.php' method="get" align="center">
							<input type="hidden" name="IdCampeonato" value="<?php echo $IdCampeonato?>" />
							<input type="hidden" name="Tipo" value="<?php echo $Tipo?>" />
							<input type="hidden" name="Nivel" value="<?php echo $Nivel?>" />
							<input type="hidden" name="Letra" value="<?php echo $Letra?>" />
							<input type="hidden" name="NumEnfrentamiento" value="<?php echo $NumEnfrentamientosCuartos[0]?>" />
							<input type="hidden" name="pareja1" value="<?php echo $ParejasCuartos[0]?>" />
							<input type="hidden" name="pareja2" value="<?php echo $ParejasCuartos[1]?>" />
							<button id ="buttonBien" type="submit" id="INFORMACION2" name="action" value="INFORMACION2" >
							<img src="../Views/icon/calendario.png" alt="<?php echo $strings['Modificar']?>" width="20" height="20" />
							</button>
							<?php
	  							if($this->capitan == $_SESSION['login'] && (($this->numParejaActual == $ParejasCuartos[0])|| ($this->numParejaActual == $ParejasCuartos[1]) )){
	  						?>
							<button id ="buttonBien" type="submit" id="PROPONER" name="action" value="PROPONER2" >
							<img  src="../Views/icon/enviar.png" alt="<?php echo $strings['Modificar']?>" width="20" height="20" />
							</button>
							<?php
								   }
	  						?>
						</form>
										<?php
								   }}}
	  						?>
						</td>
					</tr>
					
			<!----------------------------------------------------------------------------------------------------------------------------------------------------------------------------->		
					
					<tr style="height: 33px">
						<td><?php echo $ParejasCuartos[2] ?></td> 
						<td><?php echo $ParejasCuartos[3] ?></td>
						
					<?php 
									if($EstadosProPar1Cuartos[2] == 3){?> 
											<td style ="background-color: #7BB661;">
						<form action='../Controllers/CALENDARIO_CONTROLLER.php' method="get" align="center">
							<input type="hidden" name="IdCampeonato" value="<?php echo $IdCampeonato?>" />
							<input type="hidden" name="Tipo" value="<?php echo $Tipo?>" />
							<input type="hidden" name="Nivel" value="<?php echo $Nivel?>" />
							<input type="hidden" name="Letra" value="<?php echo $Letra?>" />
							<input type="hidden" name="NumEnfrentamiento" value="<?php echo $NumEnfrentamientosCuartos[1]?>" />
							<input type="hidden" name="pareja1" value="<?php echo $ParejasCuartos[2]?>" />
							<input type="hidden" name="pareja2" value="<?php echo $ParejasCuartos[3]?>" />
							<button id ="buttonBien" type="submit" id="INFORMACION2" name="action" value="INFORMACION2" >
							<img src="../Views/icon/calendario.png" alt="<?php echo $strings['Modificar']?>" width="20" height="20" />
							</button>
				
						</form>	
								<?php
								   } else { 
											if(($EstadosProPar1Cuartos[2] == 2 && $ParejasCuartos[2] == $this->numParejaActual) || ( $EstadosProPar2Cuartos[3] == 2 && $ParejasCuartos[3] == $this->numParejaActual)){
	  						?>
							<td style ="background-color: #E49E56;">
							<form action='../Controllers/CALENDARIO_CONTROLLER.php' method="get" align="center">
							<input type="hidden" name="IdCampeonato" value="<?php echo $IdCampeonato?>" />
							<input type="hidden" name="Tipo" value="<?php echo $Tipo?>" />
							<input type="hidden" name="Nivel" value="<?php echo $Nivel?>" />
							<input type="hidden" name="Letra" value="<?php echo $Letra?>" />
							<input type="hidden" name="NumEnfrentamiento" value="<?php echo $NumEnfrentamientosCuartos[1]?>" />
							<input type="hidden" name="pareja1" value="<?php echo $ParejasCuartos[2]?>" />
							<input type="hidden" name="pareja2" value="<?php echo $ParejasCuartos[3]?>" />
							<button id ="buttonBien" type="submit" id="INFORMACION2" name="action" value="INFORMACION2" >
							<img src="../Views/icon/calendario.png" alt="<?php echo $strings['Modificar']?>" width="20" height="20" />
							</button>
							<?php
	  							if($this->capitan == $_SESSION['login'] && (($this->numParejaActual == $ParejasCuartos[2])|| ($this->numParejaActual == $ParejasCuartos[3]) )){
	  						?>
							<button id ="buttonBien" type="submit" id="ACEPTAR2" name="action" value="ACEPTAR2" >
							<img src="../Views/icon/recibido.png" alt="<?php echo $strings['Modificar']?>" width="20" height="20" />
							</button>
							<?php
								   }
	  						?>
						</form>
									<?php
								   } else {
										if(($EstadosProPar1Cuartos[2] == 1 && $ParejasCuartos[2] == $this->numParejaActual) || ( $EstadosProPar2Cuartos[3] == 1 && $ParejasCuartos[3] == $this->numParejaActual)){
											
	  						?>
								<td style ="background-color: #FDFD96;"> 
							<form action='../Controllers/CALENDARIO_CONTROLLER.php' method="get" align="center">
							<input type="hidden" name="IdCampeonato" value="<?php echo $IdCampeonato?>" />
							<input type="hidden" name="Tipo" value="<?php echo $Tipo?>" />
							<input type="hidden" name="Nivel" value="<?php echo $Nivel?>" />
							<input type="hidden" name="Letra" value="<?php echo $Letra?>" />
							<input type="hidden" name="NumEnfrentamiento" value="<?php echo $NumEnfrentamientosCuartos[1]?>" />
							<input type="hidden" name="pareja1" value="<?php echo $ParejasCuartos[2]?>" />
							<input type="hidden" name="pareja2" value="<?php echo $ParejasCuartos[3]?>" />
							<button id ="buttonBien" type="submit" id="INFORMACION2" name="action" value="INFORMACION2" >
							<img src="../Views/icon/calendario.png" alt="<?php echo $strings['Modificar']?>" width="20" height="20" />
							</button>
						</form>
									<?php
								   }else{
									?>
									<td > 
							<form action='../Controllers/CALENDARIO_CONTROLLER.php' method="get" align="center">
							<input type="hidden" name="IdCampeonato" value="<?php echo $IdCampeonato?>" />
							<input type="hidden" name="Tipo" value="<?php echo $Tipo?>" />
							<input type="hidden" name="Nivel" value="<?php echo $Nivel?>" />
							<input type="hidden" name="Letra" value="<?php echo $Letra?>" />
							<input type="hidden" name="NumEnfrentamiento" value="<?php echo $NumEnfrentamientosCuartos[1]?>" />
							<input type="hidden" name="pareja1" value="<?php echo $ParejasCuartos[2]?>" />
							<input type="hidden" name="pareja2" value="<?php echo $ParejasCuartos[3]?>" />
							<button id ="buttonBien" type="submit" id="INFORMACION2" name="action" value="INFORMACION2" >
							<img src="../Views/icon/calendario.png" alt="<?php echo $strings['Modificar']?>" width="20" height="20" />
							</button>
							<?php
	  							if($this->capitan == $_SESSION['login'] && (($this->numParejaActual == $ParejasCuartos[2])|| ($this->numParejaActual == $ParejasCuartos[3]) )){
	  						?>
							<button id ="buttonBien" type="submit" id="PROPONER" name="action" value="PROPONER2" >
							<img  src="../Views/icon/enviar.png" alt="<?php echo $strings['Modificar']?>" width="20" height="20" />
							</button>
							<?php
								   }
	  						?>
						</form>
										<?php
								   }}}
	  						?>
						</td>
					</tr>
					<!----------------------------------------------------------------------------------------------------------------------------------------------------------------------------->	
					<tr style="height: 33px">
						<td><?php echo $ParejasCuartos[4] ?></td> 
						<td><?php echo $ParejasCuartos[5] ?></td> 
						<?php 
									if($EstadosProPar1Cuartos[4] == 3){?> 
											<td style ="background-color: #7BB661;">
						<form action='../Controllers/CALENDARIO_CONTROLLER.php' method="get" align="center">
							<input type="hidden" name="IdCampeonato" value="<?php echo $IdCampeonato?>" />
							<input type="hidden" name="Tipo" value="<?php echo $Tipo?>" />
							<input type="hidden" name="Nivel" value="<?php echo $Nivel?>" />
							<input type="hidden" name="Letra" value="<?php echo $Letra?>" />
							<input type="hidden" name="NumEnfrentamiento" value="<?php echo $NumEnfrentamientosCuartos[2]?>" />
							<input type="hidden" name="pareja1" value="<?php echo $ParejasCuartos[4]?>" />
							<input type="hidden" name="pareja2" value="<?php echo $ParejasCuartos[5]?>" />
							<button id ="buttonBien" type="submit" id="INFORMACION2" name="action" value="INFORMACION2" >
							<img src="../Views/icon/calendario.png" alt="<?php echo $strings['Modificar']?>" width="20" height="20" />
							</button>
				
						</form>	
								<?php
								   } else { 
											if(($EstadosProPar1Cuartos[4] == 2 && $ParejasCuartos[4] == $this->numParejaActual) || ( $EstadosProPar2Cuartos[5] == 2 && $ParejasCuartos[5] == $this->numParejaActual)){
	  						?>
							<td style ="background-color: #E49E56;">
							<form action='../Controllers/CALENDARIO_CONTROLLER.php' method="get" align="center">
							<input type="hidden" name="IdCampeonato" value="<?php echo $IdCampeonato?>" />
							<input type="hidden" name="Tipo" value="<?php echo $Tipo?>" />
							<input type="hidden" name="Nivel" value="<?php echo $Nivel?>" />
							<input type="hidden" name="Letra" value="<?php echo $Letra?>" />
							<input type="hidden" name="NumEnfrentamiento" value="<?php echo $NumEnfrentamientosCuartos[2]?>" />
							<input type="hidden" name="pareja1" value="<?php echo $ParejasCuartos[4]?>" />
							<input type="hidden" name="pareja2" value="<?php echo $ParejasCuartos[5]?>" />
							<button id ="buttonBien" type="submit" id="INFORMACION2" name="action" value="INFORMACION2" >
							<img src="../Views/icon/calendario.png" alt="<?php echo $strings['Modificar']?>" width="20" height="20" />
							</button>
							<?php
	  							if($this->capitan == $_SESSION['login'] && (($this->numParejaActual == $ParejasCuartos[4])|| ($this->numParejaActual == $ParejasCuartos[5]) )){
	  						?>
							<button id ="buttonBien" type="submit" id="ACEPTAR2" name="action" value="ACEPTAR2" >
							<img src="../Views/icon/recibido.png" alt="<?php echo $strings['Modificar']?>" width="20" height="20" />
							</button>
							<?php
								   }
	  						?>
						</form>
									<?php
								   } else {
										if(($EstadosProPar1Cuartos[4] == 1 && $ParejasCuartos[4] == $this->numParejaActual) || ( $EstadosProPar2Cuartos[5] == 1 && $ParejasCuartos[5] == $this->numParejaActual)){
											
	  						?>
								<td style ="background-color: #FDFD96;"> 
							<form action='../Controllers/CALENDARIO_CONTROLLER.php' method="get" align="center">
							<input type="hidden" name="IdCampeonato" value="<?php echo $IdCampeonato?>" />
							<input type="hidden" name="Tipo" value="<?php echo $Tipo?>" />
							<input type="hidden" name="Nivel" value="<?php echo $Nivel?>" />
							<input type="hidden" name="Letra" value="<?php echo $Letra?>" />
							<input type="hidden" name="NumEnfrentamiento" value="<?php echo $NumEnfrentamientosCuartos[2]?>" />
							<input type="hidden" name="pareja1" value="<?php echo $ParejasCuartos[4]?>" />
							<input type="hidden" name="pareja2" value="<?php echo $ParejasCuartos[5]?>" />
							<button id ="buttonBien" type="submit" id="INFORMACION2" name="action" value="INFORMACION2" >
							<img src="../Views/icon/calendario.png" alt="<?php echo $strings['Modificar']?>" width="20" height="20" />
							</button>
						</form>
									<?php
								   }else{
									?>
									<td > 
							<form action='../Controllers/CALENDARIO_CONTROLLER.php' method="get" align="center">
							<input type="hidden" name="IdCampeonato" value="<?php echo $IdCampeonato?>" />
							<input type="hidden" name="Tipo" value="<?php echo $Tipo?>" />
							<input type="hidden" name="Nivel" value="<?php echo $Nivel?>" />
							<input type="hidden" name="Letra" value="<?php echo $Letra?>" />
							<input type="hidden" name="NumEnfrentamiento" value="<?php echo $NumEnfrentamientosCuartos[2]?>" />
							<input type="hidden" name="pareja1" value="<?php echo $ParejasCuartos[4]?>" />
							<input type="hidden" name="pareja2" value="<?php echo $ParejasCuartos[5]?>" />
							<button id ="buttonBien" type="submit" id="INFORMACION2" name="action" value="INFORMACION2" >
							<img src="../Views/icon/calendario.png" alt="<?php echo $strings['Modificar']?>" width="20" height="20" />
							</button>
							<?php
	  							if($this->capitan == $_SESSION['login'] && (($this->numParejaActual == $ParejasCuartos[4])|| ($this->numParejaActual == $ParejasCuartos[5]) )){
	  						?>
							<button id ="buttonBien" type="submit" id="PROPONER" name="action" value="PROPONER2" >
							<img src="../Views/icon/enviar.png" alt="<?php echo $strings['Modificar']?>" width="20" height="20" />
							</button>
							<?php
								   }
	  						?>
						</form>
										<?php
								   }}}
	  						?>
						</td>
					</tr>
					<!----------------------------------------------------------------------------------------------------------------------------------------------------------------------------->	
					<tr style="height: 33px" >
						<td><?php echo $ParejasCuartos[6] ?></td> 
						<td><?php echo $ParejasCuartos[7] ?></td> 
						<?php 
									if($EstadosProPar1Cuartos[6] == 3){?> 
											<td style ="background-color: #7BB661;">
						<form action='../Controllers/CALENDARIO_CONTROLLER.php' method="get" align="center">
							<input type="hidden" name="IdCampeonato" value="<?php echo $IdCampeonato?>" />
							<input type="hidden" name="Tipo" value="<?php echo $Tipo?>" />
							<input type="hidden" name="Nivel" value="<?php echo $Nivel?>" />
							<input type="hidden" name="Letra" value="<?php echo $Letra?>" />
							<input type="hidden" name="NumEnfrentamiento" value="<?php echo $NumEnfrentamientosCuartos[3]?>" />
							<input type="hidden" name="pareja1" value="<?php echo $ParejasCuartos[6]?>" />
							<input type="hidden" name="pareja2" value="<?php echo $ParejasCuartos[7]?>" />
							<button id ="buttonBien" type="submit" id="INFORMACION2" name="action" value="INFORMACION2" >
							<img src="../Views/icon/calendario.png" alt="<?php echo $strings['Modificar']?>" width="20" height="20" />
							</button>
				
						</form>	
								<?php
								   } else { 
											if(($EstadosProPar1Cuartos[6] == 2 && $ParejasCuartos[6] == $this->numParejaActual) || ( $EstadosProPar2Cuartos[7] == 2 && $ParejasCuartos[7] == $this->numParejaActual)){
	  						?>
							<td style ="background-color: #E49E56;">
							<form action='../Controllers/CALENDARIO_CONTROLLER.php' method="get" align="center">
							<input type="hidden" name="IdCampeonato" value="<?php echo $IdCampeonato?>" />
							<input type="hidden" name="Tipo" value="<?php echo $Tipo?>" />
							<input type="hidden" name="Nivel" value="<?php echo $Nivel?>" />
							<input type="hidden" name="Letra" value="<?php echo $Letra?>" />
							<input type="hidden" name="NumEnfrentamiento" value="<?php echo $NumEnfrentamientosCuartos[3]?>" />
							<input type="hidden" name="pareja1" value="<?php echo $ParejasCuartos[6]?>" />
							<input type="hidden" name="pareja2" value="<?php echo $ParejasCuartos[7]?>" />
							<button id ="buttonBien" type="submit" id="INFORMACION2" name="action" value="INFORMACION2" >
							<img src="../Views/icon/calendario.png" alt="<?php echo $strings['Modificar']?>" width="20" height="20" />
							</button>
							<?php
	  							if($this->capitan == $_SESSION['login'] && (($this->numParejaActual == $ParejasCuartos[6])|| ($this->numParejaActual == $ParejasCuartos[7]) )){
	  						?>
							<button id ="buttonBien" type="submit" id="ACEPTAR2" name="action" value="ACEPTAR2" >
							<img src="../Views/icon/recibido.png" alt="<?php echo $strings['Modificar']?>" width="20" height="20" />
							</button>
							<?php
								   }
	  						?>
						</form>
									<?php
								   } else {
										if(($EstadosProPar1Cuartos[6] == 1 && $ParejasCuartos[6] == $this->numParejaActual) || ( $EstadosProPar2Cuartos[7] == 1 && $ParejasCuartos[7] == $this->numParejaActual)){
											
	  						?>
								<td style ="background-color: #FDFD96;"> 
							<form action='../Controllers/CALENDARIO_CONTROLLER.php' method="get" align="center">
							<input type="hidden" name="IdCampeonato" value="<?php echo $IdCampeonato?>" />
							<input type="hidden" name="Tipo" value="<?php echo $Tipo?>" />
							<input type="hidden" name="Nivel" value="<?php echo $Nivel?>" />
							<input type="hidden" name="Letra" value="<?php echo $Letra?>" />
							<input type="hidden" name="NumEnfrentamiento" value="<?php echo $NumEnfrentamientosCuartos[3]?>" />
							<input type="hidden" name="pareja1" value="<?php echo $ParejasCuartos[6]?>" />
							<input type="hidden" name="pareja2" value="<?php echo $ParejasCuartos[7]?>" />
							<button id ="buttonBien" type="submit" id="INFORMACION2" name="action" value="INFORMACION2" >
							<img src="../Views/icon/calendario.png" alt="<?php echo $strings['Modificar']?>" width="20" height="20" />
							</button>
						</form>
									<?php
								   }else{
									?>
									<td > 
							<form action='../Controllers/CALENDARIO_CONTROLLER.php' method="get" align="center">
							<input type="hidden" name="IdCampeonato" value="<?php echo $IdCampeonato?>" />
							<input type="hidden" name="Tipo" value="<?php echo $Tipo?>" />
							<input type="hidden" name="Nivel" value="<?php echo $Nivel?>" />
							<input type="hidden" name="Letra" value="<?php echo $Letra?>" />
							<input type="hidden" name="NumEnfrentamiento" value="<?php echo $NumEnfrentamientosCuartos[3]?>" />
							<input type="hidden" name="pareja1" value="<?php echo $ParejasCuartos[6]?>" />
							<input type="hidden" name="pareja2" value="<?php echo $ParejasCuartos[7]?>" />
							<button id ="buttonBien" type="submit" id="INFORMACION2" name="action" value="INFORMACION2" >
							<img src="../Views/icon/calendario.png" alt="<?php echo $strings['Modificar']?>" width="20" height="20" />
							</button>
							<?php
	  							if($this->capitan == $_SESSION['login'] && (($this->numParejaActual == $ParejasCuartos[6])|| ($this->numParejaActual == $ParejasCuartos[7]) )){
	  						?>
							<button id ="buttonBien" type="submit" id="PROPONER" name="action" value="PROPONER2" >
							<img  src="../Views/icon/enviar.png" alt="<?php echo $strings['Modificar']?>" width="20" height="20" />
							</button>
							<?php
								   }
	  						?>
						</form>
										<?php
								   }}}
	  						?>
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
						
							<?php 
									
									if($EstadosProPar1Semis[0] == 3){?> 
											<td style ="background-color: #7BB661;">
						<form action='../Controllers/CALENDARIO_CONTROLLER.php' method="get" align="center">
							<input type="hidden" name="IdCampeonato" value="<?php echo $IdCampeonato?>" />
							<input type="hidden" name="Tipo" value="<?php echo $Tipo?>" />
							<input type="hidden" name="Nivel" value="<?php echo $Nivel?>" />
							<input type="hidden" name="Letra" value="<?php echo $Letra?>" />
							<input type="hidden" name="NumEnfrentamiento" value="<?php echo $NumEnfrentamientosSemis[0]?>" />
							<input type="hidden" name="pareja1" value="<?php echo $ParejasSemis[0]?>" />
							<input type="hidden" name="pareja2" value="<?php echo $ParejasSemis[1]?>" />
							<button id ="buttonBien" type="submit" id="INFORMACION2" name="action" value="INFORMACION2" >
							<img src="../Views/icon/calendario.png" alt="<?php echo $strings['Modificar']?>" width="20" height="20" />
							</button>
				
						</form>	
								<?php
								   } else { 
											if(($EstadosProPar1Semis[0] == 2 && $ParejasSemis[0] == $this->numParejaActual) || ( $EstadosProPar2Semis[1] == 2 && $ParejasSemis[1] == $this->numParejaActual)){
	  						?>
							<td style ="background-color: #E49E56;">
							<form action='../Controllers/CALENDARIO_CONTROLLER.php' method="get" align="center">
							<input type="hidden" name="IdCampeonato" value="<?php echo $IdCampeonato?>" />
							<input type="hidden" name="Tipo" value="<?php echo $Tipo?>" />
							<input type="hidden" name="Nivel" value="<?php echo $Nivel?>" />
							<input type="hidden" name="Letra" value="<?php echo $Letra?>" />
							<input type="hidden" name="NumEnfrentamiento" value="<?php echo $NumEnfrentamientosSemis[0]?>" />
							<input type="hidden" name="pareja1" value="<?php echo $ParejasSemis[0]?>" />
							<input type="hidden" name="pareja2" value="<?php echo $ParejasSemis[1]?>" />
							<button id ="buttonBien" type="submit" id="INFORMACION2" name="action" value="INFORMACION2" >
							<img src="../Views/icon/calendario.png" alt="<?php echo $strings['Modificar']?>" width="20" height="20" />
							</button>
							<?php
	  							if($this->capitan == $_SESSION['login'] && (($this->numParejaActual == $ParejasSemis[0])|| ($this->numParejaActual == $ParejasSemis[1]) )){
	  						?>
							<button id ="buttonBien" type="submit" id="ACEPTAR2" name="action" value="ACEPTAR2" >
							<img src="../Views/icon/recibido.png" alt="<?php echo $strings['Modificar']?>" width="20" height="20" />
							</button>
							<?php
								   }
	  						?>
						</form>
									<?php
								   } else {
										if(($EstadosProPar1Semis[0] == 1 && $ParejasSemis[0] == $this->numParejaActual) || ( $EstadosProPar2Semis[1] == 1 && $ParejasSemis[1] == $this->numParejaActual)){
											
	  						?>
								<td style ="background-color: #FDFD96;"> 
							<form action='../Controllers/CALENDARIO_CONTROLLER.php' method="get" align="center">
							<input type="hidden" name="IdCampeonato" value="<?php echo $IdCampeonato?>" />
							<input type="hidden" name="Tipo" value="<?php echo $Tipo?>" />
							<input type="hidden" name="Nivel" value="<?php echo $Nivel?>" />
							<input type="hidden" name="Letra" value="<?php echo $Letra?>" />
							<input type="hidden" name="NumEnfrentamiento" value="<?php echo $NumEnfrentamientosSemis[0]?>" />
							<input type="hidden" name="pareja1" value="<?php echo $ParejasSemis[0]?>" />
							<input type="hidden" name="pareja2" value="<?php echo $ParejasSemis[1]?>" />
							<button id ="buttonBien" type="submit" id="INFORMACION2" name="action" value="INFORMACION2" >
							<img src="../Views/icon/calendario.png" alt="<?php echo $strings['Modificar']?>" width="20" height="20" />
							</button>
						</form>
									<?php
								   }else{
									?>
									<td > 
							<form action='../Controllers/CALENDARIO_CONTROLLER.php' method="get" align="center">
							<input type="hidden" name="IdCampeonato" value="<?php echo $IdCampeonato?>" />
							<input type="hidden" name="Tipo" value="<?php echo $Tipo?>" />
							<input type="hidden" name="Nivel" value="<?php echo $Nivel?>" />
							<input type="hidden" name="Letra" value="<?php echo $Letra?>" />
							<input type="hidden" name="NumEnfrentamiento" value="<?php echo $NumEnfrentamientosSemis[0]?>" />
							<input type="hidden" name="pareja1" value="<?php echo $ParejasSemis[0]?>" />
							<input type="hidden" name="pareja2" value="<?php echo $ParejasSemis[1]?>" />
							<button id ="buttonBien" type="submit" id="INFORMACION2" name="action" value="INFORMACION2" >
							<img src="../Views/icon/calendario.png" alt="<?php echo $strings['Modificar']?>" width="20" height="20" />
							</button>
							<?php
	  							if($this->capitan == $_SESSION['login'] && (($this->numParejaActual == $ParejasSemis[0])|| ($this->numParejaActual == $ParejasSemis[1]) )){
	  						?>
							<button id ="buttonBien" type="submit" id="PROPONER" name="action" value="PROPONER2" >
							<img  src="../Views/icon/enviar.png" alt="<?php echo $strings['Modificar']?>" width="20" height="20" />
							</button>
							<?php
								   }
	  						?>
						</form>
										<?php
								   }}}
	  						?>
						</td>
					</tr>
					
			<!----------------------------------------------------------------------------------------------------------------------------------------------------------------------------->		
					
					<tr style="height: 33px">
						<td><?php echo $ParejasSemis[2] ?></td> 
						<td><?php echo $ParejasSemis[3] ?></td>
						
					<?php 
									if($EstadosProPar1Semis[2] == 3){?> 
											<td style ="background-color: #7BB661;">
						<form action='../Controllers/CALENDARIO_CONTROLLER.php' method="get" align="center">
							<input type="hidden" name="IdCampeonato" value="<?php echo $IdCampeonato?>" />
							<input type="hidden" name="Tipo" value="<?php echo $Tipo?>" />
							<input type="hidden" name="Nivel" value="<?php echo $Nivel?>" />
							<input type="hidden" name="Letra" value="<?php echo $Letra?>" />
							<input type="hidden" name="NumEnfrentamiento" value="<?php echo $NumEnfrentamientosSemis[1]?>" />
							<input type="hidden" name="pareja1" value="<?php echo $ParejasSemis[2]?>" />
							<input type="hidden" name="pareja2" value="<?php echo $ParejasSemis[3]?>" />
							<button id ="buttonBien" type="submit" id="INFORMACION2" name="action" value="INFORMACION2" >
							<img src="../Views/icon/calendario.png" alt="<?php echo $strings['Modificar']?>" width="20" height="20" />
							</button>
				
						</form>	
								<?php
								   } else { 
											if(($EstadosProPar1Semis[2] == 2 && $ParejasSemis[2] == $this->numParejaActual) || ( $EstadosProPar2Semis[3] == 2 && $ParejasSemis[3] == $this->numParejaActual)){
	  						?>
							<td style ="background-color: #E49E56;">
							<form action='../Controllers/CALENDARIO_CONTROLLER.php' method="get" align="center">
							<input type="hidden" name="IdCampeonato" value="<?php echo $IdCampeonato?>" />
							<input type="hidden" name="Tipo" value="<?php echo $Tipo?>" />
							<input type="hidden" name="Nivel" value="<?php echo $Nivel?>" />
							<input type="hidden" name="Letra" value="<?php echo $Letra?>" />
							<input type="hidden" name="NumEnfrentamiento" value="<?php echo $NumEnfrentamientosSemis[1]?>" />
							<input type="hidden" name="pareja1" value="<?php echo $ParejasSemis[2]?>" />
							<input type="hidden" name="pareja2" value="<?php echo $ParejasSemis[3]?>" />
							<button id ="buttonBien" type="submit" id="INFORMACION2" name="action" value="INFORMACION2" >
							<img src="../Views/icon/calendario.png" alt="<?php echo $strings['Modificar']?>" width="20" height="20" />
							</button>
							<?php
	  							if($this->capitan == $_SESSION['login'] && (($this->numParejaActual == $ParejasSemis[2])|| ($this->numParejaActual == $ParejasSemis[3]) )){
	  						?>
							<button id ="buttonBien" type="submit" id="ACEPTAR2" name="action" value="ACEPTAR2" >
							<img src="../Views/icon/recibido.png" alt="<?php echo $strings['Modificar']?>" width="20" height="20" />
							</button>
							<?php
								   }
	  						?>
						</form>
									<?php
								   } else {
										if(($EstadosProPar1Semis[2] == 1 && $ParejasSemis[2] == $this->numParejaActual) || ( $EstadosProPar2Semis[3] == 1 && $ParejasSemis[3] == $this->numParejaActual)){
											
	  						?>
								<td style ="background-color: #FDFD96;"> 
							<form action='../Controllers/CALENDARIO_CONTROLLER.php' method="get" align="center">
							<input type="hidden" name="IdCampeonato" value="<?php echo $IdCampeonato?>" />
							<input type="hidden" name="Tipo" value="<?php echo $Tipo?>" />
							<input type="hidden" name="Nivel" value="<?php echo $Nivel?>" />
							<input type="hidden" name="Letra" value="<?php echo $Letra?>" />
							<input type="hidden" name="NumEnfrentamiento" value="<?php echo $NumEnfrentamientosSemis[1]?>" />
							<input type="hidden" name="pareja1" value="<?php echo $ParejasSemis[2]?>" />
							<input type="hidden" name="pareja2" value="<?php echo $ParejasSemis[3]?>" />
							<button id ="buttonBien" type="submit" id="INFORMACION2" name="action" value="INFORMACION2" >
							<img src="../Views/icon/calendario.png" alt="<?php echo $strings['Modificar']?>" width="20" height="20" />
							</button>
						</form>
									<?php
								   }else{
									?>
									<td > 
							<form action='../Controllers/CALENDARIO_CONTROLLER.php' method="get" align="center">
							<input type="hidden" name="IdCampeonato" value="<?php echo $IdCampeonato?>" />
							<input type="hidden" name="Tipo" value="<?php echo $Tipo?>" />
							<input type="hidden" name="Nivel" value="<?php echo $Nivel?>" />
							<input type="hidden" name="Letra" value="<?php echo $Letra?>" />
							<input type="hidden" name="NumEnfrentamiento" value="<?php echo $NumEnfrentamientosSemis[1]?>" />
							<input type="hidden" name="pareja1" value="<?php echo $ParejasSemis[2]?>" />
							<input type="hidden" name="pareja2" value="<?php echo $ParejasSemis[3]?>" />
							<button id ="buttonBien" type="submit" id="INFORMACION" name="action" value="INFORMACION" >
							<img src="../Views/icon/calendario.png" alt="<?php echo $strings['Modificar']?>" width="20" height="20" />
							</button>
							<?php
	  							if($this->capitan == $_SESSION['login'] && (($this->numParejaActual == $ParejasSemis[2])|| ($this->numParejaActual == $ParejasSemis[3]) )){
	  						?>
							<button id ="buttonBien" type="submit" id="PROPONER" name="action" value="PROPONER2" >
							<img  src="../Views/icon/enviar.png" alt="<?php echo $strings['Modificar']?>" width="20" height="20" />
							</button>
							<?php
								   }
	  						?>
						</form>
										<?php
								   }}}
	  						?>
						</td>
					</tr>
					<!------------------------------------------------------------------------------------------------------------------------------->
	
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
					<tr style="height: 33px">
						<td><?php echo $ParejasFinal[0] ?></td> 
						<td><?php echo $ParejasFinal[1] ?></td> 
						
							<?php 
									
									if($EstadosProPar1Final == 3){?> 
											<td style ="background-color: #7BB661;">
						<form action='../Controllers/CALENDARIO_CONTROLLER.php' method="get" align="center">
							<input type="hidden" name="IdCampeonato" value="<?php echo $IdCampeonato?>" />
							<input type="hidden" name="Tipo" value="<?php echo $Tipo?>" />
							<input type="hidden" name="Nivel" value="<?php echo $Nivel?>" />
							<input type="hidden" name="Letra" value="<?php echo $Letra?>" />
							<input type="hidden" name="NumEnfrentamiento" value="<?php echo $NumEnfrentamientoFinal?>" />
							<input type="hidden" name="pareja1" value="<?php echo $ParejasFinal[0]?>" />
							<input type="hidden" name="pareja2" value="<?php echo $ParejasFinal[1]?>" />
							<button id ="buttonBien" type="submit" id="INFORMACION2" name="action" value="INFORMACION2" >
							<img src="../Views/icon/calendario.png" alt="<?php echo $strings['Modificar']?>" width="20" height="20" />
							</button>
				
						</form>	
								<?php
								   } else { 
											if(($EstadosProPar1Final == 2 && $ParejasFinal[0] == $this->numParejaActual) || ( $EstadosProPar2Final == 2 && $ParejasFinal[1] == $this->numParejaActual)){
	  						?>
							<td style ="background-color: #E49E56;">
							<form action='../Controllers/CALENDARIO_CONTROLLER.php' method="get" align="center">
							<input type="hidden" name="IdCampeonato" value="<?php echo $IdCampeonato?>" />
							<input type="hidden" name="Tipo" value="<?php echo $Tipo?>" />
							<input type="hidden" name="Nivel" value="<?php echo $Nivel?>" />
							<input type="hidden" name="Letra" value="<?php echo $Letra?>" />
							<input type="hidden" name="NumEnfrentamiento" value="<?php echo $NumEnfrentamientoFinal?>" />
							<input type="hidden" name="pareja1" value="<?php echo $ParejasFinal[0]?>" />
							<input type="hidden" name="pareja2" value="<?php echo $ParejasFinal[1]?>" />
							<button id ="buttonBien" type="submit" id="INFORMACION2" name="action" value="INFORMACION2" >
							<img src="../Views/icon/calendario.png" alt="<?php echo $strings['Modificar']?>" width="20" height="20" />
							</button>
							<?php
	  							if($this->capitan == $_SESSION['login'] && (($this->numParejaActual == $ParejasFinal[0])|| ($this->numParejaActual == $ParejasFinal[1]) )){
	  						?>
							<button id ="buttonBien" type="submit" id="ACEPTAR2" name="action" value="ACEPTAR2" >
							<img src="../Views/icon/recibido.png" alt="<?php echo $strings['Modificar']?>" width="20" height="20" />
							</button>
							<?php
								   }
	  						?>
						</form>
									<?php
								   } else {
										if(($EstadosProPar1Final == 1 && $ParejasFinal[0] == $this->numParejaActual) || ( $EstadosProPar2Final == 1 && $ParejasFinal[1] == $this->numParejaActual)){
											
	  						?>
								<td style ="background-color: #FDFD96;"> 
							<form action='../Controllers/CALENDARIO_CONTROLLER.php' method="get" align="center">
							<input type="hidden" name="IdCampeonato" value="<?php echo $IdCampeonato?>" />
							<input type="hidden" name="Tipo" value="<?php echo $Tipo?>" />
							<input type="hidden" name="Nivel" value="<?php echo $Nivel?>" />
							<input type="hidden" name="Letra" value="<?php echo $Letra?>" />
							<input type="hidden" name="NumEnfrentamiento" value="<?php echo $NumEnfrentamientoFinal?>" />
							<input type="hidden" name="pareja1" value="<?php echo $ParejasFinal[0]?>" />
							<input type="hidden" name="pareja2" value="<?php echo $ParejasFinal[1]?>" />
							<button id ="buttonBien" type="submit" id="INFORMACION2" name="action" value="INFORMACION2" >
							<img src="../Views/icon/calendario.png" alt="<?php echo $strings['Modificar']?>" width="20" height="20" />
							</button>
						</form>
									<?php
								   }else{
									?>
									<td > 
							<form action='../Controllers/CALENDARIO_CONTROLLER.php' method="get" align="center">
							<input type="hidden" name="IdCampeonato" value="<?php echo $IdCampeonato?>" />
							<input type="hidden" name="Tipo" value="<?php echo $Tipo?>" />
							<input type="hidden" name="Nivel" value="<?php echo $Nivel?>" />
							<input type="hidden" name="Letra" value="<?php echo $Letra?>" />
							<input type="hidden" name="NumEnfrentamiento" value="<?php echo $NumEnfrentamientoFinal?>" />
							<input type="hidden" name="pareja1" value="<?php echo $ParejasFinal[0]?>" />
							<input type="hidden" name="pareja2" value="<?php echo $ParejasFinal[1]?>" />
							<button id ="buttonBien" type="submit" id="INFORMACION2" name="action" value="INFORMACION2" >
							<img src="../Views/icon/calendario.png" alt="<?php echo $strings['Modificar']?>" width="20" height="20" />
							</button>
							<?php
	  							if($this->capitan == $_SESSION['login'] && (($this->numParejaActual == $ParejasFinal[0])|| ($this->numParejaActual == $ParejasFinal[1]) )){
	  						?>
							<button id ="buttonBien" type="submit" id="PROPONER" name="action" value="PROPONER2" >
							<img  src="../Views/icon/enviar.png" alt="<?php echo $strings['Modificar']?>" width="20" height="20" />
							</button>
							<?php
								   }
	  						?>
						</form>
										<?php
								   }}}
	  						?>
						</td>
					</tr>
					<!--------------------------------------------------------------------------------->
					
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