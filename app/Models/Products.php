<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Products extends Model
{
    use HasFactory;

    protected $fillable = ['Nom', 'prix', 'Quantité', 'image', 'categorie_id'];

    public function category()
    {
        return $this->belongsTo(Categories::class, 'categorie_id');
    }

    public function orders()
    {
        return $this->belongsToMany(Orders::class, 'order_product')
            ->withPivot('Quantité', 'prix')
            ->withTimestamps();
    }
}
