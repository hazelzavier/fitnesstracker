<?php

namespace App\Http\Controllers;

use App\Models\Clothing;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WardrobeController extends Controller
{
    // Display the wardrobe items
    public function index()
    {
        $clothingItems = Clothing::where('user_id', Auth::id())->get();
        return view('wardrobe.index', compact('clothingItems'));
    }

    // Store a new clothing item
    public function store(Request $request)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $imageName = time().'.'.$request->image->extension();  
        $request->image->move(public_path('storage'), $imageName);

        Clothing::create([
            'user_id' => Auth::id(),
            'image' => $imageName,
            'name' => $request->name ?? 'Unnamed Item',
        ]);

        return redirect()->route('wardrobe.index');
    }

}