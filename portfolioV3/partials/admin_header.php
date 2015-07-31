<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>Mon administration</title>

    <!-- Bootstrap -->
    <link href="<?php echo WEBROOT; ?>css/bootstrap.css" rel="stylesheet">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
  <body>
    

    <nav class="navbar navbar-inverse">
      <div class="container-fluid">
        <div class="navbar-header">
          <a class="navbar-brand" href="<?php echo WEBROOT; ?>admin/index.php">FBO Portfolio</a>
        </div>

          <div>
            <ul class="nav navbar-nav">
              <li><a href="category.php">Catégories</a></li>
              <li><a href="work.php">Réalisations</a></li>
              <li><a href="administrator.php">Gestion des comptes</a></li>
              <li><a href="competences.php">Compétences</a></li>
              <li><a href="contact.php">Contact</a></li>
            </ul>
          </div>
          <div>
            <ul class="nav navbar-nav navbar-right">
              <p class="navbar-text">Salutations <?php echo $_SESSION['auth']['username']; ?></p>
              <li><a href="<?php echo WEBROOT; ?>logout.php"><span class="glyphicon glyphicon-off"></span></a></li> 
            </ul>
          </div>
      </div>
    </nav>

    <?php echo flash(); ?>