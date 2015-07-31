<?php
try{
	$db = new PDO('mysql:host=localhost;dbname=portfolio', 'root', '');

	//le code ci-dessous détermine l'attribut de connexion à la base de donnée (objet, tableau associatif...)
	$db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

	//le code ci-dessous permet d'avoir des erruers à la base de donnée plus explicite
	$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);

}catch(Exception $e){
	echo 'impossible de se connecter à la base de donnée...';
	echo $e->get_message();
	die();
}
?>