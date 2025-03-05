<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class AdminController extends Controller
{
    //
    public function users(){
        $users = User::with('products')->get();
        return view('admin.index', compact('users'));
    }
}
