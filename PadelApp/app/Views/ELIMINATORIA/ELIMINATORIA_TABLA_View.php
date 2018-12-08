<?php

class ELIMINATORIA_TABLA{

	function __construct( $vuelta,
								   $pareja0Cuartos,$pareja1Cuartos,$pareja2Cuartos,$pareja3Cuartos,$pareja4Cuartos,$pareja5Cuartos,$pareja6Cuartos,$pareja7Cuartos,
								   $pareja0Semis,$pareja1Semis,$pareja2Semis,$pareja3Semis,
								   $pareja0Final,$pareja1Final,
									$resulSet1Pareja0Cuartos ,  
									$resulSet1Pareja7Cuartos ,
									$resulSet2Pareja0Cuartos ,  
									$resulSet2Pareja7Cuartos ,
									$resulSet3Pareja0Cuartos ,  
									$resulSet3Pareja7Cuartos ,

									$resulSet1Pareja1Cuartos ,  
									$resulSet1Pareja6Cuartos ,
									$resulSet2Pareja1Cuartos ,  
									$resulSet2Pareja6Cuartos ,
									$resulSet3Pareja1Cuartos ,  
									$resulSet3Pareja6Cuartos ,

									$resulSet1Pareja2Cuartos ,  
									$resulSet1Pareja5Cuartos ,
									$resulSet2Pareja2Cuartos ,  
									$resulSet2Pareja5Cuartos ,
									$resulSet3Pareja2Cuartos ,  
									$resulSet3Pareja5Cuartos ,				

									$resulSet1Pareja3Cuartos ,  
									$resulSet1Pareja4Cuartos ,
									$resulSet2Pareja3Cuartos ,  
									$resulSet2Pareja4Cuartos ,
									$resulSet3Pareja3Cuartos ,  
									$resulSet3Pareja4Cuartos ,

									$resulSet1Pareja0Semis ,  
									$resulSet1Pareja3Semis ,
									$resulSet2Pareja0Semis ,  
									$resulSet2Pareja3Semis ,
									$resulSet3Pareja0Semis ,  
									$resulSet3Pareja3Semis ,

									$resulSet1Pareja1Semis ,  
									$resulSet1Pareja2Semis ,
									$resulSet2Pareja1Semis,  
									$resulSet2Pareja2Semis ,
									$resulSet3Pareja1Semis ,  
									$resulSet3Pareja2Semis ,
									$resulSet1Pareja0Final ,  
									$resulSet1Pareja1Final ,
									$resulSet2Pareja0Final ,  
									$resulSet2Pareja1Final ,
									$resulSet3Pareja0Final ,  
									$resulSet3Pareja1Final 
						
						
						) {

		$this->render($vuelta,
								   $pareja0Cuartos,$pareja1Cuartos,$pareja2Cuartos,$pareja3Cuartos,$pareja4Cuartos,$pareja5Cuartos,$pareja6Cuartos,$pareja7Cuartos,
								   $pareja0Semis,$pareja1Semis,$pareja2Semis,$pareja3Semis,
								   $pareja0Final,$pareja1Final,
					 
									$resulSet1Pareja0Cuartos ,  
									$resulSet1Pareja7Cuartos ,
									$resulSet2Pareja0Cuartos ,  
									$resulSet2Pareja7Cuartos ,
									$resulSet3Pareja0Cuartos ,  
									$resulSet3Pareja7Cuartos ,

									$resulSet1Pareja1Cuartos ,  
									$resulSet1Pareja6Cuartos ,
									$resulSet2Pareja1Cuartos ,  
									$resulSet2Pareja6Cuartos ,
									$resulSet3Pareja1Cuartos ,  
									$resulSet3Pareja6Cuartos ,

									$resulSet1Pareja2Cuartos ,  
									$resulSet1Pareja5Cuartos ,
									$resulSet2Pareja2Cuartos ,  
									$resulSet2Pareja5Cuartos ,
									$resulSet3Pareja2Cuartos ,  
									$resulSet3Pareja5Cuartos ,				

									$resulSet1Pareja3Cuartos ,  
									$resulSet1Pareja4Cuartos ,
									$resulSet2Pareja3Cuartos ,  
									$resulSet2Pareja4Cuartos ,
									$resulSet3Pareja3Cuartos ,  
									$resulSet3Pareja4Cuartos ,

									$resulSet1Pareja0Semis ,  
									$resulSet1Pareja3Semis ,
									$resulSet2Pareja0Semis ,  
									$resulSet2Pareja3Semis ,
									$resulSet3Pareja0Semis ,  
									$resulSet3Pareja3Semis ,

									$resulSet1Pareja1Semis ,  
									$resulSet1Pareja2Semis ,
									$resulSet2Pareja1Semis,  
									$resulSet2Pareja2Semis ,
									$resulSet3Pareja1Semis ,  
									$resulSet3Pareja2Semis ,
									$resulSet1Pareja0Final ,  
									$resulSet1Pareja1Final ,
									$resulSet2Pareja0Final ,  
									$resulSet2Pareja1Final ,
									$resulSet3Pareja0Final ,  
									$resulSet3Pareja1Final 
					 
					 
					 );
	}
	
