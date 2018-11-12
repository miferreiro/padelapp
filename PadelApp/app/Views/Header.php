<?php

	include_once '../Functions/Authentication.php';//incluimos este fichero para mirar si el usuario esta auteneticado
	if (!isset($_SESSION['idioma'])) { //miramos si existe algún idioma
		$_SESSION['idioma'] = 'SPANISH';//si no existe ponemos por defecto el español

	}
	include '../Locales/Strings_' . $_SESSION['idioma'] . '.php';//incluimos todos los strings de los idiomas:ingles,español y galego
?>

<!doctype html>
<html lang="es">
  <head>
	<meta charset="UTF-8">
	<script type="text/javascript" src="../Views/js/md5.js"></script>
	<link rel="stylesheet" type="text/css" media="screen" href="../Views/css/bootstrap-4.0.0.css" hreflang="es">
	<link rel="stylesheet" type="text/css" media="screen" href="../Views/js/tcal/tcal.css" hreflang="es">
	<script language="JavaScript" type="text/javascript" src="../Views/js/tcal/tcal.js"></script>
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	  <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="../Views/js/jquery-3.2.1.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="../Views/js/popper.min.js"></script>
    <script src="../Views/js/bootstrap-4.0.0.js"></script>
	 <!-- Datables -->
	  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.css">
	  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css">
	  <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.js"></script>
	<!-- datepicker -->
		
		<link rel="stylesheet" href="http://code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
		 <script src="http://code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
	
	 <script type="text/javascript">	  
	$(document).ready( function () {
   	$('#mydatatablePistas').DataTable( {
		'pageLength': 7,
		'lengthMenu': [ 7, 14, 21, 28, 35, 42, 49, 56, 63, 70, "All" ],
			} );
		});
		</script>
	  
	  <script type="text/javascript">
	  $(document).ready( function () {
	$('#mydatatableUsuarios').DataTable( {
		'searching':false
				} );
		} );
	  </script>
	  <script>
	  $(document).ready(function(){
		  $('#mydatatableAddPromo').DataTable(
		  )
	  })
	  </script>
		<script>
	  $(document).ready(function (){
		  $('#mydatatableUsuAll').DataTable({
			  
		  })
	  });
	  
	  </script>
	  
	  <script>
	  $(document).ready(function() {		  
     $( ".datepicker" ).datepicker({
        dateFormat: "dd/mm/yy",
        showOn: "button",
        showAnim: 'slideDown',
        showButtonPanel: true ,
        autoSize: true,
        buttonImage: "//jqueryui.com/resources/demos/datepicker/images/calendar.gif",
        buttonImageOnly: true,
        buttonText: "Select date",
        closeText: "Clear",
		onSelect: function() {
			if ($('#mydatatablePistas') != null) {
				$('#mydatatablePistas').DataTable().search( $(this).val() ).draw();
			}
			if ($('#mydatatableAddPromo') != null) {
				$('#mydatatableAddPromo').DataTable().search( $(this).val() ).draw();
			}
		}
    });
    $(document).on("click", ".ui-datepicker-close", function(){
        $('.datepicker').val("");
        dataTable.columns(0).search("").draw();
    });
} );
	  
	  
	  </script>
	  
	  
	<?php include '../Views/js/validaciones.js' ?>
	  
	 
  </head>
  <body>
	  <header>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
      <div class="container">
		<?php	if (IsAuthenticated()){ //miramos si el usuario esta autenticado ?> 
		<p style="color: white"><?php 	echo $strings['Usuario'] . ' : ' . $_SESSION['login'] . ' como ' . $_SESSION['tipo'] . '<br>'; ?></p>
		   
			  
              <a class="nav-link disabled" href="../Functions/Desconectar.php" alt="<?php echo $strings['Desconectarse']?>"/>
              <img src="../Views/icon/desconectarse_big.png" width="32" height="32" alt="<?php echo $strings['Desconectarse']?>" style="float:right;">
               </a>
            
		  <?php
	} else { //si no esta autenticado se muestra en un mensaje indicandolo
		?>
		  
		  <p style="color: white"><?php
			echo $strings['Usuario no identificado'];
?></p>	  
		  <!--<font color="white">El usuario no está registrado</font> -->
		  
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
          <ul class="navbar-nav mr-auto">
            <li class="nav-item active">
				
				
            <a  class="nav-link" href="../Controllers/Login_Controller.php" /><?php echo $strings['Conectarse']?>
				<!--<span class="sr-only">(current)</span>--></a>
				
           </li>
           <li class="nav-item">
              <a class="nav-link" href="../Controllers/Registro_Controller.php"/><?php echo $strings['Registro']?></a>
           </li>
			  <li class="nav-item">
              <a class="nav-link disabled" href="../Controllers/DEFAULT_CONTROLLER.php"/><?php echo $strings['Atras']?></a>
            </li>
<?php		
	}
?>			


		<!-- Si hay un usuario logeado (Variable de sesion login con valor) ejecuta el código dento del if
