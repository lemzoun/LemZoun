function downloadFile(sUrl) {

    $.ajax({
		type : "POST",
		url: "download.php",
		data:{sUrl: sUrl,utilisateur: localStorage.getItem('id_user')},
		dataType: "json",
		success: function(json) 
		{
		if(json.fichier){
		//resultDiv=document.getElementById("contenu");
		//resultDiv.innerHTML=json.reponse;
		window.location.href=json.fichier;
		}
		else
		{
		 alert("erreur download");
		}
		}
		});
}
