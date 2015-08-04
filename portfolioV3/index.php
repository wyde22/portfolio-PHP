<?php 
$auth = 0;
include('lib/includes.php');
include('lib/image.php');

$condition = '';
$category = false;
if(isset($_GET['category'])){
	$slug = $db->quote($_GET['category']);
	$select = $db->query("SELECT * FROM categories WHERE slug=$slug");
	if(!isset($_GET['category'])){
	  header("HTTP/1.1 301 Moved Permanently");
	  header('Location:' . WEBROOT);
	  die();
	}
	$category = $select->fetch();
	$condition = "WHERE works.category_id={$category['id']}";
}

$works = $db->query("
	SELECT works.name, works.id, works.slug, images.name as image_name 
	FROM works 
	LEFT JOIN images ON images.id = works.image_id
	LEFT JOIN categories ON categories.id = works.category_id
	$condition")->fetchAll();

//$categories = $db->query('SELECT slug,name FROM categories')->fetchAll();

if($category){
	$title = "Mes réalisations {$category['name']}";
}else{
	$title = "Bienvenue sur mon Portofolio";
}

/****
*calcul de nombre de projet par catégories
****/

$searchCat= $db->query("SELECT categories.id,categories.name, COUNT(works.id) as nbr_de_projets, categories.slug
						 FROM categories
						 LEFT JOIN works on categories.id=works.category_id GROUP BY categories.name")->fetchAll();

/****
*calcul du total de projets
****/

$totalProj= $db->query("SELECT categories.id,categories.name, COUNT(works.id) as nbr_de_projets, categories.slug
						 FROM categories
						 LEFT JOIN works on categories.id=works.category_id")->fetchAll();


include('partials/header.php');

/***
*sélection des compétences
***/
$tableauskillFront= $db->query("SELECT name_skill, pourcentage FROM skill")->fetchAll();

?>


  <h1><?php echo $title; ?></h1>

<div class="row">
	<div class="col-sm-8">
		<div class="row">
	  		<?php foreach ($works as $k => $work): ?>
		  		<div class="col-sm-3">
		  			<div class="thumbnail">
		  				<img src="<?php echo WEBROOT; ?>img/works/<?php echo resizedName($work['image_name'], 150,150); ?>" alt="" />
		  				<h2><?php echo $work['name']; ?></h2>
		  				<p><a href="<?php echo WEBROOT; ?>realisation/<?php echo $work['slug']; ?>" class="btn btn-info" role="button">Voir le projet</a></p>
					</div>
		  		</div>
	  		<?php endforeach; ?>
		</div>
	</div>
	<div class="col-sm-4">
		<ul>
			<?php foreach ($searchCat as $category): ?>
				<li>
					<a href="<?php echo WEBROOT; ?>categorie/<?php echo $category['slug']; ?>">
						<?php echo $category['name']; ?>
						<span class="badge"><?php echo $category['nbr_de_projets']; ?></span>
					</a>
				</li>
			<?php endforeach; ?>
				<li>
					<a href="<?php echo WEBROOT; ?>">
					Tous les projets <span class="badge"><?php echo $totalProj[0]['nbr_de_projets']; ?>
					</a>
				</li>
		</ul>
	</div>
</div>

 <h1>Mes compétences</h1>

 	<?php foreach ($tableauskillFront as $skillFront) : ?>

		<h2><?php echo $skillFront['name_skill']; ?></h2>
		<div class="progress"> 	
		  <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="70" aria-valuemin="0" aria-valuemax="100" style="width:<?php echo $skillFront['pourcentage']; ?>%">
		    <?php echo $skillFront['pourcentage']; ?>%
		  </div>
		</div>

 	<?php endforeach; ?>


 <h1>Me contactez</h1>

<div class="row">
	<div class="col-sm-8">
		
		<form action="post_contact.php" method="POST">
	 	
		 	<div class="form-group ">
			  <label class="control-label" for="inputName">Nom</label>
			  <input type="text" class="form-control" id="inputName" name="name">
			</div>

			<div class="form-group ">
			  <label class="control-label" for="inputFirstname">Prénom</label>
			  <input type="text" class="form-control" id="inputFirstname" name="firstname">
			</div>

			<div class="form-group">
			  <label class="control-label" for="inputEmail">Email</label>
			  <input type="email" class="form-control" id="inputEmail" name="email">
			</div>

			<div class="form-group">
			  <label class="control-label" for="inputMessage">Votre message</label>
			  <textarea class="form-control" rows="8" id="inputMessage" name="message"></textarea>
			</div>

			<button type="submit" class="btn btn-primary">Envoyer</button>

	 	</form>

	</div>

	<div class="col-sm-4">		
		<span class="label label-default">Default</span>
		<span class="label label-primary">Primary</span>
		<span class="label label-success">Success</span>
		<span class="label label-info">Info</span>
		<span class="label label-warning">Warning</span>
		<span class="label label-danger">Danger</span>		
	</div>

</div>


	


 	


<?php include('partials/footer.php'); ?>