<?php 
session_start();
header( 'content-type: text/html; charset=utf-8' );
include("upload.class.php");
include 'security.php';

if(isset($_GET['files']))
{
	$upload = new Upload();	
	$files = array();
	foreach($_FILES as $file)
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
			$reponse = $bdd->query("SELECT token_user FROM lz_session where mail=".$bdd->quote($Email, PDO::PARAM_STR)."LIMIT 1");//'$Email'");
			$donnees = $reponse->fetch();
			if (isset($donnees) && $donnees != 0)
			{
			$token_user=$donnees['token_user'];
						//}
						//global $name;
						//$file['tmp_name']=htmlspecialchars($_POST['tmp_name']);
			       $file['name']=preg_replace("/[^A-Z0-9._-]/i", "_", $file["name"]);
			//$parts = pathinfo($file['name']);
					$name=$donnees['token_user'].$file['name'];
			
					$_SESSION['name']=$name;
					$upload->SetFileName($name);
					$upload->SetTempName($file['tmp_name']);
					$upload->SetUploadDirectory('tampon/');
					$upload->SetValidExtensions(array('gif', 'jpg', 'jpeg', 'png','txt','php','html','pdf','docx','htm','zip','rar','iso')); 
					$upload->SetMaximumFileSize(1000000000);
					
					if ($upload->UploadFile()!=true)
					{
					
					//$data= $upload;//'error';
					$array['message_erreur'] = $upload;
					echo json_encode($array);
					//exit;
					
					
					}
					else
					{
						/*try
							{
							 $bdd = new PDO('mysql:host=localhost;dbname=Cloud', 'root', '');
							}
						catch (Exception $e)
							{
							  die('Erreur : ' . $e->getMessage());
							}	*/
					$value = file_get_contents("tampon/".$name);
$key = "1234567891234567"; //16 Character Key
$fp = fopen("tampon/".$name, 'w');
fwrite($fp, Security::encrypt($value, $key));
fclose($fp);					
						$reponse = $bdd->query("SELECT id_user FROM lz_user where Email=".$bdd->quote($Email, PDO::PARAM_STR)."LIMIT 1");//'$Email'");
						$donnees = $reponse->fetch();
							if (isset($donnees) && $donnees != 0)
								{
									$id_user=$donnees['id_user'];
									$reponse = $bdd->query("SELECT nom_tag FROM lz_tag where id_user=".$bdd->quote($id_user, PDO::PARAM_INT));//'$id_user'");	
									while ($donnees = $reponse->fetch())
										{
											$data[] = $donnees['nom_tag'];
										}
										
								}
							$array['liste_tag'] = $data;
							echo json_encode($array);	
							
					
					} 
				}
		$reponse->closeCursor();				
	}
}

else if(isset($_POST['tag']))
	{
		$_SESSION['tag']=$_POST['tag'];
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
        $reponse = $bdd->query("SELECT * FROM lz_session where mail='$Email'");
		$donnees = $reponse->fetch();
			if (isset($donnees) && $donnees != 0)
				{
					$token_user=$donnees['token_user'];
					$id_user=$donnees['id_user'];
				}
			$_SESSION['token_file']=$token_user;
			$a=$_SESSION["name"];
			$c=strlen($token_user);
			$b=substr($a,$c);
			$_SESSION['FileName']=$b;
			$upload = new Upload();	
			$upload->saveFile();
			rename("tampon/".$a,"donnee/".$a);
			

  
		
				$data=$_SESSION['tag'];
				$array['reponse'] = $data;
			    echo json_encode($array);
				$reponse->closeCursor();
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
