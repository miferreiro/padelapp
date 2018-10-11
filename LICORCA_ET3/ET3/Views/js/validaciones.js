<script language="JavaScript" type="text/javascript" >
	/*  Archivo javaScript
		Nombre: validaciones.js
		Autor: 	Miguel Ferreiro
		Fecha de creación: 26/11/2017 
		Función: el objetivo principal de este fichero es validar los distintos campos de los formularios, permitiendo así que los datos cumplan los
		requisitos y formatos necesarios para ser válidos. Además se incluyen las funciones asociadas a mostrar el mensaje de error cuando los datos
		son incorrectos
	*/

var atributo = new Array(); /*Array que sirve para poder traducir el nombre de los atributos de los campos del formulario */
//GESTION DE USUARIOS
atributo['login'] = '<?php echo $strings["Usuario"]?>';
atributo['password'] = '<?php echo $strings["password"]?>';
atributo['DNI'] = '<?php echo $strings["DNI"]?>';
atributo['nombre'] = '<?php echo $strings["Nombre"]?>';
atributo['apellidos'] = '<?php echo $strings["Apellidos"]?>';
atributo['telefono'] = '<?php echo $strings["Teléfono"]?>';
atributo['email'] = '<?php echo $strings["email"]?>';
atributo['FechaNacimiento'] = '<?php echo $strings["FechaNacimiento"]?>';
atributo['direc'] = '<?php echo $strings["Direccion"]?>';
atributo['sexo'] = '<?php echo $strings["Sexo"]?>';
//GESTION DE GRUPOS DE USUARIO
atributo['NombreGrupo'] = '<?php echo $strings["NombreGrupo"]?>';
atributo['DescripGrupo'] = '<?php echo $strings["DescripGrupo"]?>';

//GESTION DE FUNCIONALIDADES
atributo['IdFuncionalidad'] = '<?php echo $strings["IdFuncionalidad"]?>';
atributo['NombreFuncionalidad'] = '<?php echo $strings["NombreFuncionalidad"]?>';
atributo['DescripFuncionalidad'] = '<?php echo $strings["DescripFuncionalidad"]?>';
//GESTIÓN DE ACCIONES
atributo['IdAccion'] = '<?php echo $strings["IdAccion"]?>';
atributo['NombreAccion'] = '<?php echo $strings["NombreAccion"]?>';
atributo['DescripAccion'] = '<?php echo $strings["DescripAccion"]?>';
//GESTION DE TRABAJO
atributo['IdTrabajo'] = '<?php echo $strings["IdTrabajo"]?>';
atributo['NombreTrabajo'] = '<?php echo $strings["NombreTrabajo"]?>';
atributo['FechaIniTrabajo'] = '<?php echo $strings["FechaIniTrabajo"]?>';
atributo['FechaFinTrabajo'] = '<?php echo $strings["FechaFinTrabajo"]?>';
atributo['PorcentajeNota'] = '<?php echo $strings["PorcentajeNota"]?>';
//GESTION ENTREGA
atributo['Horas'] = '<?php echo $strings["Horas"]?>';
atributo['Ruta'] = '<?php echo $strings["Ruta"]?>';
atributo['Alias'] = '<?php echo $strings["Alias"]?>';
//GESTION HISTORIA
atributo['IdHistoria'] = '<?php echo $strings["IdHistoria"]?>';
atributo['TextoHistoria'] = '<?php echo $strings["TextoHistoria"]?>';
//GESTION EVALUACION

atributo['LoginEvaluador'] = '<?php echo $strings["LoginEvaluador"]?>';
atributo['AliasEvaluado'] = '<?php echo $strings["AliasEvaluado"]?>';
atributo['CorrectoA'] = '<?php echo $strings["CorrectoA"]?>';
atributo['CorrectoP'] = '<?php echo $strings["CorrectoP"]?>';
atributo['ComenIncorrectoA'] = '<?php echo $strings["ComenIncorrectoA"]?>';
atributo['ComentIncorrectoP'] = '<?php echo $strings["ComentIncorrectoP"]?>';
atributo['OK'] = '<?php echo $strings["OK"]?>';
//GESTION ASIGNAC_QA
atributo['LoginEvaluado'] = '<?php echo $strings["LoginEvaluado"]?>';
//GESTION NOTA
atributo['NotaTrabajo'] = '<?php echo $strings["NotaTrabajo"]?>';
//GENERAR ASIGNAC QA
atributo['num'] = '<?php echo $strings["Número de QAs"]?>';

