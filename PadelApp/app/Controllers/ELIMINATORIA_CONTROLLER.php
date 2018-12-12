<?php

session_start(); 
include '../Functions/Authentication.php'; 

if (!IsAuthenticated()){
 	header('Location:../index.php');
}

include '../Models/CAMPEONATO_MODEL.php'; 
include '../Models/ELIMINATORIA_MODEL.php';
include '../Models/ENFRENELIMINATORIA_MODEL.php';

include '../Models/CATEGORIA_MODEL.php'; 
include '../Models/GRUPO_MODEL.php'; 
include '../Models/NOTICIA_MODEL.php';
include '../Views/CAMPEONATO/CAMPEONATO_SHOWALL_View.php'; 
include '../Views/CAMPEONATO/CAMPEONATO_SEARCH_View.php'; 
include '../Views/CAMPEONATO/CAMPEONATO_ADD_View.php'; 
include '../Views/CAMPEONATO/CAMPEONATO_DELETE_View.php';
include '../Views/CAMPEONATO/CAMPEONATO_SHOWCURRENT_View.php'; 
include '../Views/DEFAULT_View.php'; 
include '../Views/MESSAGE_View.php'; 


include '../Views/ELIMINATORIA/ELIMINATORIA_TABLA_View.php';



function get_data_form_grupo(){
	
	$IdCampeonato = $_REQUEST['IdCampeonato'];
	$Tipo = $_REQUEST['Tipo'];
	$Nivel = $_REQUEST['Nivel'];
	$Letra= $_REQUEST['Letra'];
	
	
	return $GRUPO; 
}

