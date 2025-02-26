<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subcategory extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'category_id'];

    /**
     * Get the category that owns the subcategory.
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Get the users associated with the subcategory.
     */
    public function users()
    {
        return $this->belongsToMany(User::class, 'user_category_subcategory')
            ->withPivot('category_id')
            ->withTimestamps();
    }
}