<?php
session_start();
//include 'environnement/db_connection.php';
//header( "Set-Cookie: name=value; httpOnly" );
header('Access-Control-Allow-Origin: 192.168.0.0');
header( 'content-type: text/html; charset=utf-8' );
include("User.class.php");



/* ***************************************************** Connection ******************************************************* */
	if(isset($_POST['user']) && isset($_POST['p'])) 
		{
			// On rend inoffensives les balises HTML que le visiteur a pu rentrer 
				$_POST['user'] = htmlspecialchars($_POST['user']);
				$_POST['p']=htmlspecialchars($_POST['p']);
				//valider l'email
				if (preg_match("/^[^@\s]+@([-a-z0-9]+\.)+[a-z]{2,}$/i",$_POST['user']))
				{
			
				$connection=new user();
				
				if ($connection->Connection($_POST['user'], $_POST['p']) ==true)
					{
					//	header('content-type: text/html; charset=utf-8' );
						$reponse='environnement/';
						$array['reponse'] = $reponse;
						echo json_encode($array);
						
					}
					
				else
					{
						//$reponse='index.html';
					   $reponse_conn_err="Échec d'authentification. Veuillez réessayer !!";
					   $array['reponse_conn_err'] = $reponse_conn_err;
						echo json_encode($array);
					}
					}
		}	
		
/* ***************************************************** Déconnection ******************************************************* */
	elseif (isset ($_POST['welcome']))
		{
			// On rend inoffensives les balises HTML que le visiteur a pu rentrer 
			$_POST['welcome'] = htmlspecialchars($_POST['welcome']);
			//valider l'email
			if (preg_match("/^[^@\s]+@([-a-z0-9]+\.)+[a-z]{2,}$/i",$_POST['welcome']))
			{
			$Deconnection=new user();
				if ($Deconnection->deconnexion($_POST['welcome'])==true)
					{
						$reponse='../';
					}
					$array['reponse'] = $reponse;
					echo json_encode($array);
			}
		}
			
// ***************************************************** sinon ********************************************************/			
	else 
		{
    $reponse = 'lemzoun/index.html';
	$array['reponse'] = $reponse;
	echo json_encode($array);
		}
//if (isset($reponse_connexion))

//$array['reponse'] = $reponse;
//echo json_encode($array);
?>
