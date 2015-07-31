<?php
include('../lib/includes.php');
include('../partials/admin_header.php');

if(isset($_POST['username']) && isset($_POST['bio'])){
	checkCsrf();
	$nameAdmin = $db->quote($_POST['username']);
	$bio = $db->quote($_POST['bio']);
	$pass = $db->quote($_POST['password']);
	$id= $db->quote($_GET['id']);

		/***
		*modification de l'admin
		***/

		if(isset($_GET['id'])){		
			$db->query("UPDATE users SET username = $nameAdmin, bio = $bio WHERE id=$id");
			setFlash('modification sauvegardée');
			header('Location:administrator.php');
			die();

		}else{

		/***
		*insertion de l'admin
		***/

			$db->query("INSERT INTO users SET username = $nameAdmin, bio = $bio, password = SHA1($pass)");
			setFlash('l\'administrateur a bien été ajouté dans la base de donnée');
			header('Location:administrator.php');
			die();
		}

}

/***
*sélection des valeurs et inscription dans les inputs
***/

if(isset($_GET['id'])){
	$id= $db->quote($_GET['id']);
	$listAdmin= $db->query("SELECT username, bio FROM users WHERE id=$id")->fetch();
			
	//on rempli les inputs avec les bonnes informations
	$_POST = $listAdmin;
}

?>

<h1>Ajoutez un administrateur</h1>

<form action="#" method="post" enctype="multipart/form-data">
	<div class="form-group">
		<label for="name">Nom de l'administrateur</label>
		<?php echo input('username'); ?>
	</div>

	<div class="form-group">
		<label for="bio">Bio</label>
		<?php echo input('bio'); ?>
	</div>
	
	<?php if(!isset($_GET['id'])): ?>
	<div class="form-group">
		<label for="password">Password</label>
		<?php echo inputPass('password'); ?>
	</div>
	<?php endif; ?>
	
	<div class="form-group">
		<input type="hidden" name="MAX_FILE_SIZE" value="1500" />
		<input type="file" name="avatar" />
	</div>
	

	<?php echo csrfInput(); ?>
	<button type="submit" class="btn btn-default">Enregistrer</button>
</form>

<?php include('../partials/footer.php');?>