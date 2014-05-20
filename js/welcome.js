function welcome(){

	//var welcom = localStorage.getItem('id_user');
	//var welcome= JSON.parse(welcom);
	//mdiv = document.getElementById("welcome");

	$.ajax({
		type : "POST",
		url: "welcome.php",
		data: {welcome: localStorage.getItem('id_user')} ,
		dataType: "json",
		success: function(json) {
			if(json.login)
			{
			//alert (json.login);
			resultDiv=document.getElementById("mdiv");            
            resultDiv.style.display='inline';                                          
            resultDiv.innerHTML='<font color="#cf7809" size="4"><b> Bienvenue ' +json.login+'</b></font>';
			//document.getElementById("mdiv").innerHTML=json.reponse;
			//alert(json.reponse);
			}
			else if(json.non_login)
			{
				//alert('allo');
				window.location.href=json.non_login;
				removeItem("id_user");
			
			}
		}
	})
};

function logout()
{//pour la deconnexion 

$.ajax({
		type : "POST",
		url: "../connection.php",
		data: {welcome: localStorage.getItem('id_user')} ,
		dataType: "json",
		success: function(json) {
			
			//alert(json.login);
			window.location.href=json.reponse;
			removeItem("id_user");
			
			//mdiv.innerHTML =json.reponse;
			//$("div#mdiv").html("<span id=\"confirmMsg\">Vous &ecirc;tes maintenant connect&eacute;+json.reponse.</span>");
			//resultDiv=document.getElementById("mdiv");            
            //resultDiv.style.display='inline';                                          
            //resultDiv.innerHTML='<font color="#cf7809" size="4"><b> Bienvenue ' +json.login+'</b></font>';
			//document.getElementById("mdiv").innerHTML=json.reponse;
			//alert(json.reponse);
		}
	})
};

function listerFichier()
{
		$.ajax({
		type : "POST",
		url: "welcome.php",
		data: {liste: localStorage.getItem('id_user')} ,
		dataType: "json",
		success: function(json) {
			
			
			resultDiv=document.getElementById("contenu");
					//resultDiv.style.display='inline'; 
					//resultDiv.innerHTML+=json.login[0];
					resultDiv.innerHTML+='<table>';
			var obj = json.login;
			
			for (var i = 0; i < json.login.length; i++) 
			{
				//resultDiv.innerHTML+='<table>';
				//resultDiv.innerHTML+='<tr><td>'
				var download=json.login[i];
				resultDiv.innerHTML+='<a href=javascript:downloadFile("./donnee/'+download+'"); >'+json.login[i]+'</a>';
				resultDiv.innerHTML+='<a href=javascript:PartageFile("'+download+'");> 	partager 	</a>';
				//resultDiv.innerHTML+='<a href=javascript:RenommerFile("'+download+'");>  	Renommer 	</a>';
				resultDiv.innerHTML+='<a href=javascript:supprimFile("'+download+'");> 	Supprimer	</a>';
				resultDiv.innerHTML+='<br/>';
			
			
			}
			resultDiv.innerHTML+='</table>';
			//downloadFile('./test.txt');
			/*var arr=[];
				for(elem in obj){
				    arr.push(obj[elem]);
					//resultDiv.innerHTML+='<table>';
					resultDiv.innerHTML+='<tr><td>'
					resultDiv.innerHTML+=obj[elem];
					//resultDiv.innerHTML+='</tr></td>'
					//resultDiv.innerHTML+='</br>';
					//resultDiv.innerHTML+='</table>'
			}
			resultDiv.innerHTML+='</table>';*/
		}
	})

}
 
