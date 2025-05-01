<?php

namespace App\Http\Controllers;

use App\Models\Breed;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BreedController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->only(['indexAdmin', 'create', 'store', 'edit', 'update', 'destroy']);
    }

    public function index()
    {
        $breeds = Breed::all();
        return view('breed', compact('breeds'));
    }

    public function indexAdmin()
    {
        $breeds = Breed::all();
        return view('admin.breed.index', compact('breeds'));
    }

    public function create()
    {
        return view('admin.breed.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|in:dog,cat',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $data = $request->only(['name', 'type', 'description']);

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $fileName = $file->getClientOriginalName(); // Lấy tên file gốc
            $path = $file->storeAs('breeds', $fileName, 'public'); // Lưu với tên gốc
            $data['image'] = $path;
        }

        Breed::create($data);

        return redirect()->route('admin.breeds.index')->with('success', 'Thêm giống thành công!');
    }

    public function edit(Breed $breed)
    {
        return view('admin.breed.edit', compact('breed'));
    }

    public function update(Request $request, Breed $breed)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|in:dog,cat',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $data = $request->only(['name', 'type', 'description']);

        if ($request->hasFile('image')) {
            // Xóa ảnh cũ nếu có
            if ($breed->image && Storage::disk('public')->exists($breed->image)) {
                Storage::disk('public')->delete($breed->image);
            }
            $file = $request->file('image');
            $fileName = $file->getClientOriginalName(); // Lấy tên file gốc
            $path = $file->storeAs('breeds', $fileName, 'public'); // Lưu với tên gốc
            $data['image'] = $path;
        }

        $breed->update($data);

        return redirect()->route('admin.breeds.index')->with('success', 'Cập nhật giống thành công!');
    }

    public function destroy(Breed $breed)
    {
        if ($breed->image && Storage::disk('public')->exists($breed->image)) {
            Storage::disk('public')->delete($breed->image);
        }

        $breed->delete();

        return redirect()->route('admin.breeds.index')->with('success', 'Xóa giống thành công!');
    }
}