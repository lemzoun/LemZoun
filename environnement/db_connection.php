<?php
// Connexion à la base de données 
// create function
class db_connect
{
	private $host_name= "localhost";
	private $dbname_name='cloud';
	private $user_name='root';
	private $password_pass='';
	
function db_connect() {
	try
				{
					 $bdd = new PDO('mysql:host='.$host_name.';dbname='.$host_name, $user_name, $password_pass);
				}
			catch (Exception $e)
				{
					  die('Erreur : ' . $e->getMessage());
				}
				}
}
//$dbh = pdo_connect();