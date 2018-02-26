<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Models\User;

class MyController extends Controller
{
    public function usertypes()
    {
        $userTypes = DB::table('usertypes_ref')->select('userTypeID', 'userTypeName')->get();
        return view('user-add', compact('userTypes'));
    }

    public function users()
    {
        $users = DB::table('users')->select('id', 'userName', 'accountName')->get();
        return view('user-editinfo', compact('users'));
    }

    public function usercreds()
    {
        $usercreds = DB::table('users')->select('id', 'userName', 'accountName', 'email')->get();
        return view('user-editcreds', compact('usercreds'));
    }

    public function editinfo(Request $request)
    {
        $data = $request->all();

        $currentUser = $data['current-user'];
        $firstName = $data['first-name'];
        $lastName = $data['last-name'];
        
        $userdata = User::find($currentUser);

        $finalName = $firstName . " " . $lastName;

        $userdata->accountName = $finalName;

        $userdata->save();

        return redirect()->route('user-view');
    }

    public function editcreds(Request $request)
    {
        $data = $request->all();

        $currentUser = $data['current-user'];
        $username = $data['username'];
        $email = $data['email'];
        $password = bcrypt($data['password']);
        
        $userdata = User::find($currentUser);;

        $userdata->username = $username;
        $userdata->email = $email;
        $userdata->password = $password;

        $userdata->save();

        return redirect()->route('user-view');
    }
}
