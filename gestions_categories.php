<?php
	session_start();
	if(isset($_SESSION['login']) && $_SESSION['gestion'] == 'produits'){
?>
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
						<h1><marquee scrollamount="5" width="40">&lt;&lt;&lt;</marquee> Gestions des categorie <marquee scrollamount="5" direction="right" width="40">&gt;&gt;&gt;</marquee></h1> <br />
					</div>
					
					<div class="milieu">
						<?php 
							try {
								if (isset($_POST['order']) && isset($_POST['valider'])) {
						?>		
									<form id="formulaireTriCategories" method="post" action="gestions_categories.php">
										<fieldset style="width: 700px">
										Tri des cat&eacute;gories : <input type="radio" id="order" name="order" value="categorie_id" checked="checked"/>selon l'id
														    		<input type="radio" id="order" name="order" value="libelle"/>selon le libellé
														    		<input class="droite" type="submit" name="valider" id="valider" value="valider" />
										</fieldset>
									</form>
									<br /><br />
								<?php
									try{
										$pdo_options[PDO::ATTR_ERRMODE] = PDO::ERRMODE_EXCEPTION;
										$bdd = new PDO('mysql:host='.$hote.';dbname='. $base, $utilisateur, $mdp);
										// Sp�cification de l'encodage (en cas de probl�me d'affichage : 
										$bdd->exec('SET NAMES utf8');
										$reponse = $bdd->query('SELECT * FROM categorie ORDER BY ' . $_POST['order'] . ''); // Envoi de la requete
										$nb = $reponse->rowCount(); // Compte du nombre de lignes retourn�es
										echo '<table class="coller">
												<tr>
												<th class="gest_bout">Id</th>
												<th class="gest_bout">Libell&eacute;</th>
											<tr>';
										
										while ($donnees = $reponse->fetch()) {
											
											echo '<tr>
													<td class="gest_bout">' . $donnees['categorie_id'] . '</td>
													<td class="gest_bout">' . $donnees['libelle'] . '</td>
													<td class="gest_bout_supp_mod"><a href="gestions_categories.php?suppCategorie=' . $donnees['libelle'] . '"><img alt="Bouton supprimer" src="img/img_logo/Logo_Supprimer.png" height="20px"></a></td>
													<td class="gest_bout_supp_mod"><a href="gestions_categories.php?modifCategorie=' . $donnees['libelle'] . '"><img alt="Bouton modifier" src="img/img_logo/Logo_Modifier.png" height="20px"></a></td>
												</tr>';
										}
										echo '</table>
										<p class="milieu">Il y a ' . $nb . ' cat&eacute;gories.</p>'; //Affichage du compte des lignes
										// On libere la connexion du serveur pour d'autres requetes
										$reponse->closeCursor();
										$id_max = $bdd->query('SELECT MAX(categorie_id) AS id_Max FROM categorie'); // Envoi de la requ�te
										$id_max->execute();
										$id = $id_max->fetch();
										$max = $id['id_Max'] + 1;
										$id_max->closeCursor();
								?>					
										<form id="formulaireAjoutCategorie" method="post" action="gestions_categories.php">
											<fieldset style="width: 350px">
												<legend>Ajout d'une cat&eacute;gorie</legend>
												Nom : <input type="text" id="libelle" name="libelle"/> <br />
												Cat&eacute;gorie : <input type="number" id="categorie_id" name="categorie_id" min="<?php echo $max; ?>" max="<?php echo $max; ?>" value="<?php echo $max; ?>"/> <br /><br />
												<input class="droite" type="reset" name="effacer" id="effacer" value="Effacer">
												<input class="droite" type="submit" name="ajouter" id="ajouter" value="Ajouter">
											</fieldset>
										</form>
										<br /><br />
							<?php
									}catch (Exception $e){
										die ('Erreur : ' . $e->getMessage());
									}
								}else{
							?>
									<form id="formulaireTriCategories" method="post" action="gestions_categories.php">
										<fieldset style="width: 700px">
										Tri des cat&eacute;gories : <input type="radio" id="order" name="order" value="categorie_id" checked="checked"/>selon l'id
														    		<input type="radio" id="order" name="order" value="libelle"/>selon le libellé
														    		<input class="droite" type="submit" name="valider" id="valider" value="valider" />
										</fieldset>
									</form>
									<br /><br />
								<?php 
									try{
										$pdo_options[PDO::ATTR_ERRMODE] = PDO::ERRMODE_EXCEPTION;
										$bdd = new PDO('mysql:host='.$hote.';dbname='. $base, $utilisateur, $mdp);
										// Sp�cification de l'encodage (en cas de probl�me d'affichage :
										$bdd->exec('SET NAMES utf8');
										$id_max = $bdd->query('SELECT MAX(categorie_id) AS id_Max FROM categorie'); // Envoi de la requ�te
										$id_max->execute();
										$id = $id_max->fetch();
										$max = $id['id_Max'] + 1;
										$id_max->closeCursor();
								?>
										<form id="formulaireAjoutCategorie" method="post" action="gestions_categories.php">
											<fieldset style="width: 350px">
												<legend>Ajout d'une cat&eacute;gorie</legend>
												Nom : <input type="text" id="libelle" name="libelle"/> <br />
												Cat&eacute;gorie : <input type="number" id="categorie_id" name="categorie_id" min="<?php echo $max; ?>" max="<?php echo $max; ?>" value="<?php echo $max; ?>"/> <br /><br />
												<input class="droite" type="reset" name="effacer" id="effacer" value="Effacer">
												<input class="droite" type="submit" name="ajouter" id="ajouter" value="Ajouter">
											</fieldset>
										</form>
										<br /><br />
							<?php
									}catch (Exception $e){
										die ('Erreur : ' . $e->getMessage());
									}
								}
								
								if (!empty($_GET['modifCategorie'])) {
									// Ici on mofifie un produit
									$modifCategorie = $_GET['modifCategorie'];
	
									try{
										$pdo_options[PDO::ATTR_ERRMODE] = PDO::ERRMODE_EXCEPTION;
										$bdd = new PDO('mysql:host='.$hote.';dbname='. $base, $utilisateur, $mdp);
										// Sp�cification de l'encodage (en cas de probl�me d'affichage :
										$bdd->exec('SET NAMES utf8');
										$modif = $bdd->prepare('SELECT categorie_id, libelle FROM categorie WHERE libelle = "' . $modifCategorie . '"'); // Envoi de la requ�te
										$modif->execute();
										$donnees = $modif->fetch();
										$modif->closeCursor();
										$cat_max = $bdd->query('SELECT  MIN(categorie_id) AS id_Min, MAX(categorie_id) AS id_Max FROM categorie');
										$cat_max->execute();
										$id = $cat_max->fetch();
										$cat_max->closeCursor();
							?>
										
										<form id="formulaireModificationCategorie" method="post" action="gestions_categories.php?modifCategorie1=<?php echo $donnees['libelle']; ?>&categoriePrec=<?php echo $donnees['categorie_id'] ?>">
											<fieldset style="width: 400px">
											<legend>Modification de la cat&eacute;gorie <span class="gras"><?php echo $donnees['libelle']; ?></span></legend>
												Nom : <input type="text" id="libelleModif" name="libelleModif" value="<?php echo $donnees['libelle']; ?>"/> <br />
												Cat&eacute;gorie : <input type="number" id="categorieModif" name="categorieModif" min="<?php echo $id['id_Min']; ?>" max="10" value="<?php echo $donnees['categorie_id']; ?>"/> <br /><br />
												<input class="droite" type="reset" name="effacer" id="effacer" value="Effacer modification">
												<input class="droite" type="submit" name="modifier" id="modifier" value="Modifier">
											</fieldset>
										</form>
										<br /><br />
			
							<?php	
									}catch (Exception $e){
										die ('Erreur : ' . $e->getMessage());
									}
								}
								
								if (isset($_GET['suppCategorie'])) {
									// Ici on supprime un people
									$suppCategorie = $_GET['suppCategorie'];
									try{
										$pdo_options[PDO::ATTR_ERRMODE] = PDO::ERRMODE_EXCEPTION;
										$bdd = new PDO('mysql:host='.$hote.';dbname='. $base, $utilisateur, $mdp);
										// Sp�cification de l'encodage (en cas de probl�me d'affichage :
										$bdd->exec('SET NAMES utf8');
										$suppression = $bdd->prepare('DELETE FROM categorie WHERE libelle = "' . $suppCategorie .'"'); // Envoi de la requ�te
										$nb = $suppression->rowCount(); // Compte du nombre de lignes retourn�es
										if($suppression->execute()){
											echo '<h4>' . $suppCategorie . ' a &eacute;t&eacute; supprim&eacute;.</h4>';
										}else{
											echo '<h4>Erreur lors de la suppression.</h4>';
										}
										$suppression->closeCursor();
									}catch (Exception $erreur){
										die ('Erreur : ' . $erreur->getMessage());
									}
								}
								
								if(isset($_POST['ajouter']) && !empty($_POST['libelle']) && !empty($_POST['categorie_id'])){
									
									$libelle = htmlspecialchars($_POST['libelle']);
									$categorie_id = htmlspecialchars($_POST['categorie_id']);
									try {
										$pdo_options[PDO::ATTR_ERRMODE] = PDO::ERRMODE_EXCEPTION;
										$bdd = new PDO('mysql:host='.$hote.';dbname='. $base, $utilisateur, $mdp);
										// Sp�cification de l'encodage (en cas de probl�me d'affichage :
										$bdd->exec('SET NAMES utf8');
										$insertion = $bdd->prepare('INSERT INTO categorie(categorie_id, libelle) VALUES
										(' . $categorie_id . ', "' . $libelle . '")');
										if($insertion->execute()){
											echo '<h4>La cat&eacute;gorie ' . $libelle . ' a bien &eacute;t&eacute; enregistr&eacute;e.</h4>';
										}else{
											echo '<h4>Erreur lors de l\'enregistrement</h4>';
										}
										
										$insertion->closeCursor();
									}catch(Exception $erreur){
										die('Erreur : ' . $erreur->getMessage());
									}
								}
								
								
								if(isset($_POST['modifier']) && !empty($_POST['libelleModif']) && !empty($_POST['categorieModif'])){
									$libelleModif = htmlspecialchars($_POST['libelleModif']);
									$categorieModif = htmlspecialchars($_POST['categorieModif']);
									$categoriePrec = $_GET['categoriePrec'];
									try {
										$pdo_options[PDO::ATTR_ERRMODE] = PDO::ERRMODE_EXCEPTION;
										$bdd = new PDO('mysql:host='.$hote.';dbname='. $base, $utilisateur, $mdp);
										// Sp�cification de l'encodage (en cas de probl�me d'affichage :
										$bdd->exec('SET NAMES utf8');
										if($categoriePrec != $categorieModif ){
											$insertion = $bdd->prepare('UPDATE categorie SET categorie_id = ' . $categorieModif . ' WHERE categorie_id = ' . $categoriePrec . '');
										}else{
											$insertion = $bdd->prepare('UPDATE categorie SET libelle = "' . $libelleModif . '" WHERE categorie_id = "' . $categoriePrec . '"');
										}
										
										if($insertion->execute()){
											echo '<h4>La cat&eacute;gorie ' . $libelleModif . ' a bien &eacute;t&eacute; modifi&eacute;e.</h4>';
										}else{
											echo '<h4>Erreur lors de la modification</h4>';
										}
										
										$insertion->closeCursor();
									}catch(Exception $erreur){
										die('Erreur : ' . $erreur->getMessage());
									}
								}
							
						}catch (Exception $erreur){
							die ('Erreur : ' . $erreur->getMessage());
						}
					?>
				</div>
			</body>
		</html>
<?php 
	}else{
		header('Location: http://localhost/GeekZone/index.php');
	}
?>