<?php
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
				$Email=$_GET['id'];//$_POST['Email'];
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
			if (file_exists('http://smartframe-lemzoun.rhcloud.com/environnement/donnee/'.$nomfile_dansdossier)) 
				{
			$bdd->exec("DELETE FROM lz_fichier WHERE id_user=$id_user and nom_file='$dest'");
			unlink('http://smartframe-lemzoun.rhcloud.com/environnement/donnee/'.$nomfile_dansdossier);
		move_uploaded_file ($_FILES['userfile'] ['tmp_name'], "$uploads_dir/$nomfile_dansdossier");
				
					$info = new SplFileInfo($dest);
				$extension=$info->getExtension();
				
				
				$Size = filesize("$uploads_dir/$nomfile_dansdossier");
				
				$location='http://smartframe-lemzoun.rhcloud.com/environnement/donnee/'.$dest;
					
	    $bdd->exec("INSERT INTO lz_fichier(id_file,id_user,nom_file,token_file,nom_tag,type_file,size_file ,location_file)VALUES('','$id_user', '$dest', '$resident','default','$extension','$Size', '$location')");
			
				}
			
			else if($donneestoken['token_file']!=0)
				{$t=$donneestoken['token_file'];
				$nomfile_token=$t.$dest;
				if(file_exists('C:/wamp/www/LemZoun/environnement/donnee/'.$nomfile_token))
				{
				$bdd->exec("DELETE FROM lz_fichier WHERE id_user=$id_user and nom_file='$dest'");
			unlink('http://smartframe-lemzoun.rhcloud.com/environnement/donnee/'.$nomfile_token);
		move_uploaded_file ($_FILES['userfile'] ['tmp_name'], "$uploads_dir/$nomfile_token");
				
					$info = new SplFileInfo($dest);
				$extension=$info->getExtension();
				
				
				$Size = filesize("$uploads_dir/$nomfile_token");
				
				$location='http://smartframe-lemzoun.rhcloud.com/environnement/donnee/a'.$dest;
					
	    $bdd->exec("INSERT INTO lz_fichier(id_file,id_user,nom_file,token_file,nom_tag,type_file,size_file ,location_file)VALUES('','$id_user', '$dest', '$t','default','$extension','$Size', '$location')");
			
			
				}}
				
			}
			} 
		else 
			{
				echo "Possible file upload attack: ";
				echo "filename '". $_FILES['userfile']['tmp_name'] . "'.";
				print_r($_FILES);
			}
	
























