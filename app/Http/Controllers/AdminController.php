<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Subcategory;
use App\Models\User;
use App\Models\UserCategorySubcategory;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        $this->middleware(['auth', 'admin']);
    }

    /**
     * Show the admin dashboard.
     */
    public function index()
    {
        $categories = Category::with('subcategories')->get();
        $users = User::where('is_admin', false)->get();
        
        return view('admin.dashboard', compact('categories', 'users'));
    }

    /**
     * Show the create category form.
     */
    public function createCategory()
    {
        return view('admin.categories.create');
    }

    /**
     * Store a new category.
     */
    public function storeCategory(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:categories',
        ]);

        Category::create([
            'name' => $request->name,
        ]);

        return redirect()->route('admin.index')->with('success', 'Category created successfully!');
    }

    /**
     * Show the edit category form.
     */
    public function editCategory(Category $category)
    {
        return view('admin.categories.edit', compact('category'));
    }

    /**
     * Update the category.
     */
    public function updateCategory(Request $request, Category $category)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:categories,name,' . $category->id,
        ]);

        $category->update([
            'name' => $request->name,
        ]);

        return redirect()->route('admin.index')->with('success', 'Category updated successfully!');
    }

    /**
     * Delete the category.
     */
    public function destroyCategory(Category $category)
    {
        $category->delete();

        return redirect()->route('admin.index')->with('success', 'Category deleted successfully!');
    }

    /**
     * Show the create subcategory form.
     */
    public function createSubcategory()
    {
        $categories = Category::all();
        
        return view('admin.subcategories.create', compact('categories'));
    }

    /**
     * Store a new subcategory.
     */
    public function storeSubcategory(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
        ]);

        Subcategory::create([
            'name' => $request->name,
            'category_id' => $request->category_id,
        ]);

        return redirect()->route('admin.index')->with('success', 'Subcategory created successfully!');
    }

    /**
     * Show the edit subcategory form.
     */
    public function editSubcategory(Subcategory $subcategory)
    {
        $categories = Category::all();
        
        return view('admin.subcategories.edit', compact('subcategory', 'categories'));
    }

    /**
     * Update the subcategory.
     */
    public function updateSubcategory(Request $request, Subcategory $subcategory)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
        ]);

        $subcategory->update([
            'name' => $request->name,
            'category_id' => $request->category_id,
        ]);

        return redirect()->route('admin.index')->with('success', 'Subcategory updated successfully!');
    }

    /**
     * Delete the subcategory.
     */
    public function destroySubcategory(Subcategory $subcategory)
    {
        $subcategory->delete();

        return redirect()->route('admin.index')->with('success', 'Subcategory deleted successfully!');
    }

    /**
     * Show the form to assign categories and subcategories to users.
     */
    public function assignCategories(User $user)
    {
        $categories = Category::with('subcategories')->get();
        $userCategories = UserCategorySubcategory::where('user_id', $user->id)
            ->get()
            ->groupBy('category_id')
            ->map(function ($items) {
                return $items->pluck('subcategory_id')->toArray();
            })
            ->toArray();
        
        return view('admin.users.assign-categories', compact('user', 'categories', 'userCategories'));
    }

    /**
     * Store the assigned categories and subcategories for a user.
     */
    public function storeAssignedCategories(Request $request, User $user)
    {
        $request->validate([
            'categories' => 'array',
            'categories.*' => 'exists:categories,id',
            'subcategories' => 'array',
            'subcategories.*' => 'exists:subcategories,id',
        ]);
        // Delete existing assignments
        UserCategorySubcategory::where('user_id', $user->id)->delete();

        // Create new assignments
        if ($request->has('categories') ) {

            foreach ($request->categories as $categoryId) {
                if (isset($request->subcategories[$categoryId])) {
                    foreach ($request->subcategories[$categoryId] as $subcategoryId)

                        UserCategorySubcategory::create([
                            'user_id' => $user->id,
                            'category_id' => $categoryId,
                            'subcategory_id' => $subcategoryId,
                        ]);
                    }
                }
            }
        

        return redirect()->route('admin.index')->with('success', 'Categories assigned successfully!');
    }
}