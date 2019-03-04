<?php

namespace Tests\Functional;

use App\Repositories\IngredientRepository;
use App\Repositories\RecipeRepository;

class RepositoryTestCase extends BaseTestCase
{
    /**
     * It should test that the all function of IngredientRepository,
     * it should return correct length of records
     */
    public function testIngredientAll()
    {
        IngredientRepository::setPath('public/data/ingredients.json');

        // nothing is expired at this moment
        $ingredients = IngredientRepository::all('2019-01-01');
        $this->assertEquals(count($ingredients), 16);

        // everything should be expired by this date
        $ingredients = IngredientRepository::all('2019-05-05');
        $this->assertEquals(count($ingredients), 0);
    }

    /**
     * It should test the all function of RecipeRepository,
     * it should return correct length of records
     */
    public function testRecipeAll()
    {
        IngredientRepository::setPath('public/data/ingredients.json');
        RecipeRepository::setPath('public/data/recipes.json');

        // only three recipes are available
        $recipes = RecipeRepository::all('2019-01-01');
        $this->assertEquals(count($recipes), 3);

        // no recipe is available
        $recipes = RecipeRepository::all('2019-05-05');
        $this->assertEquals(count($recipes), 0);
    }
}
