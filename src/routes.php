<?php

use Slim\Http\Request;
use Slim\Http\Response;
use App\Models\Factory;

// Routes
$app->get('/lunch', 'App\Actions\ApiController:index');
