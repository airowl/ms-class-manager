<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;

class Classroom extends Model
{
    protected $collection = 'classrooms';

    //protected function categoryId(): Attribute
    //{
    //    return Attribute::make(
    //        get: fn (string $value) => Category::find($value),
    //    );
    //}

    // funzione per prendere tutti i homework

    // function per prendere tutti i notification
}