// function hayEspacio(campo): Comprueba que no tenga espacios el campo
function sinEspacio(campo) {
	//Comprueba si hay algun espacio
	if (/[\s]/.test(campo.value)) {
		//mensaje multidioma
		msgError('<?php echo $strings["El atributo "];?>' + atributo[campo.name] + '<?php echo $strings[" no puede tener espacios "];?>');
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
		msgError('<?php echo $strings["El atributo "];?>' + atributo[campo.name] + '<?php echo $strings[" no puede ser vacio"];?>');
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
		msgError('<?php echo $strings["Longitud incorrecta. El atributo "];?>' + atributo[campo.name] + '<?php echo $strings[" puede tener una longitud máxima de "];?>' + size + '<?php echo $strings[" y es de "];?>' + campo.value.length);
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
			msgError('<?php echo $strings["El atributo "];?>' + atributo[campo.name] + '<?php echo $strings[" contiene algún carácter no válido: "];?>' + campo.value.charAt(i));
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
			msgError('<?php echo $strings["El atributo "];?>' + atributo[campo.name] + '<?php echo $strings[" solo admite carácteres alfabéticos"];?>');
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
		msgError('<?php echo $strings["El atributo "];?>' + atributo[campo.name] + '<?php echo $strings[" tiene que ser un dígito"];?>');
		campo.focus();
		return false;
	} else {
		/*Comprueba que el valor de campo es mayor que valormayor, si es así muestra un mensaje de error y retorna false */
		if (campo.value > valormayor) {
			msgError('<?php echo $strings["El atributo "];?>' + atributo[campo.name] + '<?php echo $strings[" no puede ser mayor que "];?>' + valormayor);
			campo.focus();
			return false;
		} else {
			/*Comprueba que el valor de campo es menor que valormenor, si es así muestra un mensaje de error y retorna false */
			if (campo.value < valormenor) {
				msgError('<?php echo $strings["El atributo "];?>' + atributo[campo.name] + '<?php echo $strings[" no puede ser menor que "];?>' + valormenor);
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
		msgError('<?php echo $strings["El atributo "];?>' + atributo[campo.name] + '<?php echo $strings[" tiene un formato no válido"];?>');
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
			msgError('<?php echo $strings["El atributo "];?>' + atributo[campo.name] + '<?php echo $strings[" no puede tener más de "];?>' + numeroDecimales);
			campo.focus();
			return false;
		} else {// si no cumple con la condición del if anterior,
			/*Comprueba que el valor de campo es mayor que valormayor, si es así muestra un mensaje de error y retorna false */
			if (num > valormayor) {
				msgError('<?php echo $strings["El atributo "];?>' + atributo[campo.name] + '<?php echo $strings[" no puede ser mayor que "];?>' + valormayor);
				campo.focus();
				return false;
			} else {// si no cumple con la condición del if anterior,
				/*Comprueba que el valor de campo es menor que valormenor, si es así muestra un mensaje de error y retorna false */
				if (num < valormenor) {
					msgError('<?php echo $strings["El atributo "];?>' + atributo[campo.name] + '<?php echo $strings[" no puede ser menor que "];?>' + valormenor);
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
			msgError('<?php echo $strings["El atributo "];?>' + atributo[campo.name] + '<?php echo $strings[" tiene un formato erróneo, la letra del NIF no se corresponde"];?>');
			campo.focus();
			return false;
		} else {// si no cumple con la condición del if anterior,
			return true;
		}
	} else {// si no cumple con la condición del if anterior,
		msgError('<?php echo $strings["El atributo "];?>' + atributo[campo.name] + '<?php echo $strings[" tiene un formato erróneo"];?>');
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
		msgError('<?php echo $strings["El atributo "];?>' + atributo[campo.name] + '<?php echo $strings[" tiene un formato erróneo"];?>');
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
		msgError('<?php echo $strings["El atributo "];?>' + atributo[campo.name] + '<?php echo $strings[" tiene un formato erróneo"];?>');
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
        msgError('<?php echo $strings["El atributo "]?>' + atributo[campo.name] + '<?php echo $strings[" no permite las extensiones: .sh/.php"]; ?>');//mensaje multidioma
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

/*
	function comprobarLogin():valida todos los campos del formulario login antes de realizar el submit
*/
function comprobarLogin() {

	var login; /*variable que representa el elemento login del formulario de login */
	var pwd; /*variable que representa el elemento password del formulario de login */

	login = document.forms['Form'].elements[0];
	pwd = document.forms['Form'].elements[1];

	/*Comprueba si el login es vacio, retorna false*/
	if (!comprobarVacio(login)) {
		return false;
	} else {// si no cumple con la condición del if anterior,
		/*Comprobamos su longitud, si es mayor que 9, retorna false*/
		if (!comprobarLongitud(login, 9)) {
			return false;
		} else {// si no cumple con la condición del if anterior,
			/*Comprobamos si tiene caracteres especiales, si es así, retorna false */
			if (!comprobarTexto(login, 9)) {
				return false;
			}
		}
		/*Comprueba si la password es vacio, retorna false*/
		if (!comprobarVacio(pwd)) {
			return false;
		} else {// si no cumple con la condición del if anterior,
			/*Comprueba su longitud, si es mayor que 20, retorna false*/
			if (!comprobarLongitud(pwd, 20)) {
				return false;
			} else {// si no cumple con la condición del if anterior,
				/*Comprueba si tiene caracteres especiales, si es así, retorna false */
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
/*
	function comprobarAdd():valida todos los campos del formulario add antes de realizar el submit
*/
function comprobarAddUsuario() {

	var login; /*variable que representa el elemento login del formulario add */
	var pwd; /*variable que representa el elemento password del formulario add */
	var dni; /*variable que representa el elemento dni del formulario add */
	var nombreuser; /*variable que representa el elemento nombresuser del formulario add */
	var apellidosuser; /*variable que representa el elemento apellidosuser del formulario add */
	var telefono; /*variable que representa el elemento telefono del formulario add */
	var emailuser; /*variable que representa el elemento emailuser del formulario add */
	var direccion /*variable que representa el elemento direccion del formulario add */


	login = document.forms['ADD'].elements[0];
	pwd = document.forms['ADD'].elements[1];
	dni = document.forms['ADD'].elements[2];
	nombreuser = document.forms['ADD'].elements[3];
	apellidosuser = document.forms['ADD'].elements[4];
	emailuser = document.forms['ADD'].elements[5];
	direccion = document.forms['ADD'].elements[6];
	telefono = document.forms['ADD'].elements[7];



	/*Comprueba si login es vacio, retorna false*/
	if (!comprobarVacio(login)) {
		return false;
	} else {// si no cumple con la condición del if anterior,
		//Comprobamos que no hay espacio s intermedios
		if (!sinEspacio(login)) {
			return false;
		} else {// si no cumple con la condición del if anterior,
			/*Comprobamos su longitud, si es mayor que 15, retorna false*/
			if (!comprobarLongitud(login, 9)) {
				return false;
			} else {// si no cumple con la condición del if anterior,
				/*Comprobamos si tiene caracteres especiales, si es así, retorna false */
				if (!comprobarTexto(login, 9)) {
					return false;
				}
			}
		}
	}
	/*Comprueba si password es vacio, retorna false*/
	if (!comprobarVacio(pwd)) {
		return false;
	} else {// si no cumple con la condición del if anterior,
		//Comprobamos que no hay espacio s intermedios
		if (!sinEspacio(pwd)) {
			return false;
		} else {// si no cumple con la condición del if anterior,
			/*Comprueba su longitud, si es mayor que 20, retorna false*/
			if (!comprobarLongitud(pwd, 20)) {
				return false;
			} else {// si no cumple con la condición del if anterior,
				/*Comprueba si tiene caracteres especiales, si es así, retorna false */
				if (!comprobarTexto(pwd, 20)) {
					return false;
				}
			}
		}
	}
	/*Comprueba si dni es vacio, retorna false*/
	if (!comprobarVacio(dni)) {
		return false;
	} else {// si no cumple con la condición del if anterior,
		/*Comprueba su longitud, si es mayor que 9, retorna false*/
		if (!comprobarLongitud(dni, 9)) {
			return false;
		} else {// si no cumple con la condición del if anterior,
			/*Comprueba si tiene caracteres especiales, si es así, retorna false */
			if (!comprobarTexto(dni, 9)) {
				return false;
			} else {// si no cumple con la condición del if anterior,
				/*Comprueba si tiene un formato valido de dni */
				if (!comprobarDni(dni)) {
					return false;
				}
			}
		}
	}
	/*Comprueba si nombreuser es vacio, retorna false*/
	if (!comprobarVacio(nombreuser)) {
		return false;
	} else {// si no cumple con la condición del if anterior,
		/*Comprueba su longitud, si es mayor que 30, retorna false*/
		if (!comprobarLongitud(nombreuser, 30)) {
			return false;
		} else {// si no cumple con la condición del if anterior,
			/*Comprueba si tiene caracteres especiales, si es así, retorna false */
			if (!comprobarTexto(nombreuser, 30)) {
				return false;
			} else {// si no cumple con la condición del if anterior,
				/*Comprueba si tiene carácteres no alfanuméricos, si es así, retorna false */
				if (!comprobarAlfabetico(nombreuser, 30)) {
					return false;
				}
			}

		}
	}
	/*Comprueba si apellidosuser es vacio, retorna false*/
	if (!comprobarVacio(apellidosuser)) {
		return false;
	} else {// si no cumple con la condición del if anterior,
		/*Comprueba su longitud, si es mayor que 50, retorna false*/
		if (!comprobarLongitud(apellidosuser, 50)) {
			return false;
		} else {// si no cumple con la condición del if anterior,
			/*Comprueba si tiene caracteres especiales, si es así, retorna false */
			if (!comprobarTexto(apellidosuser, 50)) {
				return false;
			} else {// si no cumple con la condición del if anterior,
				/*Comprueba si tiene carácteres no alfanuméricos, si es así, retorna false */
				if (!comprobarAlfabetico(apellidosuser, 50)) {
					return false;
				}

			}
		}
	}

	/*Comprueba si emailuser es vacio, retorna false*/
	if (!comprobarVacio(emailuser)) {
		return false;
	} else {// si no cumple con la condición del if anterior,
		/*Comprueba su longitud, si es mayor que 60, retorna false*/
		if (!comprobarLongitud(emailuser, 40)) {
			return false;
		} else {// si no cumple con la condición del if anterior,
			/*Comprueba si tiene caracteres especiales, si es así, retorna false */
			if (!comprobarTexto(emailuser, 40)) {
				return false;
			} else {// si no cumple con la condición del if anterior,
				/*Comprueba si tiene su formato incorrecto, si es así, retorna false*/
				if (!comprobarEmail(emailuser)) {
					return false;
				}
			}
		}
	}
	if (!comprobarVacio(direccion)) {
		return false;
	} else {// si no cumple con la condición del if anterior,
		/*Comprueba su longitud, si es mayor que 60, retorna false*/
		if (!comprobarLongitud(direccion, 60)) {
			return false;
		} else {// si no cumple con la condición del if anterior,
			/*Comprueba si tiene caracteres especiales, si es así, retorna false */
			if (!comprobarTexto(direccion, 60)) {
				return false;
			}
		}
	}

	/*Comprueba si telelefono es vacio, retorna false*/
	if (!comprobarVacio(telefono)) {
		return false;
	} else {// si no cumple con la condición del if anterior,
		/*Comprueba su longitud, si es mayor que 11, retorna false*/
		if (!comprobarLongitud(telefono, 11)) {
			return false;
		} else {// si no cumple con la condición del if anterior,
			/*Comprueba si tiene caracteres especiales, si es así, retorna false */
			if (!comprobarTexto(telefono, 11)) {
				return false;
			} else {// si no cumple con la condición del if anterior,
				/*Comprueba si el formato no es correcto, si es así, retorna false */
				if (!comprobarTelf(telefono)) {
					return false;
				}

			}
		}
	}
	encriptar();
	return true;
}
/*
	function comprobarSearch():valida todos los campos del formulario search antes de realizar el submit
*/
function comprobarSearchUsuario() {


	var login; /*variable que representa el elemento login del formulario search*/
	var pwd; /*variable que representa el elemento password del formulario search*/
	var dni; /*variable que representa el elemento dni del formulario search */
	var nombreuser; /*variable que representa el elemento nombresuser del formulario search */
	var apellidosuser; /*variable que representa el elemento apellidosuser del formulario search */
	var telefono; /*variable que representa el elemento telefono del formulario search */
	var emailuser; /*variable que representa el elemento emailuser del formulario search */
	var direccion /*variable que representa el elemento direccion del formulario search */

	login = document.forms['SEARCH'].elements[0];
	pwd = document.forms['SEARCH'].elements[1];
	dni = document.forms['SEARCH'].elements[2];
	nombreuser = document.forms['SEARCH'].elements[3];
	apellidosuser = document.forms['SEARCH'].elements[4];
	emailuser = document.forms['SEARCH'].elements[5];
	direccion = document.forms['SEARCH'].elements[6];
	telefono = document.forms['SEARCH'].elements[7];

	/*Comprueba la longitud que tiene login, si es mayor que 15, retorna false*/
	if (!comprobarLongitud(login, 9)) {
		return false;
	} else {// si no cumple con la condición del if anterior,
		/*Comprueba si tiene caracteres especiales, si es así, retorna false */
		if (!comprobarTexto(login, 9)) {
			return false;
		}
	}
	/*Comprueba la longitud que tiene pwd, si es mayor que 128, retorna false*/
	if (!comprobarLongitud(pwd, 128)) {
		return false;
	} else {// si no cumple con la condición del if anterior,
		/*Comprueba si tiene caracteres especiales, si es así, retorna false */
		if (!comprobarTexto(pwd, 128)) {
			return false;
		}
	}

	/*Comprueba la longitud que tiene dni, si es mayor que 9, retorna false*/
	if (!comprobarLongitud(dni, 9)) {
		return false;
	} else {// si no cumple con la condición del if anterior,
		/*Comprueba si tiene caracteres especiales, si es así, retorna false */
		if (!comprobarTexto(dni, 9)) {
			return false;
		}
	}
	/*Comprueba la longitud que tiene nombreuser, si es mayor que 30, retorna false*/
	if (!comprobarLongitud(nombreuser, 30)) {
		return false;
	} else {// si no cumple con la condición del if anterior,
		/*Comprueba si tiene caracteres especiales, si es así, retorna false */
		if (!comprobarTexto(nombreuser, 30)) {
			return false;
		} else {// si no cumple con la condición del if anterior,
			/*Comprueba si tiene carácteres no alfanuméricos, si es así, retorna false */
			if (!comprobarAlfabetico(nombreuser, 30)) {
				return false;
			}
		}
	}
	/*Comprueba la longitud que tiene apellidosuser, si es mayor que 50, retorna false*/
	if (!comprobarLongitud(apellidosuser, 50)) {
		return false;
	} else {// si no cumple con la condición del if anterior,
		/*Comprueba si tiene caracteres especiales, si es así, retorna false */
		if (!comprobarTexto(apellidosuser, 50)) {
			return false;
		} else {// si no cumple con la condición del if anterior,
			/*Comprueba si tiene carácteres no alfanuméricos, si es así, retorna false */
			if (!comprobarAlfabetico(apellidosuser, 50)) {
				return false;
			}
		}
	}

	/*Comprueba la longitud que tiene emailuser, si es mayor que 60, retorna false*/
	if (!comprobarLongitud(emailuser, 40)) {
		return false;
	} else{// si no cumple con la condición del if anterior,
		/*Comprueba si tiene caracteres especiales, si es así, retorna false */
		if (!comprobarTexto(emailuser, 40)) {
			return false;
		}
	}


	/*Comprueba su longitud, si es mayor que 60, retorna false*/
	if (!comprobarLongitud(direccion, 60)) {
		return false;
	} else {// si no cumple con la condición del if anterior,
		/*Comprueba si tiene caracteres especiales, si es así, retorna false */
		if (!comprobarTexto(direccion, 60)) {
			return false;
		}
	}


	/*Comprueba la longitud que tiene telefono, si es mayor que 11, retorna false*/
	if (!comprobarLongitud(telefono, 11)) {
		return false;
	} else {// si no cumple con la condición del if anterior,
		/*Comprueba si tiene caracteres especiales, si es así, retorna false */
		if (!comprobarTexto(telefono, 11)) {
			return false;
		}
	}
	
	return true;
}
/*
	function comprobarEdit():valida todos los campos del formulario edit antes de realizar el submit
*/
function comprobarEditUsuario() {

	var login; /*variable que representa el elemento login del formulario edit */
	var pwd; /*variable que representa el elemento password del formulario edit */
	var dni; /*variable que representa el elemento dni del formulario edit */
	var nombreuser; /*variable que representa el elemento nombresuser del formulario edit */
	var apellidosuser; /*variable que representa el elemento apellidosuser del formulario edit */
	var telefono; /*variable que representa el elemento telefono del formulario edit */
	var emailuser; /*variable que representa el elemento emailuser del formulario edit */
	var direccion /*variable que representa el elemento direccion del formulario edit */

	login = document.forms['EDIT'].elements[0];
	pwd = document.forms['EDIT'].elements[1];
	dni = document.forms['EDIT'].elements[2];
	nombreuser = document.forms['EDIT'].elements[3];
	apellidosuser = document.forms['EDIT'].elements[4];
	emailuser = document.forms['EDIT'].elements[5];
	direccion = document.forms['EDIT'].elements[6];
	telefono = document.forms['EDIT'].elements[7];

	/*Comprueba si login es vacio, retorna false*/
	if (!comprobarVacio(login)) {
		return false;
	} else {// si no cumple con la condición del if anterior,
		//Comprobamos que no hay espacio s intermedios
		if (!sinEspacio(login)) {
			return false;
		} else {// si no cumple con la condición del if anterior,
			/*Comprobamos su longitud, si es mayor que 15, retorna false*/
			if (!comprobarLongitud(login, 9)) {
				return false;
			} else {// si no cumple con la condición del if anterior,
				/*Comprobamos si tiene caracteres especiales, si es así, retorna false */
				if (!comprobarTexto(login, 9)) {
					return false;
				}
			}
		}
	}
	/*Comprueba si password es vacio, retorna false*/
	if (!comprobarVacio(pwd)) {
		return false;
	} else {// si no cumple con la condición del if anterior,
		//Comprobamos que no hay espacio s intermedios
		if (!sinEspacio(pwd)) {
			return false;
		} else {// si no cumple con la condición del if anterior,
			/*Comprueba su longitud, si es mayor que 128, retorna false*/
			if (!comprobarLongitud(pwd, 128)) {
				return false;
			} else {// si no cumple con la condición del if anterior,
				/*Comprueba si tiene caracteres especiales, si es así, retorna false */
				if (!comprobarTexto(pwd, 128)) {
					return false;
				}
			}
		}
	}
	/*Comprueba si dni es vacio, retorna false*/
	if (!comprobarVacio(dni)) {
		return false;
	} else {// si no cumple con la condición del if anterior,
		/*Comprueba su longitud, si es mayor que 9, retorna false*/
		if (!comprobarLongitud(dni, 9)) {
			return false;
		} else {// si no cumple con la condición del if anterior,
			/*Comprueba si tiene caracteres especiales, si es así, retorna false */
			if (!comprobarTexto(dni, 9)) {
				return false;
			} else {// si no cumple con la condición del if anterior,
				/*Comprueba si tiene un formato valido de dni */
				if (!comprobarDni(dni)) {
					return false;
				}
			}
		}
	}
	/*Comprueba si nombreuser es vacio, retorna false*/
	if (!comprobarVacio(nombreuser)) {
		return false;
	} else {// si no cumple con la condición del if anterior,
		/*Comprueba su longitud, si es mayor que 30, retorna false*/
		if (!comprobarLongitud(nombreuser, 30)) {
			return false;
		} else {// si no cumple con la condición del if anterior,
			/*Comprueba si tiene caracteres especiales, si es así, retorna false */
			if (!comprobarTexto(nombreuser, 30)) {
				return false;
			} else {// si no cumple con la condición del if anterior,
				/*Comprueba si tiene carácteres no alfanuméricos, si es así, retorna false */
				if (!comprobarAlfabetico(nombreuser, 30)) {
					return false;
				}
			}

		}
	}
	/*Comprueba si apellidosuser es vacio, retorna false*/
	if (!comprobarVacio(apellidosuser)) {
		return false;
	} else {// si no cumple con la condición del if anterior,
		/*Comprueba su longitud, si es mayor que 50, retorna false*/
		if (!comprobarLongitud(apellidosuser, 50)) {
			return false;
		} else {// si no cumple con la condición del if anterior,
			/*Comprueba si tiene caracteres especiales, si es así, retorna false */
			if (!comprobarTexto(apellidosuser, 50)) {
				return false;
			} else {// si no cumple con la condición del if anterior,
				/*Comprueba si tiene carácteres no alfanuméricos, si es así, retorna false */
				if (!comprobarAlfabetico(apellidosuser, 50)) {
					return false;
				}

			}
		}
	}

	/*Comprueba si emailuser es vacio, retorna false*/
	if (!comprobarVacio(emailuser)) {
		return false;
	} else {// si no cumple con la condición del if anterior,
		/*Comprueba su longitud, si es mayor que 60, retorna false*/
		if (!comprobarLongitud(emailuser, 40)) {
			return false;
		} else {// si no cumple con la condición del if anterior,
			/*Comprueba si tiene caracteres especiales, si es así, retorna false */
			if (!comprobarTexto(emailuser, 40)) {
				return false;
			} else {// si no cumple con la condición del if anterior,
				/*Comprueba si tiene su formato incorrecto, si es así, retorna false*/
				if (!comprobarEmail(emailuser)) {
					return false;
				}
			}
		}
	}

	/*Comprueba si direccion es vacio, retorna false*/
	if (!comprobarVacio(direccion)) {
		return false;
	} else {// si no cumple con la condición del if anterior,
		/*Comprueba su longitud, si es mayor que 50, retorna false*/
		if (!comprobarLongitud(direccion, 60)) {
			return false;
		} else {// si no cumple con la condición del if anterior,
			/*Comprueba si tiene caracteres especiales, si es así, retorna false */
			if (!comprobarTexto(direccion, 60)) {
				return false;
			}
		}
	}

	/*Comprueba si telelefono es vacio, retorna false*/
	if (!comprobarVacio(telefono)) {
		return false;
	} else {// si no cumple con la condición del if anterior,
		/*Comprueba su longitud, si es mayor que 11, retorna false*/
		if (!comprobarLongitud(telefono, 11)) {
			return false;
		} else {// si no cumple con la condición del if anterior,
			/*Comprueba si tiene caracteres especiales, si es así, retorna false */
			if (!comprobarTexto(telefono, 11)) {
				return false;
			} else {// si no cumple con la condición del if anterior,
				/*Comprueba si tiene un formato incorrecto, si es así, retorna false */
				if (!comprobarTelf(telefono)) {
					return false;
				}

			}
		}
	}
	return true;


}
/*
	function comprobarSearchAccion: valida todos los campos del formulario search antes de realizar el submit
*/
function comprobarSearchAccion() {

	var IdAccion; /*variable que representa el elemento IdAccion del formulario search de gestión de accion*/
	var NombreAccion; /*variable que representa el elemento NombreAccion del formulario search de gestión de accion*/
	var DescripAccion; /*variable que representa el elemento DescripAccion del formulario search de gestión de accion*/

	IdAccion = document.forms['SEARCH'].elements[0];
	NombreAccion = document.forms['SEARCH'].elements[1];
	DescripAccion = document.forms['SEARCH'].elements[2];

	/*Comprueba su longitud, si es mayor que 6, retorna false*/
	if (!comprobarLongitud(IdAccion, 6)) {
		return false;
	} else {// si no cumple con la condición del if anterior,
		/*Comprueba si tiene caracteres especiales, si es así, retorna false */
		if (!comprobarTexto(IdAccion, 6)) {
			return false;
		}
	}
	/*Comprueba su longitud, si es mayor que 60, retorna false*/
	if (!comprobarLongitud(NombreAccion, 60)) {
		return false;
	} else {// si no cumple con la condición del if anterior,
		/*Comprueba si tiene caracteres especiales, si es así, retorna false */
		if (!comprobarTexto(NombreAccion, 60)) {
			return false;
		} 
	}
	/*Comprueba su longitud, si es mayor que 100, retorna false*/
	if (!comprobarLongitud(DescripAccion, 100)) {
		return false;
	} else {// si no cumple con la condición del if anterior,
		/*Comprueba si tiene caracteres especiales, si es así, retorna false */
		if (!comprobarTexto(DescripAccion, 100)) {
			return false;
		}
	}

	return true;
}
/*
	function comprobarEditAccion: valida todos los campos del formulario edit antes de realizar el submit
*/
function comprobarEditAccion() {

	var IdAccion; /*variable que representa el elemento IdAccion del formulario edit de gestión de accion*/
	var NombreAccion; /*variable que representa el elemento NombreAccion del formulario edit de gestión de accion*/
	var DescripAccion; /*variable que representa el elemento DescripAccion del formulario edit de gestión de accion*/

	IdAccion = document.forms['EDIT'].elements[0];
	NombreAccion = document.forms['EDIT'].elements[1];
	DescripAccion = document.forms['EDIT'].elements[2];


	/*Comprueba si IdAccion es vacio, retorna false*/
	if (!comprobarVacio(IdAccion)) {
		return false;
	} else {// si no cumple con la condición del if anterior,
			/*Comprobamos su longitud, si es mayor que 6, retorna false*/
			if (!comprobarLongitud(IdAccion, 6)) {
				return false;
			} else {// si no cumple con la condición del if anterior,
				/*Comprobamos si tiene caracteres especiales, si es así, retorna false */
				if (!comprobarTexto(IdAccion, 6)) {
					return false;
				}
			}
		}
	
	/*Comprueba si NombreAccion es vacio, retorna false*/
	if (!comprobarVacio(NombreAccion)) {
		return false;
	} else {// si no cumple con la condición del if anterior,
			/*Comprueba su longitud, si es mayor que 128, retorna false*/
			if (!comprobarLongitud(NombreAccion, 60)) {
				return false;
			} else {// si no cumple con la condición del if anterior,
				/*Comprueba si tiene caracteres especiales, si es así, retorna false */
				if (!comprobarTexto(NombreAccion, 60)) {
					return false;
				}
			}
		}
	
	/*Comprueba si DescripAccion es vacio, retorna false*/
	if (!comprobarVacio(DescripAccion)) {
		return false;
	} else {// si no cumple con la condición del if anterior,
		/*Comprueba su longitud, si es mayor que 100, retorna false*/
		if (!comprobarLongitud(DescripAccion, 100)) {
			return false;
		} else {// si no cumple con la condición del if anterior,
			/*Comprueba si tiene caracteres especiales, si es así, retorna false */
			if (!comprobarTexto(DescripAccion, 100)) {
				return false;
			}
		}
	}

	return true;

}
/*
	function comprobarAddAccion: valida todos los campos del formulario add antes de realizar el submit
*/
function comprobarAddAccion() {

	var IdAccion; /*variable que representa el elemento IdAccion del formulario add de gestión de accion*/
	var NombreAccion; /*variable que representa el elemento NombreAccion del formulario add de gestión de accion*/
	var DescripAccion; /*variable que representa el elemento DescripAccion del formulario add de gestión de accion*/

	IdAccion = document.forms['ADD'].elements[0];
	NombreAccion = document.forms['ADD'].elements[1];
	DescripAccion = document.forms['ADD'].elements[2];


	/*Comprueba si IdAccion es vacio, retorna false*/
	if (!comprobarVacio(IdAccion)) {
		return false;
	} else {// si no cumple con la condición del if anterior,
			/*Comprobamos su longitud, si es mayor que 6, retorna false*/
			if (!comprobarLongitud(IdAccion, 6)) {
				return false;
			} else {// si no cumple con la condición del if anterior,
				/*Comprobamos si tiene caracteres especiales, si es así, retorna false */
				if (!comprobarTexto(IdAccion, 6)) {
					return false;
				}
			}
		}
	
	/*Comprueba si NombreAccion es vacio, retorna false*/
	if (!comprobarVacio(NombreAccion)) {
		return false;
	} else{// si no cumple con la condición del if anterior,
			/*Comprueba su longitud, si es mayor que 60, retorna false*/
			if (!comprobarLongitud(NombreAccion, 60)) {
				return false;
			} else {// si no cumple con la condición del if anterior,
				/*Comprueba si tiene caracteres especiales, si es así, retorna false */
				if (!comprobarTexto(NombreAccion, 60)) {
					return false;
				}
			}
		}
	
	/*Comprueba si DescripAccion es vacio, retorna false*/
	if (!comprobarVacio(DescripAccion)) {
		return false;
	} else {// si no cumple con la condición del if anterior,
		/*Comprueba su longitud, si es mayor que 100, retorna false*/
		if (!comprobarLongitud(DescripAccion, 100)) {
			return false;
		} else {// si no cumple con la condición del if anterior,
			/*Comprueba si tiene caracteres especiales, si es así, retorna false */
			if (!comprobarTexto(DescripAccion, 100)) {
				return false;
			}
		}
	}

	return true;

}
/*
	function comprobarAddTrabajo: valida todos los campos del formulario add antes de realizar el submit
*/
function comprobarAddTrabajo() {


	var IdTrabajo; /*variable que representa el elemento IdTrabajo del formulario add */
	var NombreTrabajo; /*variable que representa el elemento NombreTrabajo del formulario add */
	var FechaIniTrabajo; /*variable que representa el elemento fechaIniYrabajo del formulario add */
	var FechaFinTrabajo; /*variable que representa el elemento fechaFinTrabajo del formulario add */
	var PorcentajeNota; /*variable que representa el elemento PorcentajeNota del formulario add */


	IdTrabajo = document.forms['ADD'].elements[0];
	NombreTrabajo = document.forms['ADD'].elements[1];
	FechaIniTrabajo = document.forms['ADD'].elements[2];
	FechaFinTrabajo = document.forms['ADD'].elements[3];
	PorcentajeNota = document.forms['ADD'].elements[4];


	/*Comprueba si IdTrabajo es vacio, retorna false*/
	if (!comprobarVacio(IdTrabajo)) {
		return false;
	} else  {// si no cumple con la condición del if anterior,
			/*Comprobamos su longitud, si es mayor que 6, retorna false*/
			if (!comprobarLongitud(IdTrabajo, 6)) {
				return false;
			} else {// si no cumple con la condición del if anterior,
				/*Comprobamos si tiene caracteres especiales, si es así, retorna false */
				if (!comprobarTexto(IdTrabajo, 6)) {
					return false;
				}
			}
		}
	
	/*Comprueba si NombreTrabajo es vacio, retorna false*/
	if (!comprobarVacio(NombreTrabajo)) {
		return false;
	} else {// si no cumple con la condición del if anterior,
			/*Comprueba su longitud, si es mayor que 60, retorna false*/
			if (!comprobarLongitud(NombreTrabajo, 60)) {
				return false;
			} else {// si no cumple con la condición del if anterior,
				/*Comprueba si tiene caracteres especiales, si es así, retorna false */
				if (!comprobarTexto(NombreTrabajo, 60)) {
					return false;
				}
			}
		}
	

	/*Comprueba si FechaIniTrabajo es vacio, retorna false*/
	if (!comprobarVacio(FechaIniTrabajo)) {
		return false;
	}
	/*Comprueba si FechaFinTrabajo es vacio, retorna false*/
	if (!comprobarVacio(FechaFinTrabajo)) {
		return false;
	}

	/*Comprueba si PorcentajeNota es vacio, retorna false*/
	if (!comprobarVacio(PorcentajeNota)) {
		return false;
	} else {// si no cumple con la condición del if anterior,
		/*Comprueba su longitud, si es mayor que 2, retorna false*/
		if (!comprobarLongitud(PorcentajeNota, 2)) {
			return false;
		} else {// si no cumple con la condición del if anterior,
			/*Comprueba si tiene caracteres especiales, si es así, retorna false */
			if (!comprobarTexto(PorcentajeNota, 2)) {
				return false;
			} else {// si no cumple con la condición del if anterior,
				/*Comprueba que sea un numero entero y este entre 0 y 100*/
				if (!comprobarEntero(PorcentajeNota, 0, 100)) {
					return false;

				}
			}
		}
	}

	return true;

}
/*
	function comprobarEditAccion: valida todos los campos del formulario edit antes de realizar el submit
*/
function comprobarEditTrabajo() {


	var IdTrabajo; /*variable que representa el elemento IdTrabajo del formulario edit */
	var NombreTrabajo; /*variable que representa el elemento NombreTrabajo del formulario edit */
	var FechaIniTrabajo; /*variable que representa el elemento fechaIniYrabajo del formulario edit */
	var FechaFinTrabajo; /*variable que representa el elemento fechaFinTrabajo del formulario edit */
	var PorcentajeNota; /*variable que representa el elemento PorcentajeNota del formulario edit */


	IdTrabajo = document.forms['EDIT'].elements[0];
	NombreTrabajo = document.forms['EDIT'].elements[1];
	FechaIniTrabajo = document.forms['EDIT'].elements[2];
	FechaFinTrabajo = document.forms['EDIT'].elements[3];
	PorcentajeNota = document.forms['EDIT'].elements[4];


	/*Comprueba si IdTrabajo es vacio, retorna false*/
	if (!comprobarVacio(IdTrabajo)) {
		return false;
	} else {// si no cumple con la condición del if anterior,
			/*Comprobamos su longitud, si es mayor que 6, retorna false*/
			if (!comprobarLongitud(IdTrabajo, 6)) {
				return false;
			} else {// si no cumple con la condición del if anterior,
				/*Comprobamos si tiene caracteres especiales, si es así, retorna false */
				if (!comprobarTexto(IdTrabajo, 6)) {
					return false;
				}
			}
		}
	
	/*Comprueba si NombreTrabajo es vacio, retorna false*/
	if (!comprobarVacio(NombreTrabajo)) {
		return false;
	}  else {// si no cumple con la condición del if anterior,
			/*Comprueba su longitud, si es mayor que 60, retorna false*/
			if (!comprobarLongitud(NombreTrabajo, 60)) {
				return false;
			} else {// si no cumple con la condición del if anterior,
				/*Comprueba si tiene caracteres especiales, si es así, retorna false */
				if (!comprobarTexto(NombreTrabajo, 60)) {
					return false;
				}
			}
		}
	

	/*Comprueba si FechaIniTrabajo es vacio, retorna false*/
	if (!comprobarVacio(FechaIniTrabajo)) {
		return false;
	}
	/*Comprueba si FechaFinTrabajo es vacio, retorna false*/
	if (!comprobarVacio(FechaFinTrabajo)) {
		return false;
	}

	/*Comprueba si PorcentajeNota es vacio, retorna false*/
	if (!comprobarVacio(PorcentajeNota)) {
		return false;
	} else {// si no cumple con la condición del if anterior,
		/*Comprueba su longitud, si es mayor que 2, retorna false*/
		if (!comprobarLongitud(PorcentajeNota, 2)) {
			return false;
		} else {// si no cumple con la condición del if anterior,
			/*Comprueba si tiene caracteres especiales, si es así, retorna false */
			if (!comprobarTexto(PorcentajeNota, 2)) {
				return false;
			} else {// si no cumple con la condición del if anterior,
				/*Comprueba que sea un numero entero y este entre 0 y 100*/
				if (!comprobarEntero(PorcentajeNota, 0, 100)) {
					return false;

				}
			}
		}
	}

	return true;

}
/*
	function comprobarSearchAccion: valida todos los campos del formulario search antes de realizar el submit
*/
function comprobarSearchTrabajo() {



	var IdTrabajo; /*variable que representa el elemento IdTrabajo del formulario search */
	var NombreTrabajo; /*variable que representa el elemento NombreTrabajo del formulario search */
	var FechaIniTrabajo; /*variable que representa el elemento fechaIniYrabajo del formulario search */
	var FechaFinTrabajo; /*variable que representa el elemento fechaFinTrabajo del formulario search */
	var PorcentajeNota; /*variable que representa el elemento PorcentajeNota del formulario search */


	IdTrabajo = document.forms['SEARCH'].elements[0];
	NombreTrabajo = document.forms['SEARCH'].elements[1];
	FechaIniTrabajo = document.forms['SEARCH'].elements[2];
	FechaFinTrabajo = document.forms['SEARCH'].elements[3];
	PorcentajeNota = document.forms['SEARCH'].elements[4];




	/*Comprobamos su longitud, si es mayor que 6, retorna false*/
	if (!comprobarLongitud(IdTrabajo, 6)) {
		return false;
	} else {// si no cumple con la condición del if anterior,
		/*Comprobamos si tiene caracteres especiales, si es así, retorna false */
		if (!comprobarTexto(IdTrabajo, 6)) {
			return false;
		}
	}



	/*Comprueba su longitud, si es mayor que 60, retorna false*/
	if (!comprobarLongitud(NombreTrabajo, 60)) {
		return false;
	} else {// si no cumple con la condición del if anterior,
		/*Comprueba si tiene caracteres especiales, si es así, retorna false */
		if (!comprobarTexto(NombreTrabajo, 60)) {
			return false;
		}
	}

	//Comprobamos que tenga un formato válido
	if (!comprobarCampoNumFormSearch(PorcentajeNota, 2, 0, 100)) {
		return false;
	}

	return true;

}
/*
	function comprobarAddEntrega: valida todos los campos del formulario add antes de realizar el submit
*/
function comprobarAddEntrega() {

	var login; /*variable que representa el elemento login del formulario add de gestión de accion*/
	var IdTrabajo; /*variable que representa el elemento IdTrabajo del formulario add de gestión de accion*/
	var Horas; /*variable que representa el elemento Horas del formulario add de gestión de accion*/
	var Ruta; /*variable que representa el elemento Ruta del formulario add de gestión de accion*/
	login = document.forms['ADD'].elements[0];
	IdTrabajo = document.forms['ADD'].elements[1];
	Horas = document.forms['ADD'].elements[2];
	Ruta = document.forms['ADD'].elements[3];

	/*Comprueba si login es vacio, retorna false*/
	if (!comprobarVacio(login)) {
		return false;
	} else {// si no cumple con la condición del if anterior,
			/*Comprobamos su longitud, si es mayor que 6, retorna false*/
			if (!comprobarLongitud(login, 9)) {
				return false;
			} else {// si no cumple con la condición del if anterior,
				/*Comprobamos si tiene caracteres especiales, si es así, retorna false */
				if (!comprobarTexto(login, 9)) {
					return false;
				}
			}
		}
	
	/*Comprueba si IdTrabajo es vacio, retorna false*/
	if (!comprobarVacio(IdTrabajo)) {
		return false;
	} else {// si no cumple con la condición del if anterior,
			/*Comprueba su longitud, si es mayor que 6, retorna false*/
			if (!comprobarLongitud(IdTrabajo, 6)) {
				return false;
			} else {// si no cumple con la condición del if anterior,
				/*Comprueba si tiene caracteres especiales, si es así, retorna false */
				if (!comprobarTexto(IdTrabajo, 6)) {
					return false;
				}
			}
		}
	
	/*Comprueba si Horas es vacio, retorna false*/
	if (!comprobarVacio(Horas)) {
		return false;
	} else {// si no cumple con la condición del if anterior,
		/*Comprueba su longitud, si es mayor que 2, retorna false*/
		if (!comprobarLongitud(Horas, 2)) {
			return false;
		} else {// si no cumple con la condición del if anterior,
			/*Comprueba si tiene caracteres especiales, si es así, retorna false */
			if (!comprobarTexto(Horas, 2)) {
				return false;
			} else {// si no cumple con la condición del if anterior,
				//Comprueba si es un numero entero y esta entre 0 y 99
				if (!comprobarEntero(Horas, 0, 99)) {
					return false;
				}
			}
		}
	}
	/*Comprueba si Ruta es vacio, retorna false*/
	if (!comprobarVacio(Ruta)) {
		return false;
	}else{// si no cumple con la condición del if anterior,
		/*Comprueba que Ruta tenga una extensión permitida*/
		if(!comprobarExtension(Ruta)){
			return false;
		}
	}

	return true;

}
/*
	function comprobarEditEntrega: valdia todos los campos del formulario Edit antes de realizar el submit
*/
function comprobarEditEntrega() {
	
	var Alias /*variable que representa el elemento Alias del formulario edit de gestión de accion*/
	var Horas; /*variable que representa el elemento Horas del formulario edit de gestión de accion*/
	var Ruta; /*variable que representa el elemento Ruta del formulario edit de gestión de accion*/
	
	Alias = document.forms['EDIT'].elements[2];
	Horas = document.forms['EDIT'].elements[3];
	Ruta = document.forms['EDIT'].elements[4];

	
	/*Comprueba si Horas es vacio, retorna false*/
	if (!comprobarVacio(Alias)) {
		return false;
	} else {// si no cumple con la condición del if anterior,
		/*Comprueba su longitud, si es mayor que 6, retorna false*/
		if (!comprobarLongitud(Alias, 6)) {
			return false;
		} else {
			/*Comprueba si tiene caracteres especiales, si es así, retorna false */
			if (!comprobarTexto(Alias, 6)) {
				return false;
			} 
		}
	}
	/*Comprueba si Horas es vacio, retorna false*/
	if (!comprobarVacio(Horas)) {
		return false;
	} else {// si no cumple con la condición del if anterior,
		/*Comprueba su longitud, si es mayor que 2, retorna false*/
		if (!comprobarLongitud(Horas, 2)) {
			return false;
		} else {// si no cumple con la condición del if anterior,
			/*Comprueba si tiene caracteres especiales, si es así, retorna false */
			if (!comprobarTexto(Horas, 2)) {
				return false;
			} else {// si no cumple con la condición del if anterior,
				//Comprueba si es un numero entero y esta entre 0 y 99
				if (!comprobarEntero(Horas, 0, 99)) {
					return false;
				}
			}
		}
	}

		/*Comprueba que Ruta tenga una extensión permitida*/
		if(Ruta.value != null && !comprobarExtension(Ruta)){
			return false;
		}
	

	return true;

}
/*
	function comprobarSearchEntrega: valida todos los campos del formulario Seach antes de realizar el submit
*/
function comprobarSearchEntrega(){
	var login; /*variable que representa el elemento login del formulario search de gestión de entrega*/
	var IdTrabajo; /*variable que representa el elemento IdTrabajo del formulario search de gestión de entrega*/
	var Alias; /*variable que representa el elemento Alias del formulario search de gestión de entrega*/
	var Horas; /*variable que representa el elemento Horas del formulario search de gestión de entrega*/
	var Ruta; /*variable que representa el elemento Ruta del formulario search de gestión de entrega*/
	
	login = document.forms['SEARCH'].elements[0];
	IdTrabajo = document.forms['SEARCH'].elements[1];
	Alias = document.forms['SEARCH'].elements[2];
	Horas = document.forms['SEARCH'].elements[3];
	Ruta = document.forms['SEARCH'].elements[4];
	


	/*Comprobamos su longitud, si es mayor que 6, retorna false*/
	if (!comprobarLongitud(login, 9)) {
		return false;
	} else {// si no cumple con la condición del if anterior,
		/*Comprobamos si tiene caracteres especiales, si es así, retorna false */
		if (!comprobarTexto(login, 9)) {
			return false;
		}
	}



	/*Comprueba su longitud, si es mayor que 6, retorna false*/
	if (!comprobarLongitud(IdTrabajo, 6)) {
		return false;
	} else {// si no cumple con la condición del if anterior,
		/*Comprueba si tiene caracteres especiales, si es así, retorna false */
		if (!comprobarTexto(IdTrabajo, 6)) {
			return false;
		}
	}



	/*Comprueba su longitud, si es mayor que 6, retorna false*/
	if (!comprobarLongitud(Alias, 6)) {
		return false;
	} else {// si no cumple con la condición del if anterior,
		/*Comprueba si tiene caracteres especiales, si es así, retorna false */
		if (!comprobarTexto(Alias, 6)) {
			return false;
		}
	}

	//Comprobamos que tenga un formato válido
	if (!comprobarCampoNumFormSearch(Horas, 2, 0, 99)) {
		return false;
	}


		/*Comprueba que Ruta tenga una extensión permitida*/
		if(Ruta.value != null && !comprobarExtension(Ruta)){
			return false;
		}
	

	return true;
}
/*
	function comprobarAddHistoria: valida todos los campos del formulario add antes de realizar el submit
*/
function comprobarAddHistoria() {

	var IdTrabajo; /*variable que representa el elemento IdTrabajo del formulario add de gestión de historia*/
	var IdHistoria; /*variable que representa el elemento IdHistoria del formulario add de gestión de historia*/
	var TextoHistoria; /*variable que representa el elemento TextoHistoria del formulario add de gestión de historia*/

	IdTrabajo = document.forms['ADD'].elements[0];
	IdHistoria = document.forms['ADD'].elements[1];
	TextoHistoria = document.forms['ADD'].elements[2];


	/*Comprueba si IdTrabajo es vacio, retorna false*/
	if (!comprobarVacio(IdTrabajo)) {
		return false;
	} else {// si no cumple con la condición del if anterior,
			/*Comprobamos su longitud, si es mayor que 6, retorna false*/
			if (!comprobarLongitud(IdTrabajo, 6)) {
				return false;
			} else {// si no cumple con la condición del if anterior,
				/*Comprobamos si tiene caracteres especiales, si es así, retorna false */
				if (!comprobarTexto(IdTrabajo, 6)) {
					return false;
				}
			}
		}
	
	/*Comprueba si IdHistoria es vacio, retorna false*/
	if (!comprobarVacio(IdHistoria)) {
		return false;
	}else {// si no cumple con la condición del if anterior,
			/*Comprueba su longitud, si es mayor que 2, retorna false*/
			if (!comprobarLongitud(IdHistoria, 2)) {
				return false;
			} else {// si no cumple con la condición del if anterior,
				/*Comprueba si tiene caracteres especiales, si es así, retorna false */
				if (!comprobarTexto(IdHistoria, 2)) {
					return false;
				} else {// si no cumple con la condición del if anterior,
					/*Comprueba que sea un entero y esté entre 0 y 99*/
					if (!comprobarEntero(IdHistoria, 0, 99)) {
						return false;
					}
				}
			}
		}
	
	/*Comprueba si TextoHistoria es vacio, retorna false*/
	if (!comprobarVacio(TextoHistoria)) {
		return false;
	} else {// si no cumple con la condición del if anterior,
		/*Comprueba su longitud, si es mayor que 300, retorna false*/
		if (!comprobarLongitud(TextoHistoria, 300)) {
			return false;
		} else {// si no cumple con la condición del if anterior,
			/*Comprueba si tiene caracteres especiales, si es así, retorna false */
			if (!comprobarTexto(TextoHistoria, 300)) {
				return false;
			}
		}
	}

	return true;

}
/*
	function comprobarEditHistoria: valida todos los campos del formulario edit antes de realizar el submit
*/
function comprobarEditHistoria() {

	var IdTrabajo; /*variable que representa el elemento IdTrabajo del formulario edit de gestión de historia*/
	var IdHistoria; /*variable que representa el elemento IdHistoria del formulario edit de gestión de historia*/
	var TextoHistoria; /*variable que representa el elemento TextoHistoria del formulario edit de gestión de historia*/

	IdTrabajo = document.forms['EDIT'].elements[0];
	IdHistoria = document.forms['EDIT'].elements[1];
	TextoHistoria = document.forms['EDIT'].elements[2];


	/*Comprueba si IdTrabajo es vacio, retorna false*/
	if (!comprobarVacio(IdTrabajo)) {
		return false;
	} else {// si no cumple con la condición del if anterior,
			/*Comprobamos su longitud, si es mayor que 6, retorna false*/
			if (!comprobarLongitud(IdTrabajo, 6)) {
				return false;
			} else {// si no cumple con la condición del if anterior,
				/*Comprobamos si tiene caracteres especiales, si es así, retorna false */
				if (!comprobarTexto(IdTrabajo, 6)) {
					return false;
				}
			}
		}
	
	/*Comprueba si IdHistoria es vacio, retorna false*/
	if (!comprobarVacio(IdHistoria)) {
		return false;
	} else {// si no cumple con la condición del if anterior,
			/*Comprueba su longitud, si es mayor que 2, retorna false*/
			if (!comprobarLongitud(IdHistoria, 2)) {
				return false;
			} else {// si no cumple con la condición del if anterior,
				/*Comprueba si tiene caracteres especiales, si es así, retorna false */
				if (!comprobarTexto(IdHistoria, 2)) {
					return false;
				} else {// si no cumple con la condición del if anterior,
					/*Comprueba que sea un entero y esté entre 0 y 99*/
					if (!comprobarEntero(IdHistoria, 0, 99)) {
						return false;
					}
				}
			}
		}
	
	/*Comprueba si TextoHistoria es vacio, retorna false*/
	if (!comprobarVacio(TextoHistoria)) {
		return false;
	} else {// si no cumple con la condición del if anterior,
		/*Comprueba su longitud, si es mayor que 300, retorna false*/
		if (!comprobarLongitud(TextoHistoria, 300)) {
			return false;
		} else {
			/*Comprueba si tiene caracteres especiales, si es así, retorna false */
			if (!comprobarTexto(TextoHistoria, 300)) {
				return false;
			}
		}
	}

	return true;
}
/*
	function comprobarSearchHistoria: valida todos los campos del formulario search antes de realizar el submit
*/
function comprobarSearchHistoria() {

	var IdTrabajo; /*variable que representa el elemento IdTrabajo del formulario search de gestión de historia*/
	var IdHistoria; /*variable que representa el elemento IdHistoria del formulario search de gestión de historia*/
	var TextoHistoria; /*variable que representa el elemento TextoHistoria del formulario search de gestión de historia*/

	IdTrabajo = document.forms['SEARCH'].elements[0];
	IdHistoria = document.forms['SEARCH'].elements[1];
	TextoHistoria = document.forms['SEARCH'].elements[2];



	/*Comprobamos su longitud, si es mayor que 6, retorna false*/
	if (!comprobarLongitud(IdTrabajo, 6)) {
		return false;
	} else {// si no cumple con la condición del if anterior,
		/*Comprobamos si tiene caracteres especiales, si es así, retorna false */
		if (!comprobarTexto(IdTrabajo, 6)) {
			return false;
		}
	}

	//Comprobamos que tenga un formato válido
	if (!comprobarCampoNumFormSearch(IdHistoria, 2, 0, 99)) {
		return false;
	}


	/*Comprueba su longitud, si es mayor que 300, retorna false*/
	if (!comprobarLongitud(TextoHistoria, 300)) {
		return false;
	} else {// si no cumple con la condición del if anterior,
		/*Comprueba si tiene caracteres especiales, si es así, retorna false */
		if (!comprobarTexto(TextoHistoria, 300)) {
			return false;
		}
	}

	return true;

}
/*
	function comprobarAddHistoria: valida todos los campos del formulario add antes de realizar el submit
*/
function comprobarAddEvaluacion() {


	var IdTrabajo; /*variable que representa el elemento IdTrabajo del formulario add de gestión de evaluacion*/
	var LoginEvaluador; /*variable que representa el elemento LoginEvaluador del formulario add de gestión de evaluacion*/
	var AliasEvaluado; /*variable que representa el elemento AliasEvaluado del formulario add de gestión de evaluacion*/
	var IdHistoria; /*variable que representa el elemento IdHistoria del formulario add de gestión de evaluacion*/
	var CorrectoA; /*variable que representa el elemento CorrectoA del formulario add de gestión de evaluacion*/
	var ComenIncorrectoA; /*variable que representa el elemento ComenIncorrectoA del formulario add de gestión de evaluacion*/
	var CorrectoP; /*variable que representa el elemento CorrectoP del formulario add de gestión de evaluacion*/
	var ComentIncorrectoP; /*variable que representa el elemento ComentIncorrectoP del formulario add de gestión de evaluacion*/
	var OK; /*variable que representa el elemento OK del formulario add de gestión de evaluacion*/
	IdTrabajo = document.forms['ADD'].elements[0];
	LoginEvaluador = document.forms['ADD'].elements[1];
	AliasEvaluado = document.forms['ADD'].elements[2];
	IdHistoria = document.forms['ADD'].elements[3];
	CorrectoA = document.forms['ADD'].elements[4];
	ComenIncorrectoA = document.forms['ADD'].elements[5];
	CorrectoP = document.forms['ADD'].elements[6];
	ComentIncorrectoP = document.forms['ADD'].elements[7];
	OK = document.forms['ADD'].elements[8];

	/*Comprueba si IdTrabajo es vacio, retorna false*/
	if (!comprobarVacio(IdTrabajo)) {
		return false;
	} else {// si no cumple con la condición del if anterior,
			/*Comprobamos su longitud, si es mayor que 6, retorna false*/
			if (!comprobarLongitud(IdTrabajo, 6)) {
				return false;
			} else {// si no cumple con la condición del if anterior,
				/*Comprobamos si tiene caracteres especiales, si es así, retorna false */
				if (!comprobarTexto(IdTrabajo, 6)) {
					return false;
				}
			}
		}
	
	/*Comprueba si LoginEvaluador es vacio, retorna false*/
	if (!comprobarVacio(LoginEvaluador)) {
		return false;
	} else {// si no cumple con la condición del if anterior,
			/*Comprueba su longitud, si es mayor que 9, retorna false*/
			if (!comprobarLongitud(LoginEvaluador, 9)) {
				return false;
			} else {// si no cumple con la condición del if anterior,
				/*Comprueba si tiene caracteres especiales, si es así, retorna false */
				if (!comprobarTexto(LoginEvaluador, 9)) {
					return false;
				} 
			}
		}
	

	/*Comprueba si AliasEvaluado es vacio, retorna false*/
	if (!comprobarVacio(AliasEvaluado)) {
		return false;
	} else {// si no cumple con la condición del if anterior,
		/*Comprueba su longitud, si es mayor que 6, retorna false*/
		if (!comprobarLongitud(AliasEvaluado, 6)) {
			return false;
		} else {// si no cumple con la condición del if anterior,
			/*Comprueba si tiene caracteres especiales, si es así, retorna false */
			if (!comprobarTexto(AliasEvaluado, 6)) {
				return false;
			}
		}
	}


	/*Comprueba si IdHistoria es vacio, retorna false*/
	if (!comprobarVacio(IdHistoria)) {
		return false;
	} else {// si no cumple con la condición del if anterior,
			/*Comprueba su longitud, si es mayor que 2, retorna false*/
			if (!comprobarLongitud(IdHistoria, 2)) {
				return false;
			} else {// si no cumple con la condición del if anterior,
				/*Comprueba si tiene caracteres especiales, si es así, retorna false */
				if (!comprobarTexto(IdHistoria, 2)) {
					return false;
				} else {// si no cumple con la condición del if anterior,
					/*Comprueba que sea un entero y esté entre 0 y 99*/
					if (!comprobarEntero(IdHistoria, 0, 99)) {
						return false;
					}
				}
			}
		}
	


	/*Comprueba si CorrectoA es vacio, retorna false*/
	if (!comprobarVacio(CorrectoA)) {
		return false;
	} else {// si no cumple con la condición del if anterior,
			/*Comprueba su longitud, si es mayor que 1, retorna false*/
			if (!comprobarLongitud(CorrectoA, 1)) {
				return false;
			} else {// si no cumple con la condición del if anterior,
				/*Comprueba si tiene caracteres especiales, si es así, retorna false */
				if (!comprobarTexto(CorrectoA, 1)) {
					return false;
				} else {// si no cumple con la condición del if anterior,
					/*Comprueba que sea un entero y esté entre 0 y 2*/
					if (!comprobarEntero(CorrectoA, 0, 2)) {
						return false;
					}
				}
			}
		}
	

	
		/*Comprueba su longitud, si es mayor que 300, retorna false*/
		if (!comprobarLongitud(ComenIncorrectoA, 300)) {
			return false;
		} else {// si no cumple con la condición del if anterior,
			/*Comprueba si tiene caracteres especiales, si es así, retorna false */
			if (!comprobarTexto(ComenIncorrectoA, 300)) {
				return false;
			}
		}
	



	/*Comprueba si CorrectoP es vacio, retorna false*/
	if (!comprobarVacio(CorrectoP)) {
		return false;
	} else {// si no cumple con la condición del if anterior,
			/*Comprueba su longitud, si es mayor que 1, retorna false*/
			if (!comprobarLongitud(CorrectoP, 1)) {
				return false;
			} else {// si no cumple con la condición del if anterior,
				/*Comprueba si tiene caracteres especiales, si es así, retorna false */
				if (!comprobarTexto(CorrectoP, 1)) {
					return false;
				} else {// si no cumple con la condición del if anterior,
					/*Comprueba que sea un entero y esté entre 0 y 2*/
					if (!comprobarEntero(CorrectoP, 0, 2)) {
						return false;
					}
				}
			}
		}
	

		/*Comprueba su longitud, si es mayor que 300, retorna false*/
		if (!comprobarLongitud(ComentIncorrectoP, 300)) {
			return false;
		} else {// si no cumple con la condición del if anterior,
			/*Comprueba si tiene caracteres especiales, si es así, retorna false */
			if (!comprobarTexto(ComentIncorrectoP, 300)) {
				return false;
			}
		}
	
	/*Comprueba si OK es vacio, retorna false*/
	if (!comprobarVacio(OK)) {
		return false;
	} else {// si no cumple con la condición del if anterior,
			/*Comprueba su longitud, si es mayor que 1, retorna false*/
			if (!comprobarLongitud(OK, 1)) {
				return false;
			} else {// si no cumple con la condición del if anterior,
				/*Comprueba si tiene caracteres especiales, si es así, retorna false */
				if (!comprobarTexto(OK, 1)) {
					return false;
				} else {// si no cumple con la condición del if anterior,
					/*Comprueba que sea un entero y esté entre 0 y 1*/
					if (!comprobarEntero(OK, 0, 2)) {
						return false;
					}
				}
			}
		}
	
	return true;

}
/*
	function comprobarEditHistoria: valida todos los campos del formulario edit antes de realizar el submit
*/
function comprobarEditEvaluacion() {
	var IdTrabajo; /*variable que representa el elemento IdTrabajo del formulario edit de gestión de evaluacion*/
	var LoginEvaluador; /*variable que representa el elemento LoginEvaluador del formulario edit de gestión de evaluacion*/
	var AliasEvaluado; /*variable que representa el elemento AliasEvaluado del formulario edit de gestión de evaluacion*/
	var IdHistoria; /*variable que representa el elemento IdHistoria del formulario edit de gestión de evaluacion*/
	var CorrectoA; /*variable que representa el elemento CorrectoA del formulario edit de gestión de evaluacion*/
	var ComenIncorrectoA; /*variable que representa el elemento ComenIncorrectoA del formulario edit de gestión de evaluacion*/
	var CorrectoP; /*variable que representa el elemento CorrectoP del formulario edit de gestión de evaluacion*/
	var ComentIncorrectoP; /*variable que representa el elemento ComentIncorrectoP del formulario edit de gestión de evaluacion*/
	var OK; /*variable que representa el elemento OK del formulario edit de gestión de evaluacion*/
	IdTrabajo = document.forms['EDIT'].elements[0];
	LoginEvaluador = document.forms['EDIT'].elements[1];
	AliasEvaluado = document.forms['EDIT'].elements[2];
	IdHistoria = document.forms['EDIT'].elements[3];
	CorrectoA = document.forms['EDIT'].elements[4];
	ComenIncorrectoA = document.forms['EDIT'].elements[5];
	CorrectoP = document.forms['EDIT'].elements[6];
	ComentIncorrectoP = document.forms['EDIT'].elements[7];
	OK = document.forms['EDIT'].elements[8];

	/*Comprueba si IdTrabajo es vacio, retorna false*/
	if (!comprobarVacio(IdTrabajo)) {
		return false;
	} else {// si no cumple con la condición del if anterior,
			/*Comprobamos su longitud, si es mayor que 6, retorna false*/
			if (!comprobarLongitud(IdTrabajo, 6)) {
				return false;
			} else {// si no cumple con la condición del if anterior,
				/*Comprobamos si tiene caracteres especiales, si es así, retorna false */
				if (!comprobarTexto(IdTrabajo, 6)) {
					return false;
				}
			}
		}
	
	/*Comprueba si LoginEvaluador es vacio, retorna false*/
	if (!comprobarVacio(LoginEvaluador)) {
		return false;
	}  else {// si no cumple con la condición del if anterior,
			/*Comprueba su longitud, si es mayor que 9, retorna false*/
			if (!comprobarLongitud(LoginEvaluador, 9)) {
				return false;
			} else {// si no cumple con la condición del if anterior,
				/*Comprueba si tiene caracteres especiales, si es así, retorna false */
				if (!comprobarTexto(LoginEvaluador, 9)) {
					return false;
				} 
			}
		}
	

	/*Comprueba si AliasEvaluado es vacio, retorna false*/
	if (!comprobarVacio(AliasEvaluado)) {
		return false;
	} else {// si no cumple con la condición del if anterior,
		/*Comprueba su longitud, si es mayor que 6, retorna false*/
		if (!comprobarLongitud(AliasEvaluado, 6)) {
			return false;
		} else {// si no cumple con la condición del if anterior,
			/*Comprueba si tiene caracteres especiales, si es así, retorna false */
			if (!comprobarTexto(AliasEvaluado, 6)) {
				return false;
			}
		}
	}


	/*Comprueba si IdHistoria es vacio, retorna false*/
	if (!comprobarVacio(IdHistoria)) {
		return false;
	}  else {// si no cumple con la condición del if anterior,
			/*Comprueba su longitud, si es mayor que 2, retorna false*/
			if (!comprobarLongitud(IdHistoria, 2)) {
				return false;
			} else {// si no cumple con la condición del if anterior,
				/*Comprueba si tiene caracteres especiales, si es así, retorna false */
				if (!comprobarTexto(IdHistoria, 2)) {
					return false;
				} else {// si no cumple con la condición del if anterior,
					/*Comprueba que sea un entero y esté entre 0 y 99*/
					if (!comprobarEntero(IdHistoria, 0, 99)) {
						return false;
					}
				}
			}
		}
	


	/*Comprueba si CorrectoA es vacio, retorna false*/
	if (!comprobarVacio(CorrectoA)) {
		return false;
	} else{// si no cumple con la condición del if anterior,
		/*Comprueba su longitud, si es mayor que 1, retorna false*/
			if (!comprobarLongitud(CorrectoA, 1)) {
				return false;
			} else {// si no cumple con la condición del if anterior,
				/*Comprueba si tiene caracteres especiales, si es así, retorna false */
				if (!comprobarTexto(CorrectoA, 1)) {
					return false;
				} else {// si no cumple con la condición del if anterior,
					/*Comprueba que sea un entero y esté entre 0 y 2*/
					if (!comprobarEntero(CorrectoA, 0, 2)) {
						return false;
					}
				}
			}
		}
	


		/*Comprueba su longitud, si es mayor que 300, retorna false*/
		if (!comprobarLongitud(ComenIncorrectoA, 300)) {
			return false;
		} else {// si no cumple con la condición del if anterior,
			/*Comprueba si tiene caracteres especiales, si es así, retorna false */
			if (!comprobarTexto(ComenIncorrectoA, 300)) {
				return false;
			}
		}
	



	/*Comprueba si CorrectoP es vacio, retorna false*/
	if (!comprobarVacio(CorrectoP)) {
		return false;
	} else {// si no cumple con la condición del if anterior,
			/*Comprueba su longitud, si es mayor que 1, retorna false*/
			if (!comprobarLongitud(CorrectoP, 1)) {
				return false;
			} else {// si no cumple con la condición del if anterior,
				/*Comprueba si tiene caracteres especiales, si es así, retorna false */
				if (!comprobarTexto(CorrectoP, 1)) {
					return false;
				} else {// si no cumple con la condición del if anterior,
					/*Comprueba que sea un entero y esté entre 0 y 2*/
					if (!comprobarEntero(CorrectoP, 0, 2)) {
						return false;
					}
				}
			}
		}
	

		/*Comprueba su longitud, si es mayor que 300, retorna false*/
		if (!comprobarLongitud(ComentIncorrectoP, 300)) {
			return false;
		} else {// si no cumple con la condición del if anterior,
			/*Comprueba si tiene caracteres especiales, si es así, retorna false */
			if (!comprobarTexto(ComentIncorrectoP, 300)) {
				return false;
			}
		}
	
	/*Comprueba si OK es vacio, retorna false*/
	if (!comprobarVacio(OK)) {
		return false;
	} else {// si no cumple con la condición del if anterior,
			/*Comprueba su longitud, si es mayor que 1, retorna false*/
			if (!comprobarLongitud(OK, 1)) {
				return false;
			} else {// si no cumple con la condición del if anterior,
				/*Comprueba si tiene caracteres especiales, si es así, retorna false */
				if (!comprobarTexto(OK, 1)) {
					return false;
				} else {// si no cumple con la condición del if anterior,
					/*Comprueba que sea un entero y esté entre 0 y 2*/
					if (!comprobarEntero(OK, 0, 2)) {
						return false;
					}// si no cumple con la condición del if anterior,
				}
			}
		}
	
	return true;
}
/*
	function comprobarSearchHistoria: valida todos los campos del formulario search antes de realizar el submit
*/
function comprobarSearchEvaluacion() {
	var IdTrabajo; /*variable que representa el elemento IdTrabajo del formulario search de gestión de evaluacion*/
	var LoginEvaluador; /*variable que representa el elemento LoginEvaluador del formulario search de gestión de evaluacion*/
	var AliasEvaluado; /*variable que representa el elemento AliasEvaluado del formulario search de gestión de evaluacion*/
	var IdHistoria; /*variable que representa el elemento IdHistoria del formulario search de gestión de evaluacion*/
	var CorrectoA; /*variable que representa el elemento CorrectoA del formulario search de gestión de evaluacion*/
	var ComenIncorrectoA; /*variable que representa el elemento ComenIncorrectoA del formulario search de gestión de evaluacion*/
	var CorrectoP; /*variable que representa el elemento CorrectoP del formulario search de gestión de evaluacion*/
	var ComentIncorrectoP; /*variable que representa el elemento ComentIncorrectoP del formulario search de gestión de evaluacion*/
	var OK; /*variable que representa el elemento OK del formulario search de gestión de evaluacion*/
	IdTrabajo = document.forms['SEARCH'].elements[0];
	LoginEvaluador = document.forms['SEARCH'].elements[1];
	AliasEvaluado = document.forms['SEARCH'].elements[2];
	IdHistoria = document.forms['SEARCH'].elements[3];
	CorrectoA = document.forms['SEARCH'].elements[4];
	ComenIncorrectoA = document.forms['SEARCH'].elements[5];
	CorrectoP = document.forms['SEARCH'].elements[6];
	ComentIncorrectoP = document.forms['SEARCH'].elements[7];
	OK = document.forms['SEARCH'].elements[8];


	/*Comprobamos su longitud, si es mayor que 6, retorna false*/
	if (!comprobarLongitud(IdTrabajo, 6)) {
		return false;
	} else {// si no cumple con la condición del if anterior,
		/*Comprobamos si tiene caracteres especiales, si es así, retorna false */
		if (!comprobarTexto(IdTrabajo, 6)) {
			return false;
		}
	}



	/*Comprueba su longitud, si es mayor que 9, retorna false*/
	if (!comprobarLongitud(LoginEvaluador, 9)) {
		return false;
	} else {// si no cumple con la condición del if anterior,
		/*Comprueba si tiene caracteres especiales, si es así, retorna false */
		if (!comprobarTexto(LoginEvaluador, 9)) {
			return false;
		}
	}




	/*Comprueba su longitud, si es mayor que 6, retorna false*/
	if (!comprobarLongitud(AliasEvaluado, 6)) {
		return false;
	} else {// si no cumple con la condición del if anterior,
		/*Comprueba si tiene caracteres especiales, si es así, retorna false */
		if (!comprobarTexto(AliasEvaluado, 6)) {
			return false;
		}
	}

	//Comprobamos que tenga un formato válido
	if (!comprobarCampoNumFormSearch(IdHistoria, 2, 0, 99)) {
		return false;
	}

	//Comprobamos que tenga un formato válido
	if (!comprobarCampoNumFormSearch(CorrectoA, 1, 0, 2)) {
		return false;
	}




	/*Comprueba su longitud, si es mayor que 300, retorna false*/
	if (!comprobarLongitud(ComenIncorrectoA, 300)) {
		return false;
	} else {// si no cumple con la condición del if anterior,
		/*Comprueba si tiene caracteres especiales, si es así, retorna false */
		if (!comprobarTexto(ComenIncorrectoA, 300)) {
			return false;
		}
	}

	//Comprobamos que tenga un formato válido
	if (!comprobarCampoNumFormSearch(CorrectoP, 1, 0, 2)) {
		return false;
	}




	/*Comprueba su longitud, si es mayor que 300, retorna false*/
	if (!comprobarLongitud(ComentIncorrectoP, 300)) {
		return false;
	} else {// si no cumple con la condición del if anterior,
		/*Comprueba si tiene caracteres especiales, si es así, retorna false */
		if (!comprobarTexto(ComentIncorrectoP, 300)) {
			return false;
		}
	}
	//Comprobamos que tenga un formato válido
	if (!comprobarCampoNumFormSearch(OK, 1, 0, 2)) {
		return false;
	}
	/*Comprueba si OK es vacio, retorna false*/

}
/*
	function comprobarAddGrupo: valida todos los campos del formulario add antes de realizar el submit
*/
function comprobarAddGrupo() {


	var IdGrupo; /*variable que representa el elemento IdGrupo del formulario add de gestión de grupo*/
	var NombreGrupo; /*variable que representa el elemento NombreGrupo del formulario add de gestión de grupo*/
	var DescripGrupo; /*variable que representa el elemento DescripGrupo del formulario add de gestión de grupo*/
	
	IdGrupo = document.forms['ADD'].elements[0];
	NombreGrupo = document.forms['ADD'].elements[1];
	DescripGrupo = document.forms['ADD'].elements[2];
	
	
	/*Comprueba si NombreGrupo es vacio, retorna false*/
	if (!comprobarVacio(IdGrupo)) {
		return false;
	} else {// si no cumple con la condición del if anterior,
			/*Comprobamos su longitud, si es mayor que 60, retorna false*/
			if (!comprobarLongitud(IdGrupo, 60)) {
				return false;
			} else {// si no cumple con la condición del if anterior,
				/*Comprobamos si tiene caracteres especiales, si es así, retorna false */
				if (!comprobarTexto(IdGrupo, 60)) {
					return false;
				} 
			}
		}
	
	

	/*Comprueba si NombreGrupo es vacio, retorna false*/
	if (!comprobarVacio(NombreGrupo)) {
		return false;
	} else {// si no cumple con la condición del if anterior,
			/*Comprobamos su longitud, si es mayor que 60, retorna false*/
			if (!comprobarLongitud(NombreGrupo, 60)) {
				return false;
			} else {// si no cumple con la condición del if anterior,
				/*Comprobamos si tiene caracteres especiales, si es así, retorna false */
				if (!comprobarTexto(NombreGrupo, 60)) {
					return false;
				} 
			}
		}
	
	/*Comprueba si DescripGrupo es vacio, retorna false*/
	if (!comprobarVacio(DescripGrupo)) {
		return false;
	} else {// si no cumple con la condición del if anterior,

			/*Comprueba su longitud, si es mayor que 100, retorna false*/
			if (!comprobarLongitud(DescripGrupo, 100)) {
				return false;
			} else {// si no cumple con la condición del if anterior,
				/*Comprueba si tiene caracteres especiales, si es así, retorna false */
				if (!comprobarTexto(DescripGrupo, 100)) {
					return false;
				}

			}
		}



	return true;

}
/*
	function comprobarEditGrupo: valida todos los campos del formulario edit antes de realizar el submit
*/
function comprobarEditGrupo() {

	var IdGrupo; /*variable que representa el elemento IdGrupo del formulario edit de gestión de grupo*/
	var NombreGrupo; /*variable que representa el elemento NombreGrupo del formulario edit de gestión de grupo*/
	var DescripGrupo; /*variable que representa el elemento DescripGrupo del formulario edit de gestión de grupo*/
	IdGrupo = document.forms['EDIT'].elements[0];
	NombreGrupo = document.forms['EDIT'].elements[1];
	DescripGrupo = document.forms['EDIT'].elements[2];


	/*Comprueba si IdGrupo es vacio, retorna false*/
	if (!comprobarVacio(IdGrupo)) {
		return false;
	}  else {// si no cumple con la condición del if anterior,
			/*Comprobamos su longitud, si es mayor que 6, retorna false*/
			if (!comprobarLongitud(IdGrupo, 6)) {
				return false;
			} else {// si no cumple con la condición del if anterior,
				/*Comprobamos si tiene caracteres especiales, si es así, retorna false */
				if (!comprobarTexto(IdGrupo, 6)) {
					return false;
				}
			}
		}
	
	/*Comprueba si NombreGrupo es vacio, retorna false*/
	if (!comprobarVacio(NombreGrupo)) {
		return false;
	} else {// si no cumple con la condición del if anterior,
			/*Comprobamos su longitud, si es mayor que 60, retorna false*/
			if (!comprobarLongitud(NombreGrupo, 60)) {
				return false;
			} else {// si no cumple con la condición del if anterior,
				/*Comprobamos si tiene caracteres especiales, si es así, retorna false */
				if (!comprobarTexto(NombreGrupo, 60)) {
					return false;
				} 
			}
		}
	
	/*Comprueba si DescripGrupo es vacio, retorna false*/
	if (!comprobarVacio(DescripGrupo)) {
		return false;
	} else {// si no cumple con la condición del if anterior,
			/*Comprueba su longitud, si es mayor que 100, retorna false*/
			if (!comprobarLongitud(DescripGrupo, 100)) {
				return false;
			} else {// si no cumple con la condición del if anterior,
				/*Comprueba si tiene caracteres especiales, si es así, retorna false */
				if (!comprobarTexto(DescripGrupo, 100)) {
					return false;
				}

			}
		}
	


	return true;

}
/*
	function comprobarSearchGrupo: valida todos los campos del formulario search antes de realizar el submit
*/
function comprobarSearchGrupo() {

	var IdGrupo; /*variable que representa el elemento IdGrupo del formulario search de gestión de grupo*/
	var NombreGrupo; /*variable que representa el elemento NombreGrupo del formulario search de gestión de grupo*/
	var DescripGrupo; /*variable que representa el elemento DescripGrupo del formulario search de gestión de grupo*/
	IdGrupo = document.forms['SEARCH'].elements[0];
	NombreGrupo = document.forms['SEARCH'].elements[1];
	DescripGrupo = document.forms['SEARCH'].elements[2];



	/*Comprobamos su longitud, si es mayor que 6, retorna false*/
	if (!comprobarLongitud(IdGrupo, 6)) {
		return false;
	} else {// si no cumple con la condición del if anterior,
		/*Comprobamos si tiene caracteres especiales, si es así, retorna false */
		if (!comprobarTexto(IdGrupo, 6)) {
			return false;
		}
	}


	/*Comprobamos su longitud, si es mayor que 60, retorna false*/
	if (!comprobarLongitud(NombreGrupo, 60)) {
		return false;
	} else {// si no cumple con la condición del if anterior,
		/*Comprobamos si tiene caracteres especiales, si es así, retorna false */
		if (!comprobarTexto(NombreGrupo, 60)) {
			return false;
		}
	}



	/*Comprueba su longitud, si es mayor que 100, retorna false*/
	if (!comprobarLongitud(DescripGrupo, 100)) {
		return false;
	} else {// si no cumple con la condición del if anterior,
		/*Comprueba si tiene caracteres especiales, si es así, retorna false */
		if (!comprobarTexto(DescripGrupo, 100)) {
			return false;
		}

	}




	return true;
} 
/*
	function comprobarSearchFuncionalidad: valida todos los campos del formulario search antes de realizar el submit
*/
function comprobarSearchFuncionalidad() {

	var IdFuncionalidad; /*variable que representa el elemento IdFuncionalidad del formulario search de gestión de funcinalidad*/
	var NombreFuncionalidad; /*variable que representa el elemento NombreAccion del formulario search de gestión de funcionalidad*/
	var DescripFuncionalidad; /*variable que representa el elemento DescripAccion del formulario search de gestión de funcionalidad*/

	IdFuncionalidad = document.forms['SEARCH'].elements[0];
	NombreFuncionalidad = document.forms['SEARCH'].elements[1];
	DescripFuncionalidad = document.forms['SEARCH'].elements[2];

	/*Comprueba su longitud, si es mayor que 6, retorna false*/
	if (!comprobarLongitud(IdFuncionalidad, 6)) {
		return false;
	} else {// si no cumple con la condición del if anterior,
		/*Comprueba si tiene caracteres especiales, si es así, retorna false */
		if (!comprobarTexto(IdFuncionalidad, 6)) {
			return false;
		}
	}
	/*Comprueba su longitud, si es mayor que 60, retorna false*/
	if (!comprobarLongitud(NombreFuncionalidad, 60)) {
		return false;
	} else {// si no cumple con la condición del if anterior,
		/*Comprueba si tiene caracteres especiales, si es así, retorna false */
		if (!comprobarTexto(NombreFuncionalidad, 60)) {
			return false;
		} 
	}
	/*Comprueba su longitud, si es mayor que 100, retorna false*/
	if (!comprobarLongitud(DescripFuncionalidad, 100)) {
		return false;
	} else {// si no cumple con la condición del if anterior,
		/*Comprueba si tiene caracteres especiales, si es así, retorna false */
		if (!comprobarTexto(DescripFuncionalidad, 100)) {
			return false;
		}
	}

	return true;
}
/*
	function comprobarEditFuncionalidad: valida todos los campos del formulario edit antes de realizar el submit
*/
function comprobarEditFuncionalidad() {

	var IdFuncionalidad; /*variable que representa el elemento IdFuncionalidad del formulario edit de gestión de funcionalidad*/
	var NombreFuncionalidad; /*variable que representa el elemento NombreFuncionalidad del formulario edit de gestión de funcionalidad*/
	var DescripFuncionalidad; /*variable que representa el elemento DescripFuncionalidad del formulario edit de gestión de funcionalidad*/

	IdFuncionalidad = document.forms['EDIT'].elements[0];
	NombreFuncionalidad = document.forms['EDIT'].elements[1];
	DescripFuncionalidad = document.forms['EDIT'].elements[2];


	/*Comprueba si IdAccion es vacio, retorna false*/
	if (!comprobarVacio(IdFuncionalidad)) {
		return false;
	}  else {// si no cumple con la condición del if anterior,
			/*Comprobamos su longitud, si es mayor que 6, retorna false*/
			if (!comprobarLongitud(IdFuncionalidad, 6)) {
				return false;
			} else {// si no cumple con la condición del if anterior,
				/*Comprobamos si tiene caracteres especiales, si es así, retorna false */
				if (!comprobarTexto(IdFuncionalidad, 6)) {
					return false;
				}
			}
		}
	
	/*Comprueba si NombreAccion es vacio, retorna false*/
	if (!comprobarVacio(NombreFuncionalidad)) {
		return false;
	} else {// si no cumple con la condición del if anterior,
			/*Comprueba su longitud, si es mayor que 128, retorna false*/
			if (!comprobarLongitud(NombreFuncionalidad, 60)) {
				return false;
			} else {// si no cumple con la condición del if anterior,
				/*Comprueba si tiene caracteres especiales, si es así, retorna false */
				if (!comprobarTexto(NombreFuncionalidad, 60)) {
					return false;
				}
			}
		}
	
	/*Comprueba si DescripFuncionalidad es vacio, retorna false*/
	if (!comprobarVacio(DescripFuncionalidad)) {
		return false;
	} else {// si no cumple con la condición del if anterior,
		/*Comprueba su longitud, si es mayor que 100, retorna false*/
		if (!comprobarLongitud(DescripFuncionalidad, 100)) {
			return false;
		} else {// si no cumple con la condición del if anterior,
			/*Comprueba si tiene caracteres especiales, si es así, retorna false */
			if (!comprobarTexto(DescripFuncionalidad, 100)) {
				return false;
			}
		}
	}

	return true;

}
/*
	function comprobarAddFuncionalidad: valida todos los campos del formulario add antes de realizar el submit
*/
function comprobarAddFuncionalidad() {

	var IdFuncionalidad; /*variable que representa el elemento IdFuncionalidad del formulario add de gestión de funcionalidad*/
	var NombreFuncionalidad; /*variable que representa el elemento NombreFuncionalidad del formulario add de gestión de funcionalidad*/
	var DescripFuncionalidad; /*variable que representa el elemento DescripFuncionalidad del formulario add de gestión de funcionalidad*/

	IdFuncionalidad = document.forms['ADD'].elements[0];
	NombreFuncionalidad = document.forms['ADD'].elements[1];
	DescripFuncionalidad = document.forms['ADD'].elements[2];


	/*Comprueba si IdFuncionalidad es vacio, retorna false*/
	if (!comprobarVacio(IdFuncionalidad)) {
		return false;
	} else {// si no cumple con la condición del if anterior,
			/*Comprobamos su longitud, si es mayor que 6, retorna false*/
			if (!comprobarLongitud(IdFuncionalidad, 6)) {
				return false;
			} else {// si no cumple con la condición del if anterior,
				/*Comprobamos si tiene caracteres especiales, si es así, retorna false */
				if (!comprobarTexto(IdFuncionalidad, 6)) {
					return false;
				}
			}
		}
	
	/*Comprueba si NombreFuncionalidad es vacio, retorna false*/
	if (!comprobarVacio(NombreFuncionalidad)) {
		return false;
	}else {// si no cumple con la condición del if anterior,
			/*Comprueba su longitud, si es mayor que 60, retorna false*/
			if (!comprobarLongitud(NombreFuncionalidad, 60)) {
				return false;
			} else {// si no cumple con la condición del if anterior,
				/*Comprueba si tiene caracteres especiales, si es así, retorna false */
				if (!comprobarTexto(NombreFuncionalidad, 60)) {
					return false;
				}
			}
		}
	
	/*Comprueba si DescripFuncionalidad es vacio, retorna false*/
	if (!comprobarVacio(DescripFuncionalidad)) {
		return false;
	} else {// si no cumple con la condición del if anterior,
		/*Comprueba su longitud, si es mayor que 100, retorna false*/
		if (!comprobarLongitud(DescripFuncionalidad, 100)) {
			return false;
		} else {// si no cumple con la condición del if anterior,
			/*Comprueba si tiene caracteres especiales, si es así, retorna false */
			if (!comprobarTexto(DescripFuncionalidad, 100)) {
				return false;
			}
		}
	}

	return true;

}

/*
	function comprobarSearchPermisos: valida todos los campos del formulario search antes de realizar el submit
*/
function comprobarSearchPermisos() {

	var NombreGrupo; /*variable que representa el elemento NombreGrupo del formulario search de gestión de permisos*/
	var NombreFuncionalidad; /*variable que representa el elemento NombreAccion del formulario search de gestión de permisos*/
	var NombreAccion; /*variable que representa el elemento NombreAccion del formulario search de gestión de permisos*/

	NombreGrupo = document.forms['SEARCH'].elements[0];
	NombreFuncionalidad = document.forms['SEARCH'].elements[1];
	NombreAccion = document.forms['SEARCH'].elements[2];

	/*Comprueba su longitud, si es mayor que 60, retorna false*/
	if (!comprobarLongitud(NombreGrupo, 60)) {
		return false;
	} else {// si no cumple con la condición del if anterior,
		/*Comprueba si tiene caracteres especiales, si es así, retorna false */
		if (!comprobarTexto(NombreGrupo, 60)) {
			return false;
		} 
	}

	/*Comprueba su longitud, si es mayor que 60, retorna false*/
	if (!comprobarLongitud(NombreFuncionalidad, 60)) {
		return false;
	} else {// si no cumple con la condición del if anterior,
		/*Comprueba si tiene caracteres especiales, si es así, retorna false */
		if (!comprobarTexto(NombreFuncionalidad, 60)) {
			return false;
		} 
	}

	/*Comprueba su longitud, si es mayor que 60, retorna false*/
	if (!comprobarLongitud(NombreAccion, 60)) {
		return false;
	} else {// si no cumple con la condición del if anterior,
		/*Comprueba si tiene caracteres especiales, si es así, retorna false */
		if (!comprobarTexto(NombreAccion, 60)) {
			return false;
		}
	}

	return true;
}

/*
	function comprobarAddNotas(): valida todos los campos del formulario add antes de realizar el submit
*/
function comprobarAddNotas(){
	
	var login; /*variable que representa el elemento login del formulario add de gestión de notas*/
	var IdTrabajo; /*variable que representa el elemento IdTrabajo del formulario add de gestión de notas*/
	var NotaTrabajo; /*variable que representa el elemento NotaTrabajo del formulario add de gestión de notas*/

	login = document.forms['ADD'].elements[0];
	IdTrabajo = document.forms['ADD'].elements[1];
	NotaTrabajo = document.forms['ADD'].elements[2];
	
	
	/*Comprueba su longitud, si es mayor que 9, retorna false*/
	if (!comprobarVacio(login, 9)) {
		return false;
	} else {// si no cumple con la condición del if anterior,
		/*Comprueba si tiene caracteres especiales, si es así, retorna false */
		if (!comprobarLoNgitud(login, 9)) {
			return false;
		}else{// si no cumple con la condición del if anterior,
			/*Comprueba si tiene caracteres especiales, si es así, retorna false */
			if(!comprobarTexto(login, 9)){
				return false;
			}
		}
	}
	
	/*Comprueba su longitud, si es mayor que 6, retorna false*/
	if (!comprobarVacio(IdTrabajo, 6)) {
		return false;
	} else {// si no cumple con la condición del if anterior,
		/*Comprueba si tiene caracteres especiales, si es así, retorna false */
		if (!comprobarLongitud(IdTrabajo, 6)) {
			return false;
		}else{// si no cumple con la condición del if anterior,
			/*Comprueba si tiene caracteres especiales, si es así, retorna false */
			if(!comprobarTexto(IdTrabajo, 6)){
				return false;
			}
		}
	}
	
	/*Comprueba su longitud, si es mayor que 4, retorna false*/
	if (!comprobarVacio(NotaTrabajo, 4)) {
		return false;
	} else {// si no cumple con la condición del if anterior,
		/*Comprueba si tiene caracteres especiales, si es así, retorna false */
		if (!comprobarLongitud(NotaTrabajo, 4)) {
			return false;
		}else{// si no cumple con la condición del if anterior,
			/*Comprueba si tiene caracteres especiales, si es así, retorna false */
			if(!comprobarTexto(NotaTrabajo, 4)){
				return false;
			}else{// si no cumple con la condición del if anterior,
				/*Comprueba que la nota tenga el formato concreto*/
				if(!comprobarReal(NotaTrabajo,2,0,10)){
					return false;
				}
			}
		}
	}


	return true;
	
	
}
/*
	function comprobarSearchNotas(): valida todos los campos del formulario search antes de realizar el submit
*/
function comprobarSearchNotas(){
	
	var login; /*variable que representa el elemento login del formulario search de gestión de notas*/
	var IdTrabajo; /*variable que representa el elemento IdTrabajo del formulario search de gestión de notas*/
	var NotaTrabajo; /*variable que representa el elemento NotaTrabajo del formulario search de gestión de notas*/

	login = document.forms['SEARCH'].elements[0];
	IdTrabajo = document.forms['SEARCH'].elements[1];
	NotaTrabajo = document.forms['SEARCH'].elements[2];
	

	/*Comprueba si tiene caracteres especiales, si es así, retorna false */
	if (!comprobarLongitud(login, 9)) {
		return false;
	}else{// si no cumple con la condición del if anterior,
		/*Comprueba si tiene caracteres especiales, si es así, retorna false */
		if(!comprobarTexto(login,9)){
			return false;
		}
	}
	
	

	/*Comprueba si tiene caracteres especiales, si es así, retorna false */
	if (!comprobarLongitud(IdTrabajo, 6)) {
		return false;
	}else{// si no cumple con la condición del if anterior,
		/*Comprueba si tiene caracteres especiales, si es así, retorna false */
		if(!comprobarTexto(IdTrabajo,6)){
			return false;
		}
	}


	/*Comprueba si tiene caracteres especiales, si es así, retorna false */
	if (!comprobarLongitud(NotaTrabajo, 4)) {
		return false;
	}else{// si no cumple con la condición del if anterior,
		/*Comprueba si tiene caracteres especiales, si es así, retorna false */
		if(!comprobarTexto(NotaTrabajo,4)){
			return false;
		}
	}


	return true;
}
/*
	function comprobarEditNotas(): valida todos los campos del formulario edit antes de realizar el submit
*/
function comprobarEditNotas(){
	var login; /*variable que representa el elemento login del formulario edit de gestión de notas*/
	var IdTrabajo; /*variable que representa el elemento IdTrabajo del formulario edit de gestión de notas*/
	var NotaTrabajo; /*variable que representa el elemento NotaTrabajo del formulario edit de gestión de notas*/

	login = document.forms['EDIT'].elements[0];
	IdTrabajo = document.forms['EDIT'].elements[1];
	NotaTrabajo = document.forms['EDIT'].elements[2];
	
	
	/*Comprueba su longitud, si es mayor que 9, retorna false*/
	if (!comprobarVacio(login, 9)) {
		return false;
	} else {// si no cumple con la condición del if anterior,
		/*Comprueba si tiene caracteres especiales, si es así, retorna false */
		if (!comprobarLongitud(login, 9)) {
			return false;
		}else{// si no cumple con la condición del if anterior,
			/*Comprueba si tiene caracteres especiales, si es así, retorna false */
			if(!comprobarTexto(login,9)){
				return false;
			}
		}
	}
	
	/*Comprueba su longitud, si es mayor que 6, retorna false*/
	if (!comprobarVacio(IdTrabajo, 6)) {
		return false;
	} else {// si no cumple con la condición del if anterior,
		/*Comprueba si tiene caracteres especiales, si es así, retorna false */
		if (!comprobarLongitud(IdTrabajo, 6)) {
			return false;
		}else{// si no cumple con la condición del if anterior,
			/*Comprueba si tiene caracteres especiales, si es así, retorna false */
			if(!comprobarTexto(IdTrabajo,6)){
				return false;
			}
		}
	}
	
	/*Comprueba su longitud, si es mayor que 4, retorna false*/
	if (!comprobarVacio(NotaTrabajo, 4)) {
		return false;
	} else {// si no cumple con la condición del if anterior,
		/*Comprueba si tiene caracteres especiales, si es así, retorna false */
		if (!comprobarLongitud(NotaTrabajo, 4)) {
			return false;
		}else{// si no cumple con la condición del if anterior,
			/*Comprueba si tiene caracteres especiales, si es así, retorna false */
			if(!comprobarTexto(NotaTrabajo,4)){
				return false;
			}else{// si no cumple con la condición del if anterior,
				/*Comprueba que la nota tenga el formato concreto*/
				if(!comprobarReal(NotaTrabajo,2,0,10)){
					return false;
				}
			}
		}
	}
	return true;
}
/*
	function comprobarAddAsignQa(): valida todos los campos del formulario add antes de realizar el submit
*/
function comprobarAddAsignQa(){
	
	var IdTrabajo; /*variable que representa el elemento IdTrabajo del formulario add de gestión de asign_qa*/
	var LoginEvaluador; /*variable que representa el elemento LoginEvaluador del formulario add de gestión de asign_qa*/
	var LoginEvaluado; /*variable que representa el elemento LoginEvaluado del formulario add de gestión de asign_qa*/
	var AliasEvaluado; /*variable que representa el elemento AliasEvaluado del formulario add de gestión de asign_qa*/
	
	IdTrabajo = document.forms['ADD'].elements[0];
	LoginEvaluador = document.forms['ADD'].elements[1];
	LoginEvaluado = document.forms['ADD'].elements[2];
	AliasEvaluado = document.forms['ADD'].elements[2];

	/*Comprueba si IdTrabajo es vacio, retorna false*/
	if (!comprobarVacio(IdTrabajo)) {
		return false;
	} else {// si no cumple con la condición del if anterior,
			/*Comprobamos su longitud, si es mayor que 6, retorna false*/
			if (!comprobarLongitud(IdTrabajo, 6)) {
				return false;
			} else {// si no cumple con la condición del if anterior,
				/*Comprobamos si tiene caracteres especiales, si es así, retorna false */
				if (!comprobarTexto(IdTrabajo, 6)) {
					return false;
				}
			}
		}
	
	/*Comprueba si LoginEvaluador es vacio, retorna false*/
	if (!comprobarVacio(LoginEvaluador)) {
		return false;
	} else {// si no cumple con la condición del if anterior,
			/*Comprobamos su longitud, si es mayor que 9, retorna false*/
			if (!comprobarLongitud(LoginEvaluador, 9)) {
				return false;
			} else {// si no cumple con la condición del if anterior,
				/*Comprobamos si tiene caracteres especiales, si es así, retorna false */
				if (!comprobarTexto(LoginEvaluador, 9)) {
					return false;
				}
			}
		}
	
	/*Comprueba si LoginEvaluado es vacio, retorna false*/
	if (!comprobarVacio(LoginEvaluado)) {
		return false;
	} else {// si no cumple con la condición del if anterior,
			/*Comprobamos su longitud, si es mayor que 9, retorna false*/
			if (!comprobarLongitud(LoginEvaluado, 9)) {
				return false;
			} else {// si no cumple con la condición del if anterior,
				/*Comprobamos si tiene caracteres especiales, si es así, retorna false */
				if (!comprobarTexto(LoginEvaluado, 9)) {
					return false;
				}
			}
		}
	
	/*Comprueba si AliasEvaluado es vacio, retorna false*/
	if (!comprobarVacio(AliasEvaluado)) {
		return false;
	} else {// si no cumple con la condición del if anterior,
			/*Comprobamos su longitud, si es mayor que 6, retorna false*/
			if (!comprobarLongitud(AliasEvaluado, 6)) {
				return false;
			} else {// si no cumple con la condición del if anterior,
				/*Comprobamos si tiene caracteres especiales, si es así, retorna false */
				if (!comprobarTexto(AliasEvaluado, 6)) {
					return false;
				}
			}
		}
	

	return true;
	
}
/*
	function comprobarEditAsignQa(): valida todos los campos del formulario edit antes de realizar el submit
*/
function comprobarEditAsignQa(){
	
	var IdTrabajo; /*variable que representa el elemento IdTrabajo del formulario edit de gestión de asign_qa*/
	var LoginEvaluador; /*variable que representa el elemento LoginEvaluador del formulario edit de gestión de asign_qa*/
	var LoginEvaluado; /*variable que representa el elemento LoginEvaluado del formulario edit de gestión de asign_qa*/
	var AliasEvaluado; /*variable que representa el elemento AliasEvaluado del formulario edit de gestión de asign_qa*/
	
	IdTrabajo = document.forms['EDIT'].elements[0];
	LoginEvaluador = document.forms['EDIT'].elements[1];
	LoginEvaluado = document.forms['EDIT'].elements[2];
	AliasEvaluado = document.forms['EDIT'].elements[2];

	/*Comprueba si IdTrabajo es vacio, retorna false*/
	if (!comprobarVacio(IdTrabajo)) {
		return false;
	} else {// si no cumple con la condición del if anterior,
			/*Comprobamos su longitud, si es mayor que 6, retorna false*/
			if (!comprobarLongitud(IdTrabajo, 6)) {
				return false;
			} else {// si no cumple con la condición del if anterior,
				/*Comprobamos si tiene caracteres especiales, si es así, retorna false */
				if (!comprobarTexto(IdTrabajo, 6)) {
					return false;
				}
			}
		}
	
	/*Comprueba si LoginEvaluador es vacio, retorna false*/
	if (!comprobarVacio(LoginEvaluador)) {
		return false;
	} else {// si no cumple con la condición del if anterior,
			/*Comprobamos su longitud, si es mayor que 9, retorna false*/
			if (!comprobarLongitud(LoginEvaluador, 9)) {
				return false;
			} else {// si no cumple con la condición del if anterior,
				/*Comprobamos si tiene caracteres especiales, si es así, retorna false */
				if (!comprobarTexto(LoginEvaluador, 9)) {
					return false;
				}
			}
		}
	
	/*Comprueba si LoginEvaluado es vacio, retorna false*/
	if (!comprobarVacio(LoginEvaluado)) {
		return false;
	} else {// si no cumple con la condición del if anterior,
			/*Comprobamos su longitud, si es mayor que 9, retorna false*/
			if (!comprobarLongitud(LoginEvaluado, 9)) {
				return false;
			} else {// si no cumple con la condición del if anterior,
				/*Comprobamos si tiene caracteres especiales, si es así, retorna false */
				if (!comprobarTexto(LoginEvaluado, 9)) {
					return false;
				}
			}
		}
	
	/*Comprueba si AliasEvaluado es vacio, retorna false*/
	if (!comprobarVacio(AliasEvaluado)) {
		return false;
	} else {// si no cumple con la condición del if anterior,
			/*Comprobamos su longitud, si es mayor que 6, retorna false*/
			if (!comprobarLongitud(AliasEvaluado, 6)) {
				return false;
			} else {// si no cumple con la condición del if anterior,
				/*Comprobamos si tiene caracteres especiales, si es así, retorna false */
				if (!comprobarTexto(IdTraAliasEvaluadobajo, 6)) {
					return false;
				}
			}
		}
	

	return true;
	
}
/*
	function comprobarSearchAsignQa(): valida todos los campos del formulario search antes de realizar el submit
*/
function comprobarSearchAsignQa(){
	
	
	var IdTrabajo; /*variable que representa el elemento IdTrabajo del formulario search de gestión de asign_qa*/
	var LoginEvaluador; /*variable que representa el elemento LoginEvaluador del formulario searcg de gestión de asign_qa*/
	var LoginEvaluado; /*variable que representa el elemento LoginEvaluado del formulario search de gestión de asign_qa*/
	var AliasEvaluado; /*variable que representa el elemento AliasEvaluado del formulario searcg de gestión de asign_qa*/
	
	IdTrabajo = document.forms['SEARCH'].elements[0];
	LoginEvaluador = document.forms['SEARCH'].elements[1];
	LoginEvaluado = document.forms['SEARCH'].elements[2];
	AliasEvaluado = document.forms['SEARCH'].elements[2];


			/*Comprobamos su longitud, si es mayor que 6, retorna false*/
			if (!comprobarLongitud(IdTrabajo, 6)) {
				return false;
			} else {// si no cumple con la condición del if anterior,
				/*Comprobamos si tiene caracteres especiales, si es así, retorna false */
				if (!comprobarTexto(IdTrabajo, 6)) {
					return false;
				}
			}
		

			/*Comprobamos su longitud, si es mayor que 9, retorna false*/
			if (!comprobarLongitud(LoginEvaluador, 9)) {
				return false;
			} else {// si no cumple con la condición del if anterior,
				/*Comprobamos si tiene caracteres especiales, si es así, retorna false */
				if (!comprobarTexto(LoginEvaluador, 9)) {
					return false;
				}
			}
		

			/*Comprobamos su longitud, si es mayor que 9, retorna false*/
			if (!comprobarLongitud(LoginEvaluado, 9)) {
				return false;
			} else {// si no cumple con la condición del if anterior,
				/*Comprobamos si tiene caracteres especiales, si es así, retorna false */
				if (!comprobarTexto(LoginEvaluado, 9)) {
					return false;
				}
			}
		
	

			/*Comprobamos su longitud, si es mayor que 6, retorna false*/
			if (!comprobarLongitud(AliasEvaluado, 6)) {
				return false;
			} else {// si no cumple con la condición del if anterior,
				/*Comprobamos si tiene caracteres especiales, si es así, retorna false */
				if (!comprobarTexto(AliasEvaluado, 6)) {
					return false;
				}
			}
		
	

	return true;
}

/*
	function validarComentIncorrectoP(): funcion que permite validar el campo de comentario incorrecto del formulario de evaluar
*/
function validarComentIncorrectoP(campo,size){
	
	/*Si el campo tiene mayor longitud que size, se manda un aviso de error llamando a la función msgError y se retorna false */
	if (campo.value.length > size) {
		msgError('<?php echo $strings["Longitud incorrecta. El atributo "];?>' + atributo['ComentIncorrectoP'] + '<?php echo $strings[" puede tener una longitud máxima de "];?>' + size + '<?php echo $strings[" y es de "];?>' + campo.value.length);
		campo.focus();
		return false;
	}
	
	
	var i; //variable auxiliar de control
	/*Estructura que permite recorrer todos los caracteres del valor de campo */
	for (i = 0; i < size; i++) {
		/*Comprueba que el carácter seleccionado de campo no es un carácter especial, si es así muestra un mensaje de error y retorna false */
		if (/[^!"#$%&'()*+,-./0123456789:;<=>?@ABCDEFGHIJKLMNOPQRSTUVWXYZ[\]^_`abcdefghijklmnopqrstuvwxyz{|}~ñáéíóúÑÁÉÍÓÚüÜ ]/.test(campo.value.charAt(i))) {
			msgError('<?php echo $strings["El atributo "];?>' + atributo['ComentIncorrectoP'] + '<?php echo $strings[" contiene algún carácter no válido: "];?>' + campo.value.charAt(i));
			campo.focus();
			return false;
		}
	}
	
	return true;
}
/*
	function comprobarGenerarAsignQa(): funcion que permite validar el formulario de generar asignación qa
*/
function comprobarGenerarAsignQa(){
	
	var num; /*variable que representa el elemento num degenerar de asign_qa*/
	num = document.forms['ASIGNAC_QA'].elements[1];
	
	/*Comprueba si num es vacio, retorna false*/
	if (!comprobarVacio(num)) {
		return false;
	} else {// si no cumple con la condición del if anterior,
			/*Comprueba su longitud, si es mayor que 3, retorna false*/
			if (!comprobarLongitud(num, 3)) {
				return false;
			} else {// si no cumple con la condición del if anterior,
				/*Comprueba si tiene caracteres especiales, si es así, retorna false */
				if (!comprobarTexto(num, 3)) {
					return false;
				} else {// si no cumple con la condición del if anterior,
					/*Comprueba que sea un entero y esté entre 0 y 999*/
					if (!comprobarEntero(num, 0, 999)) {
						return false;
					}
				}
			}
		}
	
	return true;
}
</script>
