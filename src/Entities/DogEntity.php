<?php

namespace Doginator\Entities;


class DogEntity
{
    private $breed_id;
    private $breed;
    private $images = [];

    public function __construct(int $breed_id = 1, string $breed = '', array $images=[])
    {
     $this->breed_id = $breed_id;
     $this->breed = $breed;
     $this->images = $images;

    }
    /**
     * @return integer
     */
    public function getBreedId()
    {
        return $this->breed_id;
    }

    /**
     * @return string
     */
    public function getBreed()
    {
        return $this->breed;
    }

    /**
     * @return array
     */
    public function getImages(): array
    {
        return $this->images;
    }
}
