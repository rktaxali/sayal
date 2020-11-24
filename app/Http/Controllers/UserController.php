<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    //
	
	
	 protected function create(Request $request)
    {
		
		 $request->validate([
             'firstname' => ['required', 'string', 'max:255'],
            'lastname' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
		
        $user =  User::create([
            'firstname' => $request->firstname,
            'lastname' => $request->lastname,
            'name' => $request->firstname . ' '. $request->lastname,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);
		
        // back() does not work
        return back()
            ->with('success','User ' . $request->firstname . ' ' . $request->lastname . ' Created Successfully');
        
    }
}
