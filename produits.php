<?php session_start(); ?>
<!DOCTYPE html>
<html>
	<head>
		<?php include 'includes/head.php'; ?>
	</head>
	
	<body>
		<div>
			<?php include_once 'param/id.php'; ?>
			<?php include 'includes/menu.php'; ?>
		</div>
		
		<div class="titre">
			<h1><marquee scrollamount="5" width="40">&lt;&lt;&lt;</marquee> Produits <marquee scrollamount="5" direction="right" width="40">&gt;&gt;&gt;</marquee></h1> <br />
		</div>
		
		<div class="milieu">
			<span class="representation_produit">Repr&eacute;sentation rapide de tous nos produits.</span> <br /><br /><br />
			<?php 
				try {
					$pdo_options[PDO::ATTR_ERRMODE] = PDO::ERRMODE_EXCEPTION;
					$bdd = new PDO('mysql:host='.$hote.';dbname='. $base, $utilisateur, $mdp);
					// Sp�cification de l'encodage (en cas de probl�me d'affichage : 
					$bdd->exec('SET NAMES utf8');
					$reponse = $bdd->query('SELECT * FROM produit'); // Envoi de la requ�te
					echo '<table class="coller">
							<tr>
							<table class="tab1">';

					getProduit($reponse, "cuisine.php", 1);
					
					echo '</table>
					<table class="tab2">'; //D�claration d'un tableau et de sa ligne en en-t�te
					$reponse = $bdd->query('SELECT * FROM produit'); // Envoi de la requ�te
					
					getProduit($reponse, "gadget.php", 2);
					
					echo '</table>
					<table class="tab3">'; //D�claration d'un tableau et de sa ligne en en-t�te
					$reponse = $bdd->query('SELECT * FROM produit'); // Envoi de la requ�te
					
					getProduit($reponse, "mode.php", 3);
					
					echo '</table>
					<table class="tab4">'; //D�claration d'un tableau et de sa ligne en en-t�te
					$reponse = $bdd->query('SELECT * FROM produit'); // Envoi de la requ�te
					
					getProduit($reponse, "portable.php", 4);
					
					echo '</table>
					<table class="tab5">'; //D�claration d'un tableau et de sa ligne en en-t�te
					$reponse = $bdd->query('SELECT * FROM produit'); // Envoi de la requ�te
					
					getProduit($reponse, "USB.php", 5);
					
					echo '</table>'; // Fin du tablea
					$reponse->closeCursor();
				}catch(Exception $erreur) {
					die('Erreur : ' . $erreur->getMessage());
				}

				function getProduit($reponse, $path, $categorie){
					echo '<tr>
							<th class="produit"><a href="produit/' . $path .'" class="lien_p">Articles pour la cuisine</a></th>
						</tr/>';

					while ($donnees = $reponse->fetch()) {
						if ($donnees['categorie'] == $categorie){
							echo '<td><img class="image_produit" alt="'. $donnees['nom'] . '" src="img/img_produits/' .  $donnees['image']  . '" height="250px"></td>
							</tr/>';
						}
					}
				}
			?>
		</div>
	</body>
</html>