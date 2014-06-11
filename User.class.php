<?php
//include 'environnement/db_connection.php';
class User 
{
    var $id_user;
	var $Prenom;
    var $Nom;
    var $Email;
    var $Password;
	
 public function __User($id_user,$Prenom,$Nom, $Email, $Password)    
    {
				$this->id_user = $id_user;
				$this->Nom = $Nom;
				$this->Email = $Email;
				$this->Password = $Password;
               
               
    }   
	
function CreationCompte($Prenom, $Nom, $Email, $Password)
    {
	
	
        try
            {
                 $bdd = new PDO('mysql:host=127.4.62.2;dbname=smartframe', 'admin1MwVTtq', 'sf19c3wA7hGf');
            }
        catch (Exception $e)
            {
                  die('Erreur : ' . $e->getMessage());
            }
		$reponse = $bdd->query("SELECT * FROM lz_user where Email=".$bdd->quote($Email, PDO::PARAM_STR)."LIMIT 1");
		
		$donnees = $reponse->fetch();
		
		if($Prenom==''or $Nom==''or $Email=='' or $Password=='')	
			{
		return false;
			}
		
		elseif (empty($donnees))
			{
			$pass = hash('sha512',$_POST['Password']);
			//creation d'un salt 
			$random_salt = hash('sha512', uniqid(mt_rand(1, mt_getrandmax()), true));
			//Creation d'un salted password
			$password = hash('sha512', $pass.$random_salt);

	    $bdd->exec("INSERT INTO lz_user(id_user, Prenom, Nom,Email, Password,Salt) VALUES('','$Prenom', '$Nom', '$Email','$password','$random_salt')");
		//$bdd->prepare("INSERT INTO lz_user(id_user, Prenom, Nom,Email, Password) VALUES(?,?,?,?,?)");
		//$bdd->execute(array( '',$_POST['Prenom'],$_POST['Nom'],$_POST['Email'],$_POST['Password']));
		return true;
			}
    //return 'hello';
	return false;
	
	$reponse->closeCursor();
	}
	/*function haveCompte($Email)
	{
		 try
            {
                 $bdd = new PDO('mysql:host=localhost;dbname=Cloud', 'root', '');
            }
        catch (Exception $e)
            {
                  die('Erreur : ' . $e->getMessage());
            }
			$stmt=$bdd->query("SELECT * FROM lz_user where Email='$Email'");//.$bdd->quote($mail, PDO::PARAM_STR)."LIMIT 1");
			$stmt=$stmt->fetch();
		if (empty($stmt))
		{
		return true;
		}
		else 
		{
		return false;
		}
		
	}*/
	
	
		function Connection($Email, $Password)
	{
	
	$bool=false;
		try
            {
                 $bdd = new PDO('mysql:host=127.4.62.2;dbname=smartframe', 'admin1MwVTtq', 'sf19c3wA7hGf');
            }
        catch (Exception $e)
            {
                  die('Erreur : ' . $e->getMessage());
            }
		//Protection sql injection
        $reponse = $bdd->query("SELECT * FROM lz_user where Email=".$bdd->quote($Email, PDO::PARAM_STR)." and Password=".$bdd->quote($Password,PDO::PARAM_STR)."LIMIT 1");
		
		$donnees = $reponse->fetch();
			/*if ($reponse = $bdd->query("SELECT * FROM lz_user where Email=".$bdd->quote($Email, PDO::PARAM_STR)."LIMIT 1"))
				{
				$Password=hash('sha512',$password.$donnees['salt']);//hash the password with the unique salt.
				
				} */
		
		
		if (isset($donnees) && $donnees != 0)
		{
			$_SESSION['id_utilisateur']=$donnees['Email'];
			$utilisateur= preg_replace("/[^0-9]+/", "",$donnees['id_user']); //protection contre le xss
			$nom=$donnees['Nom'];
			$login=$donnees['Email'];
			$token=uniqid(rand(), true);
			//$_SESSION['id_token']=$token;
			$bdd->exec("INSERT INTO lz_session(id_session,id_user,login,mail,token_user)VALUES('','$utilisateur','$nom','$login','$token')");  
			$bool=true;

			$reponse->closeCursor();
		}
 
		
		return $bool;
	}
	
	
	
	
	function deconnexion($Email)
	{
	$bool=false;
		try
            {
                 $bdd = new PDO('mysql:host=127.4.62.2;dbname=smartframe', 'admin1MwVTtq', 'sf19c3wA7hGf');
            }
        catch (Exception $e)
            {
                  die('Erreur : ' . $e->getMessage());
            }
			
			if (isset ($Email)){
			//$token=$_SESSION['id_token'];
			$bdd->exec("DELETE FROM lz_session WHERE mail=".$bdd->quote($Email, PDO::PARAM_STR)); //and token_user=".$bdd->quote($token, PDO::PARAM_STR));
			session_destroy();
			$bool=true;
			}
			return $bool;
	}

function SetPrenom($argv)
    {
        $this->Prenom = $argv;
    }
 
    function SetNom($argv)
    {
        $this->Nom = $argv;
    }
 
    function SetEmail($argv)
    {
        $this->Email = $argv;
    }
 
    function SetPassword($argv)
    {
        $this->Password = $argv;
    }
 
   
    function GetPrenom()
    {
        return $this->Prenom;
    }
	
	function GetNom()
    {
        return $this->Nom;
    }
	
	function GetEmail()
    {
        return $this->Email;
    }
	
    function GetPassword()
    {
        return $this->Password;
    }
}
?>
