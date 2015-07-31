<?php
	session_start();//la fonction session_start permet d'utiliser la variable SESSION
	if(!isset($auth)){
		if(!isset($_SESSION['auth']['id'])){
			header('location:' . WEBROOT . 'login.php');
			die();
		}
	}


//pour sécuriser l'envoi d'information on crée un jeton
if(!isset($_SESSION['csrf'])){

	//md5 un mode de cryptage en php, et rand génère une valeur aléatoire
	$_SESSION['csrf'] = md5(time() + rand());
}

function csrf(){
	return'csrf=' . $_SESSION['csrf'];
}

function csrfInput(){
	return '<input type="hidden" value="'.$_SESSION['csrf'].'" name="csrf">';
}

function checkCsrf(){ 
	if(
		(isset($_POST['csrf']) && $_POST['csrf'] == $_SESSION['csrf']) ||
		(isset($_GET['csrf']) && $_GET['csrf'] == $_SESSION['csrf']))
	{
		return true;
	}
	
		header('Location:' .WEBROOT. 'csrf.php');
		die();
	
}

?>