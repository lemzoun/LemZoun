<?php 
session_start();
include 'function.php';

header('Access-Control-Allow-Origin: *');
if(isset($_POST['sUrl'])&&isset($_POST['utilisateur']))
{
	if ((downloadFile($_POST['sUrl'],$_POST['utilisateur'])!=false))
	{
	$url=downloadFile($_POST['sUrl'],$_POST['utilisateur']);
	$nom_fichier=$_POST['sUrl'];
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
				
			$reponse = $bdd->query("SELECT * FROM lz_fichier where nom_file=".$bdd->quote($nom_fichier, PDO::PARAM_INT)."and id_user=".$bdd->quote($id_user, PDO::PARAM_STR)."LIMIT 1");
			$donnees = $reponse->fetch();
		$id_fichier=$donnees['id_file'];
	$value = file_get_contents('donnee/'.$url);
		$key = "1234567891234567"; 
		$fp = fopen('donnee/'.$url, 'w');
		fwrite($fp, Security::decrypt($value, $key));
		fclose($fp);
		$bdd->exec("Delete FROM lz_cryptage WHERE id_fichier =".$bdd->quote($id_fichier, PDO::PARAM_STR));
				
	header('Content-Type: application/octet-stream');
	header("Content-Transfer-Encoding: Binary"); 
	$file_url='donnee/'.$url;
	header("Content-disposition: attachment; filename=\"" . basename($file_url) . "\""); 


	//readfile($file_url);
	$array['fichier'] = $file_url;
	echo json_encode($array);	
		/*$value = file_get_contents($file_url);
$key = "1234567891234567"; //16 Character Key
$fp = fopen($file_url, 'w');
fwrite($fp, Security::encrypt($value, $key));
fclose($fp);*/
	}
	else
	{
	$url=$_POST['sUrl'];
	header('Content-Type: application/octet-stream');
	header("Content-Transfer-Encoding: Binary"); 
	$file_url='res/dist/'.$url;
	header("Content-disposition: attachment; filename=\"" . basename($file_url) . "\""); 

	//readfile($file_url);
	$array['fichier'] = $file_url;
	echo json_encode($array);	
	
	}
}

else 
{
	$array['reponse'] = "erreur de methode";
	echo json_encode($array);
}




?>
