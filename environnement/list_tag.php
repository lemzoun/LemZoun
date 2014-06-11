<?php
session_start();
header( 'content-type: text/html; charset=utf-8' );
header('Access-Control-Allow-Origin: *');
if(isset($_POST['welcome']))
	{  //reccupere la liste des tag
		//$_SESSION['id_utilisateur']=$_POST['welcome'];
		$_POST['welcome'] = htmlspecialchars($_POST['welcome']);
	if (filter_var($_POST['welcome'], FILTER_VALIDATE_EMAIL)) {
		$tag=list_tag($_POST['welcome']);
		$data=$tag;
		}
	}
else
	{
	$data[]='error';
	}


function list_Tag($Email)
 {
     $_SERVER['PHP_AUTH_USER']=$_SESSION['id_utilisateur'];
	 $Email=$_SERVER['PHP_AUTH_USER'];
 
 try
            {
                 $bdd = new PDO('mysql:host=127.4.62.2;dbname=smartframe', 'admin1MwVTtq', 'sf19c3wA7hGf');
            }
        catch (Exception $e)
            {
                  die('Erreur : ' . $e->getMessage());
            }
		
        $reponse = $bdd->query("SELECT id_user FROM lz_session where mail=".$bdd->quote($Email, PDO::PARAM_STR)."LIMIT 1");//'$Email'");
		$donnees = $reponse->fetch();
		
		if (isset($donnees) && $donnees != 0)
		{
		$id_user= preg_replace("/[^0-9]+/", "",$donnees['id_user']);//$donnees['id_user'];
		$reponse = $bdd->query("SELECT nom_tag FROM lz_tag where id_user=".$bdd->quote($id_user, PDO::PARAM_STR));//'$id_user'");
		
			while ($donnees = $reponse->fetch()) 
			{

			
			$data[] = $donnees['nom_tag'];
			}
		$reponse->closeCursor();
		
		}
		return $data;
 }
$array['reponse'] = $data;
echo json_encode($array);
