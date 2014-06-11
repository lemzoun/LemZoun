<?php
/**
 * This class allows a user to upload and validate their files.
 *
 * @author John Ciacia 
 * @version 1.0
 * @copyright Copyright (c) 2007, John Ciacia
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 */
class Tag{
    var $TagName;
 
    function Tag()
    {
 
    }
 
 
    function SetTagName($argv)
    {
        $this->TagName = $argv;
    }
    function GetTagName()
    {
        return $this->TagName;
    }
	

	 function connexion_DB()
	 {
		mysql_connect("localhost","root","") or die(mysql_error());
		mysql_select_db("cloud") or die(mysql_error());
	 }
    function EnregistrerTag()
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
		$reponse = $bdd->query("SELECT id_user FROM lz_user where Email=".$bdd->quote($Email, PDO::PARAM_STR)."LIMIT 1");//'$Email'");
		$donnees = $reponse->fetch();
		
		if (isset($donnees) && $donnees != 0)
		{
			$id_user=$donnees['id_user'];
			//}
			$TagName = $this->TagName;
			
			$stmt = $bdd->query("SELECT nom_tag FROM lz_tag where id_user=".$bdd->quote($id_user, PDO::PARAM_INT)."and nom_tag=".$bdd->quote($TagName, PDO::PARAM_STR));
			
			$stmt = $stmt->fetch();
				if (empty($stmt['nom_tag']))
			{
			
				$bdd->exec("INSERT INTO lz_tag(id_tag,nom_tag,id_user)VALUES('','$TagName','$id_user')");  
				//$bool=true;

			//$stmt->closeCursor();
		
				//$conn=mysql_connect("localhost","root","") or die(mysql_error());
				//$sql = "INSERT INTO lz_tag (id_tag,nom_tag,id_user) VALUES ( '', '$TagName' ,'$id_user' )";
				
				//mysql_select_db("cloud") or die(mysql_error());
				//$retval = mysql_query( $sql, $conn );
				
				//mysql_close($conn);
                return true;
			}
			else
			{
			return false;
			}
			$stmt->closeCursor();
		}
        $reponse->closeCursor();   
        }
 
    
 
    }

?>
