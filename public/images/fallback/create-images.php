<?php
// Crea un'immagine hardware.jpg
$hardwareImg = imagecreatetruecolor(600, 400);
$bgColor = imagecolorallocate($hardwareImg, 237, 242, 247); // #edf2f7
$textColor = imagecolorallocate($hardwareImg, 26, 42, 54);  // #1a2a36
imagefill($hardwareImg, 0, 0, $bgColor);
imagestring($hardwareImg, 5, 220, 190, 'PrimoIT Hardware', $textColor);
imagejpeg($hardwareImg, 'hardware.jpg', 90);
imagedestroy($hardwareImg);

// Crea un'immagine mission.jpg
$missionImg = imagecreatetruecolor(600, 400);
$bgColor = imagecolorallocate($missionImg, 237, 242, 247); // #edf2f7
$textColor = imagecolorallocate($missionImg, 26, 42, 54);  // #1a2a36
imagefill($missionImg, 0, 0, $bgColor);
imagestring($missionImg, 5, 250, 190, 'Our Mission', $textColor);
imagejpeg($missionImg, 'mission.jpg', 90);
imagedestroy($missionImg);

// Crea un'immagine profile.jpg
$profileImg = imagecreatetruecolor(128, 128);
$bgColor = imagecolorallocate($profileImg, 237, 242, 247); // #edf2f7
$textColor = imagecolorallocate($profileImg, 26, 42, 54);  // #1a2a36
imagefill($profileImg, 0, 0, $bgColor);
imagestring($profileImg, 5, 55, 55, 'P', $textColor);
imagejpeg($profileImg, 'profile.jpg', 90);
imagedestroy($profileImg);

echo "Images created successfully!";
?> 