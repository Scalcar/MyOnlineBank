<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ContactUserController extends Controller
{
    public function index()
    {
        return view('user.contact');
    }

    public function contact()
    {
        return view('publicContact');
    }
}
