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

/**
 * Helper function for making API calls.
 * @param string $url is the url that you are making the API call to.
 * @return stdClass is the Json response converted to php array.
 */
function makeAPICall(string $url): stdClass {
    // create curl resource
    $curlRequest = curl_init();

    //set url
    curl_setopt($curlRequest, CURLOPT_URL, $url);

    //return the transfer as a string
    curl_setopt($curlRequest, CURLOPT_RETURNTRANSFER, 1);

    //$response contains the output string
    $response = curl_exec($curlRequest);

    //close curl resource to free up system resources.
    curl_close($curlRequest);

    //converts to $response into php object and then return it
    return json_decode($response);
}

/**
 * insertBreed inserts the breed name into the breeds table
 * @param $db  connection to data-base
 * @param $breedName contains the breed name.
 */
function insertBreed($db, $breedName) {
    echo $breedName . "\n";
    $statement = $db->prepare('INSERT INTO `breed` (name) VALUES (:bname)');
    $statement->execute([
        'bname' => $breedName
    ]);
}

$responseObj = makeAPICall("https://dog.ceo/api/breeds/list/all");
$responseObj = $responseObj->message;
$breeds = [];
echo "Populating breed table\n";

foreach ($responseObj as $breed => $value) {
    $breedName;
    if (count($value) > 0) {
        foreach ($value as $subBreed) {
            $breedName = $breed . "/" . $subBreed;
            array_push($breeds, $breedName);
            insertBreed($db, $breedName);
        }
    } else {
        $breedName = $breed;
        array_push($breeds, $breedName);
        insertBreed($db, $breedName);
    }
}

echo "Populating the images table\n";

$breedId = 1;
foreach ($breeds as $breed) {
    $responseObj = makeAPICall('https://dog.ceo/api/breed/' . $breed . '/images');
    $responseObj = $responseObj->message;
    foreach ($responseObj as $url) {
        echo $url . "\n";
        $statement = $db->prepare('INSERT INTO `image` (url, breed_id) VALUES (:url, :breed_id)');
        $statement->execute([
             'url' => $url,
            'breed_id' => $breedId,
        ]);
    } 
    $breedId++;
}