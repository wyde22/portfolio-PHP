<?php
include('../lib/includes.php');
include('../partials/admin_header.php');

/***
*on liste les compétences
***/

$visuSkills = $db->query("SELECT * FROM skill")->fetchAll();

/***
*supression de la compétence
***/

if(isset($_GET['delete'])){
	$id= $db->quote($_GET['delete']);
	$db->query("DELETE FROM skill WHERE id=$id");
	setFlash('compétence supprimée');
	header('Location:competences.php');
	die();

}

?>

<h1>Gestion des compétences</h1>

<p><a href="competence_edit.php" class="btn btn-success">Ajouter une compétence</a></p>

<table class="table table-striped">
	<thead>
		<th>Id</th>
		<th>Nom de la compétence</th>
		<th>%</th>
		<th>Logo</th>
		<th>Gestion</th>
	</thead>
	<tbody>
		<?php foreach ($visuSkills as $skills) : ?>
		<tr>
			<td><?php echo $skills['id']?></td>
			<td><?php echo $skills['name_skill']?></td>
			<td><?php echo $skills['pourcentage']?></td>
			<td><img src="" alt="logo"/></td>
			<td>
				<a href="competence_edit.php?id=<?php echo $skills['id']?>" class="btn btn-default">Editez</a>
				<a href="?delete=<?php echo $skills['id']?> & <?php echo csrf(); ?>" class="btn btn-danger" onclick="return confirm('sur de sur?');">Supprimez</a>
			</td>
		</tr>
		<?php endforeach; ?>
	</tbody>
</table>

<?php include('../partials/footer.php');?>