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
		alert(json.reponse);
			}
		
		})


   
    
}