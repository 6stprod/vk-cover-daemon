<?php

date_default_timezone_set('Europe/Moscow');

$intervalHeck = 60; // sleep 60 sec

while (true) {
    $hour = (new \DateTime('now'))->format('H');
    if ($hour == 10 || $hour == 18) {
		file_get_contents("https://site.ru/you_script.php");
        echo 'The script worked' . PHP_EOL;
   }

    sleep($intervalHeck);
}


