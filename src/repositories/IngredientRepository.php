<?php

namespace App\Repositories;

use App\Models\Ingredient;

class IngredientRepository extends Repository
{

    protected static $path = '../public/data/ingredients.json';

    public static function all($now)
    {
        $data = file_get_contents(self::$path);
        return self::process(json_decode($data, true), $now);
    }

    protected static function process($data, $now)
    {
        $collection = [];
        foreach ($data['ingredients'] as $d) {
            $ingredient = new Ingredient($d);
            if (!$ingredient->isExpired($now)) {
                $collection[$ingredient->getAttribute('title')] = $ingredient;
            }
        }
        return $collection;
    }

    public static function setPath($path)
    {
        self::$path = $path;
    }
}
