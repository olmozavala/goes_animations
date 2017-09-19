<?php
  session_start();

  $nFile=scandir("images/");
  $ImageNom="Mexico_2017.0906.";
  //$lastDirectory=$nFile[2];
  //print($lastDirectory);
     
  $ruta_completa = "images/".$ImageNom ;
  $row_imagenes[0] = count($nFile)-2;

  $directory = "images/";
  $images = glob($directory . "*.jpg");
?>