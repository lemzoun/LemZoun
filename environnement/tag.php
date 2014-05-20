<?php // You need to add server side validation and better error handling here
session_start();
header( 'content-type: text/html; charset=utf-8' );
include("tag.class.php");

if(isset($_POST['Tag']))
{
	//Valider les informations recu
	$_POST['Tag'] = htmlspecialchars($_POST['Tag']);
	$Tag = new Tag();	

	$Tag->SetTagName($_POST['Tag']);


	if (($Tag->EnregistrerTag())==true) 
	{
			$data = 'le Tag a ete pris en compte';
	}
	else
	{
		$data = "erreur le tag existe deja ";
	}
					
}



else
{
$data = 'error : ';
}

$array['reponse'] = $data;
echo json_encode($array);

?>
