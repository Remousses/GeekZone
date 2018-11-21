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
			<h1><marquee scrollamount="5" width="40">&lt;&lt;&lt;</marquee> Boutiques <marquee scrollamount="5" direction="right" width="40">&gt;&gt;&gt;</marquee></h1> <br />
		</div>
		
		<div class="milieu">
			<?php 
				try {
					$pdo_options[PDO::ATTR_ERRMODE] = PDO::ERRMODE_EXCEPTION;
					$bdd = new PDO('mysql:host='.$hote.';dbname='. $base, $utilisateur, $mdp);
					// Sp�cification de l'encodage (en cas de probl�me d'affichage : 
					$bdd->exec('SET NAMES utf8');
					$reponse = $bdd->query('SELECT * FROM boutique'); // Envoi dee la requ�te
					echo '<table class="coller">
							<th class="boutique">Boutique</th>
							<th class="boutique">Adresse</th>
							<th class="boutique">Contact</th>
							<th class="boutique">Horaires</th>';
					while ($donnees = $reponse->fetch()) {
						echo '<tr>
								<td class="boutique">' . $donnees['ville'] . '<br />
								<img alt="Boutique '. $donnees['ville'] . '" src="img/img_boutiques/' .  $donnees['image']  . '" height="200px"></td>
								<td class="boutique">' . $donnees['rue'] . ' ' . $donnees['cp'] . '</td>
								<td class="boutique">' . $donnees['telephone'] . '</td>
								<td class="boutique">' . $donnees['horaires'] . '</td>
							</tr>';
					}
					echo '</table>'; // Fin du tableau
					$reponse->closeCursor();
				}catch(Exception $erreur) {
					die('Erreur : ' . $erreur->getMessage());
				}
			?>
		</div>
	</body>
</html>