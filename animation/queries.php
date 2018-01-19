<?php
  session_start();

  $nFile=scandir("images/");
  $ImageNom="Mexico_2018.".date("m");
  //print($ImageNom);
  $ruta_completa = "images/".$ImageNom ;
  $row_imagenes[0] = count($nFile)-2;

  $directory = "images/";
  $imagestmp = glob($directory . "*.jpg");
  //print_r($imagestmp);
  $images = preg_grep("~Mexico_2018.".date("m").date("d")."~", $imagestmp);
  $images = array_values($images);
  $row_imagenes[0] = count($images)-1;
  //print_r($images);
?>
