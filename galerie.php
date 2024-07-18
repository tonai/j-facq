<?php

	$dossier=opendir("photos");
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
			$source = imagecreatefromjpeg("photos/".$src[$i].".jpg");
			$largeur_source = imagesx($source);
			$hauteur_source = imagesy($source);
			
			if($largeur_source>$hauteur_source)
			{
				$largeur_destination = 100;
				$hauteur_destination = ceil($largeur_destination*$hauteur_source/$largeur_source);
			}
			else
			{
				$hauteur_destination = 100;
				$largeur_destination = ceil($hauteur_destination*$largeur_source/$hauteur_source);
			}
			$destination = imagecreatetruecolor($largeur_destination, $hauteur_destination);

			imagecopyresampled($destination, $source, 0, 0, 0, 0, $largeur_destination, $hauteur_destination, $largeur_source, $hauteur_source);
			$nom="photos/".$src[$i]."_petit.jpg";
			imagejpeg($destination, $nom);
		}
	}

	$dossier=opendir("photos");
	$i=0;
	$j=0;
	$k=0;
	while ($file=readdir($dossier))
	{
		if ($i>=2)
		{
			$fin=strlen($file)-10;
			$extension=substr($file, $fin, 10);
			if ($extension=="_petit.jpg")
			{
				if (!isset($src[$j]))
					$src[$j]="";
				if (!isset($src2[$j]))
					$src2[$j]="";
				$nombre=substr($file, $fin-1, 1);
				if ($nombre=="2")
				{
					$existe=0;
					for ($k=0;$k<$j;$k++)
					{
						$fin=strlen($file)-11;
						$titre=substr($file, 0, $fin);
						if ($src[$k]=="photos/".$titre."_petit.jpg")
						{
							$src2[$k]="photos/".$file;
							$existe=1;
						}
					}
					if ($existe==0)
					{
						$src2[$j]="photos/".$file;
						$j++;
					}
				}
				else
				{
					$existe=0;
					for ($k=0;$k<$j;$k++)
					{
						$titre=substr($file, 0, $fin);
						if ($src2[$k]=="photos/".$titre."2_petit.jpg")
						{
							$src[$k]="photos/".$file;
							$existe=1;
						}
					}
					if ($existe==0)
					{
						$src[$j]="photos/".$file;
						$j++;
					}
				}
			}
		}
		$i++;
	}
	closedir($dossier);
