<?php
session_start();
header( 'content-type: text/html; charset=utf-8' );
if(isset($_POST['tag_choisit']))
{

	//$_SESSION['id_utilisateur']=$_POST['welcome'];
	//valider les informations recut
	$_POST['tag_choisit'] = htmlspecialchars($_POST['tag_choisit']);
	$ensemble_file=file_tager($_POST['tag_choisit']);
	$data=$ensemble_file;
}
else
{
$data[]='user';
}
function file_tager($tag)
 {
 $data='';
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
		
        $reponse = $bdd->query("SELECT id_user FROM lz_session where mail=".$bdd->quote($Email, PDO::PARAM_STR)."LIMIT 1"); //$Email'");
			$donnees = $reponse->fetch();
		
		if (isset($donnees) && $donnees != 0)
		{
		$id_user=$donnees['id_user'];
		$reponse = $bdd->query("SELECT nom_file FROM lz_fichier where nom_tag='$tag' and id_user='$id_user' ");
		
		while ($donnees = $reponse->fetch()) {

		
		$data[] = $donnees['nom_file'];
					}
		
		
		}return $data;
 
 }
$array['reponse'] = $data;
echo json_encode($array);
