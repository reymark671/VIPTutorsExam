<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Scopes\ProductScope;
class Product extends Model
{
    //
    protected $fillable = ['user_id', 'title', 'description', 'price'];

    protected static function booted(): void
    {
        static::addGlobalScope(new ProductScope());
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
