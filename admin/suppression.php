<?php
	
	$fichiersSupprime="";
	$directory="../photos";
	$dossier=opendir($directory);
	while ($file=readdir($dossier))
	{
		$nomFichier=substr($file, 0, strlen($file)-4);
		$path=$directory."/".$nomFichier;
		if (isset($_POST[$nomFichier]))
		{
			if ($_POST[$nomFichier]=='on')
			{
				if (file_exists($path."2.jpg"))
				{
					if(unlink($path.".jpg") && unlink($path."_petit.jpg") && unlink($path."2.jpg") && unlink($path."2_petit.jpg"))
					{
						$fichiersSupprime=$fichiersSupprime."+".$nomFichier;
					}
				}
				else
				{
					if(unlink($path.".jpg") && unlink($path."_petit.jpg"))
					{
						$fichiersSupprime=$fichiersSupprime."+".$nomFichier;
					}
				}
			}
		}
	}
	closedir($dossier);
	
	$directory="../photos/diaporama";
	$dossier=opendir($directory);
	while ($file=readdir($dossier))
	{
		$nomFichier=substr($file, 0, strlen($file)-4);
		$path=$directory."/".$nomFichier;
		if (isset($_POST['diaporama/'.$nomFichier]))
		{
			if ($_POST['diaporama/'.$nomFichier]=='on')
			{
				if (unlink($path.".jpg") && unlink($path."_petit.jpg"))
				{
					$fichiersSupprime=$fichiersSupprime."+diaporama/".$nomFichier;
				}
			}
		}
	}
	closedir($dossier);
	
?>
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
					<li id="ajouter" style="border-bottom: 1px solid #3b3830;"><a href="ajout.php">Ajouter une photos</a></li>
					<li id="supprimer" style="background-position: -519px 0px;"><a href="suppression.php" style="color: white;">Supprimer une photos</a></li>
				</ul>
			</div>
			<h1>Administration</h1>
			<form method="post" action="suppression.php">
				<table class="left">
					<caption>Choisissez les photos à supprimer dans la galerie</caption>
<?php

	$dossier=opendir("../photos");
	$i=0;
	$j=0;
	while ($file=readdir($dossier))
	{
		if ($i>=2)
		{
			$extension=substr($file, strlen($file)-4, 4);
			if ($extension==".jpg")
			{
				$nomFichier=substr($file, 0, strlen($file)-4);
				$photoReelle=substr($nomFichier, strlen($nomFichier)-1, 1);
				$petit=substr($nomFichier, strlen($nomFichier)-5, 5);
				if ($photoReelle!="2" && $petit!="petit")
				{
					$photo[$j]=$nomFichier;
					$j++;
				}
			}
		}
		$i++;
	}
	closedir($dossier);
	
	for ($i=0; $i<$j; $i++)
	{
?>
					<tr>
						<td><img height="100" src="../photos/<?php echo $photo[$i] ?>_petit.jpg" alt="<?php echo $photo[$i] ?>"/></td>
						<td><input type="checkbox" name="<?php echo $photo[$i] ?>"/></td>
					</tr>
<?php

	}
	
?>
				</table>
				<table class="right">
					<caption>Choisissez les photos à supprimer dans le diaporama</caption>
<?php

	$dossier=opendir("../photos/diaporama");
	$i=0;
	$j=0;
	while ($file=readdir($dossier))
	{
		if ($i>=2)
		{
			$extension=substr($file, strlen($file)-4, 4);
			if ($extension==".jpg")
			{
				$nomFichier=substr($file, 0, strlen($file)-4);
				$petit=substr($nomFichier, strlen($nomFichier)-5, 5);
				if ($petit!="petit")
				{
					$diaporama[$j]=$nomFichier;
					$j++;
				}
			}
		}
		$i++;
	}
	closedir($dossier);
	
	for ($i=0; $i<$j; $i++)
	{
?>
					<tr>
						<td><img height="100" src="../photos/diaporama/<?php echo $diaporama[$i] ?>_petit.jpg" alt="<?php echo $diaporama[$i] ?>"/></td>
						<td><input type="checkbox" name="diaporama/<?php echo $diaporama[$i] ?>"/></td>
					</tr>
<?php
	}
?>
				</table>
				<p class="clear">
					<input type="submit"/>
				</p>
			</form>
<?php
	
	$fichiersSupprime=explode('+',$fichiersSupprime);
	$i=0;
	while(isset($fichiersSupprime[$i]))
	{
		$diaporama=substr($fichiersSupprime[$i], 0, 10);
		if ($fichiersSupprime[$i]!='')
		{
			if ($diaporama=='diaporama/')
			{
				$fichier=substr($fichiersSupprime[$i], 10, strlen($fichiersSupprime[$i]));
				echo "<p class=\"erreur\">l'image $fichier a été supprimée avec succés dans le diaporama</p>";
			}
			else
			{
				echo "<p class=\"erreur\">l'image $fichiersSupprime[$i] a été supprimée avec succés dans la galerie</p>";
			}
		}
		$i++;
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