	$(document).ready(function() 
		{
			$('#login').on('submit', function() 
			{
 
					var user = $('#user').val();
					var password =$('#pass').val();
					
 
			if(user == '' || password == '' || user == 'Email' || password == 'password') 
			{
            alert('veuillez remplissez les champs');
			} 
			else {
            $.ajax({
                url: 'connection.php',
                type: 'POST',
                data: $(this).serialize(),
                dataType: 'json',
                success: function(json) 
						{
						if (json.reponse){
						window.location.href=json.reponse;
						localStorage.setItem('id_user',user);}
						else if (json.reponse_conn_err){
						resultDiv=document.getElementById("push");
						 resultDiv.style.display='inline'; 
						 resultDiv.innerHTML=json.reponse_conn_err;
						 //resultDiv.innerHTML+="<INPUT type= 'radio' name='tag' id='tag' value='defaut' checked>defaut" ;
						 //resultDiv.innerHTML+='<br/>';
						
						}
						
						}
					});
				}
        return false;
			});
		});

	