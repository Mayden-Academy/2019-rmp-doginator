<?php

namespace Doginator\Hydrators;

use Doginator\Entities\DogEntity;

class DogHydrator
{

   public static function getDogEntity($dbConnection, $breed_id)
   {

        $sql = 'SELECT `breed` . `id` , `breed` . `name`, `image`. `url` 
                FROM `breed` LEFT JOIN `image` ON `image` . `breed_id` = `breed` . `id` 
                WHERE `breed`.`id` = (:breed_id);';

        $statement = $dbConnection->prepare($sql);
        $statement->bindparam(':breed_id', $breed_id);
        $statement->execute();
        $results = $statement->fetchAll();
        $dogImgsArray = [];
        $name = $results [0]['name'];
        foreach ($results as $result) {
            $url = $result['url'];
            array_push($dogImgsArray, $url);
        }
        $dog = new DogEntity($breed_id, $name, $dogImgsArray);
        return $dog;

   }

   public static function getDogEntities($dbConnection)
   {
       $sql = 'SELECT `name`, `id` FROM `breed`;';
       $statement = $dbConnection->prepare($sql);
       $statement->execute();
       $results = $statement->fetchAll();
       $dogArray = [];
       foreach($results as $breed) {
           $id = $breed['id'];
           $name = $breed['name'];
           $dog = new DogEntity($id, $name);
           array_push($dogArray, $dog);
       }
       return $dogArray;
   }
}
