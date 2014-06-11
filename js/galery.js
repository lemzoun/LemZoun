function galeryimage() {

    $.ajax({
		type : "POST",
		url: "galery.php",
		data:{utilisateur: localStorage.getItem('id_user')},
		dataType: "json",
		success: function(json) 
		{
		
			resultDiv=document.getElementById("contenu");
			var obj = json.image;
			resultDiv.innerHTML='<ul class="list-group">';
			for (var i = 0; i < json.image.length; i++) 
			{
				//resultDiv.innerHTML+='<table>';
				//resultDiv.innerHTML+='<tr><td>'
				var download=json.image[i];
			
				resultDiv.innerHTML+='<li class="list-group-item"  onmouseover="OnMouseIn (this)" onmouseout="OnMouseOut (this)"><a href=javascript:downloadFile("'+download+'"); >'+json.image[i]+'</a><a href=javascript:RenameFile("'+download+'"); ><span class="glyphicon glyphicon-pencil" id="id_div_1"></span></a><a href=javascript:PartageFile("'+download+'"); ><span class="glyphicon glyphicon-share" id="id_div_1"></span></a><a href=javascript:supprimFile("'+download+'"); ><span class="glyphicon glyphicon-remove" id="id_div_1"></span></a></li>';
		
				
			//resultDiv.innerHTML+='<a href=javascript:RenommerFile("'+download+'");>  	Renommer 	</a>';
			
			}
	
	
		
		}
		});
}
