<?php

namespace App\Http\Controllers;

use App\Http\Requests\AdminCheckRequest;
use App\Http\Requests\AdminCreateRequest;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function index()
    {
        return view('admin.forms.add_admin');
    }

    public function create(AdminCreateRequest $request)
    {
        if($request->validated())
        {
            $admin = new Admin();
            $admin->name = $request->name;
            $admin->email = $request->email;
            $admin->password = Hash::make($request->password);
            $save = $admin->save();

            if( $save ){
                return redirect()->back()->with('success','Admin created successfully');
            }else{
                return redirect()->back()->with('fail','Something went wrong, failed to create admin');    
            }
        }
    }

    public function check(AdminCheckRequest $request)
    {
        
        $request->authenticate();
        
        $request->session()->regenerate();

        return redirect()->route('admin.dashboard')->with('success','You are logged in successfully!');
    }

    public function logout(Request $request)
    {
        Auth::guard('admin')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }

    public function delete(Request $request)
    {
        $adminId = $request->post('admin_id');
        $admin = Admin::where('id',$adminId)->first();

        $admin->delete();

        return redirect()->back()->with('success','Admin removed successfully');
    }
}
