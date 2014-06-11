<?php
session_start();
header( 'content-type: text/html; charset=utf-8' );
//include 'db_connection.php';
header('Access-Control-Allow-Origin: *');
include 'function.php';
include("../User.class.php");
if(isset($_POST['welcome']))
{
	//$_SESSION['id_utilisateur']=$_POST['welcome'];
	$_POST['welcome'] = htmlspecialchars($_POST['welcome']);
	$repons=login($_POST['welcome']);
	//if(empty($repons))
	if (isset($repons))
	{
		$salut=$repons;
		$array['login'] = $salut;
		echo json_encode($array);
		//exit;	
		
	}
	else if (empty($repons))
	{
		if (preg_match("/^[^@\s]+@([-a-z0-9]+\.)+[a-z]{2,}$/i",$_POST['welcome']))
			{
			$Deconnection=new user();
				if ($Deconnection->deconnexion($_POST['welcome'])==true)
					{
						$reponse='../index.html';
					}
					$array['non_login'] = $reponse;
					echo json_encode($array);
			}
	}
}
elseif (isset($_POST['liste']))
{	
	$_POST['liste'] = htmlspecialchars($_POST['liste']);
	$reponse=fileUser();
	/*if ($repons)
	{
		$reponse=$repons;
	}
	else
	{
		$data[]='';
		$reponse=$data;
	}*/
	$array['login'] = $reponse;
	echo json_encode($array);
}
else
{
	$reponse='user';
	$array['login'] = $reponse;
	echo json_encode($array);
}



			
//$array['login'] = $reponse;
//echo json_encode($array);
