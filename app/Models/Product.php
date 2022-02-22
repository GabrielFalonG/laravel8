<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'products';

    protected $fillable = [
      'name',
      'description',
      'price'
    ];

    public static function rules($product = null)
    {
        return [
            'name'          => 'required|string|unique:products,name,' . ($product ? $product->id : 'NULL') . ',id,deleted_at,NULL',
            'description' => 'nullable|string',
            'price'          => 'required|string',
            'photo'         => 'nullable|mimes:jpg,png,jpeg|max:5048'
        ];
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
