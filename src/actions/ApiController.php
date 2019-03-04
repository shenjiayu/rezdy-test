<?php

namespace App\Actions;

use Slim\Http\Request;
use Slim\Http\Response;
use App\Repositories\RecipeRepository;

class ApiController extends Action
{

    public function index(Request $request, Response $response, $args)
    {
        // get params from url in case any passed in
        $dateParam = $request->getParam('date', null);
        if ($dateParam) {
            $now = date_create_from_format('Y-m-d', $dateParam)->format('Y-m-d');
        } else {
            $now = date('Y-m-d');
        }

        $filteredRecipes = RecipeRepository::all($now);

        // sort the final recipes order by rating
        usort($filteredRecipes, function ($a, $b) {
            return $a->rating() - $b->rating();
        });

        // only return meaningful attributes
        $formatted = array_map(function ($r) {
            return $r->toArray();
        }, $filteredRecipes);

        return $response->withJson($formatted);
    }
}
