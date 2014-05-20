// JavaScript Document
function formhash(form, password){
	//Create a new input, will be the hash password
	var p = document.createElement("input");
	//Add element to the form
	form.appendChild(p);
	p.name = "p";
	p.type = "hidden";
	p.id="pass";
	p.value = hex_sha512(password.value);
	//Make sure we don't send the plain password
	password.value = "";
	//Submit the form
	//form.submit();
}

var maillogin=false;
var passlogin=false;

//controller mail login
function checkMailLogin(login) {
	var espression= /^[_a-z0-9+-]+(\.[_a-z0-9+-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)+$/;
	var mail=login;
	
	if (!espression.test(mail)){
			//$("input#mail").addClass("ui-state-error");
			//$("label#mail").addClass("ui-state-error-text");
			maillogin=false;
		} else {
			//$("input#mail").removeClass("ui-state-error");
			//$("label#mail").removeClass("ui-state-error-text");
			maillogin=true;
		}
}

//controllo password login
function checkPasswdLogin(pass) {
	var esppass= /^([a-zA-Z0-9])+$/;
	var passwd=pass;
	
	if(!esppass.test(passwd)) {
			//$("input#passwd").addClass("ui-state-error");
			//$("label#passwd").addClass("ui-state-error-text");
			passlogin=false;
		} else {
			//$("input#passwd").removeClass("ui-state-error");
			//$("label#passwd").removeClass("ui-state-error-text");
			passlogin=true;
	}
}
