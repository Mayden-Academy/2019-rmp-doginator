<?php

$db = new PDO("mysql:host=192.168.20.20;dbname=doginator", 'root', '');
$db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

$sqlDropImage = "DROP TABLE IF EXISTS `image`;";
$queryDropImage = $db->prepare($sqlDropImage);
$queryDropImage->execute();

$sqlDropBreed = "DROP TABLE IF EXISTS `breed`;";
$queryDropBreed = $db->prepare($sqlDropBreed);
$queryDropBreed->execute();


$sqlCreateBreed = "CREATE TABLE `breed` (
                  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
                 `name` varchar(256) NOT NULL DEFAULT '',
                   PRIMARY KEY (`id`)
                  ) ENGINE=InnoDB DEFAULT CHARSET=latin1;";
$queryCreateBreed = $db->prepare($sqlCreateBreed);
$queryCreateBreed->execute();

$sqlCreateImage = "CREATE TABLE `image` (
                  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
                  `url` varchar(2048) NOT NULL DEFAULT '',
                  `breed_id` int(11) unsigned NOT NULL,
                  PRIMARY KEY (`id`),
                  KEY `breed_id` (`breed_id`),
                  CONSTRAINT `image_ibfk_1` FOREIGN KEY (`breed_id`) REFERENCES `breed` (`id`)
                ) ENGINE=InnoDB DEFAULT CHARSET=latin1;";
$queryCreateImage = $db->prepare($sqlCreateImage);
$queryCreateImage->execute();

// create curl resource
$ch = curl_init();

// set url
curl_setopt($ch, CURLOPT_URL, "https://dog.ceo/api/breeds/list/all");

//return the transfer as a string
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

// $output contains the output string
$output = curl_exec($ch);

// close curl resource to free up system resources
curl_close($ch);

$obj = json_decode($output, true);
//var_dump($obj);
$breeds = [];


foreach ($obj["message"] as $breed => $value) {
    if(count($value) > 1){
        foreach($value as $sub) {
            $subBreed = $breed . "-" . $sub . "\n";
            $breeds[] = $subBreed;
        }
    } else {
        $dog = $breed ."\n";
        $breeds[] = $dog;
    }
}

var_dump($breeds);
