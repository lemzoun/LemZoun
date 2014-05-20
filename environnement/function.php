<?php
header( 'content-type: text/html; charset=utf-8' );
//session_start();

	
function login($nom)
{
	$name='';
	try
				{
					 $bdd = new PDO('mysql:host=localhost;dbname=cloud', 'root', '5ecur1ty');
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
                 $bdd = new PDO('mysql:host=localhost;dbname=cloud', 'root', '5ecur1ty');
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
			$reponse = $bdd->query("SELECT nom_file FROM lz_fichier where id_user='$id_user'");
			//$donnees[] = $reponse->fetch();
		
			while ($donnees = $reponse->fetch()) 
			{
				$data[] = $donnees['nom_file'];
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
	$url="http://localhost/lemzoun/environnement/donnee/".$nom_file;

				try
					{
						 $bdd = new PDO('mysql:host=localhost;dbname=cloud', 'root', '5ecur1ty');
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
				$reponse = $bdd->query("SELECT nom_file FROM lz_fichier_partager where nom_file='$nom_file'");
				$donnees = $reponse->fetch();
				if($donnees==null)
				{
				
				$reponse = $bdd->query("INSERT INTO lz_fichier_partager(id,id_user,nom_file,temp) VALUES ( '', '$id_user' ,'$nom_file','$temp' )");
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
                 $bdd = new PDO('mysql:host=localhost;dbname=cloud', 'root', '5ecur1ty');
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
			$reponse = $bdd->query("SELECT nom_file FROM lz_fichier_partager where id_user=".$bdd->quote($id_user, PDO::PARAM_INT)."and nom_file=".$bdd->quote($nom_fichier, PDO::PARAM_STR)."LIMIT 1");
			$donnees = $reponse->fetch();
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
				$bdd->exec("Delete FROM lz_fichier_partager WHERE nom_file =".$bdd->quote($nom_fichier, PDO::PARAM_STR)."and id_user=".$bdd->quote($id_user, PDO::PARAM_INT));
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
                 $bdd = new PDO('mysql:host=localhost;dbname=cloud', 'root', '5ecur1ty');
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
function renommerfile($nom_fichier,$nouveaux_nom)
{
	try
            {
                 $bdd = new PDO('mysql:host=localhost;dbname=cloud', 'root', '5ecur1ty');
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
		if ($donnees)
		{
			$temp="donnee/";
			$token_file=$donnees['token_file'];
			$reponse = $bdd->query("SELECT nom_file FROM lz_fichier_partager where nom_file=".$bdd->quote($nom_fichier, PDO::PARAM_STR)."LIMIT 1");//."and nom_file=".$bdd->quote($nom_fichier, PDO::PARAM_STR)."LIMIT 1");
			$donnees = $reponse->fetch();
			if ($donnees)
			{
				$bdd->exec("UPDATE lz_fichier_partager SET nom_file =".$nouveaux_nom."where nom_file=".$nom_fichier);
				$bdd->exec("UPDATE lz_fichier SET nom_file =".$nouveaux_nom."where token_file=".$token_file."and nom_file=".$nom_fichier);
				$data = rename($temp.$token_file.$nom_fichier,$temp.$token_file.$nom_fichier);
				return data;	
			}
			else
			{
			$bdd->exec("UPDATE lz_fichier SET nom_file =".$nouveaux_nom."where token_file=".$token_file."and nom_file=".$nom_fichier);
				$data = rename($temp.$token_file.$nom_fichier,$temp.$token_file.$nom_fichier);
				return data;
			}				
			
		}
		else
		return false;
		
	

}
}

