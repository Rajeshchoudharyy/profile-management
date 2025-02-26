<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\UserCategorySubcategory;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    /**
     * Display the profile detail page.
     */
    public function show(User $user)
    {
        // Ensure the user is not an admin (to avoid displaying admin profiles)
        if ($user->isAdmin()) {
            return redirect()->route('home')->with('error', 'Profile not found.');
        }
        
        $userCategorySubcategories = UserCategorySubcategory::where('user_id', $user->id)
            ->with(['category', 'subcategory'])
            ->get();
        
        return view('profile-detail', compact('user', 'userCategorySubcategories'));
    }
}