if ( !isset( $_REQUEST[ 'action' ] ) ) {
	$_REQUEST[ 'action' ] = '';
	
}
switch ( $_REQUEST[ 'action' ] ) {
	case 'GENERAR':
	

		if($_SESSION['tipo'] == 'Admin'){

			$IdCampeonato = $_REQUEST['IdCampeonato'];
			$Tipo = $_REQUEST['Tipo'];
			$Nivel = $_REQUEST['Nivel'];
			$Letra = "";
 			
			
			$GRUPO= new GRUPO_MODEL($IdCampeonato, $Tipo,$Nivel,$Letra);
			$numGrupos = $GRUPO->numGrupos();
			
			//echo $numGrupos;

if($numGrupos == 8){
				
				$enfrentamientos = array();
				for($i = 0; $i < $numGrupos; $i++){

					
					if($i == 0) $Letra = 'A';
					else if($i == 1) $Letra = 'B';
					else if($i == 2) $Letra = 'C';
					else if($i == 3) $Letra = 'D';
					else if($i == 4) $Letra = 'E';
					else if($i == 5) $Letra = 'F';
					else if($i == 6) $Letra = 'G';
					else if($i == 7) $Letra = 'H';

					$GRUPO2= new GRUPO_MODEL($IdCampeonato, $Tipo,$Nivel,$Letra);
					$listaClasificacion = $GRUPO2 ->Clasif();
					
					//Construyo el array
					$numParejas = 0;
					$parejas = array();
					$puntos= array();
					while ( $fila = mysqli_fetch_array( $listaClasificacion ) ) {		
						$parejas[$numParejas] = $fila['NumPareja'];
						$puntos[$numParejas] = $fila['Puntos'];

						$numParejas++;
					}
					
					
					$pareja = $parejas[0];					
											
					$puntuacion = $puntos[0];
					
					$enfrentamientos [$pareja ] =  $puntuacion ;
					
				}				
			
		/*
				foreach($enfrentamientos as $pa => $pu)
				{
				echo "La pareja " . $pa . " tiene de puntuacion " . $pu;
				echo "<br>";
				}*/
				//asort |arsort
				arsort($enfrentamientos);

				$parejasOrdenadas = array();
				$aux = 0;
				foreach($enfrentamientos as $pa => $pu)
				{
					/*
					echo "La pareja " . $pa . " tiene de puntuacion " . $pu;
					echo "<br>";*/
					$parejasOrdenadas[$aux] = $pa;
					//echo $pa;
					$aux++;

				}

				echo $parejasOrdenadas[0] . "-" . $parejasOrdenadas[7];echo "<br>";
				echo $parejasOrdenadas[1] . "-" . $parejasOrdenadas[6];echo "<br>";
				echo $parejasOrdenadas[2] . "-" . $parejasOrdenadas[5];echo "<br>";
				echo $parejasOrdenadas[3] . "-" . $parejasOrdenadas[4];echo "<br>";

				
				$Fase ="Cuartos";
				$IdCampeonato = $_REQUEST['IdCampeonato'];
				$Tipo = $_REQUEST['Tipo'];
				$Nivel = $_REQUEST['Nivel'];
	
				$NumEnfrentamiento = 1;
	
				$ELIMINATORIA = new ELIMINATORIA_MODEL($IdCampeonato,$Tipo,$Nivel,$Fase,$NumEnfrentamiento,NULL,NULL,NULL,NULL,'0');
				$mensaje = $ELIMINATORIA->ADD();
				$ENFRENELIMINATORIA = new ENFRENELIMINATORIA_MODEL($IdCampeonato,$Tipo,$Nivel,$Fase,$NumEnfrentamiento,$parejasOrdenadas[0],NULL,NULL,NULL,'0');
				$mensaje = $ENFRENELIMINATORIA->ADD();
				$ENFRENELIMINATORIA = new ENFRENELIMINATORIA_MODEL($IdCampeonato,$Tipo,$Nivel,$Fase,$NumEnfrentamiento,$parejasOrdenadas[7],NULL,NULL,NULL,'0');
				$mensaje = $ENFRENELIMINATORIA->ADD();
				$NumEnfrentamiento = $NumEnfrentamiento + 1;

				$ELIMINATORIA = new ELIMINATORIA_MODEL($IdCampeonato,$Tipo,$Nivel,$Fase,$NumEnfrentamiento,NULL,NULL,NULL,NULL,'0');
				$mensaje = $ELIMINATORIA->ADD();
				$ENFRENELIMINATORIA = new ENFRENELIMINATORIA_MODEL($IdCampeonato,$Tipo,$Nivel,$Fase,$NumEnfrentamiento,$parejasOrdenadas[1],NULL,NULL,NULL,'0');
				$mensaje = $ENFRENELIMINATORIA->ADD();
				$ENFRENELIMINATORIA = new ENFRENELIMINATORIA_MODEL($IdCampeonato,$Tipo,$Nivel,$Fase,$NumEnfrentamiento,$parejasOrdenadas[6],NULL,NULL,NULL,'0');
				$mensaje = $ENFRENELIMINATORIA->ADD();
				$NumEnfrentamiento = $NumEnfrentamiento + 1;
	
				$ELIMINATORIA = new ELIMINATORIA_MODEL($IdCampeonato,$Tipo,$Nivel,$Fase,$NumEnfrentamiento,NULL,NULL,NULL,NULL,'0');
				$mensaje = $ELIMINATORIA->ADD();
				$ENFRENELIMINATORIA = new ENFRENELIMINATORIA_MODEL($IdCampeonato,$Tipo,$Nivel,$Fase,$NumEnfrentamiento,$parejasOrdenadas[2],NULL,NULL,NULL,'0');
				$mensaje = $ENFRENELIMINATORIA->ADD();
				$ENFRENELIMINATORIA = new ENFRENELIMINATORIA_MODEL($IdCampeonato,$Tipo,$Nivel,$Fase,$NumEnfrentamiento,$parejasOrdenadas[5],NULL,NULL,NULL,'0');
				$mensaje = $ENFRENELIMINATORIA->ADD();
				$NumEnfrentamiento = $NumEnfrentamiento + 1;
	
				$ELIMINATORIA = new ELIMINATORIA_MODEL($IdCampeonato,$Tipo,$Nivel,$Fase,$NumEnfrentamiento,NULL,NULL,NULL,NULL,'0');
				$mensaje = $ELIMINATORIA->ADD();
				$ENFRENELIMINATORIA = new ENFRENELIMINATORIA_MODEL($IdCampeonato,$Tipo,$Nivel,$Fase,$NumEnfrentamiento,$parejasOrdenadas[3],NULL,NULL,NULL,'0');
				$mensaje = $ENFRENELIMINATORIA->ADD();
				$ENFRENELIMINATORIA = new ENFRENELIMINATORIA_MODEL($IdCampeonato,$Tipo,$Nivel,$Fase,$NumEnfrentamiento,$parejasOrdenadas[4],NULL,NULL,NULL,'0');
				$mensaje = $ENFRENELIMINATORIA->ADD();


			}		
	
//saber como escoger los que pasan
if($numGrupos == 7){
				
				$enfrentamientos = array();
				for($i = 0; $i < $numGrupos; $i++){

					
					if($i == 0) $Letra = 'A';
					else if($i == 1) $Letra = 'B';
					else if($i == 2) $Letra = 'C';
					else if($i == 3) $Letra = 'D';
					else if($i == 4) $Letra = 'E';
					else if($i == 5) $Letra = 'F';
					else if($i == 6) $Letra = 'G';

					$GRUPO2= new GRUPO_MODEL($IdCampeonato, $Tipo,$Nivel,$Letra);
					$listaClasificacion = $GRUPO2 ->Clasif();
					
					//Construyo el array
					$numParejas = 0;
					$parejas = array();
					$puntos= array();
					while ( $fila = mysqli_fetch_array( $listaClasificacion ) ) {		
						$parejas[$numParejas] = $fila['NumPareja'];
						$puntos[$numParejas] = $fila['Puntos'];

						$numParejas++;
					}
					
					
					$pareja = $parejas[0];					
											
					$puntuacion = $puntos[0];
					
					$enfrentamientos [$pareja ] =  $puntuacion ;
					
				}				
			
		/*
				foreach($enfrentamientos as $pa => $pu)
				{
				echo "La pareja " . $pa . " tiene de puntuacion " . $pu;
				echo "<br>";
				}*/
				//asort |arsort
				arsort($enfrentamientos);

				$parejasOrdenadas = array();
				$aux = 0;
				foreach($enfrentamientos as $pa => $pu)
				{
					/*
					echo "La pareja " . $pa . " tiene de puntuacion " . $pu;
					echo "<br>";*/
					$parejasOrdenadas[$aux] = $pa;
					//echo $pa;
					$aux++;

				}

				echo $parejasOrdenadas[0] . "-" . $parejasOrdenadas[7];echo "<br>";
				echo $parejasOrdenadas[1] . "-" . $parejasOrdenadas[6];echo "<br>";
				echo $parejasOrdenadas[2] . "-" . $parejasOrdenadas[5];echo "<br>";
				echo $parejasOrdenadas[3] . "-" . $parejasOrdenadas[4];echo "<br>";


				$NumEnfrentamiento = 1;
	
				$ELIMINATORIA = new ELIMINATORIA_MODEL($IdCampeonato,$Tipo,$Nivel,$Fase,$NumEnfrentamiento,NULL,NULL,NULL,NULL,'0');
				$mensaje = $ELIMINATORIA->ADD();
				$ENFRENELIMINATORIA = new ENFRENELIMINATORIA_MODEL($IdCampeonato,$Tipo,$Nivel,$Fase,$NumEnfrentamiento,$parejasOrdenadas[0],NULL,NULL,NULL,'0');
				$mensaje = $ENFRENELIMINATORIA->ADD();
				$ENFRENELIMINATORIA = new ENFRENELIMINATORIA_MODEL($IdCampeonato,$Tipo,$Nivel,$Fase,$NumEnfrentamiento,$parejasOrdenadas[7],NULL,NULL,NULL,'0');
				$mensaje = $ENFRENELIMINATORIA->ADD();
				$NumEnfrentamiento = $NumEnfrentamiento + 1;

				$ELIMINATORIA = new ELIMINATORIA_MODEL($IdCampeonato,$Tipo,$Nivel,$Fase,$NumEnfrentamiento,NULL,NULL,NULL,NULL,'0');
				$mensaje = $ELIMINATORIA->ADD();
				$ENFRENELIMINATORIA = new ENFRENELIMINATORIA_MODEL($IdCampeonato,$Tipo,$Nivel,$Fase,$NumEnfrentamiento,$parejasOrdenadas[1],NULL,NULL,NULL,'0');
				$mensaje = $ENFRENELIMINATORIA->ADD();
				$ENFRENELIMINATORIA = new ENFRENELIMINATORIA_MODEL($IdCampeonato,$Tipo,$Nivel,$Fase,$NumEnfrentamiento,$parejasOrdenadas[6],NULL,NULL,NULL,'0');
				$mensaje = $ENFRENELIMINATORIA->ADD();
				$NumEnfrentamiento = $NumEnfrentamiento + 1;
	
				$ELIMINATORIA = new ELIMINATORIA_MODEL($IdCampeonato,$Tipo,$Nivel,$Fase,$NumEnfrentamiento,NULL,NULL,NULL,NULL,'0');
				$mensaje = $ELIMINATORIA->ADD();
				$ENFRENELIMINATORIA = new ENFRENELIMINATORIA_MODEL($IdCampeonato,$Tipo,$Nivel,$Fase,$NumEnfrentamiento,$parejasOrdenadas[2],NULL,NULL,NULL,'0');
				$mensaje = $ENFRENELIMINATORIA->ADD();
				$ENFRENELIMINATORIA = new ENFRENELIMINATORIA_MODEL($IdCampeonato,$Tipo,$Nivel,$Fase,$NumEnfrentamiento,$parejasOrdenadas[5],NULL,NULL,NULL,'0');
				$mensaje = $ENFRENELIMINATORIA->ADD();
				$NumEnfrentamiento = $NumEnfrentamiento + 1;
	
				$ELIMINATORIA = new ELIMINATORIA_MODEL($IdCampeonato,$Tipo,$Nivel,$Fase,$NumEnfrentamiento,NULL,NULL,NULL,NULL,'0');
				$mensaje = $ELIMINATORIA->ADD();
				$ENFRENELIMINATORIA = new ENFRENELIMINATORIA_MODEL($IdCampeonato,$Tipo,$Nivel,$Fase,$NumEnfrentamiento,$parejasOrdenadas[3],NULL,NULL,NULL,'0');
				$mensaje = $ENFRENELIMINATORIA->ADD();
				$ENFRENELIMINATORIA = new ENFRENELIMINATORIA_MODEL($IdCampeonato,$Tipo,$Nivel,$Fase,$NumEnfrentamiento,$parejasOrdenadas[4],NULL,NULL,NULL,'0');
				$mensaje = $ENFRENELIMINATORIA->ADD();
			}		
//saber como escoger los que pasan
if($numGrupos == 6){
				
				$enfrentamientos = array();
				for($i = 0; $i < $numGrupos; $i++){

					
					if($i == 0) $Letra = 'A';
					else if($i == 1) $Letra = 'B';
					else if($i == 2) $Letra = 'C';
					else if($i == 3) $Letra = 'D';
					else if($i == 4) $Letra = 'E';
					else if($i == 5) $Letra = 'F';

					$GRUPO2= new GRUPO_MODEL($IdCampeonato, $Tipo,$Nivel,$Letra);
					$listaClasificacion = $GRUPO2 ->Clasif();
					
					//Construyo el array
					$numParejas = 0;
					$parejas = array();
					$puntos= array();
					while ( $fila = mysqli_fetch_array( $listaClasificacion ) ) {		
						$parejas[$numParejas] = $fila['NumPareja'];
						$puntos[$numParejas] = $fila['Puntos'];

						$numParejas++;
					}
					
					
					$pareja = $parejas[0];					
											
					$puntuacion = $puntos[0];
					
					$enfrentamientos [$pareja ] =  $puntuacion ;
					
				}				
			
		/*
				foreach($enfrentamientos as $pa => $pu)
				{
				echo "La pareja " . $pa . " tiene de puntuacion " . $pu;
				echo "<br>";
				}*/
				//asort |arsort
				arsort($enfrentamientos);

				$parejasOrdenadas = array();
				$aux = 0;
				foreach($enfrentamientos as $pa => $pu)
				{
					/*
					echo "La pareja " . $pa . " tiene de puntuacion " . $pu;
					echo "<br>";*/
					$parejasOrdenadas[$aux] = $pa;
					//echo $pa;
					$aux++;

				}

				echo $parejasOrdenadas[0] . "-" . $parejasOrdenadas[7];echo "<br>";
				echo $parejasOrdenadas[1] . "-" . $parejasOrdenadas[6];echo "<br>";
				echo $parejasOrdenadas[2] . "-" . $parejasOrdenadas[5];echo "<br>";
				echo $parejasOrdenadas[3] . "-" . $parejasOrdenadas[4];echo "<br>";


				$NumEnfrentamiento = 1;
	
				$ELIMINATORIA = new ELIMINATORIA_MODEL($IdCampeonato,$Tipo,$Nivel,$Fase,$NumEnfrentamiento,NULL,NULL,NULL,NULL,'0');
				$mensaje = $ELIMINATORIA->ADD();
				$ENFRENELIMINATORIA = new ENFRENELIMINATORIA_MODEL($IdCampeonato,$Tipo,$Nivel,$Fase,$NumEnfrentamiento,$parejasOrdenadas[0],NULL,NULL,NULL,'0');
				$mensaje = $ENFRENELIMINATORIA->ADD();
				$ENFRENELIMINATORIA = new ENFRENELIMINATORIA_MODEL($IdCampeonato,$Tipo,$Nivel,$Fase,$NumEnfrentamiento,$parejasOrdenadas[7],NULL,NULL,NULL,'0');
				$mensaje = $ENFRENELIMINATORIA->ADD();
				$NumEnfrentamiento = $NumEnfrentamiento + 1;

				$ELIMINATORIA = new ELIMINATORIA_MODEL($IdCampeonato,$Tipo,$Nivel,$Fase,$NumEnfrentamiento,NULL,NULL,NULL,NULL,'0');
				$mensaje = $ELIMINATORIA->ADD();
				$ENFRENELIMINATORIA = new ENFRENELIMINATORIA_MODEL($IdCampeonato,$Tipo,$Nivel,$Fase,$NumEnfrentamiento,$parejasOrdenadas[1],NULL,NULL,NULL,'0');
				$mensaje = $ENFRENELIMINATORIA->ADD();
				$ENFRENELIMINATORIA = new ENFRENELIMINATORIA_MODEL($IdCampeonato,$Tipo,$Nivel,$Fase,$NumEnfrentamiento,$parejasOrdenadas[6],NULL,NULL,NULL,'0');
				$mensaje = $ENFRENELIMINATORIA->ADD();
				$NumEnfrentamiento = $NumEnfrentamiento + 1;
	
				$ELIMINATORIA = new ELIMINATORIA_MODEL($IdCampeonato,$Tipo,$Nivel,$Fase,$NumEnfrentamiento,NULL,NULL,NULL,NULL,'0');
				$mensaje = $ELIMINATORIA->ADD();
				$ENFRENELIMINATORIA = new ENFRENELIMINATORIA_MODEL($IdCampeonato,$Tipo,$Nivel,$Fase,$NumEnfrentamiento,$parejasOrdenadas[2],NULL,NULL,NULL,'0');
				$mensaje = $ENFRENELIMINATORIA->ADD();
				$ENFRENELIMINATORIA = new ENFRENELIMINATORIA_MODEL($IdCampeonato,$Tipo,$Nivel,$Fase,$NumEnfrentamiento,$parejasOrdenadas[5],NULL,NULL,NULL,'0');
				$mensaje = $ENFRENELIMINATORIA->ADD();
				$NumEnfrentamiento = $NumEnfrentamiento + 1;
	
				$ELIMINATORIA = new ELIMINATORIA_MODEL($IdCampeonato,$Tipo,$Nivel,$Fase,$NumEnfrentamiento,NULL,NULL,NULL,NULL,'0');
				$mensaje = $ELIMINATORIA->ADD();
				$ENFRENELIMINATORIA = new ENFRENELIMINATORIA_MODEL($IdCampeonato,$Tipo,$Nivel,$Fase,$NumEnfrentamiento,$parejasOrdenadas[3],NULL,NULL,NULL,'0');
				$mensaje = $ENFRENELIMINATORIA->ADD();
				$ENFRENELIMINATORIA = new ENFRENELIMINATORIA_MODEL($IdCampeonato,$Tipo,$Nivel,$Fase,$NumEnfrentamiento,$parejasOrdenadas[4],NULL,NULL,NULL,'0');
				$mensaje = $ENFRENELIMINATORIA->ADD();

			}
//saber como escoger los que pasan			
if($numGrupos == 5){
				
				$enfrentamientos = array();
				for($i = 0; $i < $numGrupos; $i++){

					
					if($i == 0) $Letra = 'A';
					else if($i == 1) $Letra = 'B';
					else if($i == 2) $Letra = 'C';
					else if($i == 3) $Letra = 'D';
					else if($i == 4) $Letra = 'E';


					$GRUPO2= new GRUPO_MODEL($IdCampeonato, $Tipo,$Nivel,$Letra);
					$listaClasificacion = $GRUPO2 ->Clasif();
					
					//Construyo el array
					$numParejas = 0;
					$parejas = array();
					$puntos= array();
					while ( $fila = mysqli_fetch_array( $listaClasificacion ) ) {		
						$parejas[$numParejas] = $fila['NumPareja'];
						$puntos[$numParejas] = $fila['Puntos'];

						$numParejas++;
					}
					
					
					$pareja = $parejas[0];					
											
					$puntuacion = $puntos[0];
					
					$enfrentamientos [$pareja ] =  $puntuacion ;
					
				}				
			
		/*
				foreach($enfrentamientos as $pa => $pu)
				{
				echo "La pareja " . $pa . " tiene de puntuacion " . $pu;
				echo "<br>";
				}*/
				//asort |arsort
				arsort($enfrentamientos);

				$parejasOrdenadas = array();
				$aux = 0;
				foreach($enfrentamientos as $pa => $pu)
				{
					/*
					echo "La pareja " . $pa . " tiene de puntuacion " . $pu;
					echo "<br>";*/
					$parejasOrdenadas[$aux] = $pa;
					//echo $pa;
					$aux++;

				}

				echo $parejasOrdenadas[0] . "-" . $parejasOrdenadas[7];echo "<br>";
				echo $parejasOrdenadas[1] . "-" . $parejasOrdenadas[6];echo "<br>";
				echo $parejasOrdenadas[2] . "-" . $parejasOrdenadas[5];echo "<br>";
				echo $parejasOrdenadas[3] . "-" . $parejasOrdenadas[4];echo "<br>";


				$NumEnfrentamiento = 1;
	
				$ELIMINATORIA = new ELIMINATORIA_MODEL($IdCampeonato,$Tipo,$Nivel,$Fase,$NumEnfrentamiento,NULL,NULL,NULL,NULL,'0');
				$mensaje = $ELIMINATORIA->ADD();
				$ENFRENELIMINATORIA = new ENFRENELIMINATORIA_MODEL($IdCampeonato,$Tipo,$Nivel,$Fase,$NumEnfrentamiento,$parejasOrdenadas[0],NULL,NULL,NULL,'0');
				$mensaje = $ENFRENELIMINATORIA->ADD();
				$ENFRENELIMINATORIA = new ENFRENELIMINATORIA_MODEL($IdCampeonato,$Tipo,$Nivel,$Fase,$NumEnfrentamiento,$parejasOrdenadas[7],NULL,NULL,NULL,'0');
				$mensaje = $ENFRENELIMINATORIA->ADD();
				$NumEnfrentamiento = $NumEnfrentamiento + 1;

				$ELIMINATORIA = new ELIMINATORIA_MODEL($IdCampeonato,$Tipo,$Nivel,$Fase,$NumEnfrentamiento,NULL,NULL,NULL,NULL,'0');
				$mensaje = $ELIMINATORIA->ADD();
				$ENFRENELIMINATORIA = new ENFRENELIMINATORIA_MODEL($IdCampeonato,$Tipo,$Nivel,$Fase,$NumEnfrentamiento,$parejasOrdenadas[1],NULL,NULL,NULL,'0');
				$mensaje = $ENFRENELIMINATORIA->ADD();
				$ENFRENELIMINATORIA = new ENFRENELIMINATORIA_MODEL($IdCampeonato,$Tipo,$Nivel,$Fase,$NumEnfrentamiento,$parejasOrdenadas[6],NULL,NULL,NULL,'0');
				$mensaje = $ENFRENELIMINATORIA->ADD();
				$NumEnfrentamiento = $NumEnfrentamiento + 1;
	
				$ELIMINATORIA = new ELIMINATORIA_MODEL($IdCampeonato,$Tipo,$Nivel,$Fase,$NumEnfrentamiento,NULL,NULL,NULL,NULL,'0');
				$mensaje = $ELIMINATORIA->ADD();
				$ENFRENELIMINATORIA = new ENFRENELIMINATORIA_MODEL($IdCampeonato,$Tipo,$Nivel,$Fase,$NumEnfrentamiento,$parejasOrdenadas[2],NULL,NULL,NULL,'0');
				$mensaje = $ENFRENELIMINATORIA->ADD();
				$ENFRENELIMINATORIA = new ENFRENELIMINATORIA_MODEL($IdCampeonato,$Tipo,$Nivel,$Fase,$NumEnfrentamiento,$parejasOrdenadas[5],NULL,NULL,NULL,'0');
				$mensaje = $ENFRENELIMINATORIA->ADD();
				$NumEnfrentamiento = $NumEnfrentamiento + 1;
	
				$ELIMINATORIA = new ELIMINATORIA_MODEL($IdCampeonato,$Tipo,$Nivel,$Fase,$NumEnfrentamiento,NULL,NULL,NULL,NULL,'0');
				$mensaje = $ELIMINATORIA->ADD();
				$ENFRENELIMINATORIA = new ENFRENELIMINATORIA_MODEL($IdCampeonato,$Tipo,$Nivel,$Fase,$NumEnfrentamiento,$parejasOrdenadas[3],NULL,NULL,NULL,'0');
				$mensaje = $ENFRENELIMINATORIA->ADD();
				$ENFRENELIMINATORIA = new ENFRENELIMINATORIA_MODEL($IdCampeonato,$Tipo,$Nivel,$Fase,$NumEnfrentamiento,$parejasOrdenadas[4],NULL,NULL,NULL,'0');
				$mensaje = $ENFRENELIMINATORIA->ADD();

			}	
if($numGrupos == 4){
				
				$enfrentamientos = array();
				for($i = 0; $i < $numGrupos; $i++){

					
					if($i == 0) $Letra = 'A';
					else if($i == 1) $Letra = 'B';
					else if($i == 2) $Letra = 'C';
					else if($i == 3) $Letra = 'D';


					$GRUPO2= new GRUPO_MODEL($IdCampeonato, $Tipo,$Nivel,$Letra);
					$listaClasificacion = $GRUPO2 ->Clasif();
					
					//Construyo el array
					$numParejas = 0;
					$parejas = array();
					$puntos= array();
					while ( $fila = mysqli_fetch_array( $listaClasificacion ) ) {		
						$parejas[$numParejas] = $fila['NumPareja'];
						$puntos[$numParejas] = $fila['Puntos'];

						$numParejas++;
					}
					
					
					$pareja = $parejas[0];															
					$puntuacion = $puntos[0];
					$enfrentamientos [$pareja ] =  $puntuacion ;
					$pareja = $parejas[1];															
					$puntuacion = $puntos[1];
					$enfrentamientos [$pareja ] =  $puntuacion ;
					
				}				
			
		/*
				foreach($enfrentamientos as $pa => $pu)
				{
				echo "La pareja " . $pa . " tiene de puntuacion " . $pu;
				echo "<br>";
				}*/
				//asort |arsort
				arsort($enfrentamientos);

				$parejasOrdenadas = array();
				$aux = 0;
				foreach($enfrentamientos as $pa => $pu)
				{
					/*
					echo "La pareja " . $pa . " tiene de puntuacion " . $pu;
					echo "<br>";*/
					$parejasOrdenadas[$aux] = $pa;
					//echo $pa;
					$aux++;

				}

				echo $parejasOrdenadas[0] . "-" . $parejasOrdenadas[7];echo "<br>";
				echo $parejasOrdenadas[1] . "-" . $parejasOrdenadas[6];echo "<br>";
				echo $parejasOrdenadas[2] . "-" . $parejasOrdenadas[5];echo "<br>";
				echo $parejasOrdenadas[3] . "-" . $parejasOrdenadas[4];echo "<br>";


				$NumEnfrentamiento = 1;
	
				$ELIMINATORIA = new ELIMINATORIA_MODEL($IdCampeonato,$Tipo,$Nivel,$Fase,$NumEnfrentamiento,NULL,NULL,NULL,NULL,'0');
				$mensaje = $ELIMINATORIA->ADD();
				$ENFRENELIMINATORIA = new ENFRENELIMINATORIA_MODEL($IdCampeonato,$Tipo,$Nivel,$Fase,$NumEnfrentamiento,$parejasOrdenadas[0],NULL,NULL,NULL,'0');
				$mensaje = $ENFRENELIMINATORIA->ADD();
				$ENFRENELIMINATORIA = new ENFRENELIMINATORIA_MODEL($IdCampeonato,$Tipo,$Nivel,$Fase,$NumEnfrentamiento,$parejasOrdenadas[7],NULL,NULL,NULL,'0');
				$mensaje = $ENFRENELIMINATORIA->ADD();
				$NumEnfrentamiento = $NumEnfrentamiento + 1;

				$ELIMINATORIA = new ELIMINATORIA_MODEL($IdCampeonato,$Tipo,$Nivel,$Fase,$NumEnfrentamiento,NULL,NULL,NULL,NULL,'0');
				$mensaje = $ELIMINATORIA->ADD();
				$ENFRENELIMINATORIA = new ENFRENELIMINATORIA_MODEL($IdCampeonato,$Tipo,$Nivel,$Fase,$NumEnfrentamiento,$parejasOrdenadas[1],NULL,NULL,NULL,'0');
				$mensaje = $ENFRENELIMINATORIA->ADD();
				$ENFRENELIMINATORIA = new ENFRENELIMINATORIA_MODEL($IdCampeonato,$Tipo,$Nivel,$Fase,$NumEnfrentamiento,$parejasOrdenadas[6],NULL,NULL,NULL,'0');
				$mensaje = $ENFRENELIMINATORIA->ADD();
				$NumEnfrentamiento = $NumEnfrentamiento + 1;
	
				$ELIMINATORIA = new ELIMINATORIA_MODEL($IdCampeonato,$Tipo,$Nivel,$Fase,$NumEnfrentamiento,NULL,NULL,NULL,NULL,'0');
				$mensaje = $ELIMINATORIA->ADD();
				$ENFRENELIMINATORIA = new ENFRENELIMINATORIA_MODEL($IdCampeonato,$Tipo,$Nivel,$Fase,$NumEnfrentamiento,$parejasOrdenadas[2],NULL,NULL,NULL,'0');
				$mensaje = $ENFRENELIMINATORIA->ADD();
				$ENFRENELIMINATORIA = new ENFRENELIMINATORIA_MODEL($IdCampeonato,$Tipo,$Nivel,$Fase,$NumEnfrentamiento,$parejasOrdenadas[5],NULL,NULL,NULL,'0');
				$mensaje = $ENFRENELIMINATORIA->ADD();
				$NumEnfrentamiento = $NumEnfrentamiento + 1;
	
				$ELIMINATORIA = new ELIMINATORIA_MODEL($IdCampeonato,$Tipo,$Nivel,$Fase,$NumEnfrentamiento,NULL,NULL,NULL,NULL,'0');
				$mensaje = $ELIMINATORIA->ADD();
				$ENFRENELIMINATORIA = new ENFRENELIMINATORIA_MODEL($IdCampeonato,$Tipo,$Nivel,$Fase,$NumEnfrentamiento,$parejasOrdenadas[3],NULL,NULL,NULL,'0');
				$mensaje = $ENFRENELIMINATORIA->ADD();
				$ENFRENELIMINATORIA = new ENFRENELIMINATORIA_MODEL($IdCampeonato,$Tipo,$Nivel,$Fase,$NumEnfrentamiento,$parejasOrdenadas[4],NULL,NULL,NULL,'0');
				$mensaje = $ENFRENELIMINATORIA->ADD();

			}	
//saber como escoger los que pasan
if($numGrupos == 3){
				
				$enfrentamientos = array();
				for($i = 0; $i < $numGrupos; $i++){

					
					if($i == 0) $Letra = 'A';
					else if($i == 1) $Letra = 'B';
					else if($i == 2) $Letra = 'C';


					$GRUPO2= new GRUPO_MODEL($IdCampeonato, $Tipo,$Nivel,$Letra);
					$listaClasificacion = $GRUPO2 ->Clasif();
					
					//Construyo el array
					$numParejas = 0;
					$parejas = array();
					$puntos= array();
					while ( $fila = mysqli_fetch_array( $listaClasificacion ) ) {		
						$parejas[$numParejas] = $fila['NumPareja'];
						$puntos[$numParejas] = $fila['Puntos'];

						$numParejas++;
					}
					
					
					$pareja = $parejas[0];					
											
					$puntuacion = $puntos[0];
					
					$enfrentamientos [$pareja ] =  $puntuacion ;
					
				}				
			
		/*
				foreach($enfrentamientos as $pa => $pu)
				{
				echo "La pareja " . $pa . " tiene de puntuacion " . $pu;
				echo "<br>";
				}*/
				//asort |arsort
				arsort($enfrentamientos);

				$parejasOrdenadas = array();
				$aux = 0;
				foreach($enfrentamientos as $pa => $pu)
				{
					/*
					echo "La pareja " . $pa . " tiene de puntuacion " . $pu;
					echo "<br>";*/
					$parejasOrdenadas[$aux] = $pa;
					//echo $pa;
					$aux++;

				}

				echo $parejasOrdenadas[0] . "-" . $parejasOrdenadas[7];echo "<br>";
				echo $parejasOrdenadas[1] . "-" . $parejasOrdenadas[6];echo "<br>";
				echo $parejasOrdenadas[2] . "-" . $parejasOrdenadas[5];echo "<br>";
				echo $parejasOrdenadas[3] . "-" . $parejasOrdenadas[4];echo "<br>";


				$NumEnfrentamiento = 1;
	
				$ELIMINATORIA = new ELIMINATORIA_MODEL($IdCampeonato,$Tipo,$Nivel,$Fase,$NumEnfrentamiento,NULL,NULL,NULL,NULL,'0');
				$mensaje = $ELIMINATORIA->ADD();
				$ENFRENELIMINATORIA = new ENFRENELIMINATORIA_MODEL($IdCampeonato,$Tipo,$Nivel,$Fase,$NumEnfrentamiento,$parejasOrdenadas[0],NULL,NULL,NULL,'0');
				$mensaje = $ENFRENELIMINATORIA->ADD();
				$ENFRENELIMINATORIA = new ENFRENELIMINATORIA_MODEL($IdCampeonato,$Tipo,$Nivel,$Fase,$NumEnfrentamiento,$parejasOrdenadas[7],NULL,NULL,NULL,'0');
				$mensaje = $ENFRENELIMINATORIA->ADD();
				$NumEnfrentamiento = $NumEnfrentamiento + 1;

				$ELIMINATORIA = new ELIMINATORIA_MODEL($IdCampeonato,$Tipo,$Nivel,$Fase,$NumEnfrentamiento,NULL,NULL,NULL,NULL,'0');
				$mensaje = $ELIMINATORIA->ADD();
				$ENFRENELIMINATORIA = new ENFRENELIMINATORIA_MODEL($IdCampeonato,$Tipo,$Nivel,$Fase,$NumEnfrentamiento,$parejasOrdenadas[1],NULL,NULL,NULL,'0');
				$mensaje = $ENFRENELIMINATORIA->ADD();
				$ENFRENELIMINATORIA = new ENFRENELIMINATORIA_MODEL($IdCampeonato,$Tipo,$Nivel,$Fase,$NumEnfrentamiento,$parejasOrdenadas[6],NULL,NULL,NULL,'0');
				$mensaje = $ENFRENELIMINATORIA->ADD();
				$NumEnfrentamiento = $NumEnfrentamiento + 1;
	
				$ELIMINATORIA = new ELIMINATORIA_MODEL($IdCampeonato,$Tipo,$Nivel,$Fase,$NumEnfrentamiento,NULL,NULL,NULL,NULL,'0');
				$mensaje = $ELIMINATORIA->ADD();
				$ENFRENELIMINATORIA = new ENFRENELIMINATORIA_MODEL($IdCampeonato,$Tipo,$Nivel,$Fase,$NumEnfrentamiento,$parejasOrdenadas[2],NULL,NULL,NULL,'0');
				$mensaje = $ENFRENELIMINATORIA->ADD();
				$ENFRENELIMINATORIA = new ENFRENELIMINATORIA_MODEL($IdCampeonato,$Tipo,$Nivel,$Fase,$NumEnfrentamiento,$parejasOrdenadas[5],NULL,NULL,NULL,'0');
				$mensaje = $ENFRENELIMINATORIA->ADD();
				$NumEnfrentamiento = $NumEnfrentamiento + 1;
	
				$ELIMINATORIA = new ELIMINATORIA_MODEL($IdCampeonato,$Tipo,$Nivel,$Fase,$NumEnfrentamiento,NULL,NULL,NULL,NULL,'0');
				$mensaje = $ELIMINATORIA->ADD();
				$ENFRENELIMINATORIA = new ENFRENELIMINATORIA_MODEL($IdCampeonato,$Tipo,$Nivel,$Fase,$NumEnfrentamiento,$parejasOrdenadas[3],NULL,NULL,NULL,'0');
				$mensaje = $ENFRENELIMINATORIA->ADD();
				$ENFRENELIMINATORIA = new ENFRENELIMINATORIA_MODEL($IdCampeonato,$Tipo,$Nivel,$Fase,$NumEnfrentamiento,$parejasOrdenadas[4],NULL,NULL,NULL,'0');
				$mensaje = $ENFRENELIMINATORIA->ADD();

			}		
if($numGrupos == 2){
				
				$enfrentamientos = array();
				for($i = 0; $i < $numGrupos; $i++){

					
					if($i == 0) $Letra = 'A';
					else if($i == 1) $Letra = 'B';

					$GRUPO2= new GRUPO_MODEL($IdCampeonato, $Tipo,$Nivel,$Letra);
					$listaClasificacion = $GRUPO2 ->Clasif();
					
					//Construyo el array
					$numParejas = 0;
					$parejas = array();
					$puntos= array();
					while ( $fila = mysqli_fetch_array( $listaClasificacion ) ) {		
						$parejas[$numParejas] = $fila['NumPareja'];
						$puntos[$numParejas] = $fila['Puntos'];

						$numParejas++;
					}
					
					
					$pareja = $parejas[0];										
					$puntuacion = $puntos[0];					
					$enfrentamientos [$pareja ] =  $puntuacion ;

					$pareja = $parejas[1];										
					$puntuacion = $puntos[1];					
					$enfrentamientos [$pareja ] =  $puntuacion ;

					$pareja = $parejas[2];										
					$puntuacion = $puntos[2];					
					$enfrentamientos [$pareja ] =  $puntuacion ;
					
					$pareja = $parejas[3];										
					$puntuacion = $puntos[3];					
					$enfrentamientos [$pareja ] =  $puntuacion ;
					
				}				
			
		/*
				foreach($enfrentamientos as $pa => $pu)
				{
				echo "La pareja " . $pa . " tiene de puntuacion " . $pu;
				echo "<br>";
				}*/
				//asort |arsort
				arsort($enfrentamientos);

				$parejasOrdenadas = array();
				$aux = 0;
				foreach($enfrentamientos as $pa => $pu)
				{
					/*
					echo "La pareja " . $pa . " tiene de puntuacion " . $pu;
					echo "<br>";*/
					$parejasOrdenadas[$aux] = $pa;
					//echo $pa;
					$aux++;

				}

				echo $parejasOrdenadas[0] . "-" . $parejasOrdenadas[7];echo "<br>";
				echo $parejasOrdenadas[1] . "-" . $parejasOrdenadas[6];echo "<br>";
				echo $parejasOrdenadas[2] . "-" . $parejasOrdenadas[5];echo "<br>";
				echo $parejasOrdenadas[3] . "-" . $parejasOrdenadas[4];echo "<br>";


				$NumEnfrentamiento = 1;
	
				$ELIMINATORIA = new ELIMINATORIA_MODEL($IdCampeonato,$Tipo,$Nivel,$Fase,$NumEnfrentamiento,NULL,NULL,NULL,NULL,'0');
				$mensaje = $ELIMINATORIA->ADD();
				$ENFRENELIMINATORIA = new ENFRENELIMINATORIA_MODEL($IdCampeonato,$Tipo,$Nivel,$Fase,$NumEnfrentamiento,$parejasOrdenadas[0],NULL,NULL,NULL,'0');
				$mensaje = $ENFRENELIMINATORIA->ADD();
				$ENFRENELIMINATORIA = new ENFRENELIMINATORIA_MODEL($IdCampeonato,$Tipo,$Nivel,$Fase,$NumEnfrentamiento,$parejasOrdenadas[7],NULL,NULL,NULL,'0');
				$mensaje = $ENFRENELIMINATORIA->ADD();
				$NumEnfrentamiento = $NumEnfrentamiento + 1;

				$ELIMINATORIA = new ELIMINATORIA_MODEL($IdCampeonato,$Tipo,$Nivel,$Fase,$NumEnfrentamiento,NULL,NULL,NULL,NULL,'0');
				$mensaje = $ELIMINATORIA->ADD();
				$ENFRENELIMINATORIA = new ENFRENELIMINATORIA_MODEL($IdCampeonato,$Tipo,$Nivel,$Fase,$NumEnfrentamiento,$parejasOrdenadas[1],NULL,NULL,NULL,'0');
				$mensaje = $ENFRENELIMINATORIA->ADD();
				$ENFRENELIMINATORIA = new ENFRENELIMINATORIA_MODEL($IdCampeonato,$Tipo,$Nivel,$Fase,$NumEnfrentamiento,$parejasOrdenadas[6],NULL,NULL,NULL,'0');
				$mensaje = $ENFRENELIMINATORIA->ADD();
				$NumEnfrentamiento = $NumEnfrentamiento + 1;
	
				$ELIMINATORIA = new ELIMINATORIA_MODEL($IdCampeonato,$Tipo,$Nivel,$Fase,$NumEnfrentamiento,NULL,NULL,NULL,NULL,'0');
				$mensaje = $ELIMINATORIA->ADD();
				$ENFRENELIMINATORIA = new ENFRENELIMINATORIA_MODEL($IdCampeonato,$Tipo,$Nivel,$Fase,$NumEnfrentamiento,$parejasOrdenadas[2],NULL,NULL,NULL,'0');
				$mensaje = $ENFRENELIMINATORIA->ADD();
				$ENFRENELIMINATORIA = new ENFRENELIMINATORIA_MODEL($IdCampeonato,$Tipo,$Nivel,$Fase,$NumEnfrentamiento,$parejasOrdenadas[5],NULL,NULL,NULL,'0');
				$mensaje = $ENFRENELIMINATORIA->ADD();
				$NumEnfrentamiento = $NumEnfrentamiento + 1;
	
				$ELIMINATORIA = new ELIMINATORIA_MODEL($IdCampeonato,$Tipo,$Nivel,$Fase,$NumEnfrentamiento,NULL,NULL,NULL,NULL,'0');
				$mensaje = $ELIMINATORIA->ADD();
				$ENFRENELIMINATORIA = new ENFRENELIMINATORIA_MODEL($IdCampeonato,$Tipo,$Nivel,$Fase,$NumEnfrentamiento,$parejasOrdenadas[3],NULL,NULL,NULL,'0');
				$mensaje = $ENFRENELIMINATORIA->ADD();
				$ENFRENELIMINATORIA = new ENFRENELIMINATORIA_MODEL($IdCampeonato,$Tipo,$Nivel,$Fase,$NumEnfrentamiento,$parejasOrdenadas[4],NULL,NULL,NULL,'0');
				$mensaje = $ENFRENELIMINATORIA->ADD();

			}					
if($numGrupos == 1){
				
				$enfrentamientos = array();
			

					
					$Letra = 'A';


					$GRUPO2= new GRUPO_MODEL($IdCampeonato, $Tipo,$Nivel,$Letra);
					$listaClasificacion = $GRUPO2 ->Clasif();
					
					//Construyo el array
					$numParejas = 0;
					$parejas = array();
					$puntos= array();
					while ( $fila = mysqli_fetch_array( $listaClasificacion ) ) {		
						$parejas[$numParejas] = $fila['NumPareja'];
						$puntos[$numParejas] = $fila['Puntos'];

						$numParejas++;
					}
					
					
					$pareja = $parejas[0];														
					$puntuacion = $puntos[0];					
					$enfrentamientos [$pareja ] =  $puntuacion ;
					$pareja = $parejas[1];														
					$puntuacion = $puntos[1];					
					$enfrentamientos [$pareja ] =  $puntuacion ;
					$pareja = $parejas[2];														
					$puntuacion = $puntos[2];					
					$enfrentamientos [$pareja ] =  $puntuacion ;
					$pareja = $parejas[3];														
					$puntuacion = $puntos[3];					
					$enfrentamientos [$pareja ] =  $puntuacion ;
					$pareja = $parejas[4];														
					$puntuacion = $puntos[4];					
					$enfrentamientos [$pareja ] =  $puntuacion ;
					$pareja = $parejas[5];														
					$puntuacion = $puntos[5];					
					$enfrentamientos [$pareja ] =  $puntuacion ;
					$pareja = $parejas[6];														
					$puntuacion = $puntos[6];					
					$enfrentamientos [$pareja ] =  $puntuacion ;
					$pareja = $parejas[7];														
					$puntuacion = $puntos[7];					
					$enfrentamientos [$pareja ] =  $puntuacion ;
			
		/*
				foreach($enfrentamientos as $pa => $pu)
				{
				echo "La pareja " . $pa . " tiene de puntuacion " . $pu;
				echo "<br>";
				}*/
				//asort |arsort
				arsort($enfrentamientos);

				$parejasOrdenadas = array();
				$aux = 0;
				foreach($enfrentamientos as $pa => $pu)
				{
					/*
					echo "La pareja " . $pa . " tiene de puntuacion " . $pu;
					echo "<br>";*/
					$parejasOrdenadas[$aux] = $pa;
					//echo $pa;
					$aux++;

				}

				echo $parejasOrdenadas[0] . "-" . $parejasOrdenadas[7];echo "<br>";
				echo $parejasOrdenadas[1] . "-" . $parejasOrdenadas[6];echo "<br>";
				echo $parejasOrdenadas[2] . "-" . $parejasOrdenadas[5];echo "<br>";
				echo $parejasOrdenadas[3] . "-" . $parejasOrdenadas[4];echo "<br>";


				$NumEnfrentamiento = 1;
	
				$ELIMINATORIA = new ELIMINATORIA_MODEL($IdCampeonato,$Tipo,$Nivel,$Fase,$NumEnfrentamiento,NULL,NULL,NULL,NULL,'0');
				$mensaje = $ELIMINATORIA->ADD();
				$ENFRENELIMINATORIA = new ENFRENELIMINATORIA_MODEL($IdCampeonato,$Tipo,$Nivel,$Fase,$NumEnfrentamiento,$parejasOrdenadas[0],NULL,NULL,NULL,'0');
				$mensaje = $ENFRENELIMINATORIA->ADD();
				$ENFRENELIMINATORIA = new ENFRENELIMINATORIA_MODEL($IdCampeonato,$Tipo,$Nivel,$Fase,$NumEnfrentamiento,$parejasOrdenadas[7],NULL,NULL,NULL,'0');
				$mensaje = $ENFRENELIMINATORIA->ADD();
				$NumEnfrentamiento = $NumEnfrentamiento + 1;

				$ELIMINATORIA = new ELIMINATORIA_MODEL($IdCampeonato,$Tipo,$Nivel,$Fase,$NumEnfrentamiento,NULL,NULL,NULL,NULL,'0');
				$mensaje = $ELIMINATORIA->ADD();
				$ENFRENELIMINATORIA = new ENFRENELIMINATORIA_MODEL($IdCampeonato,$Tipo,$Nivel,$Fase,$NumEnfrentamiento,$parejasOrdenadas[1],NULL,NULL,NULL,'0');
				$mensaje = $ENFRENELIMINATORIA->ADD();
				$ENFRENELIMINATORIA = new ENFRENELIMINATORIA_MODEL($IdCampeonato,$Tipo,$Nivel,$Fase,$NumEnfrentamiento,$parejasOrdenadas[6],NULL,NULL,NULL,'0');
				$mensaje = $ENFRENELIMINATORIA->ADD();
				$NumEnfrentamiento = $NumEnfrentamiento + 1;
	
				$ELIMINATORIA = new ELIMINATORIA_MODEL($IdCampeonato,$Tipo,$Nivel,$Fase,$NumEnfrentamiento,NULL,NULL,NULL,NULL,'0');
				$mensaje = $ELIMINATORIA->ADD();
				$ENFRENELIMINATORIA = new ENFRENELIMINATORIA_MODEL($IdCampeonato,$Tipo,$Nivel,$Fase,$NumEnfrentamiento,$parejasOrdenadas[2],NULL,NULL,NULL,'0');
				$mensaje = $ENFRENELIMINATORIA->ADD();
				$ENFRENELIMINATORIA = new ENFRENELIMINATORIA_MODEL($IdCampeonato,$Tipo,$Nivel,$Fase,$NumEnfrentamiento,$parejasOrdenadas[5],NULL,NULL,NULL,'0');
				$mensaje = $ENFRENELIMINATORIA->ADD();
				$NumEnfrentamiento = $NumEnfrentamiento + 1;
	
				$ELIMINATORIA = new ELIMINATORIA_MODEL($IdCampeonato,$Tipo,$Nivel,$Fase,$NumEnfrentamiento,NULL,NULL,NULL,NULL,'0');
				$mensaje = $ELIMINATORIA->ADD();
				$ENFRENELIMINATORIA = new ENFRENELIMINATORIA_MODEL($IdCampeonato,$Tipo,$Nivel,$Fase,$NumEnfrentamiento,$parejasOrdenadas[3],NULL,NULL,NULL,'0');
				$mensaje = $ENFRENELIMINATORIA->ADD();
				$ENFRENELIMINATORIA = new ENFRENELIMINATORIA_MODEL($IdCampeonato,$Tipo,$Nivel,$Fase,$NumEnfrentamiento,$parejasOrdenadas[4],NULL,NULL,NULL,'0');
				$mensaje = $ENFRENELIMINATORIA->ADD();

			}			
		
							
			
		}else{  
			new MESSAGE( 'El usuario no tiene los permisos necesarios', '../Controllers/CAMPEONATO_CONTROLLER.php' );			
		}
	
		break;
	case "CUADRO":
		if($_SESSION['tipo'] == 'Admin'){


			
			//obtener
			//categoria,numPareja0,numPareja7,partido1,cuartos,resultado
			//categoria,numPareja1,numPareja6,partido2,cuartos,resultado
			//categoria,numPareja2,numPareja5,partido3,cuartos,resultado
			//categoria,numPareja3,numPareja4,partido4,cuartos,resultado
			$pareja0Cuartos = "pareja0Cuartos";
			$pareja1Cuartos = "pareja1Cuartos";
			$pareja2Cuartos = "pareja2Cuartos";
			$pareja3Cuartos = "pareja3Cuartos";
			$pareja4Cuartos = "pareja4Cuartos";
			$pareja5Cuartos = "pareja5Cuartos";
			$pareja6Cuartos = "pareja6Cuartos";
			$pareja7Cuartos = "pareja7Cuartos";
			
			$resulSet1Pareja0Cuartos =  "";
			$resulSet1Pareja7Cuartos ="";
			$resulSet2Pareja0Cuartos =  "";
			$resulSet2Pareja7Cuartos ="";
			$resulSet3Pareja0Cuartos =  "";
			$resulSet3Pareja7Cuartos ="";
				
			$resulSet1Pareja1Cuartos =  "";
			$resulSet1Pareja6Cuartos ="";
			$resulSet2Pareja1Cuartos =  "";
			$resulSet2Pareja6Cuartos ="";
			$resulSet3Pareja1Cuartos =  "";
			$resulSet3Pareja6Cuartos ="";

			$resulSet1Pareja2Cuartos =  "";
			$resulSet1Pareja5Cuartos ="";
			$resulSet2Pareja2Cuartos =  "";
			$resulSet2Pareja5Cuartos ="";
			$resulSet3Pareja2Cuartos =  "";
			$resulSet3Pareja5Cuartos =		"";		
				
			$resulSet1Pareja3Cuartos =  "";
			$resulSet1Pareja4Cuartos ="";
			$resulSet2Pareja3Cuartos =  "";
			$resulSet2Pareja4Cuartos ="";
			$resulSet3Pareja3Cuartos =  "";
			$resulSet3Pareja4Cuartos =		"";		
			
			//categoria,numPareja0,numPareja3,partido1,semis,resultado
			//categoria,numPareja1,numPareja2,partido2,semis,resultado
			$pareja0Semis = "pareja0Semis";
			$pareja1Semis = "pareja1Semis";
			$pareja2Semis = "pareja2Semis";
			$pareja3Semis = "pareja3Semis";
			
			
			$resulSet1Pareja0Semis =  "";
			$resulSet1Pareja3Semis ="";
			$resulSet2Pareja0Semis =  "";
			$resulSet2Pareja3Semis ="";
			$resulSet3Pareja0Semis =  "";
			$resulSet3Pareja3Semis ="";
				
			$resulSet1Pareja1Semis =  "";
			$resulSet1Pareja2Semis ="";
			$resulSet2Pareja1Semis=  "";
			$resulSet2Pareja2Semis ="";
			$resulSet3Pareja1Semis =  "";
			$resulSet3Pareja2Semis =	"";		
						
			
			//categoria,numPareja0,numPareja1,partido1,final,resultado
			$pareja0Final = "pareja0Final";
			$pareja1Final = "pareja1Final";
			
			$resulSet1Pareja0Final =  "";
			$resulSet1Pareja1Final ="";
			$resulSet2Pareja0Final =  "";
			$resulSet2Pareja1Final ="";
			$resulSet3Pareja0Final =  "";
			$resulSet3Pareja1Final ="";
							
			
			
			$vuelta['IdCampeonato'] = $_REQUEST['IdCampeonato'];
			new ELIMINATORIA_TABLA($vuelta,
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
		}else{
			new MESSAGE( 'El usuario no tiene los permisos necesarios', '../Controllers/CALENDARIO_CONTROLLER.php' );
		}
	
	break;

	default: 
		if($_SESSION['tipo'] == 'Admin'){
				if ( !$_POST ) {
					$CAMPEONATO = new CAMPEONATO_MODEL( '', '', '','','');						
				} else {
					$CAMPEONATO = get_data_form();
				}
				$datos = $CAMPEONATO->SEARCH();
				$lista = array( 'IdCampeonato','FechaIni','HoraIni','FechaFin','HoraFin');

				new CAMPEONATO_SHOWALL( $lista, $datos);

		}else{
			$NOTICIA = new NOTICIA_MODEL( '', '', '');
			$datos = $NOTICIA->SEARCH();
			new USUARIO_DEFAULT($datos);
		}
			
}

?>