<?php

namespace Doginator\Hydrators;

//use Doginator\Entities\DogEntity;

class DogHydrator
{

   public function getDogEntity($connection, $breed_id)
   {
        $sql = 'SELECT `name`, `id` FROM `breed` WHERE `id` = (:breed_id);';

        $statement = $connection->prepare($sql);
        $statement->bindparam(':breed_id', $breed_id);
        $statement->execute();
        $results = $statement->fetch();
        var_dump($results);
//        $dog = new DogEntity()
   }
}
