$(document).ready(function() 
		{
			$('#monForm').on('submit', function() 
			{
 
					var Prenom = $('#Prenom').val();
					var Nom = $('#Nom').val();
					var Email = $('#Email').val();
					var Password = $('#pass').val();
 
			if(Prenom == '' || Prenom == 'Prenom') 
			{
			
           document.forms["monForm"].Prenom.focus();
		   
			} 
			
			
			else if(Nom == '' || Nom == 'Nom' ) 
			{
             document.forms["monForm"].Nom.focus();
			} 
			
			else if(Email == ''|| Email == 'Email' ) 
			{
             document.forms["monForm"].Email.focus();
			} 
			
			//else if(Password == '' || Password == 'Password') 
			//{
            // document.forms["monForm"].Password.focus();
			//} 
			
			else if(!verifPseudo(document.forms["monForm"].Nom))
			{
			 document.forms["monForm"].Nom.focus();
			}
			
			else if(!verifPseudo(document.forms["monForm"].Prenom))
			{
			 document.forms["monForm"].Prenom.focus();
			}
			else if(!verifMail(document.forms["monForm"].Email))
			{
			 document.forms["monForm"].Email.focus();
			}
			//else if(!verifPseudo(document.forms["monForm"].Password))
			//{
			// document.forms["monForm"].Password.focus();
			//}
			
			else {
            $.ajax({
                url: 'AjoutUser.php',
                type: 'POST',
                data: $(this).serialize(),
                dataType: 'json',
                success: function(json) 
						{
						if (json.reponse){
                       // alert(json.reponse);
						resultDiv=document.getElementById("reponse_creation");
						 resultDiv.style.display='inline'; 
						 resultDiv.innerHTML=json.reponse;
						document.getElementById("monForm").reset();
						}
						
						
						}
					});
				}
        return false;
			});
		});
		
		
		
	

function verifPseudo(champ)
{
   if(champ.value.length <= 2 || champ.value.length > 25)
   {
      surligne(champ, true);
	  
	  
      return false;
   }
   else
   {
      surligne(champ, false);
      return true;
   }
}

function surligne(champ, erreur)
{
   if(erreur)
      champ.style.backgroundColor = "#fba";
   else
      champ.style.backgroundColor = "";
}
function verifMail(champ)
{
   var regex = /^[a-zA-Z0-9._-]+@[a-z0-9._-]{2,}\.[a-z]{2,4}$/;
   if(!regex.test(champ.value))
   {
      surligne(champ, true);
      return false;
   }
   else
   {
      surligne(champ, false);
      return true;
   }
}