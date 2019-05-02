<?php

require_once 'vendor/autoload.php';
use Doginator\DBconnector;
use Doginator\Hydrators\DogHydrator;

$dbConnector = new DBconnector();
$dbConnection= $dbConnector->getConnection();

$allDogEntities = DogHydrator::getDogEntities($dbConnection);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>DOGINATOR || Gallery</title>
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="CSS/normalize.css" type="text/css">
    <link rel="stylesheet" href="CSS/style.css" type="text/css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>
    <div class="container">
        <div class="row">
            <div class="col-3">
                <img src="Assets/Images/logo.svg" class="logo">
            </div>

            <div class="col-6 header">
                <img src="Assets/Images/bone.svg" class="bone gallery-bone">
                <h1 class="gallery-title">DOGINATOR</h1>
            </div>

            <div class="col-3">
                <img src="Assets/Images/logo.svg" class="logo">
            </div>
        </div>
        <?php
                if(empty($_GET['id']) || $_GET['id'] < 1 || !is_numeric($_GET['id'])){
                    echo '<div class="alert alert-danger">You have not selected a valid breed. Please select one from the dropdown below</div>';
                } else {
                    $id = $_GET['id'];
                    $dbConnection = new DBconnector();
                    $dog = DogHydrator::getDogEntity($dbConnection->getConnection(), $id);
                }
        ?>
        <div class="dropdown show gallery-dropdown">
            <a class="btn btn-secondary dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <?php
                if (!empty($dog)) {
                    echo $dog->getBreed();
                } else {
                    echo 'No breed selected';
                }
                ?>
            </a>

            <div class="dropdown-menu scrollable-menu" id="dropdown-content" aria-labelledby="dropdownMenuLink">
                <!--links to populate with foreach loop in php-->
                <?php
                foreach ($allDogEntities as $dogEntity) {
                    echo '<a class="dropdown-item" href="gallery.php?id=' . $dogEntity->getBreedId() . '">' . $dogEntity->getBreed() . '</a>';
                }
                ?>
            </div>
        </div>

            <div class="row">
                <?php
                    if (empty($dog) || empty($dog->getImages())) {
                        echo '<p class="alert alert-danger">There is no pictures for this breed</p>';
                    } else {
                        foreach ($dog->getImages() as $image) {
                            echo '<div class="col-4 img-container">
                                  <img src="'. $image . '">
                                  </div>';
                        }
                    }
                ?>
            </div>

    </div>
</body>
</html>