<?php

// Crée une nouvelle image de 200x200 pixels
$image = imagecreatetruecolor(200, 200);

// Définit la couleur de fond
$background_color = imagecolorallocate($image, 255, 255, 255); // Blanc
imagefill($image, 0, 0, $background_color);

// Définit les couleurs pour les yeux, les cheveux et la peau
$eye_color = imagecolorallocate($image, 0, 0, 0); // Noir
$hair_color = imagecolorallocate($image, 128, 78, 42); // Marron
$skin_color = imagecolorallocate($image, 255, 218, 185); // Peau claire

// Dessine les yeux
$eye_radius = 20;
$eye_x = 75;
$eye_y = 75;
imagefilledellipse($image, $eye_x, $eye_y, $eye_radius, $eye_radius, $eye_color);
imagefilledellipse($image, 125, 75, $eye_radius, $eye_radius, $eye_color);

// Dessine les cheveux
$hair_width = 150;
$hair_height = 100;
$hair_x = 25;
$hair_y = 100;
imagefilledellipse($image, $hair_x, $hair_y, $hair_width, $hair_height, $hair_color);

// Dessine le visage
$face_width = 150;
$face_height = 150;
$face_x = 25;
$face_y = 25;
imagefilledellipse($image, $face_x, $face_y, $face_width, $face_height, $skin_color);

// Affiche l'image générée
header('Content-Type: image/png');
imagepng($image);

// Libère la mémoire utilisée par l'image
imagedestroy($image);

?>
