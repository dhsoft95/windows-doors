<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductFeature extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'features',
        'sort_order'
    ];

    protected $casts = [
        'features' => 'array',
    ];

    // Modified mutator to handle single string values
    public function setFeaturesAttribute($value)
    {
        // If it's a string (coming from form), wrap it in an array
        if (is_string($value) && !is_null($value)) {
            $this->attributes['features'] = json_encode([$value]);
        }
        // Handle normal array input
        else if (is_array($value)) {
            $this->attributes['features'] = json_encode($value);
        }
        // Handle empty values
        else {
            $this->attributes['features'] = json_encode([]);
        }
    }

    // Accessor to ensure we always get an array
    public function getFeaturesAttribute($value)
    {
        if (empty($value)) {
            return [];
        }

        // Always decode JSON string to array
        return is_string($value) ? json_decode($value, true) : $value;
    }



    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
