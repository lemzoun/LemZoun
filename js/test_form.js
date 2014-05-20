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
