<?php

namespace App\Models;

use Vinelab\NeoEloquent\Eloquent\Model as NeoEloquent;

class Product extends NeoEloquent
{
    protected $label = 'Product'; 
    protected $fillable = ['name', 'description', 'price', 'quantity'];
}
