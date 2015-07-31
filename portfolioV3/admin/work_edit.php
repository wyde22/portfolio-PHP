<?php
include('../lib/includes.php');

/***
*la sauvegarde
***/

if(isset($_POST['name']) && isset($_POST['slug'])){
	checkCsrf();
	$slug = $_POST['slug'];
	//on teste le slug si il est valable grâce à la fonction régulière ci dessous (on veut seulement des caractères minuscules, des tirets, des chiffres répétés plusieurs fois)
	if(preg_match('/^[a-z\0-9]+$/', $slug)){
		$name = $db->quote($_POST['name']);
		$slug = $db->quote($_POST['slug']);
		$category_id = $db->quote($_POST['category_id']);
		$content = $db->quote($_POST['content']);

		/***
		*on récupère une réalisation
		***/

		if(isset($_GET['id'])){
			$id = $db->quote($_GET['id']);
			$db->query("UPDATE works SET name = $name,slug = $slug, content = $content, category_id = $category_id WHERE id=$id");
		}else{
			$db->query("INSERT INTO works SET name = $name,slug = $slug, content = $content, category_id = $category_id");
			$_GET['id'] = $db -> lastInsertId();
		}
		
		setFlash('la réalisation a bien été ajoutée');

		/***
		*envoi des images
		***/

		$work_id = $db->quote($_GET['id']);
		$files = $_FILES['images'];
		$images = array();
		require '../lib/image.php';
		foreach ($files['tmp_name'] as $k => $v) {
			$image = array(
				'name' => $files['name'][$k],
				'tmp_name' =>$files['tmp_name'][$k]

			);
			
			$extension = pathinfo($image['name'], PATHINFO_EXTENSION);
			if(in_array($extension, array('jpg','png'))){
				$db->query("INSERT INTO images SET work_id=$work_id");
				$image_id = $db -> lastInsertId();
				$image_name = $image_id . '.' . $extension;
				move_uploaded_file($image['tmp_name'], IMAGES . '/works/' . $image_name);

				resizeImage(IMAGES . '/works/' . $image_name, 150,150);

				$image_name = $db->quote($image_name);
				$db->query("UPDATE images SET name = $image_name WHERE id = $image_id");
			}
		}
		
		
		header('Location:work.php');
		die();
		
	}else{
		setFlash('le slug n\'est pas valide','danger');
	}
}

if(isset($_GET['id'])){
	$id = $db->quote($_GET['id']);
	$select = $db->query("SELECT * FROM works where id=$id");
	if($select->rowCount() == 0){
		setFlash('il n\'y a pas de réalisation avec cet ID', 'danger');
		header('Location:work.php');
		die();
	}
	$_POST = $select->fetch();
}

/***
*suppression d'une image
***/

if(isset($_GET['delete_image'])){
	checkCsrf();
	$id = $db->quote($_GET['delete_image']);
	$select = $db->query("SELECT name, work_id FROM images WHERE id=$id");
	$image = $select->fetch();
	
	$images = glob(IMAGES .'/works/' . pathinfo($image['name'], PATHINFO_FILENAME) . '_*x*.*');
	
	if(is_array($images)){
		foreach($images as $v){
			unlink($v);
		}
	}

	unlink(IMAGES . '/works/' . $image['name']);
	$db->query("DELETE FROM images WHERE id=$id");
	setFlash("l'image a bien été supprimée");
	header('Location:work_edit.php?id=' . $image['work_id']);
	die();
}

/***
*mise en avant d'une image
***/

if(isset($_GET['highlight_image'])){
	checkCsrf();
	$work_id = $db->quote($_GET['id']);
	$image_id = $db->quote($_GET['highlight_image']);
	$db->query("UPDATE works SET image_id=$image_id WHERE id=$work_id");
	setFlash("l'image a bien été mise en avant");
	header('Location:work_edit.php?id=' . $_GET['id']);
	die();
}

/***
*on récupère les catégories
***/

$select = $db->query('SELECT id, name FROM categories ORDER BY name ASC');
$categories = $select->fetchAll();
$categories_list = array();
foreach($categories as $category){
	$categories_list[$category['id']] = $category['name'];
}

/***
*on récupère la liste des images
***/
if(isset($_GET['id'])){
	$work_id = $db->quote($_GET['id']);
	$select = $db->query("SELECT id, name FROM images WHERE work_id=$work_id");
	$images = $select->fetchAll();
}else{
	$images = array();
}


include('../partials/admin_header.php');
?>

<h1>Editez une réalisation</h1>

<div class="row">
	<form action="#" method="post" enctype="multipart/form-data">
	<div class="col-sm-8">
			<div class="form-group">
				<label for="name">Nom de la réalisation</label>
				<?php echo input('name'); ?>
			</div>

			<div class="form-group">
				<label for="slug">URL de la réalisation</label>
				<?php echo input('slug'); ?>
			</div>

			<div class="form-group">
				<label for="content">Contenu de la réalisation</label>
				<?php echo textarea('content'); ?>
			</div>

			<div class="form-group">
				<label for="category_id">Nom de la catégorie</label>
				<?php echo select('category_id', $categories_list); ?>
			</div>

			<?php echo csrfInput(); ?>

			<button type="submit" class="btn btn-default">Enregistrer</button>	
	</div>

	<div class="col-sm-4">
		<?php foreach ($images as $k => $image) :?>
			<p>
				<img src="<?php echo WEBROOT; ?>img/works/<?php echo $image['name']; ?>" width="100" />
				<a href="?delete_image=<?php echo $image['id']; ?>&<?php echo csrf(); ?>" onclick="return confirm('sur de sur?');">Supprimez</a>
				<a href="?highlight_image=<?php echo $image['id']?>&id=<?php echo $_GET['id']; ?>&<?php echo csrf(); ?>">Mettre à la une</a>
			</p>
		<?php endforeach; ?>

		<div class="form-group">
			<input type="file" name="images[]" />
			<input type="file" name="images[]" class="hidden" id="duplicate"/>
		</div>

		<p>
			<a href="#" class="btn btn-success" id="duplicatebtn">Ajoutez une image</a>
		</p>

	</div>

	</form>
</div>





<?php ob_start(); ?>
<script src="<?php echo WEBROOT; ?>js/tinymce/tinymce.min.js"></script>
<script>
//duplication du champ téléchargement d'image
(function($){

    $('#duplicatebtn').click(function(e){
          e.preventDefault();

          var $clone = $('#duplicate').clone().attr('id','').removeClass('hidden');
          $('#duplicate').before($clone);
          //console.log($clone);

    })

})(jQuery);

tinyMCE.init({
        // General options
        mode : "textareas",
        
});
</script>
<?php $script = ob_get_clean();?>

<?php include('../partials/footer.php');?>