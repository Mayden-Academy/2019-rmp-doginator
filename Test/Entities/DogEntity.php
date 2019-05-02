<?php

use PHPUnit\Framework\TestCase;
use Doginator\Entities\DogEntity;
require_once '../../src/Entities/DogEntity.php';


class TestDogEntity extends TestCase
{
    public function testGetBreedID ()
    {
        $dog = new DogEntity(1, "colly");
        $dogID = $dog->getBreedId();

        $this->assertEquals(1, $dogID);
    }

    public function testGetBreed ()
    {
        $dog = new DogEntity(1, "colly");
        $dogBreed = $dog->getBreed();

        $this->assertEquals('colly', $dogBreed);
    }

    public function testGetImages ()
    {
        $dog = new DogEntity(1, "colly", ['url.com']);
        $dogImgs = $dog->getImages();

        $this->assertEquals(['url.com'], $dogImgs);
    }

    public function testGetBreedID_failure ()
    {
        $this->expectException(TypeError::class);
        new DogEntity([], 'rty');
    }

    public function testGetBreed_failure ()
    {
        $this->expectException(TypeError::class);
        new DogEntity(1, []);
    }

    public function testGetImages_failure ()
    {
        $this->expectException(TypeError::class);
        new DogEntity(1, "colly", 'dfg');
    }
}
