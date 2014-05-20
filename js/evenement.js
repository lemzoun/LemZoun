function evenement(){

	
	$.ajax({
		type : "POST",
		url: "evenement.php",
		data: {welcome: localStorage.getItem('id_user')} ,
		dataType: "json",
		success: function(json) {
			
			resultDiv=document.getElementById("contenu");
			resultDiv.style.display='inline'; 
			resultDiv.innerHTML='';
			var obj = json.reponse;
			
															for (var i = 0; i < json.reponse.length; i++) 
															{
																var download=json.reponse[i];
																resultDiv.innerHTML+=json.reponse[i];
																resultDiv.innerHTML+='<br/>';
			
															}
			
		}
	})
};