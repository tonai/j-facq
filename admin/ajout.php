<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" >
	<head>
		<title>Johan FACQ - portraitiste aquarelliste</title>
		<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
		<meta name="author" content="Tony CABAYE" />
		<meta name="description" content="Site personnel de Jahan FACQ, portraitiste aquarelliste" />
		<meta name="keywords" content="peinture, portrait, aquarelle, animal" />
		<meta name="reply-to" content="tonai59@hotmail.fr" />
		<link rel="stylesheet" media="screen" type="text/css" title="Style" href="../css/style.css" />
	</head>
	<body>
		<div id="admin">
			<div id="menu">
				<ul>
					<li id="ajouter" style="background-position: -519px 0px;"><a href="ajout.php" style="color: white;">Ajouter une photos</a></li>
					<li id="supprimer" style="border-bottom: 1px solid #3b3830;"><a href="suppression.php">Supprimer une photos</a></li>
				</ul>
			</div>
			<h1>Administration</h1>
			<div id="conventions">
				<p>Pour ajouter correctement un photos il faut respecter certaines conventions :</p>
				<ol>
					<li>La largeur des images enregistrées doit être inférieure à 900 pixels.</li>
					<li>Seul le format "jpg" est accepté.</li>
					<li>Si le dessin peut être associé à une photo d'inspiration, le nom de la photo doit être le même que celui du dessin avec un "2" ajouté à la fin. Il vaut mieux commencer par uploader le dessin, puis ensuite la photo d'inspiration.</li>
				</ol>
				<p>
				exemple :<br/>
				Si le dessin se nomme : "Tigre.jpg"</br>
				La photo doit êre nommée : "Tigre2.jpg"
				</p>
			</div>
			<form method="post" action="ajout.php" enctype="multipart/form-data">
				<div id="ajout">
					<div>
						Ajouter une photo
					</div>
					<p>
						<label for="photo">Sélectionner la photos à inclure dans la galerie : </label><br/>
						<input type="file" name="photo"/><br/><br/>
						<label for="diaporama">Inclure aussi la photos dans le diaporama? </label>
						<input type="checkbox" name="diaporama"/>
					</p>
				</div>
				<p class="clear">
					<input type="submit"/>
				</p>
			</form>
<?php
	
	if (isset($_FILES['photo']['error']))
	{
		$erreur = "Une erreur s'est produite";
		if ($_FILES['photo']['error'] > 0)
			$erreur = "Erreur lors du tranfsert";
		else
		{
			$extension = 'jpg';
			$nomFichier = explode('.', $_FILES['photo']['name']);
			if ($extension == $nomFichier[1])
			{
				$taille = getimagesize($_FILES['photo']['tmp_name']);
				if ($taille[0] >= 900)
					$erreur = "Image trop grande";
				else
				{
					$direction1 = "../photos/".$nomFichier[0].".".$extension;
					$resultat = move_uploaded_file($_FILES['photo']['tmp_name'],$direction1);
					if ($resultat)
						$erreur = "Transfert réussi";
					if (isset($_POST['diaporama']))
					{
						if ($_POST['diaporama']=="on")
						{
							$direction2 = "../photos/diaporama/".$nomFichier[0].".".$extension;
							copy ($direction1, $direction2);
							if ($resultat)
								$erreur = "Transfert réussi";
						}
					}
				}
			}
		}
		echo "<p class=\"erreur\">".$erreur."</p>";
	}

?>
			<div id="footer">
				<p>
					<a href="../index.php">Retour à l'accueil</a>
				</p>
			</div>
		</div>
	</body>
</html>