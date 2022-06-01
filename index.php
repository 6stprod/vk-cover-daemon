<?php

date_default_timezone_set('Europe/Moscow');

$token = "";
$group_id = "";
$v_api = '5.103';

$curleckCountMembers = file_get_contents("https://api.vk.com/method/groups.getMembers?group_id=".$group_id."&access_token=".$token."&v=".$v_api."");
$members = json_decode($curleckCountMembers)->response->count; // Получить количество участников сообщества

$img = ImageCreateFromJPEG("image.jpg");
$color = imagecolorallocate($img, 255, 255, 255); // Цвет RGB
$color_red = imagecolorallocate($img, 	150, 255, 205); // Цвет RGB
$font = __DIR__ .'/arial.ttf'; // Путь к шрифту

imagettftext($img, 20, 0, 500, 150, $color, $font, "Нас уже");
imagettftext($img, 30, 0, 628, 154, $color_red, $font, $members); // 0 - размер шрифта  0 - угол поворота  0 - смещение по горизонтали 0 - смещение по вертикали
imagejpeg($img, 'result.jpg', 100);


$imgPath = dirname(__FILE__).'./result.jpg';
$requestData = array('file' => new CURLFile($imgPath, 'image/jpeg', 'image0'));

$upload_url = file_get_contents("https://api.vk.com/method/photos.getOwnerCoverPhotoUploadServer?group_id=".$group_id."&crop_x2=1590&crop_y2=400&access_token=".$token."&v=".$v_api."");
$url = json_decode($upload_url)->response->upload_url;

$curl = curl_init();
curl_setopt($curl, CURLOPT_URL, $url);
curl_setopt($curl, CURLOPT_POST, true);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
curl_setopt($curl, CURLOPT_POSTFIELDS, $requestData);
$result = json_decode(curl_exec($curl),true);

$save = file_get_contents("https://api.vk.com/method/photos.saveOwnerCoverPhoto?hash=".$result['hash']."&photo=".$result['photo']."&access_token=".$token."&v=".$v_api."");

var_dump($save);

?>
<img src="result.jpg" />