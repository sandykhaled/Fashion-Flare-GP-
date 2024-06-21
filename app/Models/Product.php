<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{
    use HasFactory;
    protected $fillable = [
        'category_id',
        'name',
        'slug',
        'main_fabric',
        'pattern',
        'fit',
        'description',
        'price',
        'compare_price',
        'thickness',
        'sleeve_length',
        'occasion',
        'material',
        'gender',
    ];    public function images(): HasMany
    {
        return $this->hasMany(Image::class);
    }
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }
   public function colors(): BelongsToMany
   {
       return $this->belongsToMany(Color::class);
   }
}
