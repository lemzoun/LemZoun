$(function()
{
// Variable to store your files
var files;

// Add events
$('input[type=file]').on('change', prepareUpload);
$('form').on('change', uploadFiles);

// Grab the files and set them to our variable
function prepareUpload(event)
{
files = event.target.files;
}

// Catch the form submit and upload the files
function uploadFiles(event)
{
event.stopPropagation(); // Stop stuff happening
        event.preventDefault(); // Totally stop stuff happening

        // START A LOADING SPINNER HERE

        // Create a formdata object and add the files
var data = new FormData();
$.each(files, function(key, value)
{
data.append(key, value);
});
        
        $.ajax({
            url: 'upload.php?files',
            type: 'POST',
            data: data,
            cache: false,
            dataType: 'json',
            processData: false, // Don't process the files
            contentType: false, // Set content type to false as jQuery will tell the server its a query string request
            success: function(json)
            {
				if(json.message_erreur)
				{
				alert(json.message_erreur);
					resultDiv=document.getElementById("mess_up");
					resultDiv.style.display='inline'; 
					resultDiv.innerHTML=json.message_erreur;
				}
				else(json.liste_tag)
				{
			
			
			 var obj = json.liste_tag;
		

			 resultDiv=document.getElementById("contenu");
			 resultDiv.style.display='inline'; 
			 resultDiv.innerHTML="<form method='POST' action='' name='formTest' id='formTest'>";
			 resultDiv.innerHTML+="<INPUT type= 'radio' name='tag' id='tag' value='defaut' checked>defaut" ;
			 resultDiv.innerHTML+='<br/>';

						
				var arr = [];
				for (elem in obj) 
				{
					arr.push(obj[elem]);
					resultDiv.innerHTML+="<INPUT type= 'radio' name='tag' id='tag' value="+obj[elem]+ ">" +obj[elem];
					resultDiv.innerHTML+='<br/>';
				}
				resultDiv.innerHTML+="<INPUT type= submit name=ok value=ok id=ok onclick=test();>" ;            
																 
				resultDiv.innerHTML+="</form>";
			

             if(typeof data.error === 'undefined')
             {
             // Success so call function to process the form
             submitForm(event, data);
			 
             }
             else
             {
             // Handle errors here
             console.log('ERRORS: ' + data.error);
             }
			 
            }
			},
            error: function(jqXHR, textStatus, errorThrown)
            {
             // Handle errors here
             console.log('ERRORS: ' + textStatus);
             // STOP LOADING SPINNER
            }
			
        });
		
		 document.forms['form1'].reset();
    }

    function submitForm(event, data)
{
// Create a jQuery object from the form
$form = $(event.target);

// Serialize the form data
var formData = $form.serialize();

// You should sterilise the file names
$.each(data.files, function(key, value)
{
formData = formData + '&filenames[]=' + value;
});

$.ajax({
url: 'upload.php',
            type: 'POST',
            data: formData,
            cache: false,
            dataType: 'json',
            success: function(data, textStatus, jqXHR)
            {
			
             if(typeof data.error === 'undefined')
             {
             // Success so call function to process the form
             console.log('SUCCESS: ' + data.success);
			 

             }
             else
             {
             // Handle errors here
             console.log('ERRORS: ' + data.error);
             }
			
            },
            error: function(jqXHR, textStatus, errorThrown)
            {
             // Handle errors here
             console.log('ERRORS: ' + textStatus);
            },
            complete: function()
            {
             // STOP LOADING SPINNER
            }
			
});
}
});




function test() 
		{
			
 
					var tag=$('input[type=radio][name=tag]:checked').attr('value');
					
 
			
            $.ajax({
                url: 'upload.php',
                type: 'POST',
                data: {tag: $('input[type=radio][name=tag]:checked').attr('value')},
                dataType: 'json',
                success: function(json) 
						{
                    
                        resultDiv.innerHTML="" ; 
						contenuDiv=document.getElementById("contenu");
						contenuDiv.innerHTML="" ;
						listerFichier();
					 
						
						}
					});
				
        return false;
			
		};
   