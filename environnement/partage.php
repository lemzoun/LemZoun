<?php 
session_start();
header( 'content-type: text/html; charset=utf-8' );
include 'function.php';


if(isset($_POST['nom_file']))
{
	$_POST['nom_file']=htmlspecialchars($_POST['nom_file']);
	$data=partageFichier($_POST['nom_file']);
	$array['reponse'] = $data;
	echo json_encode($array);
}
else if($_POST['suppression_fichier'])
{
	if (isset ($_SESSION['id_utilisateur']))
	{
		$_POST['suppression_fichier']=htmlspecialchars($_POST['suppression_fichier']);
		//confirme si le ficier existe ou pas dans la base
		if (confirme_suppression($_POST['suppression_fichier'])==true)
		{
		$token_file=confirme_suppression($_POST['suppression_fichier']);
		//supprime le fichier 
			$resultat=supression_fichier($_POST['suppression_fichier'],$token_file);
			$array['reponse'] =$resultat;
			echo json_encode($array);
		}
		else
		{
		$data='error 1';
		$array['reponse'] = $data;
		echo json_encode($array);
		
		}
	}
	else
	{
	$data="Sorry Vous n'etes pas connecte";
		$array['reponse'] = $data;
		echo json_encode($array);
	
	}
	
}
else if ($_POST['renomme'])
{
	$_POST['renomme']=htmlspecialchars($_POST['renomme']);
	
	
}

else
{
		$data='error';
		$array['reponse'] = $data;
		echo json_encode($array);
}

//$array['reponse'] = $data;
//echo json_encode($array);

?>
