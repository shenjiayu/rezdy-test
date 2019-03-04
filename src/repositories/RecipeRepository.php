<?php

namespace App\Repositories;

use App\Models\Recipe;

class RecipeRepository extends Repository
{
    protected static $path = '../public/data/recipes.json';

    public static function all($now)
    {
        $data = file_get_contents(self::$path);
        return self::process(json_decode($data, true), $now);
    }

    protected static function process($data, $now)
    {
        $collection = [];
        // get non-expired ingredients from the fridge
        $ingredients = IngredientRepository::all($now);
        foreach ($data['recipes'] as $recipeData) {
            $recipe = new Recipe($recipeData);
            $recipe->checkIngredients($ingredients, $now);
            if ($recipe->available()) {
                $collection[] = $recipe;
            }
        }

        return $collection;
    }

    public static function setPath($path)
    {
        self::$path = $path;
    }
}
