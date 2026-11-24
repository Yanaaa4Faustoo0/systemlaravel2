<?php

namespace App\Http\Controllers;

use App\Models\MembershipCategory;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class CategoryController extends Controller
{
    public function index() { return view('categories', ['categories' => MembershipCategory::orderBy('name')->get()]); }

    public function store(Request $request)
    {
        $data = $request->validate(['name' => ['required', 'string', 'max:100', 'unique:membership_categories,name'], 'description' => ['nullable', 'string']]);
        MembershipCategory::create($data);
        return back()->with('success', 'Category added.');
    }

    public function update(Request $request, MembershipCategory $category)
    {
        $data = $request->validate(['name' => ['required', 'string', 'max:100', Rule::unique('membership_categories', 'name')->ignore($category)], 'description' => ['nullable', 'string']]);
        $category->update($data);
        return back()->with('success', 'Category updated.');
    }

    public function destroy(MembershipCategory $category)
    {
        $category->delete();
        return back()->with('success', 'Category deleted.');
    }
}
