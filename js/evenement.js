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
			resultDiv.innerHTML+='<ul class="list-group">';
			var obj = json.reponse;
			
															for (var i = 0; i < json.reponse.length; i++) 
															{
																var download=json.reponse[i];
																//resultDiv.innerHTML+=json.reponse[i];
																resultDiv.innerHTML+='<li class="list-group-item"  ><a href=javascript:downloadFile("'+download+'"); >'+json.reponse[i]+'</a><a href=javascript:RenameFile("'+download+'"); ><span class="glyphicon glyphicon-pencil" id="id_div_1"></span></a><a href=javascript:PartageFile("'+download+'"); ><span class="glyphicon glyphicon-share" id="id_div_1"></span></a><a href=javascript:supprimFile("'+download+'"); ><span class="glyphicon glyphicon-remove" id="id_div_1"></span></a></li>';
		
																//resultDiv.innerHTML+='<br/>';
			
															}
			resultDiv.innerHTML+='</ul>';
		}
	})
};