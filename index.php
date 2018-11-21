<?php session_start(); ?>
<!DOCTYPE html>
<html>
	<head>
		<?php include 'includes/head.php'; ?>
	</head>
	
	<body>
		<div class="noir">
			<?php include_once 'param/id.php'; ?>
			<?php include 'includes/menu.php'; ?>
		</div>
		
		<div class="titre">
			<h1><marquee scrollamount="5" width="40">&lt;&lt;&lt;</marquee> Accueil <marquee scrollamount="5" direction="right" width="40">&gt;&gt;&gt;</marquee></h1> <br />
		</div>
		
		<div class="milieu">
			<?php
				header('Content-Type: text/html; charset=UTF-8');
				
				if(isset($_POST['search']) && !empty($_POST['search'])) {
					$chainesearch = addslashes($_POST['search']);
					
					try{
						$pdo_options[PDO::ATTR_ERRMODE] = PDO::ERRMODE_EXCEPTION;
						$bdd = new PDO('mysql:host='.$hote.';dbname='. $base, $utilisateur, $mdp);
						// Sp�cification de l'encodage (en cas de probl�me d'affichage :
						$bdd->exec('SET NAMES utf8');
					}catch(Exception $erreur){
						echo 'Erreur : '.$e->getMessage().'N° : '.$e->getCode();
					}
						
					echo '<form class="formulaire1" id="formulaire1" method="post" action="index.php">
							Barre de recherche : <input type="text" id="search" name="search"/>
							<input type="submit" value="valider">
						</form> <br /><br />';				  

					$requete = 'SELECT * from produit WHERE nom LIKE "%'. $chainesearch . '%" OR description LIKE "%'. $chainesearch .'%" OR detail LIKE "%'. $chainesearch . '%"';
						
				    // Ex�cution de la requ�te SQL
				    $resultat = $bdd->query($requete) or die(print_r($bdd->errorInfo()));
				    $nb = $resultat->rowCount();
				    if($nb == 0){
				    	echo 'Aucun r&eacute;sultat pour ' . $chainesearch;
				    }else{
				    	echo '<span>Vous avez recherch&eacute; : ' . $chainesearch . '</span><br /><br />
					    Les r&eacute;sultats de recherche sont : <br /><br />';
					    while($donnees = $resultat->fetch(PDO::FETCH_ASSOC)) {
							echo $donnees['nom'] .'<br />
							<img class="image_barre_recherche" alt="'. $donnees['nom'] . '" src="img/img_produits/' .  $donnees['image']  . '" height="200px"><br />';
							echo $donnees['prix'] .' €<br />';
							echo $donnees['description'] .'<br />';
							echo $donnees['detail'] .'<br /><br /><hr><br /><br />';
						}	
				    }
				    
				}else{
					echo '<form class="formulaire1" id="formulaire1" method="post" action="index.php">
							Barre de recherche : <input type="text" id="search" name="search"/> 
							<input type="submit" value="valider">
						</form>';
				}
			?>
			<br /><br /><br /><br />
			
			Ici, toutes les images de nos produits vont d&eacute;fil&eacute;es mais &ccedil;a peut mettre un peu de temps alors je vous invite &agrave; 
			y allez directement en <a class="clique_ici" href="produits.php">cliquant ici</a> <br /><br />
			<?php 
				try {
					$pdo_options[PDO::ATTR_ERRMODE] = PDO::ERRMODE_EXCEPTION;
					$bdd = new PDO('mysql:host='.$hote.';dbname='. $base, $utilisateur, $mdp);
					// Sp�cification de l'encodage (en cas de probl�me d'affichage : 
					$bdd->exec('SET NAMES utf8');
					$reponse = $bdd->query('SELECT * FROM produit ORDER BY RAND()'); // Envoi de la requ�te
					echo '<marquee behavior="scroll" direction="left" width="700">';
					while ($donnees = $reponse->fetch()) {
						echo '<img alt="'. $donnees['nom'] . '" src="img/img_produits/' .  $donnees['image']  . '" height="280px" border="1px"> ';
					}
					echo '</marquee>';
					$reponse->closeCursor();
				}catch(Exception $erreur) {
					die('Erreur : ' . $erreur->getMessage());
				}
			?>
		</div>
		
		<div id="conteneur">
			<div class="image_gauche">
				<?php 
					try {
						$pdo_options[PDO::ATTR_ERRMODE] = PDO::ERRMODE_EXCEPTION;
						$bdd = new PDO('mysql:host='.$hote.';dbname='. $base, $utilisateur, $mdp);
						// Sp�cification de l'encodage (en cas de probl�me d'affichage : 
						$bdd->exec('SET NAMES utf8');
						$reponse = $bdd->query('SELECT * FROM boutique'); // Envoi de la requ�te
			?>
						<script type="text/javascript">
								window.onload = function() {
									var image=document.getElementById("aaa");
									var img_array=[];
									var i = 0;
						
			<?php			
							while ($donnees = $reponse->fetch()) { ?>
		
								img_array[i]=<?php echo '"img/img_boutiques/'.$donnees['image'].'",'; ?>
								i++;					
				<?php 
							}
				?>
								var index = 0;
								var interval = 2000;
								function slide() {
									image.src = img_array[index++ % img_array.length];
								}
											
								setInterval(slide, interval);
								}
								
							</script>
			<?php
								$reponse->closeCursor();
						}catch(Exception $erreur) {
							die('Erreur : ' . $erreur->getMessage());
						}
			?>
				<br />
				
				<img id="aaa" src="img/img_boutiques/boutique_albertville.jpg" height="300px" name="image" />
			</div>
			
			<div class="texte_droite">
				La soci&eacute;t&eacute; GeekZone, est une entreprise sp&eacute;cialis&eacute; dans le commerce d'objet en rapport avec la t&eacute;chnologie, les mangas,  <br />
				les jeux videos... Nous avons actuellement 7 boutiques implant&eacute;es en France, Elles vendent toutes la plus part les memes  <br />
				choses, vous pouvez voir sur notre site nos gammes de produits vendus. Vous trouverez aussi l'ensemble de nos boutiques  <br />
				ainsi que leurs localisations et le moyens de nous contacter.<br /><br />
			</div>
		</div>
	</body>
</html>