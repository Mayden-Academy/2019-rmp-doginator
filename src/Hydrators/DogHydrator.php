<?php

namespace Doginator\Hydrators;

use Doginator\Entities\DogEntity;

class DogHydrator
{
    /**
     * @param \PDO
     * @param int
     *
     * @return DogEntity
     */
   public static function getDogEntity(\PDO $dbConnection, int $breed_id): DogEntity
   {

        $sql = 'SELECT `breed` . `id` , `breed` . `name`, `image`. `url` 
                FROM `breed` LEFT JOIN `image` ON `image` . `breed_id` = `breed` . `id` 
                WHERE `breed`.`id` = (:breed_id);';


       $statement = $dbConnection->prepare($sql);
       $statement->bindparam(':breed_id', $breed_id);
       try {
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
       } catch(\PDOException $exception) {
           echo 'Unexpected error occurred';
       }
   }

    /**
     * @param \PDO
     *
     * @return array
     */
   public static function getDogEntities(\PDO $dbConnection): array
   {
       $sql = 'SELECT `name` AS "breed", `id` AS "breed_id" FROM `breed`;';
       $statement = $dbConnection->prepare($sql);
       try {
           $statement->execute();
           return $statement->fetchAll(\PDO::FETCH_CLASS|\PDO::FETCH_PROPS_LATE, DogEntity::class);
       } catch(\PDOException $exception) {
           echo 'Unexpected error occurred';
       }
   }
}
