<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserCategorySubcategory extends Model
{
    use HasFactory;

    protected $table = 'user_category_subcategory';

    protected $fillable = [
        'user_id',
        'category_id',
        'subcategory_id'
    ];

    /**
     * Get the user that owns the record.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the category that owns the record.
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Get the subcategory that owns the record.
     */
    public function subcategory()
    {
        return $this->belongsTo(Subcategory::class);
    }
}