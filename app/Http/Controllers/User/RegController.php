<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\AddProfilePictureRequest;
use App\Http\Requests\User\UserLogRequest;
use App\Http\Requests\User\UserRegRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class RegController extends Controller
{
    public function index()
    {
        return view('admin.forms.add_customer');
    }

    public function create(UserRegRequest $request)
    {
        if($request->validated())
        {
            $user = new User();
            $user->fname = $request->fname;
            $user->lname = $request->lname;
            $user->gender = $request->gender;
            $user->dob = $request->dob;
            $user->cnp = $request->cnp;
            $user->email = $request->email;
            $user->phone = $request->phone;
            $user->address = $request->address;
            $user->username = $request->username;
            $user->password = Hash::make($request->password);
            $user->admin_id = $request->admin_id;
            $save = $user->save();

            if( $save ){
                return redirect()->back()->with('success','Customer added successfully');
            }else{
                return redirect()->back()->with('fail','Something went wrong, failed to add customer');
            }
        }
    }

    public function check(UserLogRequest $request)
    {
        if($request->validated())
        {
            $creds = $request->only('email','password');
            if(Auth::attempt($creds)){
                return redirect()->route('user.home')->with('success','You are logged in successfully!');
            }else{
                return redirect()->route('user.login')->with('fail','Incorrect credentials');
            }
        }
    }

    public function logout(Request $request)
    {
        Auth::logout();
       
        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }

    public function addProfilePicture(AddProfilePictureRequest $request)
    {
        if($request->validated())
        {
            $user = Auth::user();

            $path = $request->file('profile_picture')->storeAs(
                'public/images/profile', "profile_". $user->id . "." . $request->file('profile_picture')->extension()
            );

            $imagePath = explode('public',$path);

            $user->profile_picture = '/storage' . $imagePath[1];

            $user->save();

            return redirect()->back()->with('changed','You have a new profile picture!');
        }
    }

    public function changePasswordView()
    {
        $user = Auth::user();

        return view('user.forms.changePassword',[
            'user' => $user
        ]);
    }
   
    
}
