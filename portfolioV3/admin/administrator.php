<?php
include('../lib/includes.php');
include('../partials/admin_header.php');

/**
*suppression du compte
**/

$sessionEncours = $_SESSION['auth']['id'];

if(isset($_GET['delete'])){
	checkCsrf();
	$id = $db->quote($_GET['delete']);
	$db->query("DELETE FROM users WHERE id=$id");
	setFlash('l\'administrateur a bien été supprimé');
	header('Location:administrator.php');
	die();
}

/**
*on liste les différents administrateurs du site
**/

$visuAdmin = $db->query("SELECT * FROM users")->fetchAll();

?>

<h1>Gestion des comptes</h1>

<p><a href="administrator_edit.php" class="btn btn-success">Ajouter un administrateur</a></p>

<table class="table table-striped">
	<thead>
		<th>Id</th>
		<th>Nom</th>
		<th>Gestion</th>
		<th>Bio</th>
		<th>Avatar</th>
	</thead>
	<tbody>
		<?php foreach ($visuAdmin as $tableauAdmin) :?>
			<tr>
				<td><?php echo $tableauAdmin['id']; ?></td>
				<td><?php echo $tableauAdmin['username']; ?></td>
				<td>
					<a href="administrator_edit.php?id=<?php echo $tableauAdmin['id']; ?>" class="btn btn-default">Editez</a>
					<a href="?delete=<?php echo $tableauAdmin['id']; ?> & <?php echo csrf(); ?>" class="btn btn-danger <?php if($tableauAdmin['id'] === $sessionEncours){
																														 echo 'hidden';
																														 }?>"
																														 onclick="return confirm('sur de sur?');">Supprimez</a> 
					<?php if($tableauAdmin['id'] === $sessionEncours){
						echo '<span class="label label-warning">Connexion en tant que '. $tableauAdmin['username'] .', donc pas de suppression possible</span>';
					}?>												 													 
				</td>
				<td><?php echo $tableauAdmin['bio']?></td>
				<td><img src="" alt="avatar"></td>
			</tr>

		<?php endforeach; ?>
	</tbody>
</table>

<?php include('../partials/footer.php');?>