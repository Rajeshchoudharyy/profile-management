<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    /**
     * Get the subcategories for the category.
     */
    public function subcategories()
    {
        return $this->hasMany(Subcategory::class);
    }

    /**
     * Get the users associated with the category.
     */
    public function users()
    {
        return $this->belongsToMany(User::class, 'user_category_subcategory')
            ->withPivot('subcategory_id')
            ->withTimestamps();
    }
}