<?php

$dossier=opendir(".");
$i=0;
while ($file=readdir($dossier))
{
	if ($i>=2)
	{
		$n=strlen($file)-4;
		$extension=substr($file, $n, 4);
		if ($extension==".jpg"  || $extension==".JPG")
		{
			$source = imagecreatefromjpeg($file);
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
			$nom=substr($file, 0, $n)."_petit.jpg";
			imagejpeg($destination, $nom);
		}
	}
	$i++;
}
closedir($dossier);

/* pour utiliser le script directement dans une page en include, ajouter en haut :
header ("Content-type: image/png");
et à la fin :
imagejpeg($destination);
on appelle l'image avec :
<img src="script.php"/>
*/

?>