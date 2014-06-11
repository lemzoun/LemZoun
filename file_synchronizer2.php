<?php
session_start();
class File_Synchronizerr
{
	
	
	function nom_file($Email,$Password)
	{
		$file=null;	
			try
				{
					$bdd = new PDO('mysql:host=127.4.62.2;dbname=smartframe', 'admin1MwVTtq', 'sf19c3wA7hGf');
				}
			catch (Exception $e)
				{
					 die('Erreur : ' . $e->getMessage());
				}
				 $reponse = $bdd->query("SELECT * FROM lz_user where Email='$Email'");
				$donnees = $reponse->fetch();
				if (isset($donnees) && $donnees != 0 && $donnees["Password"]==$Password)
				{echo "1" ;
				$id_user=$donnees['id_user'];
				$reponse = $bdd->query("SELECT * FROM lz_fichier where id_user='$id_user'");
				while ($donnees = $reponse->fetch())
					{
						
						$files_a = scandir("http://smartframe-lemzoun.rhcloud.com/environnement/donnee");
						foreach($files_a as $file)
						{
						$token=$donnees['token_file'];
					 $longueur=strlen($token);
						 $long=strlen($file);
						$file_name=substr($file,$longueur,$long-1);
						if($file_name==$donnees['nom_file'])
						{
						$date=$donnees['date_upload'];
					$tout=$file." ";
					$tout=$tout.$date;
						echo $tout."\n" ;
						}
						else
						{
						echo "mauvais";
						}
						}
					}
					$_SESSION['id']=$Email;
				}
				else
				{
				echo 'error:mail ou password incorrect';
				}
				
	}
	
//uploader fichier local sur serveur	
	function uploadfile()
	{
		
	$uploads_dir = 'http://smartframe-lemzoun.rhcloud.com/environnement/donnee';
		if(is_uploaded_file($_FILES['userfile']['tmp_name']))
			{
				echo  "File ".  $_FILES['userfile']['name']  ." uploaded successfully ";
				$dest=  $_FILES['userfile'] ['name'];
				//ajouter
				try
					{
						$bdd = new PDO('mysql:host=127.4.62.2;dbname=smartframe', 'admin1MwVTtq', 'sf19c3wA7hGf');
					}
				catch (Exception $e)
					{
						die('Erreur : ' . $e->getMessage());
					}
				$Email=$_POST['id'];//$_POST['Email'];
				 $reponse = $bdd->query("SELECT * FROM lz_user where Email='$Email'");
				$donnees = $reponse->fetch();
				if (isset($donnees) && $donnees != 0)
				{
					$id_user=$donnees['id_user'];
					$resident=$donnees['resident'];
					$long=strlen($resident);
					
					if($resident==0)
					{
					$resident=uniqid(rand(1000000000,9999999999), true);
					 $bdd->exec("UPDATE lz_user SET resident='$resident'  where id_user='$id_user'");
					}
					$nomfile_dansdossier=$resident.$dest;
					$reponsetoken = $bdd->query("SELECT * FROM lz_fichier where id_user='$id_user' and nom_file='$dest'");
					$donneestoken = $reponsetoken->fetch();
			if (file_exists($nomfile_dansdossier)) 
				{
				}
			else if(file_exists($dest))	
				{
				}
			else if($donneestoken['token_file']!=0)
				{
				}
				else
				{
				move_uploaded_file ($_FILES['userfile'] ['tmp_name'], "$uploads_dir/$nomfile_dansdossier");
				
					$info = new SplFileInfo($dest);
				$extension=$info->getExtension();
				
				
				$Size = filesize("$uploads_dir/$nomfile_dansdossier");
				
				$location='http://smartframe-lemzoun.rhcloud.com/environnement/donnee/a'.$dest;
					
	    $bdd->exec("INSERT INTO lz_fichier(id_file,id_user,nom_file,token_file,nom_tag,type_file,size_file ,location_file)VALUES('','$id_user', '$dest', '$resident','defaut','$extension','$Size', '$location')");
				}
			}
			} 
		else 
			{
				echo "Possible file upload attack: ";
				echo "filename '". $_FILES['userfile']['tmp_name'] . "'.";
				print_r($_FILES);
			}
	
/*$file=$_POST['nom_file'];
		$fichier=fopen("C:/wamp/www/LemZoun/environnement/donnee/".$_POST['nom_file'],"a+");
//$contenu=base64_decode($_POST['contenu']);
$contenu = mb_convert_encoding($_POST['contenu'], "utf-16","utf-8");
		fwrite($fichier,$contenu);
		echo 'le contenu'.$_POST['contenu'];
	fclose($fichier);
	
	*/
	/*Création du fichier
	$fichier = fopen("C:/wamp/www/LemZoun/environnement/donnee/".$_POST['nom_file'],"a+"); 
		if (fwrite($fichier,$_POST['contenu'])) 
		{
			echo "bravo";
			
		}
		else 
		{
		// Erreur
			echo "error";
		} 
		fclose($fichier); 
		
	/*	$tabfich=file($file); 
		for( $i = 1 ; $i < count($tabfich) ; $i++ )
		{
		echo $tabfich[$i]."</br>";
		}*/
		

	}
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	function fileModifierLocal()
	{
		
	$uploads_dir = 'http://smartframe-lemzoun.rhcloud.com/environnement/donnee';
		if(is_uploaded_file($_FILES['userfile']['tmp_name']))
			{
				echo  "File ".  $_FILES['userfile']['name']  ." uploaded successfully ";
				$dest=  $_FILES['userfile'] ['name'];
				//ajouter
				try
					{
						$bdd = new PDO('mysql:host=127.4.62.2;dbname=smartframe', 'admin1MwVTtq', 'sf19c3wA7hGf');
					}
				catch (Exception $e)
					{
						die('Erreur : ' . $e->getMessage());
					}
				$Email='fadigaoumar@gmail.com';//$_POST['Email'];
				 $reponse = $bdd->query("SELECT * FROM lz_user where Email='$Email'");
				$donnees = $reponse->fetch();
				if (isset($donnees) && $donnees != 0)
				{
					$id_user=$donnees['id_user'];
					$resident=$donnees['resident'];
					$long=strlen($resident);
					
					if($resident==0)
					{
					$resident=uniqid(rand(1000000000,9999999999), true);
					 $bdd->exec("UPDATE lz_user SET resident='$resident'  where id_user='$id_user'");
					}
					$nomfile_dansdossier=$resident.$dest;
					$reponsetoken = $bdd->query("SELECT * FROM lz_fichier where id_user='$id_user' and nom_file='$dest'");
					$donneestoken = $reponsetoken->fetch();
			if (file_exists($nomfile_dansdossier)) 
				{
			$bdd->exec("DELETE FROM lz_fichier WHERE id_uder=$id_user and nom_file='$nomfile_dansdossier'");
			unlink('C:/wamp/www/LemZoun/environnement/donnee'.$nomfile_dansdossier);
		move_uploaded_file ($_FILES['userfile'] ['tmp_name'], "$uploads_dir/$dest");
				
					$info = new SplFileInfo($dest);
				$extension=$info->getExtension();
				
				
				$Size = filesize("$uploads_dir/$nomfile_dansdossier");
				
				$location='http://smartframe-lemzoun.rhcloud.com/environnement/donnee/a'.$dest;
					
	    $bdd->exec("INSERT INTO lz_fichier(id_file,id_user,nom_file,token_file,nom_tag,type_file,size_file ,location_file)VALUES('','$id_user', '$dest', '$resident','defaut','$extension','$Size', '$location')");
			
				}
			
			else if($donneestoken['token_file']!=0)
				{$t=$donneestoken['token_file'];
				$nomfile_token=$t.$dest;
				if(file_exists($nomfile_token))
				{
				$bdd->exec("DELETE FROM lz_fichier WHERE id_uder=$id_user and nom_file='$dest'");
			unlink('http://smartframe-lemzoun.rhcloud.com/environnement/donnee/'.$nomfile_token);
		move_uploaded_file ($_FILES['userfile'] ['tmp_name'], "$uploads_dir/$nomfile_token");
				
					$info = new SplFileInfo($dest);
				$extension=$info->getExtension();
				
				
				$Size = filesize("$uploads_dir/$nomfile_token");
				
				$location='http://smartframe-lemzoun.rhcloud.com/environnement/donnee/a'.$dest;
					
	    $bdd->exec("INSERT INTO lz_fichier(id_file,id_user,nom_file,token_file,nom_tag,type_file,size_file ,location_file)VALUES('','$id_user', '$dest', '$t','defaut','$extension','$Size', '$location')");
			
			
				}}
				
			}
			} 
		else 
			{
				echo "Possible file upload attack: ";
				echo "filename '". $_FILES['userfile']['tmp_name'] . "'.";
				print_r($_FILES);
			}
	

	}
	}
 

?>
