function myFunction() {
	var x = document.getElementById("psw");
	if (x.type === "password") {
		x.type = "text";
	}
	else {
		x.type = "password";
	}
}

function validateForm() {
	var nome = document.getElementById("nome");
	var cognome = document.getElementById("cognome");
	var email = document.getElementById("email");
	var username = document.getElementById("username");
	var password1 = document.getElementById("password1");
	var password2 = document.getElementById("password2");

	var error = false;

    if (nome == "") {
        alert("Compilare il campo 'Nome'!");
        error = true;
        return false;
    }

    if (cognome == "") {
    	alert("Compilare il campo 'Cognome'!");
    	error = true;
        return false;
    }

    if (email == "") {
    	alert("Compilare il campo 'Email'!");
    	error = true;
        return false;
    }

    if (username == "") {
    	alert("Compilare il campo 'Username'!");
    	error = true;
        return false;
    }

    if (password1 == "") {
    	alert("Compilare il campo 'Password 1'!");
    	error = true;
        return false;
    }

    if (password2 == "") {
    	alert("Compilare il campo 'Password 2'!");
    	error = true;
        return false;
    }

    else {
    	document.getElementById("form").submit();
    }
}