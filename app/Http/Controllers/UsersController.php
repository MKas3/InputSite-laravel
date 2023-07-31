<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Http\Request;
use App\Models\User;
use Auth;

class UsersController extends Controller
{
    public function index() {
        $user = Auth::user();
        
        return view('profile', compact('user'));
    }

    public function store() {
        request()->validate([
            'image' => 'required|image|max:2048',
        ]);
    
        $imagePath = request()->file('image')->storeAs(
            'public/uploads', request()->user()->id.'.jpg'
        );
    
        Auth::user()->update(['image' => $imagePath]);
    
        return redirect('/profile')->with('success');
    }
}
