/* ***************************** test pour le formulaire de connexion***************************************** */
		function testonblurEmail()
		{
		Email=document.forms["login"].user.value;
		
		if(Email=="")
		{
		document.forms["login"].user.value='Email';
		}
		else if (Email=="Email")
		{
		document.forms["login"].user.value='';
		}
		
		
		}
		
		function testonblurPassword()
		{
		
		password=document.forms["login"].password.value;
		
		
		if(password=="")
		{
		document.forms["login"].password.value='password';
		}
		else if(password=="password")
		{
		document.forms["login"].password.value='';
		}
		
		}
/* ***************************** fin pour le test du formulaire de connexion***************************************** */


/* ***************************** test pour le formulaire de Création Compte***************************************** */
		function testonblurEmailCompte()
		{
		Email=document.forms["monForm"].Email.value;
		
		if(Email=="")
		{
		document.forms["monForm"].Email.value='Email';
		}
		else if (Email=="Email")
		{
		document.forms["monForm"].Email.value='';
		}
		}
		
		function testonblurNomCompte()
		{
		Nom=document.forms["monForm"].Nom.value;
		
		if(Nom=="")
		{
		document.forms["monForm"].Nom.value='Nom';
		}
		else if (Nom=="Nom")
		{
		document.forms["monForm"].Nom.value='';
		}
		}
		
		function testonblurPrenomCompte()
		{
		Prenom=document.forms["monForm"].Prenom.value;
		
		if(Prenom=="")
		{
		document.forms["monForm"].Prenom.value='Prenom';
		}
		else if (Prenom=="Prenom")
		{
		document.forms["monForm"].Prenom.value='';
		}
		
		}
		
		function testonblurPasswordCompte()
		{
		password=document.forms["monForm"].Password.value;
		
		if(password=="")
		{
		document.forms["monForm"].password.value='Password';
		}
		else if (password=="Password")
		{
		document.forms["monForm"].password.value='';
		}
		}
		
/* ***************************** fin pour le test du formulaire de connexion***************************************** */


