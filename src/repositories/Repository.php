<?php

namespace App\Repositories;

abstract class Repository
{

    // path to the file, e.g recipes.json, ingredients.json
    // could be replaced with a db connection
    protected static $path;

    // entry for any repositories to get records
    abstract public static function all($now);

    // process the data and return
    abstract protected static function process($data, $now);

    // set path for testing purpose
    abstract public static function setPath($path);
}
