<?php

namespace App\Models;

class Ingredient extends BaseModel
{

    public function __construct($attributes)
    {
        ['title' => $title, 'best-before' => $bestBefore, 'use-by' => $useBy] = $attributes;
        $this->attributes['title'] = $title;
        $this->attributes['best-before'] = $bestBefore;
        $this->attributes['use-by'] = $useBy;
    }

    public function getAttribute($key)
    {
        return $this->attributes[$key];
    }

    public function isExpired($now)
    {
        if ($now > $this->attributes['use-by']) {
            return true;
        }
        return false;
    }

    public function toBeExpired($now)
    {
        if ($now < $this->attributes['use-by'] && $now > $this->attributes['best-before']) {
            return true;
        }
        return false;
    }
}
