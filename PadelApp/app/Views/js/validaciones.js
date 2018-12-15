<script language="JavaScript" type="text/javascript" >





var atributo = new Array(); 

//Registro
atributo['login'] = 'Usuario';
atributo['password'] = 'Contraseña';
atributo['Dni'] = 'Dni';
atributo['nombre'] = 'Nombre';
atributo['apellidos'] = 'Apellidos';
atributo['telefono'] = 'Teléfono';
atributo['sexo'] = 'Sexo';
atributo['Tipo'] = 'Tipo';

//Campeonato
atributo['IdCampeonato'] = 'IdCampeonato';
atributo['FechaIni'] = 'FechaIni';
atributo['HoraIni'] = 'HoraIni';
atributo['FechaFin'] = 'FechaFin';
atributo['HoraFin'] = 'HoraFin';





// function hayEspacio(campo): Comprueba que no tenga espacios el campo
function sinEspacio(campo) {
	//Comprueba si hay algun espacio
	if (/[\s]/.test(campo.value)) {
		//mensaje multidioma
		msgError('El atributo ' + atributo[campo.name] + ' no puede tener espacios ');
		campo.focus();
		return false;
	}
	return true; //Devuelve "true"
}
/*
	function comprobarVacio(campo): realiza una comprobación de si el campo es vacío o está compuesto de espacios en blanco.
*/
function comprobarVacio(campo) {
	/*Si el campo es nulo, tiene longitud 0 o está compuesto por espacios en blanco, se muestra un mensaje de error y se retorna false*/
	if (campo.value == null || campo.value.length == 0 || /^\s+$/.test(campo.value)) {
		msgError('El atributo ' + atributo[campo.name] + ' no puede ser vacio');
		campo.focus();
		return false;
	}
	return true;
}
/*
	function comprobarLongitud(campo,size): realiza una comprobación de si el campo es mayor que el indicado en el parámetro size.
*/
function comprobarLongitud(campo, size) {
	/*Si el campo tiene mayor longitud que size, se manda un aviso de error llamando a la función msgError y se retorna false */
	if (campo.value.length > size) {
		msgError('Longitud incorrecta. El atributo ' + atributo[campo.name] + ' puede tener una longitud máxima de ' + size + ' y es de ' + campo.value.length);
		campo.focus();
		return false;
	}
	return true;
}
/*
	function comrpobarTexto(campo,size): realiza una comprobación de si el valor de campo contiene algún carácter especial.
*/
function comprobarTexto(campo, size) {

	var i; //variable auxiliar de control
	/*Estructura que permite recorrer todos los caracteres del valor de campo */
	for (i = 0; i < size; i++) {
		/*Comprueba que el carácter seleccionado de campo no es un carácter especial, si es así muestra un mensaje de error y retorna false */
		if (/[^!"#$%&'()*+,-./0123456789:;<=>?@ABCDEFGHIJKLMNOPQRSTUVWXYZ[\]^_`abcdefghijklmnopqrstuvwxyz{|}~ñáéíóúÑÁÉÍÓÚüÜ ]/.test(campo.value.charAt(i))) {
			msgError('El atributo ' + atributo[campo.name] + '  contiene algún carácter no válido: ' + campo.value.charAt(i));
			campo.focus();
			return false;
		}
	}

	return true;
}
/*
	function comprobarAlfabetico(campo,size): realiza una comprobación de si el campo contiene letras minúsculas o mayúsculas (los espacios también están incluidos).
*/
function comprobarAlfabetico(campo, size) {
	var i; //variable auxiliar de control
	/*Estructura que permite recorrer todos los caracteres del valor de campo */
	for (i = 0; i < size; i++) {
		/*Comprueba que el carácter seleccionado de campo no es una letra o un espacio, si es así se muestra un mensaje de error y retorna false */
		if (/[^A-Za-zñáéíóúÑÁÉÍÓÚüÜ -]/.test(campo.value.charAt(i))) {
			msgError('El atributo ' + atributo[campo.name] + ' solo admite carácteres alfabéticos');
			campo.focus();
			return false;
		}
	}
	return true;
}
/*
	function comprobarCampoNumFormSearch(campo,size,valormenor,valormayor): realiza una comprobación de si el contenido de un campo numérico de un 
	formulario de búsqueda es correcto.
*/
function comprobarCampoNumFormSearch(campo, size, valormenor, valormayor) {

	/*Si el campo es nulo, tiene longitud 0 o está compuesto por espacios en blanco, se retorna true. Si no es así se valida el campo*/
	if (campo.value == null || campo.value.length == 0 || /^\s+$/.test(campo.value)) {
		return true;
	} else {// si no cumple con la condición del if anterior,
		/*Comprueba que el campo no tenga una longitud mayor que el indicado por size, si la supera, se retorna false*/
		if (!comprobarLongitud(campo, size)) {
			return false;
		} else {// si no cumple con la condición del if anterior,
			/*Comprueba que el campo no contenga carácteres especiales, si no es así, se retorna false */
			if (!comprobarTexto(campo, size)) {
				return false;
			} else {// si no cumple con la condición del if anterior,
				/*Comprueba que el campo es un dígito y es mayor que valormenor y es menor que valormayor, si no es así, se retorna false */
				if (!comprobarEntero(campo, valormenor, valormayor)) {
					return false;
				}
			}
		}
	}

	return true;
}
/*
	function comprobarEntero(campo,valormenor,valormayor): realiza una comprobación de que el campo sea entero. Si es así comprueba que es un número
	comprendido entre el valormenor y valormayor
*/
function comprobarEntero(campo, valormenor, valormayor) {

	/*Comprueba que campo es un dígito*/
	if (!/^([0-9])*$/.test(campo.value)) {
		msgError('El atributo ' + atributo[campo.name] + ' tiene que ser un dígito');
		campo.focus();
		return false;
	} else {
		/*Comprueba que el valor de campo es mayor que valormayor, si es así muestra un mensaje de error y retorna false */
		if (campo.value > valormayor) {
			msgError('El atributo ' + atributo[campo.name] + ' no puede ser mayor que ' + valormayor);
			campo.focus();
			return false;
		} else {
			/*Comprueba que el valor de campo es menor que valormenor, si es así muestra un mensaje de error y retorna false */
			if (campo.value < valormenor) {
				msgError('El atributo ' + atributo[campo.name] + ' no puede ser menor que ' + valormenor);
				campo.focus();
				return false;
			}
		}
	}

	return true;
}
/*
	function comprobarReal(campo,numeroDecimales,valormenor,valormayor): realiza una comprobación
	de que el número introducido en este caso llamado num, tenga el mismo número de decimales que
	el parámetro numeroDecimales y sea menor que el valormayor y mayor que el valormenor.
 */
function comprobarReal(campo, numeroDecimales, valormenor, valormayor) {

	var num; //variable que representa el número del valor de campo
	var i; //variable de control de bucle
	var j; //variable de control de bucle
	var control; //variable de control de bucle
	var numeroDecimalesCampo; //variable que representa el número de decimales del valor de campo
	num = campo.value;
	i = 0;
	j = 0;
	numeroDecimalesCampo = 0;
	control = true;
	/*Comprueba que el formato del valor del campo se corresponde con el formato indicado con la expresión regular */
	if (!(/^-?[0-9]+([,\.][0-9]*)?$/.test(num))) {
		msgError('El atributo ' + atributo[campo.name] + ' tiene un formato no válido ');
		campo.focus();
		return false;
	} else {// si no cumple con la condición del if anterior,
		/*Recorre el valor de campo hasta que control sea falso o la variable de de control i sobrepase la longitud de campo*/
		do {
			/*Comprueba si el caracter seleccionado es un punto o una coma, si es así cuenta los carácteres que le siguen*/
			if (num.charAt(i) == ',' || num.charAt(i) == '.') {
				control = false;
				i++;
				/*Recorre el valor del campo hasta que se sobrepase, mientras aumenta el contador de caracteres encontrados despues del punto y a coma*/
				for (j = i; j < num.length; j++) {
					numeroDecimalesCampo++;
				}
			}
			i++;
		} while (control && (i < num.length));
		/*Comprueba que si el numero de decimales del campo es mayor que el numeroDecimales establecido, muestra un mensaje de error y retorna false*/
		if (numeroDecimalesCampo > numeroDecimales) {
			msgError('El atributo ' + atributo[campo.name] + ' no puede tener más de ' + numeroDecimales);
			campo.focus();
			return false;
		} else {// si no cumple con la condición del if anterior,
			/*Comprueba que el valor de campo es mayor que valormayor, si es así muestra un mensaje de error y retorna false */
			if (num > valormayor) {
				msgError('El atributo ' + atributo[campo.name] + ' no puede ser mayor que ' + valormayor);
				campo.focus();
				return false;
			} else {// si no cumple con la condición del if anterior,
				/*Comprueba que el valor de campo es menor que valormenor, si es así muestra un mensaje de error y retorna false */
				if (num < valormenor) {
					msgError('El atributo ' + atributo[campo.name] + ' no puede ser menor que ' + valormenor);
					campo.focus();
					return false;
				}
			}
		}
		return true;
	}
}
/*
	comprobarDni(campo): realiza la comprobación de que el valor de campo tenga formato de DNI
*/
function comprobarDni(campo) {
	var numero; //variable que representa la parte numérica del dni
	var letr; //variable que representa la letra del dni
	var letra; //variable que representa el array que permite averiguar la letra del dni
	var expresion_regular_dni; //variable que representa la expresión regular del dni
	letra = 'TRWAGMYFPDXBNJZSQVHLCKET';
	expresion_regular_dni = /^\d{8}[a-zA-Z]$/;

	/*Comprueba si la expresión regular coincide con el formato del valor del campo, si no coincide se muestra un mensaje de error y retorna false*/
	if (expresion_regular_dni.test(campo.value)) {
		numero = campo.value.substr(0, 8);
		letr = campo.value.substr(8, 1);
		numero = numero % 23;
		letra = letra.substring(numero, numero + 1);
		/*Valida que la letra introducida en la variable campo sea correcta, si es así se devuelve devuelve true. Si no, muestra un mensaje de error y devuelve false*/
		if (letra != letr.toUpperCase()) {
			msgError('El atributo ' + atributo[campo.name] + ' tiene un formato erróneo, la letra del NIF no se corresponde');
			campo.focus();
			return false;
		} else {// si no cumple con la condición del if anterior,
			return true;
		}
	} else {// si no cumple con la condición del if anterior,
		msgError('El atributo ' + atributo[campo.name] + ' tiene un formato erróneo');
		campo.focus();
		return false;
	}
}
/*
	function comprobarTelf(campo): realiza la comprobación de que el valor de campo tenga el formato de teléfono español, tanto para nacional como internacional
*/
function comprobarTelf(campo) {
	/*Si el valor del campo no cumple el formato de la expresión, se muestra un mensaje de error y se retorna false*/
	if (!/^(34)?[6|7|9][0-9]{8}$/.test(campo.value)) {
		msgError('El atributo ' + atributo[campo.name] + ' tiene un formato erróneo');
		campo.focus();
		return false;
	}
	return true;
}
/*
	function comprobarEmail(campo): realiza la comprobación de que campo tenga el formato correcto de una dirección de correo
*/
function comprobarEmail(campo) {
	//Si el valor del campo no cumple el formato de la dirección de correo determinada por la expresión regular, muetra un mensaje de error y retorna false.
	if (!/^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?(?:\.[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?)*$/.test(campo.value)) {
		msgError('El atributo ' + atributo[campo.name] + ' tiene un formato erróneo');
		campo.focus();
		return false;
	}
	return true;
}

/*
	function comprobarExtension(campo):funcion que comprueba si el tipo de extensión de un type "file" es aceptada
*/
function comprobarExtension(campo){
	//variable que recoje el campo
    var fileInput = campo;
    //variable que recoje el valor del campo
    var filePath = fileInput.value;
    //variable que recoje la extensiones permitidas
    var NotallowedExtensions = /(.sh|.php)$/i;
    //Si el archivo no tiene una extensión permitida ejecuta el código del "if"
    if(NotallowedExtensions.exec(filePath)){
    	//muestra mensaje de alerta
        msgError('El atributo ' + atributo[campo.name] + ' no permite las extensiones: .sh/.php');//mensaje multidioma
        campo.focus();
        return false;//Devuelve false
    }
    return true;//Devuelve true
}
/*
	function abrirVentana(): realiza la función de abrir una ventana emergente, a través de una capa, capaFondo1, para que no se pueda interacionar con la capa base. Estas dos capas se activan y su visibility pasa a visible.
*/
function abrirVentana() {
	document.getElementById("capaFondo1").style.visibility = "visible";//Se establece la capa de fondo a visible
	document.getElementById("capaVentana").style.visibility = "visible";//Se establece la capa de ventana a visible
	document.formError.bAceptar.focus();
}
/*
	function cerrarVentana(): realiza la función de cerrar una ventana emergente, a través de una capa, capaFondo1, para que no se pueda interacionar con la capa base. Estas dos capas se desactivas y su visibility pasa a hidden.
*/
function cerrarVentana() {
	document.getElementById("capaFondo1").style.visibility = "hidden";
	document.getElementById("capaVentana").style.visibility = "hidden";//Se establece la capa de ventana a oculta
	document.formError.bAceptar.blur();
}
/*
	msgError(msg): realiza la función de mostrar el valor del parámetro msg en el div, cuyo id es "miDiv". Además se encarga de llamar a la función abrirVentana(), la cual muestra un mensaje de error cuya información está en html
*/
function msgError(msg) {

	var miDiv = document.getElementById("miDiv"); // Cogemos la referencia al nuestro div.
	var html = ""; //En esta variable guardamos lo que queramos añadir al div.

	miDiv.innerHTML = ""; //innerHTML te añade código a lo que ya haya por eso primero lo ponemos en blanco.
	html = msg;
	miDiv.innerHTML = html;//añadimos el texto que queramos al div
	abrirVentana();
	return true;
}

//Funciona
function comprobarLogin() {

	var login; 
	var pwd; 

	login = document.forms['Form'].elements[0];
	pwd = document.forms['Form'].elements[1];

	if (!comprobarVacio(login)) {
		return false;
	} else {
		if (!comprobarLongitud(login, 25)) {
			return false;
		} else {
			if (!comprobarTexto(login, 25)) {
				return false;
			}
		}
		if (!comprobarVacio(pwd)) {
			return false;
		} else {
			if (!comprobarLongitud(pwd, 20)) {
				return false;
			} else {
				if (!comprobarTexto(pwd, 20)) {
					return false;
				}
			}
		}

	}

	encriptar();

	return true;
}
/*
	function encriptar(): encripta en md5 el valor del campo password
*/
function encriptar() {
	document.getElementById('password').value = hex_md5(document.getElementById('password').value); //cambia el valor del campo password introducido por el usuario, 																							   //por el valor de la password encriptada
}

//Funciona
function comprobarRegistrar() {

	var login; 
	var pwd; 
	var dni;
	var nombreuser; 
	var apellidosuser;
	var telefono; 
	var sexo;


	login = document.forms['ADD'].elements[0];
	pwd = document.forms['ADD'].elements[1];
	dni = document.forms['ADD'].elements[2];
	nombreuser = document.forms['ADD'].elements[3];
	apellidosuser = document.forms['ADD'].elements[4];
	hombre = document.forms['ADD'].elements[5];
	mujer = document.forms['ADD'].elements[6];
	telefono = document.forms['ADD'].elements[7];




	if (!comprobarVacio(login)) {
		return false;
	} else {
		if (!sinEspacio(login)) {
			return false;
		} else {
			
			if (!comprobarLongitud(login, 25)) {
				return false;
			} else {
				
				if (!comprobarTexto(login, 25)) {
					return false;
				}
			}
		}
	}

	if (!comprobarVacio(pwd)) {
		return false;
	} else {
		
		if (!sinEspacio(pwd)) {
			return false;
		} else {
			if (!comprobarLongitud(pwd, 20)) {
				return false;
			} else {
				if (!comprobarTexto(pwd, 20)) {
					return false;
				}
			}
		}
	}

	if (!comprobarVacio(dni)) {
		return false;
	} else {
		if (!comprobarLongitud(dni, 9)) {
			return false;
		} else {
			if (!comprobarTexto(dni, 9)) {
				return false;
			} else {
				if (!comprobarDni(dni)) {
					return false;
				}
			}
		}
	}
	
	if (!comprobarVacio(nombreuser)) {
		return false;
	} else {
		if (!comprobarLongitud(nombreuser, 30)) {
			return false;
		} else {
			if (!comprobarTexto(nombreuser, 30)) {
				return false;
			} else {
				if (!comprobarAlfabetico(nombreuser, 30)) {
					return false;
				}
			}

		}
	}

	if (!comprobarVacio(apellidosuser)) {
		return false;
	} else {
		if (!comprobarLongitud(apellidosuser, 45)) {
			return false;
		} else {
			if (!comprobarTexto(apellidosuser, 45)) {
				return false;
			} else {
				if (!comprobarAlfabetico(apellidosuser, 45)) {
					return false;
				}

			}
		}
	}


	if (!comprobarVacio(hombre) && !comprobarVacio(mujer) ) {
		return false;
	}	

	if (!comprobarVacio(telefono)) {
		return false;
	} else {
		if (!comprobarLongitud(telefono, 11)) {
			return false;
		} else {
			if (!comprobarTexto(telefono, 11)) {
				return false;
			} else {
				if (!comprobarTelf(telefono)) {
					return false;
				}

			}
		}
	}
	encriptar();
	return true;
}
//Funciona
function comprobarAddUsuario() {

	var dni;
	var login; 
	var pwd; 
	var nombreuser; 
	var apellidosuser; 

	var telefono;
	var tipo;
	
	dni = document.forms['ADD'].elements[0];
	login = document.forms['ADD'].elements[1];
	pwd = document.forms['ADD'].elements[2];
	nombreuser = document.forms['ADD'].elements[3];
	apellidosuser = document.forms['ADD'].elements[4];

	telefono = document.forms['ADD'].elements[7];
	tipo = document.forms['ADD'].elements[8];


	if (!comprobarVacio(dni)) {
		return false;
	} else {
		if (!comprobarLongitud(dni, 9)) {
			return false;
		} else {
			if (!comprobarTexto(dni, 9)) {
				return false;
			} else {
				if (!comprobarDni(dni)) {
					return false;
				}
			}
		}
	}
	if (!comprobarVacio(login)) {
		return false;
	} else {
		if (!sinEspacio(login)) {
			return false;
		} else {
			if (!comprobarLongitud(login,25)) {
				return false;
			} else {
				if (!comprobarTexto(login, 25)) {
					return false;
				}
			}
		}
	}

	if (!comprobarVacio(pwd)) {
		return false;
	} else {
		if (!sinEspacio(pwd)) {
			return false;
		} else {
			if (!comprobarLongitud(pwd, 20)) {
				return false;
			} else {
				if (!comprobarTexto(pwd, 20)) {
					return false;
				}
			}
		}
	}

	
	if (!comprobarVacio(nombreuser)) {
		return false;
	} else {
		if (!comprobarLongitud(nombreuser, 30)) {
			return false;
		} else {
			if (!comprobarTexto(nombreuser, 30)) {
				return false;
			} else {
				if (!comprobarAlfabetico(nombreuser, 30)) {
					return false;
				}
			}

		}
	}
	
	if (!comprobarVacio(apellidosuser)) {
		return false;
	} else {
		if (!comprobarLongitud(apellidosuser, 45)) {
			return false;
		} else {
			if (!comprobarTexto(apellidosuser, 45)) {
				return false;
			} else {
				if (!comprobarAlfabetico(apellidosuser, 45)) {
					return false;
				}

			}
		}
	}


	if (!comprobarVacio(telefono)) {
		return false;
	} else {
		if (!comprobarLongitud(telefono, 12)) {
			return false;
		} else {
			if (!comprobarTexto(telefono, 12)) {
				return false;
			} else {
				if (!comprobarTelf(telefono)) {
					return false;
				}

			}
		}
	}

	

	encriptar();
	return true;
}
//Funciona
function comprobarSearchUsuario() {


	var dni;
	var login; 
	var pwd; 
	var nombreuser; 
	var apellidosuser; 

	var telefono;
	var tipo;

	dni = document.forms['SEARCH'].elements[0];
	login = document.forms['SEARCH'].elements[1];
	pwd = document.forms['SEARCH'].elements[2];
	nombreuser = document.forms['SEARCH'].elements[3];
	apellidosuser = document.forms['SEARCH'].elements[4];

	telefono = document.forms['SEARCH'].elements[7];
	tipo = document.forms['SEARCH'].elements[8];


	if (!comprobarLongitud(dni, 9)) {
		return false;
	} else {
		if (!comprobarTexto(dni, 9)) {
			return false;
		}
	}


	if (!comprobarLongitud(pwd, 128)) {
		return false;
	} else {
		if (!comprobarTexto(pwd, 128)) {
			return false;
		}
	}

	if (!comprobarLongitud(login, 25)) {
		return false;
	} else {
		if (!comprobarTexto(login, 25)) {
			return false;
		}
	}

	if (!comprobarLongitud(nombreuser, 30)) {
		return false;
	} else {
		if (!comprobarTexto(nombreuser, 30)) {
			return false;
		} else {
			if (!comprobarAlfabetico(nombreuser, 30)) {
				return false;
			}
		}
	}

	if (!comprobarLongitud(apellidosuser, 45)) {
		return false;
	} else {
		if (!comprobarTexto(apellidosuser, 45)) {
			return false;
		} else {
			if (!comprobarAlfabetico(apellidosuser, 45)) {
				return false;
			}
		}
	}
	if (!comprobarLongitud(telefono, 14)) {
		return false;
	} else {
		if (!comprobarTexto(telefono, 14)) {
			return false;
		}
	}
	if (!comprobarLongitud(tipo, 12)) {
		return false;
	} else{
		if (!comprobarTexto(tipo, 12)) {
			return false;
		}
	}


	
	return true;
}

function comprobarEditUsuario() {

	var dni;
	var login; 
	var pwd; 
	var nombreuser; 
	var apellidosuser; 

	var telefono;


	dni = document.forms['EDIT'].elements[0];
	login = document.forms['EDIT'].elements[1];
	pwd = document.forms['EDIT'].elements[2];
	nombreuser = document.forms['EDIT'].elements[3];
	apellidosuser = document.forms['EDIT'].elements[4];

	telefono = document.forms['EDIT'].elements[7];



	if (!comprobarVacio(dni)) {
		return false;
	} else {
		if (!comprobarLongitud(dni, 9)) {
			return false;
		} else {
			if (!comprobarTexto(dni, 9)) {
				return false;
			} else {
				if (!comprobarDni(dni)) {
					return false;
				}
			}
		}
	}
	

	if (!comprobarVacio(login)) {
		return false;
	} else {
		if (!sinEspacio(login)) {
			return false;
		} else {
			if (!comprobarLongitud(login, 25)) {
				return false;
			} else {
				if (!comprobarTexto(login, 25)) {
					return false;
				}
			}
		}
	}

	if (!comprobarVacio(pwd)) {
		return false;
	} else {
		if (!sinEspacio(pwd)) {
			return false;
		} else {
			if (!comprobarLongitud(pwd, 128)) {
				return false;
			} else {
				if (!comprobarTexto(pwd, 128)) {
					return false;
				}
			}
		}
	}


	if (!comprobarVacio(nombreuser)) {
		return false;
	} else {
		if (!comprobarLongitud(nombreuser, 30)) {
			return false;
		} else {
			if (!comprobarTexto(nombreuser, 30)) {
				return false;
			} else {
				if (!comprobarAlfabetico(nombreuser, 30)) {
					return false;
				}
			}

		}
	}

	if (!comprobarVacio(apellidosuser)) {
		return false;
	} else {
		if (!comprobarLongitud(apellidosuser, 45)) {
			return false;
		} else {
			if (!comprobarTexto(apellidosuser, 45)) {
				return false;
			} else {
				if (!comprobarAlfabetico(apellidosuser, 45)) {
					return false;
				}

			}
		}
	}


	if (!comprobarVacio(telefono)) {
		return false;
	} else {
		if (!comprobarLongitud(telefono, 12)) {
			return false;
		} else {
			if (!comprobarTexto(telefono, 12)) {
				return false;
			} else {
				if (!comprobarTelf(telefono)) {
					return false;
				}

			}
		}
	}
	
	encriptar();
	return true;


}





function comprobarAddCampeonato(){
	
	var idCampeonato; 
	var fechaIni; 
	var horaIni;
	var fechaFin; 
	var horaFin;
	var elementosTotales; 


	idCampeonato = document.forms['ADD'].elements[0];
	fechaIni = document.forms['ADD'].elements[1];
	horaIni = document.forms['ADD'].elements[2];
	fechaFin = document.forms['ADD'].elements[3];
	horaFin = document.forms['ADD'].elements[4];
	elementosTotales = document.forms['ADD'].elements.length;


	if (!comprobarVacio(idCampeonato)) {
		return false;
	} else {
		if (!sinEspacio(idCampeonato)) {
			return false;
		} else {
			
			if (!comprobarLongitud(idCampeonato, 11)) {
				return false;
			} else {
				
				if (!comprobarTexto(idCampeonato, 11)) {
					return false;
				}else{
					if (!comprobarEntero(idCampeonato, 0,2147483647)) {
						return false;
					}
				}
			}
		}
	}

	if (!comprobarVacio(fechaIni)) {
		return false;
	}
	if (!comprobarVacio(horaIni)) {
		return false;
	}	
	if (!comprobarVacio(fechaFin)) {
		return false;
	}
	if (!comprobarVacio(horaFin)) {
		return false;
	}	
	var total_checked = 0;
      for(i=0;i<elementosTotales;i++)
         {
               if((document.forms['ADD'].elements[i].type=="checkbox")
               &&(document.forms['ADD'].elements[i].checked))
               { total_checked++; }
         }
	if(total_checked ==0){
		msgError('El atributo ' + 'categoria' + ' no puede ser vacio');
		//campo.focus();					
		return false;
	}
	
	return true;
}

function comprobarSearchCampeonato(){
	
	var idCampeonato; 
	var fechaIni; 
	var horaIni;
	var fechaFin; 
	var horaFin;


	idCampeonato = document.forms['ADD'].elements[0];
	fechaIni = document.forms['ADD'].elements[1];
	horaIni = document.forms['ADD'].elements[2];
	fechaFin = document.forms['ADD'].elements[3];
	horaFin = document.forms['ADD'].elements[4];

	if (!comprobarLongitud(idCampeonato, 11)) {
		return false;
	} else {
		
		if (!comprobarTexto(idCampeonato, 11)) {
			return false;
		}else{
			if (!comprobarEntero(idCampeonato, 0,2147483647)) {
				return false;
			}
		}
	}
	
	return true;

	
	
}




</script>
