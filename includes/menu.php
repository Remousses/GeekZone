<div id="menugz">
	<?php
		if(isset($_SESSION['login'])){
			if($_SESSION['gestion'] == "boutiques"){
	?>
			<div class="bouton" style="margin-top: 150px;">
				<a class="btn" href="http://localhost/GeekZone/gestions_boutiques.php">Gestions des boutiques</a>
			</div>
	<?php 
	
			}elseif($_SESSION['gestion'] == "produits" && $_SERVER["REQUEST_URI"] != "/GeekZone/gestions_prod_cat.php"){
	?>
				<div class="bouton" style="margin-top: 150px;">
					<a class="btn" href="http://localhost/GeekZone/gestions_produits.php">Gestions des produits</a>
				</div>
				
				<div class="bouton" style="margin-top: 200px;">
					<a class="btn" href="http://localhost/GeekZone/gestions_categories.php">Gestions des cat&eacute;gories</a>
				</div>
	<?php
			}
	?>

			<div class="bouton">
				<a class="btn" href="http://localhost/GeekZone/deconnexion.php">D&eacute;connexion</a>
			</div>
	<?php
			echo '<br /><br />
			<span class="bouton_deco">Bonjour ' . $_SESSION['nom'] . ' ' . $_SESSION['prenom'] . '</span>';
		}else{
	?>
			<div class="bouton">
				<a class="btn" href="http://localhost/GeekZone/connexion.php">Espace admin</a>
			</div>
	<?php
		}
	?>
	
	<ul id="menu">
		<li><a id="header"href="http://localhost/GeekZone/index.php">Accueil</a></li>
		<li><a id="header" href="http://localhost/GeekZone/boutiques.php">Boutiques</a></li>
	  	<li><a id="header"href="http://localhost/GeekZone/produits.php">Produits</a>
	    	<ul>
		        <li><a href="http://localhost/GeekZone/produit/cuisine.php">Cuisines</a></li>
		        <li><a href="http://localhost/GeekZone/produit/gadget.php">Gadget</a></li>
		      	<li><a href="http://localhost/GeekZone/produit/mode.php">Mode</a></li>
		        <li><a href="http://localhost/GeekZone/produit/portable.php">Portable</a></li>
				<li><a href="http://localhost/GeekZone/produit/USB.php">USB</a></li>
	    	</ul>
	 	</li>
	 	<li><a id="header"href="http://localhost/GeekZone/contacter.php">Nous contacter</a></li>
	</ul>
</div>