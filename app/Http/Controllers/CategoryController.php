<?php

namespace App\Http\Controllers;

use App\Http\Requests\CategoryCreateRequest;
use App\Http\Requests\CategoryUpdateRequest;
use App\Models\Category;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::where('user_id', Auth::id())->get();
        return view('category.index', compact('categories'));
    }

    public function create()
    {
        return view('category.create');
    }

    public function store(CategoryCreateRequest $request)
    {
        Category::create([
            'name' => $request->name,
            'color' => $request->color,
            'user_id' => Auth::id(),
        ]);

        return redirect()->route('category.index')->with('success', 'Categoria criada com sucesso!');
    }

    public function edit(Category $category)
    {
        if ($category->user_id !== Auth::id()) {
            return redirect()->route('category.index')->with('error', 'Categoria não encontrada.');
        }

        return view('category.edit', compact('category'));
    }

    public function update(CategoryUpdateRequest $request, Category $category)
    {
        if ($category->user_id !== Auth::id()) {
            return redirect()->route('category.index')->with('error', 'Categoria não encontrada.');
        }

        $data = $request->validated();
        DB::transaction(function () use ($category, $data) {
            $category->update([
                'name' => $data['name'],
                'color' => $data['color'],
            ]);
        });

        return Redirect::route('category.index')->with('success', 'Categoria atualizada com sucesso!');
    }

    public function destroy(Category $category)
    {
        if ($category->user_id !== Auth::id()) {
            return redirect()->route('category.index')->with('error', 'Categoria não encontrada.');
        }

        $category->delete();

        return Redirect::route('category.index')->with('success', 'Categoria excluída com sucesso!');
    }
}
