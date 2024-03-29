<?php
$titrePage="Localoc, les meilleurs voitures aux meileurs prix";
require('templates/navbar.php');
require('utility/fonctions.php');?>
<div class="wrapperAcc">
  <h1 id="mainTitle" data-splitting>Bienvenue<span class="unders">_</span>sur<span class="unders">_</span>Localoc</h1>
  <h2 id="subTitle">Louez une voiture au meilleur prix</h2>

  <!-- LE SLIDER NE S'AFFICHE QUE SUR LA PAGE D'ACCUEIL -->
  <?php
  $db=connexion('sira');
  //Si une agence est sélectionnée on récupère les infos grâce à l'URL
  if (isset($_GET['agence'])) {$_SESSION['selectA']=$_GET['agence'];}
  if (isset($_GET['nomA']))   {$_SESSION['nomAg']=$_GET['nomA'];}
  $selectA=isset($_SESSION['selectA'])?$_SESSION['selectA']:'all';             //'all' par défaut
  $nomAg=isset($_SESSION['nomAg']) ?$_SESSION['nomAg']:'Toutes les agences';  //'Toutes les agences' par défaut
  if($selectA!='all'){      //Si une agence spécifique est sélectionnée RequeteA devient un bout de requête SQL
  	$requeteA="AND id_agence=" . $_SESSION['selectA'];
  }else{
  	$requeteA="";
  }
  
  $filtre=isset($_SESSION['filtre'])?$_SESSION['filtre']:'ASC';
   if ((!isset($_GET['page'])) OR $_GET['page']==0) : ?>

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
<a href="utility/suppr.php?filtre=0" <?php if($filtre=='DESC'){echo 'class="filtre"';}?> >Prix Croissant</a>
<a href="utility/suppr.php?filtre=1" <?php if($filtre=='ASC' ){echo 'class="filtre"';}?> >Prix Décroissant</a>
</div>
	<select name="agence" id="agence" oninput="selectionA()"> <!--Sélection d'une agence-->
						<option hidden disabled selected  value id="empty" ><?= $nomAg;?></option>
						<option value="all"  id='all'>Toutes les agences</option>
						<?php listArticle("sira","agences","titreA"); ?>
	</select>

  <?php 
// VARIABLE PHP POUR PAGE PRECEDENTE ET PAGE SUIVANTE
  $pageS=isset($_GET['page']) ? $_GET['page'] +1 : 1;
  $pageP=isset($_GET['page']) ? $_GET['page'] -1 : 0;
  $nb_pages=floor(((compteurVehicule('sira','vehicule',$requeteA)-1)/5));
  
// FIN DES VARIABLE PHP POUR PAGE PRECEDENTE ET PAGE SUIVANTE

// CONDITION POUR L'AFFICHAGE DE 5 VEHICULE SUR LA PAGE
  if ((!isset($_GET['page'])) OR $_GET['page']==0) {

    $db = connexion('sira');
    //Ici, la requête est variable requeteA va spécifier une agence et filtre l'ordre des prix
    $req=$db->prepare('SELECT * FROM vehicule WHERE statutV="dispo" '.$requeteA.' ORDER BY prix_journalier '. $filtre .' LIMIT 5 ');
    $req->execute();
    while($donnees = $req->fetch()){
     echo '<a href="pages/order.php?id=' . $donnees['id_vehicule'] . '"><div class="carSection"> 
     <img src="img/voitures/' . $donnees['photoV'] . '" class="photoSect" alt="pas d\'image"> <div class="infosSect"><h3>'. $donnees['titreV'] . '</h3><p>' . $donnees['prix_journalier'] . ' €/jour</p><p><em>'. $donnees['descriptionV']. '</em></p></div></div></a>';
   }
   if($nb_pages!=0){
    echo '<div id="pageSP"><a href="index.php?page=' . $pageS . '" id="pageS">Page suivante ►</a></div>';
  }
}


else if($_GET['page']<=$nb_pages AND $_GET['page']>0){

  $db = connexion('sira');
  $skip=5*$_GET['page'];
//Ici, la requête est variable requeteA va spécifier une agence et filtre l'ordre des prix. skip représentant le nombre de résultats à ignorer
  $query='SELECT * FROM vehicule WHERE statutV="dispo" '.$requeteA.' ORDER BY prix_journalier '. $filtre .' LIMIT 5 OFFSET '. $skip   ;
  $req=$db->prepare($query);
  $req->execute();
  while($donnees = $req->fetch()){
   echo '<a href="pages/order.php?id=' . $donnees['id_vehicule'] . '"><div class="carSection"> 
   <img src="img/voitures/' . $donnees['photoV'] . '" class="photoSect" alt="pas d\'image"> <div class="infosSect"><h3>'. $donnees['titreV'] . '</h3><p>' . $donnees['prix_journalier'] . '€/mois</p><p><em>'. $donnees['descriptionV']. '</em></p></div></div></a>';
 }
 echo '<div id="pageSP"><a href="index.php?page=' . $pageP . '" id="pageP">◄ Page précédente</a>';
 if($_GET['page']!=$nb_pages){
   echo '<a href="index.php?page=' . $pageS . '" id="pageS">Page suivante ►</a>';
 }
 echo '</div>';
}else{
  echo "<p class='erreur'>La page demandée n'existe pas! <a href='index.php'>Revenir à l'accueil</a></p>";
}
?>
<div class="push"></div>
</div>
<script type="text/javascript">Splitting()</script>
<style>
.splitting .char {
    position: static;
}
</style>
<script type="text/javascript">
	function selectionA(){
    // On récupère le nom et le numéro de l'agence et on rafraichit la page en spécifiant ces informations dans l'URL (GET)
		var agence= document.getElementById('agence').value; 
		var nomAgence=document.getElementById(agence).innerHTML;
		document.location.replace('/projet_sira/index.php?agence='+agence+ '&nomA='+nomAgence);
	}
</script>
<?php 
// FIN DE LA REQUETE D'AFFICHAGE
require($_SERVER['DOCUMENT_ROOT'] . '/projet_sira/templates/footer.php');
?>