<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Scopes\ProductScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class Product extends Model
{
    //
    use HasFactory;
    protected $fillable = ['user_id', 'title', 'description', 'price','del_flag','quantity','image'];

    protected static function booted(): void
    {
        static::addGlobalScope(new ProductScope());
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
