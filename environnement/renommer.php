<?php 
session_start();
header( 'content-type: text/html; charset=utf-8' );
include 'function.php';


if (isset($_POST['extension']))
{
		
		
	$_POST['extension']=htmlspecialchars($_POST['extension']);
	
	$info = new SplFileInfo($_POST['extension']);
	$extension=$info->getExtension();
	
	$data=$extension;
	$array['reponse'] = $data;
	echo json_encode($array);
	
	
}
else if ($_POST['renomme'])
{
		$_SERVER['PHP_AUTH_USER']=$_SESSION['id_utilisateur'];
		$Email=$_SERVER['PHP_AUTH_USER'];
	$_POST['renomme']=htmlspecialchars($_POST['renomme']);
	renommerfile($_POST['ancien'],$_POST['renomme'],$Email);
	$data=$_POST['renomme'];
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
