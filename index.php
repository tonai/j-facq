<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" >
	<head>
		<title>Joanne FACQ - portraitiste aquarelliste</title>
		<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
		<meta name="author" content="Tony CABAYE" />
		<meta name="description" content="Site personnel de Joanne FACQ, portraitiste aquarelliste" />
		<meta name="keywords" content="peinture, portrait, aquarelle, animal" />
		<meta name="reply-to" content="tonai59@hotmail.fr" />
		<link rel="stylesheet" media="screen" type="text/css" title="Style" href="css/style.css" />
		<!--[if lte IE 7]>
			<style type="text/css">
				body #accueil #menu
				{
					margin-left: 360px;	
				}
			</style>
		<![endif]-->
	</head>
	<body>
<?php

	$dossier=opendir("photos/diaporama");
	$i=0;
	$j=0;
	while ($file=readdir($dossier))
	{
		if ($i>=2)
		{
			$n=strlen($file)-10;
			$extension_petit=substr($file, $n, 10);
			$fin=strlen($file)-4;
			$extension=substr($file, $fin, 4);
			
			if ($extension==".jpg")
			{
				if (!isset($src[$j]))
					$src[$j]="";
				if (!isset($src_petit[$j]))
					$src_petit[$j]="";
				if ($extension_petit=="_petit.jpg")
				{
					$existe=0;
					for ($k=0;$k<$j;$k++)
					{
						$titre=substr($file, 0, $n);
						if ($src[$k]==$titre)
						{
							$src_petit[$k]=$titre;
							$existe=1;
						}
					}
					if ($existe==0)
					{
						$titre=substr($file, 0, $n);
						$src_petit[$j]=$titre;
						$j++;
					}
				}
				else
				{
					$existe=0;
					for ($k=0;$k<$j;$k++)
					{
						$titre=substr($file, 0, $fin);
						if ($src_petit[$k]==$titre)
						{
							$src[$k]=$titre;
							$existe=1;
						}
					}
					if ($existe==0)
					{
						$titre=substr($file, 0, $fin);
						$src[$j]=$titre;
						$j++;
					}
				}
			}
		}
		$i++;
	}
	closedir($dossier);
	
	for($i=0;$i<$j;$i++)
	{
		if($src[$i]!=$src_petit[$i])
		{
			$fond = imagecreatetruecolor(360, 360);
			$background = imagecolorallocate($fond, 59, 56, 48);
			imagefill($fond, 0, 0, $background);
			$source = imagecreatefromjpeg("photos/diaporama/".$src[$i].".jpg");
			$largeur_source = imagesx($source);
			$hauteur_source = imagesy($source);
			
			if($largeur_source>$hauteur_source)
			{
				$largeur_destination = 360;
				$hauteur_destination = ceil($largeur_destination*$hauteur_source/$largeur_source);
				$position_X=0;
				$position_Y=(360-$hauteur_destination)/2;
			}
			else
			{
				$hauteur_destination = 360;
				$largeur_destination = ceil($hauteur_destination*$largeur_source/$hauteur_source);
				$position_Y=0;
				$position_X=(360-$largeur_destination)/2;
			}
			$destination = imagecreatetruecolor($largeur_destination, $hauteur_destination);

			imagecopyresampled($destination, $source, 0, 0, 0, 0, $largeur_destination, $hauteur_destination, $largeur_source, $hauteur_source);
			imagecopy($fond, $destination, $position_X, $position_Y, 0, 0, $largeur_destination, $hauteur_destination);
			$nom="photos/diaporama/".$src[$i]."_petit.jpg";
			imagejpeg($fond, $nom);
		}
	}
	
	$dossier=opendir("photos/diaporama");
	$i=0;
	$j=0;
	while ($file=readdir($dossier))
	{
		if ($i>=2)
		{
			$n=strlen($file)-10;
			$extension_petit=substr($file, $n, 10);
			if ($extension_petit=="_petit.jpg")
			{
				$diaporama[$j]=$file;
				$j++;
			}
		}
		$i++;
	}
	closedir($dossier);
	
?>
		<script language="javascript">

	imgPath = new Array;
	if (document.images)
	{
<?php

	for($i=0;$i<$j;$i++)
	{
		echo "i".$i." = new Image;";
		echo "i".$i.".src = 'photos/diaporama/".$diaporama[$i]."';";
		echo "imgPath[".$i."] = i".$i.".src;";
	}

?>
	}
	a = 0;
	
	function ejs_img_fx(img)
	{
		if(img && img.filters && img.filters[0])
		{
			img.filters[0].apply();
			img.filters[0].play();
		}
	}
	
	function defilimg()
	{
		if (a==<?php echo $j; ?>)
		{
			a = 0;
		}
		if (document.images)
		{
			ejs_img_fx(document.defil)
			document.defil.src = imgPath[a];
			//document.defil.width = imgWidth[a];
			//document.defil.height = imgHeight[a];
			tempo3 = setTimeout("defilimg()",4000);
			a++;
		}
	}

		</script>
		<div id="accueil">
			<div id="corps">
				<p>
					<span id="johan">Joanne</span><br/>
					<span id="facq">F A C Q</span>
					<hr/>
					<span id="fonction">Portraitiste aquarelliste</span>
				</p>
			</div>
			<div id="diaporama">
				<img src="photos/diaporama/flatcoat_petit.jpg" alt="diaporama" name="defil" style="filter:progid:DXImageTransform.Microsoft.Fade(Overlap=1.00);"/>
			</div>
			<div id="menu">
				<ul>
					<li><a href="index.php">Accueil</a></li>
					<li><a href="presentation.php">Pr�sentation</a></li>
					<li><a href="galerie.php">Galerie</a></li>
					<li><a href="contact.php">Contact</a></li>
				</ul>
			</div>
		</div>
		<div id="footer">
			<p class="left">
				<a href="admin/ajout.php">Administration</a>
			</p>
			<p class="right">
				&copy; Joanne FACQ - creation : Tony CABAYE - optimised for IE7
			</p>
		</div>
		<script language="javascript">
			defilimg();
		</script>
	</body>
</html>