window.PartageFile = function (nom_file) {

$.ajax({
		type : "POST",
		url: "partage.php",
		data: {nom_file:nom_file} ,
		dataType: "json",
		success: function(json) {
		alert(json.reponse);
			}
		
		})


   
    
}
window.supprimFile = function (nom_file) {

$.ajax({
		type : "POST",
		url: "partage.php",
		data: {suppression_fichier:nom_file} ,
		dataType: "json",
		success: function(json) {
		window.location.reload();
			}
		
		})


   
    
}
window.RenameFile = function (nom_file) {
  $.ajax({
                url: 'renommer.php',
                type: 'POST',
                data: {extension: nom_file},
                dataType: 'json',
                success: function(json) 
						{
						var longeur_nom_file=nom_file.length;
						
						var extension_fichier=json.reponse;
						var longueur_extension=extension_fichier.length;
						
						var longeur=longeur_nom_file-longueur_extension-1;
						var fichier = nom_file.substring(0,longeur);
						
				resultDiv=document.getElementById("rename");
					resultDiv.style.display='inline'; 
					 resultDiv.innerHTML="<form method='POST' action='' name='renommerFichier' id='renommerFichier'>";
					resultDiv.innerHTML+="fichier à renommer:<INPUT type= 'text' name='renomme' id='renomme' value="+fichier+">" ;
					resultDiv.innerHTML+='<INPUT type= submit name=renommer value=renommer id=renommer onclick=renommer("'+nom_file+'");>' ;    
					resultDiv.innerHTML+="</form>";
						
						}
					});
					


   
    
}
function renommer(nom_file) 
		{
			var renomme=document.getElementById("renomme").value;
			

   
	   $.ajax({
                url: 'renommer.php',
                type: 'POST',
                data: {renomme: renomme,ancien:nom_file},
                dataType: 'json',
                success: function(json) 
						{
					
						contenuDiv=document.getElementById("rename");
						contenuDiv.innerHTML="fichier modifié" ;
				window.location.reload();
					 
						
						}
					});
				
        return false;
			
		}
		
		
		function changer_password()
		{resultDiv=document.getElementById("contenu");
				resultDiv.style.display='inline'; 
					resultDiv.innerHTML="<form method='POST' action='' name='changer_passord' id='changer_passord'>";
					resultDiv.innerHTML="ancien mot de passe:<INPUT type= 'text' name='ancien_password' id='ancien_password' value=''></br>" ;
					resultDiv.innerHTML+="nouveau mot de passe:<INPUT type= 'text' name='nouveau_password' id='nouveau_password' value=''></br>" ;
					resultDiv.innerHTML+="confirmer mot de passe:<INPUT type= 'text' name='confirmer_password' id='confirmer_password' value=''></br>" ;
					resultDiv.innerHTML+='<INPUT type= submit name=modifier value=modifier id=modifier onclick=modifierPassword();>' ;    
				   resultDiv.innerHTML+="</form>";
	  
			
		}
		function modifierPassword()
		{
				var ancien_password=document.getElementById("ancien_password").value;
			//ancien_password.value = hex_sha512(ancien_password.value);
	
				var nouveau_password=document.getElementById("nouveau_password").value;
				var confirmer_password=document.getElementById("confirmer_password").value;
		   $.ajax({
                url: 'password.php',
                type: 'POST',
                data: {ancien_password: ancien_password,nouveau_password:nouveau_password,confirmer_password:confirmer_password},
                dataType: 'json',
                success: function(json) 
						{
					
						contenuDiv=document.getElementById("rename");
						contenuDiv.innerHTML="mot de passe modifié" ;
			
					 
						
						}
					});
				
	  
			
		}
		