<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class NewsUserController extends Controller
{
    public function index()
    {
        return view('user.news');
    }

    public function newsView()
    {
        return view('publicNews');
    }
}
