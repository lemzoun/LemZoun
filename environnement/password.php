<?php 
session_start();
header( 'content-type: text/html; charset=utf-8' );
include 'function.php';


 if ($_POST['ancien_password'] )
{
		$_SERVER['PHP_AUTH_USER']=$_SESSION['id_utilisateur'];
		$Email=$_SERVER['PHP_AUTH_USER'];
	$_POST['ancien_password']=htmlspecialchars($_POST['ancien_password']);
	$_POST['nouveau_password']=htmlspecialchars($_POST['nouveau_password']);
	$_POST['confirmer_password']=htmlspecialchars($_POST['confirmer_password']);
	$data=confidentialiter($_POST['ancien_password'], $_POST['nouveau_password'], $_POST['confirmer_password'],$Email );
	
		$array['reponse'] = $data;
		echo json_encode($array);
	
	
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
