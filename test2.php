<?php
require_once("file_synchronizer2.php");


$file = new File_Synchronizerr();
//$file2 = new File_Synchronizerr();


 
  // $file->nom_file($_POST['Email'],$_POST['Password']);
if (isset($_POST['Email']) && isset($_POST['Password']))
				{
				$Email=$_POST['Email'];
				$Password=$_POST['Password'];
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
				{
				$id_user=$donnees['id_user'];
				$reponse2 = $bdd->query("SELECT * FROM lz_fichier where id_user='$id_user'");
				while ($donnees2 = $reponse2->fetch())
					{
					$date=$donnees2['date_upload'];
						$tout=$donnees['token_file'].$donnees['nom_file']." ".$date;
						echo $tout."\n" ;
						}
				}




}
















