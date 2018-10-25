<?php
/*  Archivo php
	Nombre: USUARIOS_SHOWALL_View.php
	Autor: 	Alejandro Vila
	Fecha de creación: 29/11/2017 
	Función:se muestra una vista por defecto que no tiene nada
*/

//es la clase donde se muestra una vista por defecto
class USUARIO_DEFAULT {
//es el constructor de la clase
	function __construct( ) { 

		$this->render();//llamamos a esta función para mostrar la vista
	}
	//función para mostrar la vista
	function render(){
	if (!isset($_SESSION['idioma'])) { //miramos si existe algún idioma
		$_SESSION['idioma'] = 'SPANISH';//si no existe ponemos por defecto el español

	}
		
		include '../Locales/Strings_' . $_SESSION[ 'idioma' ] . '.php';//incluimos los strings de idiomas, para que la página pueda estar en español,inglés y galego
		include '../Views/Header.php';//incluimos la cabecera
?>
		<style>
	  
		  .titulo {text-align: center;}
	  
	  </style>
	<div class="dropdown-divider"></div>
    <div class="container mt-3">
      <div class="row">
        <div class="col-12">
          <div id="carouselExampleControls" class="carousel slide" data-ride="carousel">
            <ol class="carousel-indicators">
              <li data-target="#carouselExampleControls" data-slide-to="0" class="active"></li>
              <li data-target="#carouselExampleControls" data-slide-to="1"></li>
              <li data-target="#carouselExampleControls" data-slide-to="2"></li>
            </ol>
            <div class="carousel-inner">
              <div class="carousel-item active">
                <img class="d-block w-100" src="../Views/icon/padel2.jpg" alt="First slide">
                <div class="carousel-caption d-none d-md-block">
                  <h5>Bienvenido a Padel App</h5>
                  <p></p>
                </div>
              </div>
              <div class="carousel-item">
                <img class="d-block w-100" src="../Views/icon/pandapadel.png" alt="Second slide">
                <div class="carousel-caption d-none d-md-block">
                  <h5>Panda panda pra</h5>
                  <p></p>
                </div>
              </div>
              <div class="carousel-item">
                <img class="d-block w-100" src="../Views/icon/Instalaciones.jpg" alt="Third slide">
                <div class="carousel-caption d-none d-md-block">
                  <h5>Disfruta de nuestras instalaciones</h5>
                  <p></p>
                </div>
              </div>
            </div>
            <a class="carousel-control-prev" href="#carouselExampleControls" role="button" data-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="sr-only">Anterior</span>
            </a>
            <a class="carousel-control-next" href="#carouselExampleControls" role="button" data-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="sr-only">Siguiente</span>
            </a>
          </div>
        </div>
      </div>
	
		
	<div class="dropdown-divider"></div>
    </div>
    <div class="container">
      <div class="row">
        <div class="col-4">
          <div class="row">
            <div class="col-2"></div>
            <div class="col-lg-6 col-10 ml-1">
              <h4 align="center">Partidos y campeonatos</h4>
            </div>
          </div>
        </div>
        <div class="col-4">
          <div class="row">
            <div class="col-2"></div>
            <div class="col-lg-6 col-10 ml-1">
              <h4 align="center">Partidos promocionados</h4>
            </div>
          </div>
        </div>
        <div class="col-4">
          <div class="row">
            <div class="col-2"></div>
            <div class="col-lg-6 col-10 ml-1">
              <h4 align="center">Clases y actividades</h4>
            </div>
          </div>
        </div>
      </div>
		<div class="dropdown-divider"></div>
		<div class="video-responsive" align="center"><iframe width="560" height="315" src="https://www.youtube.com/embed/yJP0ZVBEtjM" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen></iframe>
		<div class="dropdown-divider"></div>
			<div>
				<h5 align="center">Cuatro pistas de pádel de cristal:</h5> 
				<p align="left">Cuatro pistas dobles. La iluminación (8 proyectores Philips LED laterales y suspendidos a 6 metros por pista, como exige la normativa.</p>
				<br>
				<h5 align="center">Reserva online de pistas y actividades:</h5>
				<p align="left">Contamos con el sistema de reservas y organización de partidos a través de nuestro sistema de ¡Juega ya!(partidos promocionados) en el que podrás anotarte y disfrutar de una buena jornada de pádel conociendo a gente nueva.</p>
				<br>
				<h5 align="center">Campeonatos estilo "Ranking"</h5>
				<p align="left">Contamos con un nuevo formato de campeonato, al que te podrás anotar con tu pareja y así competir en nuestro club para poder llegar a la fase final y convertirte en la mejor pareja del Ranking de cada categoría.</p>
				<br>
				<h5 align="center">Vestuarios femeninos y masculinos climatizados:</h5>
				<p align="left">Podrás disfrutar de unas duchas individuales y temporizadores de agua con regulación individual de temperatura. En ambos vestuarios tenéis a vuestra disposición taquillas individuales. Contamos con un vestuario para personas de movilidad reducida.</p>
				<br>
				<h5 align="center">Zona de juegos, estiramientos y cafetería</h5>
				<p align="left">Tres zonas habilitadas para su disfrute por los usuarios, podrás traer a tu familia a verte y no se sentirán indiferentes en la cafetería con vistas panorámicas de las pistas, también podrán utilizar la zona de juegos donde los más pequeños pasarán un buen rato.</p>
			</div>
			</div>
			<div class="dropdown-divider"></div>
		<h3 align="center">Noticias</h3>
		<div class="dropdown-divider"></div>
	  <div>
		<h5 align="center">Tello y Chingotto, dos argentinos que ya saborean las mieles del triunfo</h5>
		  <p>
			Padel Spain.- Juan Tello y Fede Chingotto, dos ''tapados'' que han terminado por descubrirse del todo, y de qué manera. Dos argentinos muy jóvenes que se colaban en la final del Challenger de París ante los favoritos, con total merecimiento, y que en el último duelo del torneo ofrecían un rendimiento excelso. Ya son, oficialmente, campeones.

			Todo ello tras un duelo extenuante que les ponía cara a cara con Ramiro Moyano y Lucho Capra, otros dos jóvenes que están en un gran momento de forma y que llegaban también con unos cuantos kilómetros en las piernas. Bien es cierto que el duelo de semis fue mucho más cómodo para Fede y Juan, pero en cuartos, estos sufrieron de lo lindo para superar a sus oponentes (Javier Martínez y Adrián Blanco (7-6, 6-7 y 6-2), por lo que la cosa estaba igualada en cuanto a distancia y pesadez de piernas.

			Un duelo decidido por una sola cosa, el mayor depósito de gasolina de Juan y Fede, que les hizo volar en el tercero mientras que sus oponentes se iban quedando lentamente.

			El resultado de 7-5, 6-7 y 6-2 deja bien clara la pelea que hubo por conseguir cada punto, por ganar un solo centímetro de la pista, por llevarse el título, siendo los aficionados presentes los que se llevaron una muy grata impresión del espectáculo que los jugadores y jugadoras pueden desarrollar.
			<br>
		<p align="center">
		 <img src="../Views/icon/tellochingotto.jpg" width="600" height="340" alt=""/>
	    </p>
			</p>
   	  </div>
	</div>
    <hr>
<div class="container text-white bg-dark p-4">
      <div class="row">
        <div class="col-6 col-md-8 col-lg-7">
          <div class="row text-center">
            <div class="col-sm-6 col-md-4 col-lg-4 col-12">
              <ul class="list-unstyled">
                <li class="btn-link"> <a href="https://es.wikipedia.org/wiki/P%C3%A1del">WikiPadel</a> </li>
                <br>
				  <li class="btn-link"> <a href="https://www.marca.com/padel.html">Marca Padel</a> </li>
                <br>
				  <li class="btn-link"> <a href="https://www.worldpadeltour.com/">World Padel Tour</a> </li>
                <!--<li class="btn-link"> <a>Link anchor</a> </li>
                <li class="btn-link"> <a>Link anchor</a> </li>-->
              </ul>
            </div>
          </div>
        </div>
        <div class="col-md-4 col-lg-5 col-6">
          <address>
            <strong>Informatica Ourense</strong><br>
            Universidad de Vigo<br>
            Ourense, 32004<br>
            <abbr title="Phone">P:</abbr> 666888555
          </address>
          <address>
            <strong>PadelApp</strong><br>
            <a href="mailto:#">padelapp@padelapp.es</a>
          </address>
        </div>
      </div>
</div>
<?php
		include 'Footer.php';//incluimos el pie de la página
		}
		}
?>