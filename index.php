<!DOCTYPE html>
<html class="ng-csp">

	<head>
		<title>LemZoun</title>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta name="apple-itunes-app" content="app-id=543672169">
		
		<link rel="shortcut icon" href="image-site/image-index/favicon.png" />
		<link rel="stylesheet" href="css/styles.css" type="text/css" media="screen" />
		<link type="text/css" rel="stylesheet" href="css/lightbox-form.css">
		
		<script type="text/javascript" src="js/jquery.min.js"></script>
		<script type="text/javascript" src="js/sha512.js"></script>
		<script type="text/javascript" src="js/forms.js"></script>
		<script type="text/javascript" src="js/test.js"></script>
		<script type="text/javascript" src="js/connection.js"></script>
		<script type="text/javascript" src="js/lightbox-form.js"></script>
		<script type="text/javascript" src="js/CreationCompte.js"></script>
		
	</head>

	<body id="body-login"><div class="wrapper">
		<div id="LemZoun"><div id="SeConnecter">
			
				<header>
					<div id="header"></div>
				</header>
				<!-- ------------- formulaire pour la connexion ------------  --> 
				<form method="POST" name="login" id="login">
					
						<fieldset>
							<p id="message" class="hidden">
								<img class="float-spinner" src="image-site/image-index/patienter.gif"/>
								<span id="messageText"></span>
								<div style="clear: both;"></div>
							</p>
							<p class="infield grouptop">
								<input type="text" name="user" id="user" placeholder="" value="Email"  autocomplete="on" required onFocus="javascript:testonblurEmail()"onblur="javascript:testonblurEmail();" style="border:none"/>
								<img class="svg" id="user-icon" src="image-site/image-index/utilisateur.png" alt=""/>
								
							</p>
							<p class="infield groupbottom">
								<input type="password" name="password" id="password" value="password" placeholder="" autocomplete="off" onFocus="javascript:testonblurPassword()" onblur="javascript:testonblurPassword()" style="border:none"/>
								<img class="svg" id="password-icon" src="image-site/image-index/motDePasse.png" alt=""/>
							</p>
							</br></br>
								<a href="#CreateCompte" onclick="openbox(1)"><font size=3px>Créer Un Compte</font></a>
							<input type="submit" id="submit" class="login primary" value="Log in" onClick="formhash(this.form, this.form.password);" />
							
						</fieldset>
					
				</form>
				</div>
				<!-- ------------- fin du formulaire ------------  -->
			</div>	
			<div id='push' class="push"></div>
		</div>
		
		
				<!-- ------------- Création Compte ------------  -->		
		
	<div id="shadowing"></div>
		<div id="box">
			<div class="modalLayer" id="CreateCompte">
				<div class="popup_block">
					<a href=""><img alt="Fermer" title="Fermer la fenêtre" class="btn_close" src="./image-site/image-index/close_pop.png"></a>
					<img style="float: right; margin: 0 0 0 10px;" alt="Lil bomb dude" src="./image-site/image-index/image_gallery.png">
					
						
							<form method="POST" action="" name="monForm" id="monForm" >
							<font size=5px>Création Compte</font>
								<input id="Prenom" type="text" name="Prenom" value="Prenom"  placeholder="" autocomplete="on" required onFocus="javascript:testonblurPrenomCompte()"onblur="javascript:testonblurPrenomCompte();verifPseudo(this);">
								<input id="Nom" type="text" name="Nom" value="Nom"  placeholder="" autocomplete="on" required onFocus="javascript:testonblurNomCompte()"onblur="javascript:testonblurNomCompte();verifPseudo(this);">
								<input id="Email" type="text" placeholder="" name="Email" value="Email"  autocomplete="on" required onFocus="javascript:testonblurEmailCompte()" onblur="javascript:testonblurEmailCompte();verifMail(this);">
								<input id="password" type="password" name="Password" value="Password"  placeholder="" autocomplete="off" onFocus="javascript:testonblurPasswordCompte()" onblur="javascript:testonblurPasswordCompte()"  >
								<input type="submit" name="submit" value="Envoyer" onClick="formhash(this.form, this.form.password)"; />
								<input type="button" name="cancel" value="Annuler" onclick="closebox()"  />	
							</form>
							<div id='reponse_creation'></div>
				</div>
			</div>
		</div>
				<!-- ------------- fin Création Compte ------------  -->		

		
		
		
		
		
		
		
			<!-- ------------- pieu de la page ------------  -->	
		
			
					<footer>
			<p class="info">
				<div id="description">
					<font size=4px>LemZoun – Un Cloud Sécurisé</font>	
				</div>
			</p>
		</footer>	
		
		
	</body>
</html>
