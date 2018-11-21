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
					<?php include_once 'includes/upload.inc.php'; ?>
					<?php include 'includes/menu.php'; ?>
				</div>
					
					<div class="titre">
						<h1><marquee scrollamount="5" width="40">&lt;&lt;&lt;</marquee> Gestions des produits <marquee scrollamount="5" direction="right" width="40">&gt;&gt;&gt;</marquee></h1> <br />
					</div>
					
					<div class="milieu">
						<?php 
							try {
								if (isset($_POST['order']) && isset($_POST['valider'])) {
						?>		
									<form id="formulaireTriProduits" method="post" action="gestions_produits.php">
										<fieldset style="width: 700px">
										Tri des produits : <input type="radio" id="order" name="order" value="produit_id" checked="checked"/>selon l'id
														    <input type="radio" id="order" name="order" value="nom"/>selon le nom
														    <input type="radio" id="order" name="order" value="prix"/>selon le prix
														    <input type="radio" id="order" name="order" value="categorie"/>selon la cat&eacute;gorie
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
										$reponse = $bdd->query('SELECT * FROM produit ORDER BY ' . $_POST['order'] . ''); // Envoi de la requete
										$nb = $reponse->rowCount(); // Compte du nombre de lignes retourn�es
										echo '<table class="coller">
												<tr>
													<th class="gest_bout">Id</th>
													<th class="gest_bout">Nom</th>
													<th class="gest_bout">Description</th>
													<th class="gest_bout">Détail</th>
													<th class="gest_bout">Prix</th>
													<th class="gest_bout">Catégorie</th>
												<tr>';
										
										while ($donnees = $reponse->fetch()) {
											$description = $donnees['description'];
											$detail = $donnees['detail'];
											
											if (strlen($description) > 100){
												$description = substr($description, 0, 100);
												$description .= " ...";
											}
												
											if (strlen($detail) > 100){
												$detail = substr($detail, 0, 100);
												$detail .= " ...";
											}
											
											echo '<tr>
											<td class="gest_bout">' . $donnees['produit_id'] . '</td>
											<td class="gest_bout">' . $donnees['nom'] . '<br />
											<img alt="'. $donnees['nom'] . '" src="img/img_produits/' .  $donnees['image']  . '" height="75px"></td>
											<td class="gest_bout">' . $description . '</td>
											<td class="gest_bout">' . $detail . '</td>
											<td class="gest_bout">' . $donnees['prix'] . ' €</td>
											<td class="gest_bout">' . $donnees['categorie'] . '</td>
											<td class="gest_bout_supp_mod"><a href="gestions_produits.php?suppProdNom=' . $donnees['nom'] . '&suppProdImg=' . $donnees['image'] . '"><img alt="Bouton supprimer" src="img/img_logo/Logo_Supprimer.png" height="20px"></a></td>
											<td class="gest_bout_supp_mod"><a href="gestions_produits.php?modifProdNom=' . $donnees['nom'] . '"><img alt="Bouton modifier" src="img/img_logo/Logo_Modifier.png" height="20px"></a></td>
											</tr>';
										}
										echo '</table>
										<p class="milieu">Il y a ' . $nb . ' produits.</p>'; //Affichage du compte des lignes
										// On libere la connexion du serveur pour d'autres requetes
										$reponse->closeCursor();
										$id_max = $bdd->query('SELECT MIN(categorie_id) AS id_Min, MAX(categorie_id) AS id_Max FROM categorie'); // Envoi de la requ�te
										$id_max->execute();
										$id = $id_max->fetch();
										$id_max->closeCursor();
								?>					
										<form id="formulaireAjoutProduit" method="post" action="gestions_produits.php" enctype="multipart/form-data">
											<fieldset style="width: 350px">
												<legend>Ajout d'un produit</legend>
												Nom : <input type="text" id="nom" name="nom"/> <br />
												Description : <textarea id="description" name="description" cols="30" rows="3"/></textarea> <br />
												D&eacute;tail : <textarea id="detail" name="detail" cols="30" rows="3"></textarea> <br />
												Prix : <input type="number" step="0.1" id="prix" name="prix" /> €<br />
												Image : <input type="file" id="image" name="image" /> <br />
												Cat&eacute;gorie : <input type="number" id="categorie" name="categorie" min="<?php echo $id['id_Min']; ?>" max="<?php echo $id['id_Max']; ?>"/> <br /><br />
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
									<form id="formulaireTriProduits" method="post" action="gestions_produits.php">
										<fieldset style="width: 700px">
										Tri des produits : <input type="radio" id="order" name="order" value="produit_id" checked="checked"/>selon l'id
														    <input type="radio" id="order" name="order" value="nom"/>selon le nom
														    <input type="radio" id="order" name="order" value="prix"/>selon le prix
														    <input type="radio" id="order" name="order" value="categorie"/>selon la cat&eacute;gorie
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
										$id_max = $bdd->query('SELECT MIN(categorie_id) AS id_Min, MAX(categorie_id) AS id_Max FROM categorie'); // Envoi de la requ�te
										$id_max->execute();
										$id = $id_max->fetch();
										$id_max->closeCursor();
								?>
										<form id="formulaireAjoutProduit" method="post" action="gestions_produits.php" enctype="multipart/form-data">
											<fieldset style="width: 350px">
												<legend>Ajout d'un produit</legend>
												Nom : <input type="text" id="nom" name="nom"/> <br />
												Description : <textarea id="description" name="description" cols="30" rows="3"></textarea> <br />
												D&eacute;tail : <textarea id="detail" name="detail" cols="30" rows="3"></textarea> <br />
												Prix : <input type="number" step="0.1" id="prix" name="prix" /> €<br />
												Image : <input type="file" id="image" name="image" /> <br />
												Cat&eacute;gorie : <input type="number" id="categorie" name="categorie" min="<?php echo $id['id_Min']; ?>" max="<?php echo $id['id_Max']; ?>"/> <br /><br />
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
								
								if (!empty($_GET['modifProdNom'])) {
									// Ici on mofifie un produit
									$modifProdNom = $_GET['modifProdNom'];
	
									try{
										$pdo_options[PDO::ATTR_ERRMODE] = PDO::ERRMODE_EXCEPTION;
										$bdd = new PDO('mysql:host='.$hote.';dbname='. $base, $utilisateur, $mdp);
										// Sp�cification de l'encodage (en cas de probl�me d'affichage :
										$bdd->exec('SET NAMES utf8');
										$modif = $bdd->prepare('SELECT * FROM produit WHERE nom = ?'); // Envoi de la requ�te
										$modif->execute(array($modifProdNom));
										$donnees = $modif->fetch();
										$modif->closeCursor();
										$id_max = $bdd->query('SELECT MIN(categorie_id) AS id_Min, MAX(categorie_id) AS id_Max FROM categorie'); // Envoi de la requ�te
										$id_max->execute();
										$id = $id_max->fetch();
										$id_max->closeCursor();
							?>
										
										<form id="formulaireModificationProduit" method="post" action="gestions_produits.php?modifProdNom1=<?php echo $donnees['nom']; ?>&modifProdImg1=<?php echo $donnees['image']; ?>" enctype="multipart/form-data">
											<fieldset style="width: 400px">
											<legend>Modification du produit <span class="gras"><?php echo $donnees['nom']; ?></span></legend>
												Nom : <input type="text" id="nomModif" name="nomModif" value="<?php echo $donnees['nom']; ?>"/> <br />
												Description : <textarea id="descriptionModif" name="descriptionModif" cols="30" rows="3"><?php echo $donnees['description']; ?></textarea> <br />
												D&eacute;tail : <textarea id="detailModif" name="detailModif" cols="30" rows="3"><?php echo $donnees['detail']; ?></textarea> <br />
												Prix : <input type="number" step="0.1" id="prixModif" name="prixModif" value="<?php echo $donnees['prix']; ?>"/> €<br />
												Nom image : <input type="text" id="imageModifNom" name="imageModifNom" value="<?php echo $donnees['image']; ?>"/> <br />
												Nouvelle image : <input type="file" id="imageModif" name="imageModif"/> <br />
												Cat&eacute;gorie : <input type="number" id="categorieModif" name="categorieModif" min="<?php echo $id['id_Min']; ?>" max="<?php echo $id['id_Max']; ?>" value="<?php echo $donnees['categorie']; ?>"/> <br /><br />
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
								
								if (isset($_GET['suppProdNom']) && isset($_GET['suppProdImg'])) {
									// Ici on supprime un people
									$suppProdNom = $_GET['suppProdNom'];
									$suppProdmg = $_GET['suppProdImg'];
									try{
										$pdo_options[PDO::ATTR_ERRMODE] = PDO::ERRMODE_EXCEPTION;
										$bdd = new PDO('mysql:host='.$hote.';dbname='. $base, $utilisateur, $mdp);
										// Sp�cification de l'encodage (en cas de probl�me d'affichage :
										$bdd->exec('SET NAMES utf8');
										$suppression = $bdd->prepare('DELETE FROM produit WHERE nom = "' . $suppProdNom .'"'); // Envoi de la requ�te
										$nb = $suppression->rowCount(); // Compte du nombre de lignes retourn�es
										if($suppression->execute()){
											unlink('img/img_produits/' . $_GET['suppProdImg']);
											echo '<h4>Le produit ' . $suppProdNom . ' a &eacute;t&eacute; supprim&eacute;.</h4>';
										}else{
											echo '<h4>Erreur lors de la suppression.</h4>';
										}
										$suppression->closeCursor();
									}catch (Exception $erreur){
										die ('Erreur : ' . $erreur->getMessage());
									}
								}
								
								if(isset($_POST['ajouter']) && !empty($_POST['nom'])
										&& !empty($_POST['description']) && !empty($_POST['description'])
										&& !empty($_POST['prix']) && isset($_FILES['image'])
										&& !empty($_POST['categorie'])){
									
									$nom = htmlspecialchars($_POST['nom']);
									$description = htmlspecialchars($_POST['description']);
									$detail = htmlspecialchars($_POST['detail']);
									$prix = htmlspecialchars($_POST['prix']);
									$image = $_FILES['image'];
									$categorie = htmlspecialchars($_POST['categorie']);
									try {
										$pdo_options[PDO::ATTR_ERRMODE] = PDO::ERRMODE_EXCEPTION;
										$bdd = new PDO('mysql:host='.$hote.';dbname='. $base, $utilisateur, $mdp);
										// Sp�cification de l'encodage (en cas de probl�me d'affichage :
										$bdd->exec('SET NAMES utf8');
										$id_max = $bdd->query('SELECT MAX(produit_id) AS id_Max FROM produit');
										$id_max->execute();
										$donnees = $id_max->fetch();
										$max = $donnees['id_Max'] + 1;
										$id_max->closeCursor();
										$insertion = $bdd->prepare('INSERT INTO produit(produit_id, nom, description, detail, prix, image, categorie) VALUES
										(' . $max . ', "' . $nom . '", "' . $description . '", "' . $detail . '", "' . $prix . '", "' . $image['name'] . '", "' . $categorie . '")');
										if($insertion->execute()){
											$listExt = array ('png', 'jpg', 'jpeg');
											if (upload($image, '10000000', $listExt,'img/img_produits/')){
												echo '<h4>Le produit ' . $nom . ' a bien &eacute;t&eacute; enregistr&eacute;.</h4>';
											}
										}else{
											echo '<h4>Erreur lors de l\'enregistrement</h4>';
										}
										
										$insertion->closeCursor();
									}catch(Exception $erreur){
										die('Erreur : ' . $erreur->getMessage());
									}
								}
								
								
								if(isset($_POST['modifier']) && !empty($_POST['nomModif'])
										&& !empty($_POST['descriptionModif']) && !empty($_POST['detailModif'])
										&& !empty($_POST['prixModif']) && !empty($_POST['imageModifNom'])
										&& !empty($_POST['categorieModif'])){
									// Ici on modifie une boutique
									$nomModif = htmlspecialchars($_POST['nomModif']);
									$descriptionModif = htmlspecialchars($_POST['descriptionModif']);
									$detailModif = htmlspecialchars($_POST['detailModif']);
									$prixModif = htmlspecialchars($_POST['prixModif']);
									$imageModifNom = htmlspecialchars($_POST['imageModifNom']);
									$categorieModif = htmlspecialchars($_POST['categorieModif']);
									
									try {
										$pdo_options[PDO::ATTR_ERRMODE] = PDO::ERRMODE_EXCEPTION;
										$bdd = new PDO('mysql:host='.$hote.';dbname='. $base, $utilisateur, $mdp);
										// Sp�cification de l'encodage (en cas de probl�me d'affichage :
										$bdd->exec('SET NAMES utf8');
										if ($_FILES['imageModif']['name'] != '' && $_GET['modifProdImg1'] == $imageModifNom){
											$imageModif = $_FILES['imageModif'];
											$listExt = array ('png', 'jpg');
											if (upload($_FILES['imageModif'], '10000000', $listExt,'img/img_produits/')){
												$insertion = $bdd->prepare('UPDATE produit SET nom = "' . $nomModif . '", description = "' . $descriptionModif . '", detail = "' . $detailModif . '",
										        prix = "' . $prixModif . '",image = "' . $imageModif['name'] . '", categorie = "' . $categorieModif . '" WHERE nom = "' . $_GET['modifProdNom1'] . '"');
												if($insertion->execute()){
													unlink('img/img_produits/' . $_POST['imageModifNom']);
													echo '<h4>Le produit ' . $nomModif . ' a bien &eacute;t&eacute; modifi&eacute;.</h4>';
												}else{
													echo '<h4>Erreur lors de la modification</h4>';
												}
											}
											$insertion->closeCursor();
										}elseif($_FILES['imageModif']['name'] == ''){
											$insertion = $bdd->prepare('UPDATE produit SET nom = "' . $nomModif . '", description = "' . $descriptionModif . '", detail = "' . $detailModif . '",
										    prix = "' . $prixModif . '",image = "' . $imageModifNom . '", categorie = "' . $categorieModif . '" WHERE nom = "' . $_GET['modifProdNom1'] . '"');
											if($insertion->execute()){
												if($_GET['modifProdImg1'] != $imageModifNom){
													rename('img/img_produits/' . $_GET['modifProdImg1'], 'img/img_produits/' . $imageModifNom);
												}
												echo '<h4>Le produit ' . $nomModif . ' a bien &eacute;t&eacute; modifi&eacute;.</h4>';
											}else{
												echo '<h4>Erreur lors de la modification</h4>';
											}
										}else{
											$modif = $bdd->prepare('SELECT * FROM produit WHERE nom = ?'); // Envoi de la requ�te
											$modif->execute(array($_GET['modifProdNom1']));
											$donnees = $modif->fetch();
											$modif->closeCursor();
											$id_max = $bdd->query('SELECT MIN(categorie_id) AS id_Min, MAX(categorie_id) AS id_Max FROM categorie'); // Envoi de la requ�te
											$id_max->execute();
											$id = $id_max->fetch();
											$id_max->closeCursor();
							?>
												
											<form id="formulaireModificationProduit" method="post" action="gestions_produits.php?modifProdNom1=<?php echo $donnees['nom']; ?>&modifProdImg1=<?php echo $donnees['image']; ?>" enctype="multipart/form-data">
												<fieldset style="width: 400px">
												<legend>Modification du produit <span class="gras"><?php echo $donnees['nom']; ?></span></legend>
													Nom : <input type="text" id="nomModif" name="nomModif" value="<?php echo $donnees['nom']; ?>"/> <br />
													Description : <textarea id="descriptionModif" name="descriptionModif" cols="30" rows="3"><?php echo $donnees['description']; ?></textarea> <br />
													D&eacute;tail : <textarea id="detailModif" name="detailModif" cols="30" rows="3"><?php echo $donnees['detail']; ?></textarea> <br />
													Prix : <input type="number" step="0.1" id="prixModif" name="prixModif" value="<?php echo $donnees['prix']; ?>"/> €<br />
													Nom image : <input type="text" id="imageModifNom" name="imageModifNom" value="<?php echo $donnees['image']; ?>"/> <br />
													Nouvelle image : <input type="file" id="imageModif" name="imageModif"/> <br />
													Cat&eacute;gorie : <input type="number" id="categorieModif" name="categorieModif" min="<?php echo $id['id_Min']; ?>" max="<?php echo $id['id_Max']; ?>" value="<?php echo $donnees['categorie']; ?>"/> <br /><br />
													<input class="droite" type="reset" name="effacer" id="effacer" value="Effacer modification">
													<input class="droite" type="submit" name="modifier" id="modifier" value="Modifier">
												</fieldset>
											</form>
											<h4>Erreur lors de la modification: le nom de l'image est introuvable.</h4>
							<?php
										}
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