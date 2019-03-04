<?php

namespace App\Models;

class Recipe extends BaseModel
{
    
    public function __construct($attributes)
    {
        ['title' => $title, 'ingredients' => $ingredients] = $attributes;
        $this->attributes['title'] = $title;
        $this->attributes['ingredients'] = $ingredients;
        $this->attributes['available'] = true;
        $this->attributes['rating'] = 0;
    }

    public function checkIngredients($ingredients, $now)
    {
        foreach ($this->attributes['ingredients'] as $key) {
            if (array_key_exists($key, $ingredients)) {
                $ingredient = $ingredients[$key];
                if ($ingredient->toBeExpired($now)) {
                    $this->attributes['rating'] += 1;
                }
            } else {
                $this->attributes['available'] = false;
            }
        }
    }

    public function available()
    {
        return $this->attributes['available'];
    }

    public function rating()
    {
        return $this->attributes['rating'];
    }

    public function toArray()
    {
        return [
            'title' => $this->attributes['title'],
            'ingredients' => $this->attributes['ingredients']
        ];
    }
}
