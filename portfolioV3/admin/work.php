<?php
include('../lib/includes.php');
include('../partials/admin_header.php');

/**
*suppression
**/

if(isset($_GET['delete'])){
	checkCsrf();

	$id = $db->quote($_GET['delete']);
	$db->query("DELETE FROM works WHERE id = $id");
	setFlash('la réalisation a bien été supprimée');
	header('Location:work.php');
	die();
}

/**
*on liste les catégories
**/

$select = $db->query('SELECT id, name, slug FROM works');
$works = $select->fetchAll();

?>

<h1>Réalisations</h1>

<p><a href="work_edit.php" class="btn btn-success">Ajouter une nouvelle réalisation</a></p>

<table class="table table-striped">
	<thead>
		<th>Id</th>
		<th>Nom</th>
		<th>Action</th>
	</thead>
	<tbody>
		<?php foreach ($works as $category) :?>
			<tr>
				<td><?php echo $category['id']; ?></td>
				<td><?php echo $category['name']; ?></td>
				<td>
					<a href="work_edit.php?id=<?php echo $category['id']; ?>" class="btn btn-default">Editez</a>
					<a href="?delete=<?php echo $category['id']; ?> & <?php echo csrf(); ?>" class="btn btn-danger" onclick="return confirm('sur de sur?');">Supprimez</a>
				</td>
			</tr>

		<?php endforeach; ?>
	</tbody>
</table>

<?php include('../partials/footer.php');?>