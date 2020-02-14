<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Business extends Model
{
    protected $fillable = ['name', 'url', 'user_id', 'description', 'category', 
        'rating', 'rating_buildzoom', 'phone', 'email', 'website', 
        'is_licensed', 'license_info', 'insured_value', 'bond_value',
        'street_address', 'city', 'state', 'zipcode', 'full_address',
        'image', 'employee', 'work_preferences'];

    public function getImageAttribute($value) {
        if($value != null) {
            return config('api.fullPath') . $value;
        }
    }
}
