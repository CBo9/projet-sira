<?php 
session_start();
?>
<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" type="text/css" href="/projet_sira/style/loc.css">
    <link rel="stylesheet" type="text/css" href="/projet_sira/style/media.css">
	<meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title><?= $titrePage ?></title>
</head>
<body>

<nav role='navigation'>
  <div id="menuToggle">
    <!-- INPUT DE CHECKBOX CACHE POUR LE MENU BURGER-->
    <input type="checkbox" />
    
    <!-- LES SPAN DECORE LE MENU BURGER -->
    <span></span>
    <span></span>
    <span></span>
    
    <ul id="menu">
    <?php  require('navigation.php');?>
    </ul>
  </div>
</nav>

</body>
</html>