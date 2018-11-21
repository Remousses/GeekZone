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
					<h1><marquee scrollamount="5" width="40">&lt;&lt;&lt;</marquee> Gestions des cat&eacute;gories et des produits <marquee scrollamount="5" direction="right" width="40">&gt;&gt;&gt;</marquee></h1> <br />
				</div>
				
				<div class="milieu">
					<div class="bouton_prod_cat">
						<a class="btn" href="http://localhost/GeekZone/gestions_produits.php">Produits</a>
					</div>
					<br /><br />
					<div class="bouton_prod_cat">
						<a class="btn" href="http://localhost/GeekZone/gestions_categories.php">Catégories</a>
					</div>
				</div>
			</body>
		</html>
<?php 
	}else{
		header('Location: http://localhost/GeekZone/index.php');
	}
?>