<?php
// Connexion à la base de données 
// create function
class db_connect
{
	private $host_name= "127.4.62.2";
	private $dbname_name='smartframe';
	private $user_name='admin1MwVTtq';
	private $password_pass='sf19c3wA7hGf';
	
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