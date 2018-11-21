<?php session_start(); ?>
<!DOCTYPE html>
<html>
	<head>
		<?php include '../includes/head.php'; ?>
	</head>
	
	<body>
		<div class="noir">
			<?php include_once '../param/id.php'; ?>
			<?php include '../includes/menu.php'; ?>
		</div>
		
		<div class="titre">
			<h1><marquee scrollamount="5" width="40">&lt;&lt;&lt;</marquee> Gadget <marquee scrollamount="5" direction="right" width="40">&gt;&gt;&gt;</marquee></h1>
		</div>
		
		<div class="milieu">
			<?php 
				try {
					$pdo_options[PDO::ATTR_ERRMODE] = PDO::ERRMODE_EXCEPTION;
					$bdd = new PDO('mysql:host='.$hote.';dbname='. $base, $utilisateur, $mdp);
					// Sp�cification de l'encodage (en cas de probl�me d'affichage : 
					$bdd->exec('SET NAMES utf8');
					$reponse = $bdd->query('SELECT * FROM produit, categorie WHERE categorie = 2 and categorie_id = 2'); // Envoi dee la requ�te
					echo '<table>
							<tr>
								<th class="tableau">Image</th>
								<th class="tableau">Nom</th>
								<th class="tableau">Description</th>
								<th class="tableau">D&eacute;tail</th>
								<th class="tableau">Prix</th>
							</tr>';
					while ($donnees = $reponse->fetch()) {
						echo '<tr>
								<td class="tableau"><img class="image_zoom" alt="'. $donnees['nom'] . '" src="../img/img_produits/' .  $donnees['image']  . '" height="300px"></td>
								<td class="tableau">' . $donnees['nom'] . '</td>
								<td class="tableau">' . $donnees['description'] . '</td>
								<td class="tableau">' . $donnees['detail'] . '</td>
								<td class="tableau">' . $donnees['prix'] . ' &euro;</span></td>
							</tr>';
					}
					echo '</table>'; // Fin du tableau
					$reponse->closeCursor();
				}catch(Exception $erreur) {
					die('Erreur : ' . $erreur->getMessage());
				}
			?>
			<br />
		</div>
	</body>
</html>