<?php 
session_start();
header( 'content-type: text/html; charset=utf-8' );
include("Upload.Class.php");

if(isset($_POST['welcome']))
{
//$data=0;
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
					$reponse = $bdd->query("SELECT id_user FROM lz_session where mail='$Email'");
				$donnees = $reponse->fetch();
				if (isset($donnees) && $donnees != 0)
					{
				$id_user=$donnees['id_user'];
				$partager='partager';
				$reponse = $bdd->query("SELECT * FROM lz_fichier  where id_user='$id_user' and fichier_partager='$partager'");
				while ($donnees = $reponse->fetch()) {

		
		$data[] = $donnees['nom_file'];
					}
					}
					else
					{
					$data="hops vous n etes pas connecter";
}

}

else
	{
		$data='error';
	}

$array['reponse'] = $data;
echo json_encode($array);

?>