	function render($vuelta,
								   $pareja0Cuartos,$pareja1Cuartos,$pareja2Cuartos,$pareja3Cuartos,$pareja4Cuartos,$pareja5Cuartos,$pareja6Cuartos,$pareja7Cuartos,
								   $pareja0Semis,$pareja1Semis,$pareja2Semis,$pareja3Semis,
								   $pareja0Final,$pareja1Final,
				   					$resulSet1Pareja0Cuartos ,  
									$resulSet1Pareja7Cuartos ,
									$resulSet2Pareja0Cuartos ,  
									$resulSet2Pareja7Cuartos ,
									$resulSet3Pareja0Cuartos ,  
									$resulSet3Pareja7Cuartos ,

									$resulSet1Pareja1Cuartos ,  
									$resulSet1Pareja6Cuartos ,
									$resulSet2Pareja1Cuartos ,  
									$resulSet2Pareja6Cuartos ,
									$resulSet3Pareja1Cuartos ,  
									$resulSet3Pareja6Cuartos ,

									$resulSet1Pareja2Cuartos ,  
									$resulSet1Pareja5Cuartos ,
									$resulSet2Pareja2Cuartos ,  
									$resulSet2Pareja5Cuartos ,
									$resulSet3Pareja2Cuartos ,  
									$resulSet3Pareja5Cuartos ,				

									$resulSet1Pareja3Cuartos ,  
									$resulSet1Pareja4Cuartos ,
									$resulSet2Pareja3Cuartos ,  
									$resulSet2Pareja4Cuartos ,
									$resulSet3Pareja3Cuartos ,  
									$resulSet3Pareja4Cuartos ,

									$resulSet1Pareja0Semis ,  
									$resulSet1Pareja3Semis ,
									$resulSet2Pareja0Semis ,  
									$resulSet2Pareja3Semis ,
									$resulSet3Pareja0Semis ,  
									$resulSet3Pareja3Semis ,

									$resulSet1Pareja1Semis ,  
									$resulSet1Pareja2Semis ,
									$resulSet2Pareja1Semis,  
									$resulSet2Pareja2Semis ,
									$resulSet3Pareja1Semis ,  
									$resulSet3Pareja2Semis ,
									$resulSet1Pareja0Final ,  
									$resulSet1Pareja1Final ,
									$resulSet2Pareja0Final ,  
									$resulSet2Pareja1Final ,
									$resulSet3Pareja0Final ,  
									$resulSet3Pareja1Final 
				   
				   
				   
				   
				   
				   ){

	
		
		include '../Locales/Strings_' . $_SESSION[ 'idioma' ] . '.php';
		include '../Views/Header.php';
      
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
					<tr style="height: 33px">
						<td><?php echo $pareja0Cuartos ?></td> 
						<td><?php echo $pareja7Cuartos ?></td> 
						<td><img src="../Views/icon/edit_big.png" alt="<?php echo $strings['Modificar']?>" width="20" height="20" /></td>
					</tr>
					<tr style="height: 33px">
						<td><?php echo $pareja1Cuartos ?></td> 
						<td><?php echo $pareja6Cuartos ?></td> 
						<td><img src="../Views/icon/edit_big.png" alt="<?php echo $strings['Modificar']?>" width="20" height="20" /></td>
					</tr>
					<tr style="height: 33px">
						<td><?php echo $pareja2Cuartos ?></td>
						<td><?php echo $pareja5Cuartos ?></td> 
						<td><img src="../Views/icon/edit_big.png" alt="<?php echo $strings['Modificar']?>" width="20" height="20" /></td>
					</tr >	
					<tr style="height: 33px" >
						<td><?php echo $pareja3Cuartos ?></td> 
						<td><?php echo $pareja4Cuartos ?></td> 
						<td><img src="../Views/icon/edit_big.png" alt="<?php echo $strings['Modificar']?>" width="20" height="20" /></td>
					</tr>			
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
					<tr style="height: 33px">
				
					</tr>
					<tr style="height: 33px">
						<td><?php echo $pareja0Semis ?></td>
						<td><?php echo $pareja3Semis ?></td> 
						<td><img src="../Views/icon/edit_big.png" alt="<?php echo $strings['Modificar']?>" width="20" height="20" /></td>
					</tr>
					<tr style="height: 33px">
						<td><?php echo $pareja1Semis ?></td>
						<td><?php echo $pareja2Semis ?></td>
						<td><img src="../Views/icon/edit_big.png" alt="<?php echo $strings['Modificar']?>" width="20" height="20" /></td>
					</tr>	
					<tr style="height: 33px">
						
					</tr>	
				
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
					<tr style="height: 50px">
					
					</tr>
					<tr style="height: 33px" >
					
						<td style="border-top-color: white;border-bottom-color: white"><?php echo $pareja0Final ?></td> 


						<td style="border-top-color: white"><?php echo $pareja1Final ?></td>

						<td style="border-top-color: white"><img src="../Views/icon/edit_big.png" alt="<?php echo $strings['Modificar']?>" width="20" height="20" /></td>
					</tr>
					<tr style="height: 50px">
					
					</tr>	
					<tr style="height: 33px">
			
					</tr>
			
				</thead>
			</table>
			</div>
			
		</div>
		<form action='../Controllers/CAMPEONATO_CATEGORIA_CONTROLLER.php' method="get" align="center">
				<input type="hidden" name="IdCampeonato" value="<?php echo $vuelta['IdCampeonato']; ?>">		
								
				<button id ="buttonBien" type="submit"><img src="../Views/icon/back_big2.png" alt="<?php echo $strings['Atras']?>" /></button>
			</form>
<?php
		include '../Views/Footer.php';//incluimos el pie de la página
		}
		}
?>