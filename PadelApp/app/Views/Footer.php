 <div id="capaVentana" 	>
		
		<table  id = "tablaE" width="250px" >
			<tr>
				<td id = "tdE" colspan="2" style="background-color:red">
						<font style="font-size:24px;color:white"><?php echo $strings['Alerta']?></font>
				</td>
			
			</tr>
			<tr>
				<td id = "tdE" colspan="2" style="background-color:white;" 	>
					<div id="miDiv" style="color:black;"><?php echo $strings['Error:']?></div>
				</td>
			</tr>
			<tr style="background-color:white">
				<td 	id = "tdE">		
					<form name="formError">
						<button id ="buttonBien" type="button" 	
						 name="bAceptar"  value="Aceptar" onclick="cerrarVentana()" ><img src="../Views/icon/confirmar.png" height="32" width="32" alt="<?php echo $strings['Aceptar']?>"  /></button>	
					</form>
				</td>
			</tr>
			
		</table>
</div>
	
	<div id="capaFondo1" ></div>
		
	<footer class="text-center" align="fixed" >
      <div class="container">
        <div class="row">
          <div class="col-12">
            <p>Copyright © Uvigo. Derechos reservados a Davurin.</p>
          </div>
        </div>
      </div>
	</footer>
  </body>
</html>
