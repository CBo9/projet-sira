<?php
require('../templates/navbar.php');

if(isset($_GET['error_supp'])){
	echo '<span style="font-size:2em;" class="erreur">Cette requête n\'existe pas et/ou vous n\'y avez pas accès!</span>';
}else{
echo'
<span style="font-size:2em;" class="erreur">Ce véhicule n\'existe pas et/ou n\'est plus dans notre catalogue!</span>
<p><a href="../index.php" class="erreur"> Retouner à l\'accueil</a></p>';}
?>