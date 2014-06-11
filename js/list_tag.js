$(document).ready(function() 
{
//cette fonction reccupere la liste des tag deja cree par l'utilisateur
	 $.ajax({
	type : "POST",
	url: "list_tag.php",
	data: {welcome: localStorage.getItem('id_user')} ,
	dataType: "json",
	success: function(json) {
		resultDiv=document.getElementById("list_tag");
		resultDiv.innerHTML+="<form method='POST' action='' name='form_tag' id='form_tag'>Filtrer par <select id='list' name='list'><option VALUE=defaut selected>defaut</option>";
		var obj = json.reponse;
		var arr = [];
		var x = document.getElementById("list");
		for (elem in obj) 
			{
				arr.push(obj[elem]);
				var length = document.forms.form_tag.list.length;	
				var option = document.createElement('OPTION');
				x.options.add(option);
				option.innerHTML = obj[elem];

			}
			resultDiv.innerHTML+="</select>";
			resultDiv.innerHTML+="</form>";
			/*------------- 4e hwe li zedet bih -------------------*/	
			$('#list').bind('change', function()
			{
						var tag_choisit = getSelectValue('list');
						
						
						$.ajax({
								type : "POST",
								url: "filtrage.php",
								data: {tag_choisit : getSelectValue('list')} ,
								dataType: "json",
								success: function(json) {
														resultDiv=document.getElementById("contenu");
														resultDiv.innerHTML="";
														//resultDiv.innerHTML+='<table>';
														resultDiv.innerHTML+='<ul class="list-group">';
														var obj = json.reponse;
			
															for (var i = 0; i < json.reponse.length; i++) 
															{
																var download=json.reponse[i];
																//resultDiv.innerHTML+='<a href=javascript:downloadFile("./donnee/'+download+'"); >'+json.reponse[i]+'</a>';
																//resultDiv.innerHTML+='<br/>';
			resultDiv.innerHTML+='<li class="list-group-item"  ><a href=javascript:downloadFile("'+download+'"); >'+json.reponse[i]+'</a><a href=javascript:RenameFile("'+download+'"); ><span class="glyphicon glyphicon-pencil" id="id_div_1"></span></a><a href=javascript:PartageFile("'+download+'"); ><span class="glyphicon glyphicon-share" id="id_div_1"></span></a><a href=javascript:supprimFile("'+download+'"); ><span class="glyphicon glyphicon-remove" id="id_div_1"></span></a></li>';
		
															}
																//resultDiv.innerHTML+='</table>';
				resultDiv.innerHTML+='</ul>';
														}
								})
										});
		
	/*------------- 4e hwe li zedet bih -------------------*/
		
		}
	})
		});
		
		
		
/*------------- 4e hwe li zedet bih -------------------*/
function getSelectValue(selectId)
{
	/**On récupère l'élement html <select>*/
	var selectElmt = document.getElementById(selectId);
	/*
	selectElmt.options correspond au tableau des balises <option> du select
	selectElmt.selectedIndex correspond à l'index du tableau options qui est actuellement sélectionné
	*/
	return selectElmt.options[selectElmt.selectedIndex].value;
}
		
/*------------- 4e hwe li zedet bih -------------------*/		


