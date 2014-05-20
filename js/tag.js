$(document).ready(function() 
		{
			$('#monForm').on('submit', function() 
			{
 
					var Tag = $('#Tag').val();
					
 
			if(Tag == '') 
			{
            alert('Les champs doivent êtres remplis');
			} 
			else {
            $.ajax({
                url: 'tag.php',
                type: 'POST',
                data: $(this).serialize(),
                dataType: 'json',
                success: function(json) 
						{
                    
                        alert(json.reponse);
						document.forms["monForm"].Tag.value="";
						
						}
					});
				}
        return false;
			});
		});
		
	