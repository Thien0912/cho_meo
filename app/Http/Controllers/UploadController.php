<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use App\Models\Upload;
use Illuminate\Http\Request;

class UploadController extends Controller
{
    public function index()
    {
        if (!Auth::check() || Auth::user()->role !== 'admin') {
            abort(403, 'Unauthorized.');
        }
        $uploads = Upload::all();
        return view('admin.uploads.index', compact('uploads'));
    }

    public function create()
    {
        return view('admin.uploads.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'file' => 'required|file|max:2048', // Giới hạn 2MB
        ]);

        $path = $request->file('file')->store('uploads');

        Upload::create([
            'file_path' => $path,
        ]);

        return redirect()->route('admin.uploads.index')
                         ->with('success', 'File uploaded successfully.');
    }

    public function destroy(Upload $upload)
    {
        $upload->delete();

        return redirect()->route('admin.uploads.index')
                         ->with('success', 'File deleted successfully.');
    }
}
