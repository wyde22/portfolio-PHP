<?php
include('../lib/includes.php');
include('../partials/admin_header.php');

if(isset($_POST['name_skill']) && isset($_POST['pourcentage'])){
	checkCsrf();
	$skillName = $db->quote($_POST['name_skill']);
	$pourcentage = $db->quote($_POST['pourcentage']);
	$id= $db->quote($_GET['id']);

		/***
		*modification de la compétence
		***/

		if(isset($_GET['id'])){		
			$db->query("UPDATE skill SET name_skill = $skillName, pourcentage = $pourcentage WHERE id=$id");
			setFlash('modification sauvegardée');
			header('Location:competences.php');
			die();

		}else{

		/***
		*insertion de la compétence
		***/

			$db->query("INSERT INTO skill SET name_skill = $skillName, pourcentage = $pourcentage");
			setFlash('la compétence a bien été ajoutée dans la base de donnée');
			header('Location:competences.php');
			die();
		}

}

/***
*sélection des valeurs et inscription dans les inputs
***/

if(isset($_GET['id'])){
	$id= $db->quote($_GET['id']);
	$listSkill= $db->query("SELECT name_skill, pourcentage FROM skill WHERE id=$id")->fetch();
			
	//on rempli les inputs avec les bonnes informations
	$_POST = $listSkill;
}

?>

<h1>Ajoutez une compétence</h1>

<form action="#" method="post" enctype="multipart/form-data">
	<div class="form-group">
		<label for="nom_competence">Nom de la compétence</label>
		<?php echo input('name_skill'); ?>
	</div>

	<div class="form-group">
		<label for="pourcentage">%</label>
		<?php echo input('pourcentage'); ?>
	</div>
	
	<div class="form-group">
		<input type="hidden" name="MAX_FILE_SIZE" value="1500" />
		<input type="file" name="logo" />
	</div>
	
	<?php echo csrfInput(); ?>
	<button type="submit" class="btn btn-default">Enregistrer</button>
</form>

<?php include('../partials/footer.php');?>