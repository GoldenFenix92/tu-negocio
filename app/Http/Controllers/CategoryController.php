<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\Routing\Controller as BaseController;

class CategoryController extends BaseController
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(): View
    {
        $categories = Category::latest()->paginate(24);
        return view('categories.index', compact('categories'));
    }

    public function create(): View
    {
        return view('categories.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'name' => 'required|string|max:255|unique:categories,name',
            'is_active' => 'boolean',
            'image' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('categories', 'public');
        }

        Category::create($data);

        return redirect()->route('categories.index')->with('success', 'Categoría creada exitosamente.');
    }



    public function edit(Category $category): View
    {
        return view('categories.edit', compact('category'));
    }

    public function update(Request $request, Category $category): RedirectResponse
    {
        $data = $request->validate([
            'name' => 'required|string|max:255|unique:categories,name,' . $category->id,
            'is_active' => 'boolean',
            'image' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('image')) {
            if ($category->image) {
                Storage::disk('public')->delete($category->image);
            }
            $data['image'] = $request->file('image')->store('categories', 'public');
        }

        $category->update($data);

        return redirect()->route('categories.index')->with('success', 'Categoría actualizada exitosamente.');
    }

    public function destroy(Category $category): RedirectResponse
    {
        // Check if category has products
        if ($category->products()->count() > 0) {
            return redirect()->route('categories.index')->with('error', 'No se puede eliminar la categoría porque tiene productos asociados.');
        }

        if ($category->image) {
            Storage::disk('public')->delete($category->image);
        }

        $category->delete();

        return redirect()->route('categories.index')->with('success', 'Categoría eliminada exitosamente.');
    }

    public function toggle(Category $category): RedirectResponse
    {
        $category->update(['is_active' => !$category->is_active]);

        $message = $category->is_active ? 'Categoría habilitada.' : 'Categoría deshabilitada.';

        return redirect()->route('categories.index')->with('success', $message);
    }

    public function destroyImage(Category $category): RedirectResponse
    {
        if ($category->image) {
            $imageName = basename($category->image);

            if ($imageName !== 'categoria_comodin.webp') {
                Storage::disk('public')->delete($category->image);
                $category->image = null;
                $category->save();
                return back()->with('success', 'Imagen de la categoría eliminada correctamente.');
            }
        }
        return back()->with('info', 'La categoría no tiene una imagen personalizada para eliminar.');
    }
}
