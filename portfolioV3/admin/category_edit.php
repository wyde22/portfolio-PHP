<?php
include('../lib/includes.php');

if(isset($_POST['name']) && isset($_POST['slug'])){
	checkCsrf();
	$slug = $_POST['slug'];
	//on teste le slug si il est valable grâce à la fonction régulière ci dessous (on veut seulement des caractères minuscules, des tirets, des chiffres répétés plusieurs fois)
	if(preg_match('/^[a-z\0-9]+$/', $slug)){
		$name = $db->quote($_POST['name']);
		$slug = $db->quote($_POST['slug']);
		if(isset($_GET['id'])){
			$id = $db->quote($_GET['id']);
			$db->query("UPDATE categories SET name = $name,slug = $slug WHERE id=$id");
		}else{
			$db->query("INSERT INTO categories SET name = $name,slug = $slug");
		}
		
		setFlash('la catégorie a bien été ajoutée');
		header('Location:category.php');
		die();
		
	}else{
		setFlash('le slug n\'est pas valide','danger');
	}
}

if(isset($_GET['id'])){
	$id = $db->quote($_GET['id']);
	$select = $db->query("SELECT * FROM categories where id=$id");
	if($select->rowCount() == 0){
		setFlash('il n\'y a pas de catégorie avec cet ID', 'danger');
		header('Location:category.php');
		die();
	}
	$_POST = $select->fetch();
}

include('../partials/admin_header.php');
?>

<h1>Editez une catégorie</h1>

<form action="#" method="post">
	<div class="form-group">
		<label for="name">Nom de la catégorie</label>
		<?php echo input('name'); ?>
	</div>

	<div class="form-group">
		<label for="slug">URL de la catégorie</label>
		<?php echo input('slug'); ?>
	</div>

	<?php echo csrfInput(); ?>
	<button type="submit" class="btn btn-default">Enregistrer</button>
</form>

<?php include('../partials/footer.php');?>