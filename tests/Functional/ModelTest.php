<?php

namespace Tests\Functional;

use App\Models\Ingredient;
use App\Models\Recipe;
use App\Repositories\IngredientRepository;

class ModelTest extends BaseTestCase
{
    /**
     * It should test isExpired of the Ingredient model,
     */
    public function testIsExpired()
    {
        $now = '2019-01-09';
        
        // already expired
        $ingredient = new Ingredient([
            'title' => 'Ham',
            'best-before' => '2019-01-01',
            'use-by' => '2019-01-08'
        ]);

        $this->assertTrue($ingredient->isExpired($now));

        // has not been expired
        $ingredient = new Ingredient([
            'title' => 'Lamb',
            'best-before' => '2019-01-01',
            'use-by' => '2019-01-10'
        ]);

        $this->assertTrue(! $ingredient->isExpired($now));
    }

    /**
     * It should test toBeExpired of the Ingredient model,
     */
    public function testToBeExpired()
    {
        $now = '2019-01-09';

        // to be expired
        $ingredient = new Ingredient([
            'title' => 'Ham',
            'best-before' => '2019-01-01',
            'use-by' => '2019-01-10'
        ]);

        $this->assertTrue($ingredient->toBeExpired($now));

        // already expired
        $ingredient = new Ingredient([
            'title' => 'Lamb',
            'best-before' => '2019-01-01',
            'use-by' => '2019-01-08'
        ]);

        $this->assertTrue(! $ingredient->toBeExpired($now));

        // fresh
        $ingredient = new Ingredient([
            'title' => 'Lamb',
            'best-before' => '2019-01-10',
            'use-by' => '2019-01-12'
        ]);

        $this->assertTrue(! $ingredient->toBeExpired($now));
    }

    /**
     * It should test checkIngredients function
     */
    public function testCheckIngredients()
    {
        $recipe = new Recipe([
            "title" => "Ham and Cheese Toastie",
            "ingredients" => [
                "Ham",
                "Cheese",
                "Bread",
                "Butter"
            ]
        ]);

        IngredientRepository::setPath('public/data/ingredients.json');

        // available
        $now = '2019-01-01';
        $ingredients = IngredientRepository::all($now);
        $recipe->checkIngredients($ingredients, $now);
        $this->assertTrue($recipe->available());

        $now = '2019-05-05';
        $ingredients = IngredientRepository::all($now);
        $recipe->checkIngredients($ingredients, $now);
        $this->assertTrue(! $recipe->available());
    }

    /**
     * It test the structure of toArray function
     */
    public function testToArray()
    {
        $recipe = new Recipe([
            "title" => "Ham and Cheese Toastie",
            "ingredients" => [
                "Ham",
                "Cheese",
                "Bread",
                "Butter"
            ]
        ]);

        $arr = $recipe->toArray();
        $this->assertArrayHasKey('title', $arr);
        $this->assertArrayHasKey('ingredients', $arr);
    }
}
