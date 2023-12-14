<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Review;
use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    //
    public function dashboard()
    {
        $bookCount = Book::count();
        $userCount = User::count();
        $reviewCount = Review::count();
        $userActivity = Review::userActivity();
        return view('admin.dashboard', compact('bookCount', 'userCount', 'reviewCount', 'userActivity'));
    }
}