que comprueba permisos para cada una de las acciones -->
	<?php if (isset($_SESSION['login']) & isset($_SESSION['tipo'])) { 
//Si el usuario tiene permisos de showall en gestión de usuarios se muestra la opción ?>
		<li class="nav-item dropdown" style="display: block">
			<a class="nav-link dropdown-toggle" style="color: white" href="<?php echo $strings['menuGestion']; ?>" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><?php echo $strings['menuGestion']; ?></a>
              <div class="dropdown-menu" aria-labelledby="navbarDropdown">
				<?php if($_SESSION['tipo'] == 'Admin'){ ?>
							<div class="dropdown-divider"></div>
								<button id ="buttonBien" type="submit"  name="usuarios"><a class="dropdown-item" href="../Controllers/USUARIO_CONTROLLER.php" /><?php echo $strings['Gestion de usuarios']?></a></button>
								  
				<?php }?>				
				<?php if (isset($_SESSION['login']) &  isset($_SESSION['tipo'])){?>
					<?php if($_SESSION['tipo'] == 'Admin'){ ?>
							<div class="dropdown-divider"></div>
	
								<button id ="buttonBien" type="submit"  name="promociones"><a class="dropdown-item"  href="../Controllers/PISTA_CONTROLLER.php" /><?php echo $strings['Gestión de pistas'] ?></a></button>
								
				<?php } } ?>
				<?php if (isset($_SESSION['login']) &  isset($_SESSION['tipo'])){?>
					<?php if($_SESSION['tipo'] == 'Deportista'){ ?>
							<div class="dropdown-divider"></div>
	
								<button id ="buttonBien" type="submit"  name="promociones"><a class="dropdown-item"  href="../Controllers/PISTA_CONTROLLER.php" /><?php echo $strings['Reservar pista'] ?></a></button>
								
				<?php } } ?>			
				<?php if (isset($_SESSION['login']) &  isset($_SESSION['tipo'])){?>
					<?php if($_SESSION['tipo'] == 'Admin'){ ?>
							<div class="dropdown-divider"></div>
	
								<button id ="buttonBien" type="submit"  name="promociones"><a class="dropdown-item"  href="../Controllers/PROM_CONTROLLER.php" /><?php echo $strings['Gestión de promociones'] ?></a></button>
								
				<?php } } ?>
				<?php if (isset($_SESSION['login']) &  isset($_SESSION['tipo'])){?>
					<?php if($_SESSION['tipo'] == 'Deportista'){ ?>
							<div class="dropdown-divider"></div>
	
								<button id ="buttonBien" type="submit"  name="promociones"><a class="dropdown-item"  href="../Controllers/PROM_CONTROLLER.php" /><?php echo $strings['Inscribirse en promoción'] ?></a></button>
								
				<?php } } ?>
				<?php if (isset($_SESSION['login']) &  isset($_SESSION['tipo'])){?>
					<?php if($_SESSION['tipo'] == 'Admin'){ ?>
							<div class="dropdown-divider"></div>

								<button id ="buttonBien" type="submit"  name="gesReservas"><a class="dropdown-item"  href="../Controllers/RESERVA_CONTROLLER.php" /><?php echo $strings['Gestión de reservas'] ?></a></button>

					<?php }  } ?>
				<?php if (isset($_SESSION['login']) & isset($_SESSION['tipo'])) { 
					//Si el usuario tiene permisos de showall en gestión de usuarios se muestra la opción ?>
					<?php if($_SESSION['tipo'] == 'Admin'){ ?>

							<div class="dropdown-divider"></div>

								<button id ="buttonBien" type="submit"  name="gesCampeonatos" ><a class="dropdown-item" href="../Controllers/CAMPEONATO_CONTROLLER.php"/><?php echo $strings['Gestión de campeonatos'] ?></a></button>
				<?php }} ?>
				
				
				
				<?php if (isset($_SESSION['login']) & isset($_SESSION['tipo'])) { 
					//Si el usuario tiene permisos de showall en gestión de usuarios se muestra la opción ?>
					<?php if($_SESSION['tipo'] == 'Deportista'){ ?>

							<div class="dropdown-divider"></div>

								<button id ="buttonBien" type="submit"  name="gesCalendario" ><a class="dropdown-item" href="../Controllers/CALENDARIO_CONTROLLER.php"/><?php echo $strings['Gestión de calendario'] ?></a></button>
				<?php }} ?>
				
				
				
				<?php if(isset($_SESSION['login']) & isset($_SESSION['tipo'])) {  ?>
					<?php if($_SESSION['tipo'] == 'Deportista'){ ?>
							<div class="dropdown-divider"></div>

								<button id ="buttonBien" type="submit"  name="insCampeonato"><a class="dropdown-item" href="../Controllers/CATEGORIA_CONTROLLER.php" /><?php echo $strings['Inscribirse en campeonato'] ?></a></button>

              	<?php } } }?>
              </div>
            </li>

            <li class="nav-item dropdown" style="display: block">
			<form name='idiomform' action="../Functions/CambioIdioma.php" method="post">
              <a class="nav-link dropdown-toggle" style="color: white" href="<?php echo $strings['idioma']; ?>" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Idiomas</a>
              <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                <button id ="buttonBien" type="submit"  name="idioma" value="SPANISH" ><a class="dropdown-item"/> <?php echo $strings['Cambiar idioma a español']?></a></button>
				
				  <div class="dropdown-divider"></div>
				
                <button id ="buttonBien" type="submit"  name="idioma" value="ENGLISH" ><a class="dropdown-item"/><?php echo $strings['Cambiar idioma a inglés']?></a></button>

                <div class="dropdown-divider"></div>

                <button id ="buttonBien" type="submit"  name="idioma" value="GALLEGO" ><a class="dropdown-item"/><?php echo $strings['Cambiar idioma a gallego']?></a></button>
              </div>
			</form>
            </li>
          </ul>
          <!--<form class="form-inline my-2 my-lg-0">
            <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search">
            <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
          </form>-->
        </div>
      </div>
</nav>






	  <hr>
	  	<!-- <?php echo $strings['Portal de Gestión']; ?>-->
	  	<div align="center" class="titulo"><h1>PADEL APP</h1></div>
</hr>
	</header>