?>
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
	</head>
	<body>
		<div id="main">
			<div id="menu">
				<ul>
					<li><a href="index.php" style="border-right: 1px solid #3b3830;">Accueil</a></li>
					<li><a href="presentation.php" style="border-right: 1px solid #3b3830;">Présentation</a></li>
					<li><a href="#" style="background-position: -100px 0px; color: white;">Galerie</a></li>
					<li><a href="contact.php" style="border-right: 1px solid #3b3830;">Contact</a></li>
				</ul>
			</div>
			<div id="corps">
				<script language="javascript">

	var maximum = <?php echo $j; ?>;
	var liste = new Array(<?php for ($i=0; $i<$j; $i++) { echo "'".$src[$i]."'"; if ($i!=$j-1) echo ","; } ?>);
	var liste2 = new Array(<?php for ($i=0; $i<$j; $i++) { echo "'".$src2[$i]."'"; if ($i!=$j-1) echo ","; } ?>);
	var positionActuelle = 0;

	function gauche()
	{
		if (document.all)
		{
			document.getElementById("right").style.display="block";
		}
		else
		{
			document.getElementById("right").setAttribute("style","display: block;");
		}
		if (positionActuelle!=0)
		{
			var image="";
			var i=0;
			var contenu="";
			var longueur=0;
			var image="";
			contenu+="<table>";
			contenu+="<tr>";
			positionActuelle--;
			for (i=positionActuelle;i<positionActuelle+8;i++)
			{
				longueur = liste[i].length-10;
				image = liste[i].substring(0, longueur);
				contenu+="<td>";
				contenu+="<a href=\"javascript:;\" onClick=\"document.maxi.src='"+image+".jpg';\"><img src=\""+liste[i]+"\" alt=\""+liste[i]+"\" /></a>";
				contenu+="</td>";
			}
			contenu+="</tr>";
			contenu+="<tr>";
			for (i=positionActuelle;i<positionActuelle+8;i++)
			{
				contenu+="<td>";
				if (liste2[i]!="")
				{
					longueur = liste2[i].length-10;
					image = liste2[i].substring(0, longueur);
					contenu+="<a href=\"javascript:;\" onClick=\"document.maxi.src='"+image+".jpg';\"><img src=\""+liste2[i]+"\" alt=\""+liste2[i]+"\" /></a>";
				}
				contenu+="</td>";
			}
			contenu+="</tr>";
			contenu+="</table>"
			document.getElementById("miniature").innerHTML = contenu;
		}
		if(positionActuelle==0)
		{
			if (document.all)
			{
				document.getElementById("left").style.display="none";
			}
			else
			{
				document.getElementById("left").setAttribute("style","display: none;");
			}
		}
	}
	
	function droite()
	{
		if (document.all)
		{
			document.getElementById("left").style.display="block";
		}
		else
		{
			document.getElementById("left").setAttribute("style","display: block;");
		}
		if (positionActuelle!=maximum-8)
		{
			var image="";
			var i=0;
			var contenu="";
			var longueur=0;
			var image="";
			contenu+="<table>";
			contenu+="<tr>";
			positionActuelle++;
			for (i=positionActuelle;i<positionActuelle+8;i++)
			{
				longueur = liste[i].length-10;
				image = liste[i].substring(0, longueur);
				contenu+="<td>";
				contenu+="<a href=\"javascript:;\" onClick=\"document.maxi.src='"+image+".jpg';\"><img src=\""+liste[i]+"\" alt=\""+liste[i]+"\" /></a>";
				contenu+="</td>";
			}
			contenu+="</tr>";
			contenu+="<tr>";
			for (i=positionActuelle;i<positionActuelle+8;i++)
			{
				contenu+="<td>";
				if (liste2[i]!="")
				{
					longueur = liste2[i].length-10;
					image = liste2[i].substring(0, longueur);
					contenu+="<a href=\"javascript:;\" onClick=\"document.maxi.src='"+image+".jpg';\"><img src=\""+liste2[i]+"\" alt=\""+liste2[i]+"\" /></a>";
				}
				contenu+="</td>";
			}
			contenu+="</tr>";
			contenu+="</table>"
			document.getElementById("miniature").innerHTML = contenu;
		}
		if(positionActuelle==maximum-8)
		{
			if (document.all)
			{
				document.getElementById("right").style.display="none";
			}
			else
			{
				document.getElementById("right").setAttribute("style","display: none;");
			}
		}
	}

				</script>
				<a href="javascript:gauche();" id="left" style="display: none;" ></a>
				<a href="javascript:droite();" id="right" ></a>
				<div id="miniature">
					<table>
						<tr>
					<?php

						for ($i=0; $i<8; $i++)
						{
							$fin=strlen($src[$i])-10;
							$image=substr($src[$i], 0, $fin).".jpg";
							echo "\n\t\t<td><a href=\"javascript:;\" onClick=\"document.maxi.src='".$image."';\"><img src=\"".$src[$i]."\" alt=\"".$src[$i]."\" /></a></td>";
						}
						
					?>
						</tr>
						<tr>
					<?php

						for ($i=0; $i<8; $i++)
						{
							echo "\n\t\t<td>";
							if ($src2[$i]!="")
							{
								$fin=strlen($src2[$i])-10;
								$image=substr($src2[$i], 0, $fin).".jpg";
								echo "\n\t\t<a href=\"javascript:;\" onClick=\"document.maxi.src='".$image."';\"><img src=\"".$src2[$i]."\" alt=\"".$src2[$i]."\" /></a>";
							}
							echo "</td>";
						}
						
					?>
						</tr>
					</table>
				</div>
				<div id="maxi">
				<?php
					$fin=strlen($src[0])-10;
					$image=substr($src[0], 0, $fin).".jpg";
				?>
					<img name="maxi" src="<?php echo $image; ?>" width="900" />
				</div>
			</div>
		</div>
	</body>
</html>