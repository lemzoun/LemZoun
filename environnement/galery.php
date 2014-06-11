<?php 
session_start();
include 'function.php';

header('Access-Control-Allow-Origin: *');
if(isset($_POST['utilisateur']))
{
$Email=$_POST['utilisateur'];
try
            {
                 $bdd = new PDO('mysql:host=127.4.62.2;dbname=smartframe', 'admin1MwVTtq', 'sf19c3wA7hGf');
            }
        catch (Exception $e)
            {
                  die('Erreur : ' . $e->getMessage());
            }
				$reponse = $bdd->query("SELECT * FROM lz_user where Email=".$bdd->quote($Email, PDO::PARAM_INT));
		    	$donnees = $reponse->fetch();
				$id_user=$donnees['id_user'];
				
				$reponse = $bdd->query("SELECT * FROM lz_fichier where id_user=".$bdd->quote($id_user, PDO::PARAM_INT));
		    while($donnees = $reponse->fetch())
			{
				$type_file=$donnees['type_file'];
				$nom_file=$donnees['nom_file'];
				if($type_file=='jpg' or $type_file=='png' or $type_file=='jpeg')
				{
				$data[] = $nom_file;
			
				}
				
			}
		$array['image'] = $data ;
				echo json_encode($array);
}

else 
{
	$array['reponse'] = "erreur ";
	echo json_encode($array);
}




?>
