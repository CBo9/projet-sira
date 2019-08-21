<?php
$titrePage="Localoc, les meilleurs voitures aux meileurs prix";
require('templates/navbar.php');
require('utility/fonctions.php');?>
<div class="wrapperAcc">
  <h1 id="mainTitle" data-splitting>Bienvenue sur Localoc</h1>
  <h2 id="subTitle">Louez une voiture au meilleur prix</h2>

  <!-- LE SLIDER NE S'AFFICHE QUE SUR LA PAGE D'ACCUEIL -->
  <?php if ((!isset($_GET['page'])) OR $_GET['page']==0) : ?>

    <!-- SLIDER DE LA PAGE D'ACCUEIL -->
    <div id="cssSlider">
      <div id="sliderImages">
        <img id="si_1" src="imgcarr/voiture1.jpg" alt="" />
        <img id="si_2" src="imgcarr/voiture2.jpg" alt="" />
        <img id="si_3" src="imgcarr/voiture3.jpg" alt="" />
        <img id="si_4" src="imgcarr/voiture4.jpg" alt="" />
        <img id="si_5" src="imgcarr/voiture1.jpg" alt="" />
        <div style="clear:left;"></div>
      </div>
    </div>
    <!-- FIN DE SLIDER -->

  <?php endif; ?>
  <!-- FIN DE LA CONDITION POUR L'AFFICHAGE DU SLIDER SUELEMENT SUR LA PAGE D'ACCUEIL -->

<h2 class="indexaf">VÉHICULES DISPONIBLES À LA LOCATION</h2>
<div class="lienFiltre">
<a href="utility/suppr.php?filtre=0" <?php if($_SESSION['filtre']=='DESC'){echo 'class="filtre"';}?> >Prix Croissant</a>
<a href="utility/suppr.php?filtre=1" <?php if($_SESSION['filtre']=='ASC' OR (!isset($_SESSION['filtre']))){echo 'class="filtre"';}?> >Prix Décroissant</a>
</div>
  <?php 
// VARIABLE PHP POUR PAGE PRECEDENTE ET PAGE SUIVANTE
  $pageS=isset($_GET['page']) ? $_GET['page'] +1 : 1;
  $pageP=isset($_GET['page']) ? $_GET['page'] -1 : 0;
  $nb_pages=floor(((compteurVehicule('sira','vehicule')-1)/5));
  $filtre=isset($_SESSION['filtre'])?$_SESSION['filtre']:'ASC';
// FIN DES VARIABLE PHP POUR PAGE PRECEDENTE ET PAGE SUIVANTE

// CONDITION POUR L'AFFICHAGE DE 5 VEHICULE SUR LA PAGE
  if ((!isset($_GET['page'])) OR $_GET['page']==0) {

    $db = connexion('sira');
    $req=$db->prepare('SELECT * FROM vehicule WHERE statutV="dispo" ORDER BY prix_journalier '. $filtre .' LIMIT 5 ');
    $req->execute();
    while($donnees = $req->fetch()){
     echo '<a href="pages/order.php?id=' . $donnees['id_vehicule'] . '"><div class="carSection"> 
     <img src="img/voitures/' . $donnees['photoV'] . '" class="photoSect" alt="pas d\'image"> <div class="infosSect"><h3>'. $donnees['titreV'] . '</h3><p>' . $donnees['prix_journalier'] . '€/mois</p><p><em>'. $donnees['descriptionV']. '</em></p></div></div></a>';
   }
   if($nb_pages!=0){
    echo '<div id="pageSP"><a href="index.php?page=' . $pageS . '" id="pageS">Page suivante</a></div>';
  }
}


else if($_GET['page']<=$nb_pages AND $_GET['page']>0){

  $db = connexion('sira');
  $skip=5*$_GET['page'];

  $query='SELECT * FROM vehicule WHERE statutV="dispo" ORDER BY prix_journalier '. $filtre .' LIMIT 5 OFFSET '. $skip   ;
  $req=$db->prepare($query);
  $req->execute();
  while($donnees = $req->fetch()){
   echo '<a href="pages/order.php?id=' . $donnees['id_vehicule'] . '"><div class="carSection"> 
   <img src="img/voitures/' . $donnees['photoV'] . '" class="photoSect" alt="pas d\'image"> <div class="infosSect"><h3>'. $donnees['titreV'] . '</h3><p>' . $donnees['prix_journalier'] . '€/mois</p><p><em>'. $donnees['descriptionV']. '</em></p></div></div></a>';
 }
 echo '<div id="pageSP"><a href="index.php?page=' . $pageP . '" id="pageP">Page précédente</a>';
 if($_GET['page']!=$nb_pages){
   echo '<a href="index.php?page=' . $pageS . '" id="pageS">Page suivante</a>';
 }
 echo '</div>';
}else{
  echo "<p class='erreur'>La page demandée n'existe pas! <a href='index.php'>Revenir à l'accueil</a></p>";
}
?>
<div class="push"></div>
</div>
<script type="text/javascript">Splitting()</script>
<?php 
// FIN DE LA REQUETE D'AFFICHAGE
require($_SERVER['DOCUMENT_ROOT'] . '/projet_sira/templates/footer.php');
?>