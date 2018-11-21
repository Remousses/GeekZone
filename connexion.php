<?php 
	session_start();
	if(empty($_SESSION['gestion'])){
		$_SESSION['gestion'] = 'erreur';
	}
	
	if($_SESSION['gestion'] == 'boutiques'){
		header('Location: http://localhost/GeekZone/gestions_boutiques.php');
	}elseif($_SESSION['gestion'] == 'boutiques'){
		header('Location: http://localhost/GeekZone/gestions_produits.php');
	}elseif($_SESSION['gestion'] == 'erreur'){
?>
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
						<h1><marquee scrollamount="5" width="40">&lt;&lt;&lt;</marquee> Connexion <marquee scrollamount="5" direction="right" width="40">&gt;&gt;&gt;</marquee></h1> <br />
					</div>
					
					<div class="milieu">
						<?php 
							if(isset($_POST['connexion'])) { // si le bouton "Connexion" est appuyé
								// on vérifie que le champ "login" n'est pas vide
								// empty vérifie à la fois si le champ est vide et si le champ existe belle et bien (isset)
		
								if(empty($_POST['login'])) {
									?>
										<form id="formulaireConnexion" method="post" action="connexion.php">
											<fieldset style="width: 300px;">
												<span class="espace">Login : </span><input type="text" id="login" name="login" autofocus/> <br />
												Mot de passe : <input type="password" id="mdp" name="mdp"/> <br /><br />
												<input class="droite" type="submit" name="connexion" id="connexion" value="Connexion"/>
											</fieldset>
										</form>
										Le champ login est vide.
									<?php
								}else{
									// on vérifie maintenant si le champ "Mot de passe" n'est pas vide"
									if(empty($_POST['mdp'])) {
										?>
											<form id="formulaireConnexion" method="post" action="connexion.php">
												<fieldset style="width: 300px;">
													<span class="espace">Login : </span><input type="text" id="login" name="login" value="<?php echo $_POST['login'] ?>"/> <br />
													Mot de passe : <input type="password" id="mdp" name="mdp" autofocus/> <br /><br />
													<input class="droite" type="submit" name="connexion" id="connexion" value="Connexion"/>
												</fieldset>
											</form>
											Le champ Mot de passe est vide.
										<?php
									} else {
										// les champs sont bien posté et pas vide, on sécurise les données entrées par le membre:
										$login = htmlentities($_POST['login'], ENT_QUOTES, "ISO-8859-1"); // le htmlentities() passera les guillemets en entités HTML, ce qui empêchera les injections SQL
										$motDePasse = htmlentities($_POST['mdp'], ENT_QUOTES, "ISO-8859-1");
										//on se connecte à la base de données:
										//on vérifie que la connexion s'effectue correctement:
										try{
											$pdo_options[PDO::ATTR_ERRMODE] = PDO::ERRMODE_EXCEPTION;
											$bdd = new PDO('mysql:host='.$hote.';dbname='. $base, $utilisateur, $mdp);
											// Sp�cification de l'encodage (en cas de probl�me d'affichage :
											$bdd->exec('SET NAMES utf8');
											$connexion = $bdd->prepare("SELECT id, nom, prenom, gestions, login, mdp FROM administrateur WHERE login = '".$login."' AND mdp = '".$motDePasse."'");
											$connexion->execute();
											$donnees = $connexion->fetch();
											if($login != $donnees['login'] && $motDePasse != $donnees['mdp']){
												?>
													<form id="formulaireConnexion" method="post" action="connexion.php">
														<fieldset style="width: 300px;">
															<span class="espace">Login : </span><input type="text" id="login" name="login" autofocus/> <br />
															Mot de passe : <input type="password" id="mdp" name="mdp"/> <br /><br />
															<input class="droite" type="submit" name="connexion" id="connexion" value="Connexion"/>
														</fieldset>
													</form>
													Le pseudo ou le mot de passe est incorrect, le compte n'a pas &eacute;t&eacute; trouv&eacute;.
												<?php
											}else{
												if($donnees['gestions'] == 'produits'){
													header("Location: gestions_prod_cat.php");
													// on ouvre la session avec $_SESSION:
													$_SESSION['gestion'] = $donnees['gestions']; // la session peut être appelée différemment et son contenu aussi peut être autre chose que la gestion
													$_SESSION['nom'] = $donnees['nom']; // la session peut être appelée différemment et son contenu aussi peut être autre chose que le nom
													$_SESSION['prenom'] =  $donnees['prenom']; // la session peut être appelée différemment et son contenu aussi peut être autre chose que le rpenom
													$_SESSION['login'] = $login; // la session peut être appelée différemment et son contenu aussi peut être autre chose que le login
												}elseif($donnees['gestions'] == 'boutiques'){
													header("Location: gestions_boutiques.php");
													// on ouvre la session avec $_SESSION:
													$_SESSION['gestion'] = $donnees['gestions']; // la session peut être appelée différemment et son contenu aussi peut être autre chose que la gestion
													$_SESSION['nom'] = $donnees['nom']; // la session peut être appelée différemment et son contenu aussi peut être autre chose que le nom
													$_SESSION['prenom'] =  $donnees['prenom']; // la session peut être appelée différemment et son contenu aussi peut être autre chose que le rpenom
													$_SESSION['login'] = $login; // la session peut être appelée différemment et son contenu aussi peut être autre chose que le login
												}else{
													?>
														<form id="formulaireConnexion" method="post" action="connexion.php">
														<fieldset style="width: 300px;">
														<span class="espace">Login : </span><input type="text" id="login" name="login" autofocus/> <br />
														Mot de passe : <input type="password" id="mdp" name="mdp"/> <br /><br />
														<input class="droite" type="submit" name="connexion" id="connexion" value="Connexion"/>
														</fieldset>
														</form>
														Vous n'avez pas les droits n&eacute;cessaires.
													<?php
												}
											}
											
											$connexion->closeCursor();
										}catch (Exception $e){
											die ('Erreur : ' . $e->getMessage());
										}
									}
								}
							}else{
						?>
								<form id="formulaireConnexion" method="post" action="connexion.php">
									<fieldset style="width: 300px;">
										<span class="espace">Login : </span><input type="text" id="login" name="login" autofocus/> <br />
										Mot de passe : <input type="password" id="mdp" name="mdp"/> <br /><br />
										<input class="droite" type="submit" name="connexion" id="connexion" value="Connexion"/>
									</fieldset>
								</form>
						<?php
							}
						?>
					</div>
			</body>
		</html>
<?php
	}
?>