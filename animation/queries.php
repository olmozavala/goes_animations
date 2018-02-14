<?php
	session_start();

    // Reads all the images in the folder (TODO separate in folders)
	$currFolder = "images/";
	$ruta_completa = $currFolder ."/". $ImageNom;
	$img_names = glob($currFolder. "*.jpg");
?>
