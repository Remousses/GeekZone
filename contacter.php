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
			<h1><marquee scrollamount="5" width="40">&lt;&lt;&lt;</marquee> Nous contacter <marquee scrollamount="5" direction="right" width="40">&gt;&gt;&gt;</marquee></h1> <br />
		</div>
		
		<div class="milieu">
			<?php
				// destinataire est votre adresse mail. Pour envoyer à plusieurs à la fois, séparez-les par une virgule
				$destinataire = 'remousses@gmail.com';
				
				// copie ? (envoie une copie au visiteur)
				$copie = 'oui'; // 'oui' ou 'non'
				
				// Messages de confirmation du mail
				$message_envoye = "Votre message nous est bien parvenu !";
				$message_non_envoye = "L'envoi du mail a échoué, veuillez réessayer SVP.";
				
				// Messages d'erreur du formulaire
				$message_erreur_formulaire = "Vous devez d'abord <a href=\"contacter.php\">envoyer le formulaire</a>.";
				$message_formulaire_invalide = "Vérifiez que tous les champs soient bien remplis et que l'email soit sans erreur.";
				
				if (isset ($_POST['envoyer']) && !(empty($_POST['mail'])) && !(empty($_POST['objet'])) && !(empty($_POST['message']))){
					// cette fonction sert à nettoyer et enregistrer un texte
					function Rec($text){
						$text = htmlspecialchars(trim($text), ENT_QUOTES);
						if (1 === get_magic_quotes_gpc())
						{
							$text = stripslashes($text);
						}
				 
						$text = nl2br($text);
						return $text;
					}
				 
					// Cette fonction sert à vérifier la syntaxe d'un email
					function IsEmail($email){
						$value = preg_match('/^(?:[\w\!\#\$\%\&\'\*\+\-\/\=\?\^\`\{\|\}\~]+\.)*[\w\!\#\$\%\&\'\*\+\-\/\=\?\^\`\{\|\}\~]+@(?:(?:(?:[a-zA-Z0-9_](?:[a-zA-Z0-9_\-](?!\.)){0,61}[a-zA-Z0-9_-]?\.)+[a-zA-Z0-9_](?:[a-zA-Z0-9_\-](?!$)){0,61}[a-zA-Z0-9_]?)|(?:\[(?:(?:[01]?\d{1,2}|2[0-4]\d|25[0-5])\.){3}(?:[01]?\d{1,2}|2[0-4]\d|25[0-5])\]))$/', $email);
						return (($value === 0) || ($value === false)) ? false : true;
					}
				 
					// formulaire envoyé, on récupère tous les champs.
					$email   = (isset($_POST['mail']))   ? Rec($_POST['mail'])   : '';
					$objet   = (isset($_POST['objet']))   ? Rec($_POST['objet'])   : '';
					$message = (isset($_POST['message'])) ? Rec($_POST['message']) : '';
				 
					// On va vérifier les variables et l'email ...
					$email = (IsEmail($email)) ? $email : ''; // soit l'email est vide si erroné, soit il vaut l'email entré
				 
					// les 4 variables sont remplies, on génère puis envoie le mail
					$headers  = 'Version MINE: 1.0' . "\r\n";
					$headers .= 'De: <'.$email.'>' . "\r\n" .
							'Répondre &agrave;:'.$email. "\r\n" .
							'Type de contenu: text/plain; charset="utf-8"'."\r\n" ;
				
					// envoyer une copie au visiteur ?
					if ($copie == 'oui'){
						$cible = $destinataire . ';' . $email;
					}else{
						$cible = $destinataire;
					}
			 
					// Remplacement de certains caractères spéciaux
					$message = str_replace("&#039;","'",$message);
					$message = str_replace("&#8217;","'",$message);
					$message = str_replace("&quot;",'"',$message);
					$message = str_replace('<br>','',$message);
					$message = str_replace('<br />','',$message);
					$message = str_replace("&lt;","<",$message);
					$message = str_replace("&gt;",">",$message);
					$message = str_replace("&amp;","&",$message);
			 
					// Envoi du mail
					$num_emails = 0;
					$tmp = explode(';', $cible);
					foreach($tmp as $email_destinataire){
						if (mail($email_destinataire, $objet, $message, $headers))
							$num_emails++;
					}
			 
					if ((($copie == 'oui') && ($num_emails == 2)) || (($copie == 'non') && ($num_emails == 1))){
						echo '<p>'.$message_envoye.'</p>';
					}
					else{
						echo '<p>'.$message_non_envoye.'</p>';
					}
				}else{
			?>
			<form id="formulaire2" method="post" action="contacter.php">
				<fieldset style="width: 300px;">
					Email : <input type="text" id="mail" name="mail"/> <br />
					&nbsp;Objet : <input type="text" id="objet" name="objet"/> <br /><br />
					Message : <br />
					<textarea id="message" name="message" cols="30" rows="6"></textarea><br />
					<input class="droite" type="submit" name="envoyer" id="envoyer" value="envoyer"/>
				</fieldset>
			</form>
			<?php 
				}
			?>
		</div>
	</body>
</html>