<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title><?= isset($title) ? $title : 'Mon Portfolio'; ?></title>

    <!-- Bootstrap -->
    <link href="<?php echo WEBROOT; ?>/css/bootstrap.css" rel="stylesheet">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
  <body>
    <nav class="navbar navbar-default">
      <div class="container-fluid">
        <div class="navbar-header">
          <a class="navbar-brand" href="<?php echo WEBROOT; ?>">Mon portfolio</a>
        </div>

        <div>
          <ul class="nav navbar-nav">
            <li><a href="#">Scenar</a></li>
            <li><a href="#">Preprod</a></li>
          </ul>
        </div>
          <div>
            <ul class="nav navbar-nav navbar-right">
              <li><a href="<?php echo WEBROOT; ?>login.php"><span class="glyphicon glyphicon-edit"></span></a></li> 
            </ul>
          </div>
      </div>
    </nav>
    

    <?php echo flash(); ?>