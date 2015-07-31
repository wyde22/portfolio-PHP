<?php
include('../lib/includes.php');

if(isset($_SESSION['auth']['id'])){
	$nomConnexion = $_SESSION['auth']['username'];
}

include('../partials/admin_header.php');
?>

<h1>Mon administration</h1>

<div class="jumbotron">
  <div class="container">
    <h1>Hello</h1>
    <p>
    	Bonjour <span class="label label-default"><?php echo $nomConnexion; ?></span>, oh grand administrateur!!
    </p>

  </div>
</div>

<?php include('../lib/debug.php');?>
<?php include('../partials/footer.php');?>