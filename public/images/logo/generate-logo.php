<?php
// Creiamo un'immagine PNG con uno sfondo trasparente
$width = 600;
$height = 300;
$image = imagecreatetruecolor($width, $height);

// Abilita la trasparenza
imagesavealpha($image, true);
$transparent = imagecolorallocatealpha($image, 0, 0, 0, 127);
imagefill($image, 0, 0, $transparent);

// Colore beige chiaro per il logo (come nell'immagine)
$logoColor = imagecolorallocate($image, 234, 233, 226); // #eae9e2

// Disegniamo il camion
// Corpo del camion
$truckBody = [
    440, 100,
    550, 100,
    550, 70,
    500, 70,
    470, 40,
    440, 40,
    440, 100
];
imagefilledpolygon($image, $truckBody, count($truckBody)/2, $logoColor);

// Cabina del camion
$truckCab = [
    420, 100,
    440, 100,
    440, 40,
    420, 40,
    420, 100
];
imagefilledpolygon($image, $truckCab, count($truckCab)/2, $logoColor);

// Ruote
imagefilledellipse($image, 450, 110, 40, 40, $logoColor);
imagefilledellipse($image, 530, 110, 40, 40, $logoColor);

// Linee di velocità
imagesetthickness($image, 8);
imageline($image, 150, 40, 420, 40, $logoColor);
imageline($image, 170, 60, 420, 60, $logoColor);
imageline($image, 190, 80, 420, 80, $logoColor);
imageline($image, 210, 100, 420, 100, $logoColor);

// Chip/processore sul camion
imagefilledrectangle($image, 470, 60, 500, 90, $transparent);
imagerectangle($image, 470, 60, 500, 90, $logoColor);
imagesetthickness($image, 3);
imageline($image, 480, 65, 480, 85, $logoColor);
imageline($image, 490, 65, 490, 85, $logoColor);
imageline($image, 475, 75, 495, 75, $logoColor);

// Testo "PrimoIT"
$font_size = 80;
$text = "PrimoIT";
$font_path = realpath('./font.ttf'); // Usiamo il default font interno
$bbox = imagettfbbox($font_size, 0, $font_path, $text);
$text_width = $bbox[2] - $bbox[0];
$text_x = 150;
$text_y = 200;

// Se non è disponibile il font TTF, usiamo una stringa di testo semplice
if (!file_exists($font_path)) {
    imagestring($image, 5, $text_x, $text_y - 40, $text, $logoColor);
} else {
    imagettftext($image, $font_size, 0, $text_x, $text_y, $logoColor, $font_path, $text);
}

// Salva l'immagine
imagepng($image, 'primoit-logo.png');
imagedestroy($image);

echo "Logo created successfully!";
?> 