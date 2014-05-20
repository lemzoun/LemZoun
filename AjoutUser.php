<?php
include("User.class.php");
if(isset($_POST['Prenom']) && isset($_POST['Nom']) && isset($_POST['Email']) && isset($_POST['p'])) 
		{
			// On rend inoffensives les balises HTML que le visiteur a pu rentrer 
				$_POST['Prenom'] = htmlspecialchars($_POST['Prenom']);
				$_POST['Nom'] = htmlspecialchars($_POST['Nom']);
				$_POST['Email'] = htmlspecialchars($_POST['Email']);
				$_POST['p']=htmlspecialchars($_POST['p']);
				//valider l'email
				if (preg_match("#^[a-z0-9._-]+@[a-z0-9._-]{2,}\.[a-z]{2,4}$#",$_POST['Email']))
				{
		   $user=new user();
		   if ($user->CreationCompte(($_POST['Prenom']), ($_POST['Nom']), ($_POST['Email']), ($_POST['p']))==true)
			{
			$reponse='felicitation! Compte cree avec success';
		    }
			
		   else
		   {
		   $reponse='Ce login est déjà pris. Veuillez en utiliser un autre !!';
		   }
		   }
		   else{
		   $reponse="L'email non valide";
		   }
		    
		} 
else 
		{
    $reponse = 'try again';
		}
 
$array['reponse'] = $reponse;
echo json_encode($array);
?>