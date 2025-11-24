<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use hasFactory;
    protected $fillable = ['store_id', 'name', 'description', 'price'];

    public static function create(array $all)
    {
    }

    public static function findOrFail(string $id)
    {
    }

    public function store()
    {
        return $this->belongsTo(Store::class);
    }

    //
}
