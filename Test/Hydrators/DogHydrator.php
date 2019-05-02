<?php

use PHPUnit\Framework\TestCase;
use Doginator\Hydrators\DogHydrator;
require_once '../../src/Entities/DogEntity.php';
require_once '../../src/Hydrators/DogHydrator.php';
require_once '../../src/DBconnector.php';

class TestDogHydrator extends TestCase
{
    public function testGetDogEntity ()
    {
        $dbConnector = new \Doginator\DBconnector();
        $dbConnection = $dbConnector->getConnection();
        $dog = DogHydrator::getDogEntity($dbConnection, 2);
        $dogImagesUrl = $dog->getImages();
        $dogId = $dog->getBreedId();
        $dogBreed = $dog->getBreed();

        $this->assertEquals(2, $dogId);
        $this->assertEquals('african', $dogBreed);
        $this->assertEquals('https://images.dog.ceo/breeds/african/n02116738_10024.jpg', $dogImagesUrl[0]);
    }

    public function testGetDogEntities ()
    {
        $dbConnector = new \Doginator\DBconnector();
        $dbConnection = $dbConnector->getConnection();
        $allDogEntities = DogHydrator::getDogEntities($dbConnection);
        $dogName0 = $allDogEntities[0]->getBreed();
        $dogName1 = $allDogEntities[1]->getBreed();

        $this->assertEquals('affenpinscher', $dogName0);
        $this->assertEquals('african', $dogName1);
    }
}


