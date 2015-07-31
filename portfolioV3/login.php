<?php $auth = 0;// mettre cette variable $auth = 0 sinon redirection en boucle. on accède à cette page sans connexion
include('lib/includes.php');

/***
TRAITEMENT DU FORMULAIRE
***/

if(isset($_POST['username']) && isset($_POST['password'])){
	$username = $db->quote($_POST['username']);
	$password = sha1($_POST['password']);
	$select = $db->query("SELECT * FROM users WHERE username=$username AND password='$password'");

	if($select->rowcount() > 0){
		$_SESSION['auth'] = $select->fetch();
		setflash('Vous êtes maintenant connecté');
		header('Location:' . WEBROOT . 'admin/index.php');
		die();
	}
}


/***
inclusion du header
***/

include('partials/header.php');?>

<form action="#" method="post">
	<div class="form-group">
		<label for="username">Nom d'utilisateur</label>
		<?php echo input('username'); ?>
	</div>

	<div class="form-group">
		<label for="username">Password</label>
		<input type="password" class="form-control" id="password" name="password">	
	</div>
	<button type="submit" class="btn btn-default">Se connecter</button>
</form>

<?php include('partials/footer.php'); ?>