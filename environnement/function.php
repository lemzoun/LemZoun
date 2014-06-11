<?php
//session_start();

	include 'security.php';
function login($nom)
{
	$name='';
	try
				{
					 $bdd = new PDO('mysql:host=127.4.62.2;dbname=smartframe', 'admin1MwVTtq', 'sf19c3wA7hGf');
				}
			catch (Exception $e)
				{
					  die('Erreur : ' . $e->getMessage());
				}
				
				//$msg=$_POST['welcome'];
				//if (!empty($msg)){
				$nom=addslashes($nom);
				$reponse = $bdd->query("SELECT login FROM lz_session where mail=".$bdd->quote($nom, PDO::PARAM_STR)."LIMIT 1");//'$nom'");
				$donnees = $reponse->fetch();
				if (isset($donnees) && $donnees != 0)
				{
					$name=$donnees['login'];
				}
				return $name;
}
			
function fileUser()
{
	try
            {
                $bdd = new PDO('mysql:host=127.4.62.2;dbname=smartframe', 'admin1MwVTtq', 'sf19c3wA7hGf');
            }
        catch (Exception $e)
            {
                  die('Erreur : ' . $e->getMessage());
            }
		
		$mail=$_SESSION['id_utilisateur'];
		$reponse = $bdd->query("SELECT id_user FROM lz_user where Email=".$bdd->quote($mail, PDO::PARAM_STR)."LIMIT 1");//'$mail'");
		$donnees = $reponse->fetch();
		if (isset($donnees) && $donnees != 0)
		{
			$id_user=$donnees['id_user'];
			$reponse = $bdd->query("SELECT * FROM lz_fichier where id_user='$id_user'");
			//$donnees[] = $reponse->fetch();
		
			while ($donnees = $reponse->fetch()) 
			{
			$id_file=$donnees['id_file'];
			$nom_file=$donnees['nom_file'];
			$token_file=$donnees['token_file'];
		 $reponsee = $bdd->query("SELECT * FROM lz_cryptage where id_fichier='$id_file'");
		 $donneess = $reponsee->fetch();
		 if(isset($donneess) && $donneess != 0)
		 {
				
		}
		else
		{
		$a=$token_file.$nom_file;
		$value = file_get_contents("donnee/".$a);
		$key = "1234567891234567"; //16 Character Key
		$fp = fopen("donnee/".$a, 'w');
		fwrite($fp, Security::encrypt($value, $key));
		fclose($fp);
		$bdd->exec("INSERT INTO lz_cryptage(id_cryptage,id_fichier)VALUES('', '$id_file')"); 
		
		}
		$data[] = $nom_file;
		}
		}
		if (isset ($data))
			{
			return $data;	
			}
			else
			{
			//return 'pas de fichier';
			}
		//return $data;
}
function partageFichier($nom_fichier)
{
//session_start();
//$nom_file=$_POST['nom_file'];
$nom_file=$nom_fichier;
	$_SERVER['PHP_AUTH_USER']=$_SESSION['id_utilisateur'];
	$Email=$_SERVER['PHP_AUTH_USER'];
	$temp=date("Y-m-d H:i:s");
	
				try
					{
						 $bdd = new PDO('mysql:host=127.4.62.2;dbname=smartframe', 'admin1MwVTtq', 'sf19c3wA7hGf');
					}
				catch (Exception $e)
					{
						  die('Erreur : ' . $e->getMessage());
					}
				$reponse = $bdd->query("SELECT * FROM lz_session where mail='$Email'");
				$donnees = $reponse->fetch();
				if (isset($donnees) && $donnees != 0)
					{
					

				$id_user=$donnees['id_user'];
				$reponse = $bdd->query("SELECT * FROM lz_fichier where nom_file='$nom_file'");
				$donnees = $reponse->fetch();
				$url="http://smartframe-lemzoun.rhcloud.com/environnement/lz_partager/".$donnees['token_file'].$nom_file;
				$url2="http://smartframe-lemzoun.rhcloud.com/environnement/lz_partager/".$donnees['token_file'].$nom_file;
				$value = file_get_contents('donnee/'.$donnees['token_file'].$nom_file, 'w');
		$key = "1234567891234567"; 
		$fp = fopen('lz_partager/'.$donnees['token_file'].$nom_file, 'w');
		fwrite($fp, Security::decrypt($value, $key));
		fclose($fp);
				$reponse = $bdd->query("SELECT * FROM lz_fichier where nom_file='$nom_file' and fichier_partager='partager'");
				$donnees = $reponse->fetch();
				if($donnees==null)
				{
				
				//$reponse = $bdd->query("INSERT INTO lz_fichier_partager(id,id_user,nom_file,temp) VALUES ( '', '$id_user' ,'$nom_file','$temp' )");
				 $bdd->exec("UPDATE lz_fichier SET fichier_partager='partager' where id_user='$id_user' and nom_file='$nom_file'");
				$data=$url;
				}
				else
				$data='fichier deja partager';
				}
				return $data;
	

}
//Procede a la suppression du fichier choisie
function supression_fichier($nom_fichier,$token_file)
{
		try
            {
                 $bdd = new PDO('mysql:host=127.4.62.2;dbname=smartframe', 'admin1MwVTtq', 'sf19c3wA7hGf');
            }
        catch (Exception $e)
            {
                  die('Erreur : ' . $e->getMessage());
            }
	$mail=$_SESSION['id_utilisateur'];
	$reponse = $bdd->query("SELECT * FROM lz_user where Email=".$bdd->quote($mail, PDO::PARAM_STR)."LIMIT 1");//'$mail'");
	$donnees = $reponse->fetch();
	$espace=$donnees['espace'];

	if (!empty($donnees))
			{
			$id_user=$donnees['id_user'];
			$reponse = $bdd->query("SELECT * FROM lz_fichier where id_user=".$bdd->quote($id_user, PDO::PARAM_INT)."and nom_file=".$bdd->quote($nom_fichier, PDO::PARAM_STR)."LIMIT 1");
			$donnees = $reponse->fetch();
			$espace=$espace-$donnees['size_file'];
			$temp = "donnee/";
			$dest = "lz_trash/";
			if (!empty($donnees))
			{
			
			//suppression du fichier
				//deplacement du fichier
				
				//$data = rename($temp.$token_file.$nom_fichier,$dest.$token_file.$nom_fichier);
				if (rename($temp.$token_file.$nom_fichier,$dest.$token_file.$nom_fichier))
				{
			//suppression de la base de donnee des fichiers et de partage
				$bdd->exec("Delete FROM lz_fichier WHERE nom_file =".$bdd->quote($nom_fichier, PDO::PARAM_STR)."and id_user=".$bdd->quote($id_user, PDO::PARAM_INT));
				//$bdd->exec("Delete FROM lz_fichier_partager WHERE nom_file =".$bdd->quote($nom_fichier, PDO::PARAM_STR)."and id_user=".$bdd->quote($id_user, PDO::PARAM_INT));
			$bdd->exec("UPDATE lz_user SET espace='$espace' where id_user='$id_user'");
			unlink('lz_partager/'.$token_file.$nom_fichier);
				}
				else
				{
					return false;
				}
				
				
			}
			else if(empty($donnees))
			{
				if (rename($temp.$token_file.$nom_fichier,$dest.$token_file.$nom_fichier))
				{
				
				$bdd->exec("Delete FROM lz_fichier WHERE nom_file =".$bdd->quote($nom_fichier, PDO::PARAM_STR)."and id_user=".$bdd->quote($id_user, PDO::PARAM_INT));
				}
				else 
				{
					return false;
				}
			
			}
			return true;
		}
		
	return false;
}
// verifie l'existance des fichiers avant leur suppression
function confirme_suppression($nom_fichier)
{
	if (isset ($_SESSION['id_utilisateur']))
	{
		try
            {
                 $bdd = new PDO('mysql:host=127.4.62.2;dbname=smartframe', 'admin1MwVTtq', 'sf19c3wA7hGf');
            }
        catch (Exception $e)
            {
                  die('Erreur : ' . $e->getMessage());
            }
			$mail=$_SESSION['id_utilisateur'];
			$reponse = $bdd->query("SELECT id_user FROM lz_user where Email=".$bdd->quote($mail, PDO::PARAM_STR)."LIMIT 1");//'$mail'");
			$donnees = $reponse->fetch();
			if (!empty($donnees))
			{
				$id_user=$donnees['id_user'];
				$reponse = $bdd->query("SELECT nom_file,token_file FROM lz_fichier where id_user=".$bdd->quote($id_user, PDO::PARAM_INT)."and nom_file=".$bdd->quote($nom_fichier, PDO::PARAM_STR)."LIMIT 1");
				$donnees = $reponse->fetch();
				$token_file=$donnees['token_file'];
				
				/*if (!empty(donnees))
				{
					$bdd->exec("Delete FROM lz_fichier WHERE nom_file =".$bdd->quote($nom_fichier, PDO::PARAM_STR)."and id_user=".$bdd->quote($id_user, PDO::PARAM_INT));//$id_membre" id_user=
					//verifier si le fichier exite dans le partage 
					$reponse = $bdd->query("SELECT nom_file from lz_fichier_partager where nom_file=".$bdd->quote($nom_fichier, PDO::PARAM_STR)."and id_user=".$bdd->quote($id_user, PDO::PARAM_INT));

				}*/
				return $token_file;
			}
			else
			{
				return false;
			}
				
				
				
			}
			return false;
	

}
function renommerfile($nom_fichier,$nouveaux_nom,$mail)
{
	try
            {
                $bdd = new PDO('mysql:host=127.4.62.2;dbname=smartframe', 'admin1MwVTtq', 'sf19c3wA7hGf');
            }
        catch (Exception $e)
            {
                  die('Erreur : ' . $e->getMessage());
            }

	$reponse = $bdd->query("SELECT id_user FROM lz_user where Email=".$bdd->quote($mail, PDO::PARAM_STR)."LIMIT 1");//'$mail'");
	$donnees = $reponse->fetch();
	if (!empty($donnees))
	{
		$id_user=$donnees['id_user'];
		$reponse = $bdd->query("SELECT nom_file,token_file,type_file FROM lz_fichier where id_user=".$bdd->quote($id_user, PDO::PARAM_INT)."and nom_file=".$bdd->quote($nom_fichier, PDO::PARAM_STR)."LIMIT 1");
		$donnees = $reponse->fetch();
		if ($donnees)
		{$type_file='.'.$donnees['type_file'];
			$temp=$_SERVER['DOCUMENT_ROOT'].'/LemZoun/environnement/donnee/';
			$token_file=$donnees['token_file'];
			$nouveaux_nom=$nouveaux_nom.$type_file;
			$bdd->exec("UPDATE lz_fichier SET nom_file ='$nouveaux_nom' where id_user='$id_user' and nom_file='$nom_fichier'");
			//$bdd->exec("UPDATE lz_user SET nom_file='$nouveaux_nom' where id_user='$id_user'");
				$data = rename($temp.$token_file.$nom_fichier,$temp.$token_file.$nouveaux_nom);
			
			
		}
		else
		return false;
		
	

}
}
function downloadFile($url,$mail)
{
	try
            {
                 $bdd = new PDO('mysql:host=127.4.62.2;dbname=smartframe', 'admin1MwVTtq', 'sf19c3wA7hGf');
            }
        catch (Exception $e)
            {
                  die('Erreur : ' . $e->getMessage());
            }
	$token_file_lien;
	$url=$url;
	$reponse = $bdd->query("SELECT id_user FROM lz_user where Email=".$bdd->quote($mail, PDO::PARAM_STR)."LIMIT 1");//'$mail'");
	$donnees = $reponse->fetch();
	$id_utilisateur=$donnees['id_user'];
	if (!empty($id_utilisateur))
	{
		$reponse =$bdd->query("SELECT * FROM lz_fichier where nom_file=".$bdd->quote($url, PDO::PARAM_STR)."and id_user=".$bdd->quote($id_utilisateur, PDO::PARAM_INT));//."LIMIT 1");
		$donnee=$reponse->fetch();
		$token_file_lien=$donnee['token_file'];
		$url=$token_file_lien.$donnee['nom_file'];
		
		
		
		return $url;
	}
	else
	{
		return false;
	}			
	
}

function confidentialiter($ancien_password,$nouveau_password,$confirmer_password,$Email)
{
	try
            {
                 $bdd = new PDO('mysql:host=127.4.62.2;dbname=smartframe', 'admin1MwVTtq', 'sf19c3wA7hGf');
            }
        catch (Exception $e)
            {
                  die('Erreur : ' . $e->getMessage());
            }
	
	$reponse = $bdd->query("SELECT * FROM lz_user where Email=".$bdd->quote($Email, PDO::PARAM_STR)."LIMIT 1");//'$mail'");
	$donnees = $reponse->fetch();
	$id_utilisateur=$donnees['id_user'];
	if ($ancien_password==$donnees['Password'])
	{
	echo "good";
	return "good";
	}
	else
	{
		return "no";
	}			
	
}

