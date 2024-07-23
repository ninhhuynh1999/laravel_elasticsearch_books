<?php

namespace App\Http\Controllers;

use App\Models\Category;
use DB;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;

class CategoryController extends Controller
{
    public function index(Request $request)
    {
        $categories = Category::all();
        return response()->json([
            'status' => 'success',
            'category' => $categories,
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'text' => 'required|string',
        ]);

        $category = Category::create([
            'name' => $request->name,
            'text' => $request->text,
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Category created successfully',
            'category' => $category,
        ]);
    }

    public function show($id)
    {
        $category = Category::find($id);
        return response()->json([
            'status' => 'success',
            'category' => $category,
        ]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string|max:255',
        ]);

        $category = Category::find($id);
        $category->title = $request->title;
        $category->description = $request->description;
        $category->save();

        return response()->json([
            'status' => 'success',
            'message' => 'Category updated successfully',
            'category' => $category,
        ]);
    }

    public function destroy($id)
    {
        $category = Category::find($id);
        $category->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Category deleted successfully',
            'category' => $category,
        ]);
    }
}
