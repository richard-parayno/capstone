<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    public function index() {
        $user = User::all();
        $user->toArray();
        
        foreach ($user as $x) {
          $usertypes = DB::table('usertypes_ref')->where('userTypeID', $x->userTypeID)->first();
          $institution = DB::table('institutions')->where('institutionID', $x->institutionID)->first();
          
          if ($usertypes != null) {
            $x['userTypeName'] = $usertypes->userTypeName;
          } else {
            $x['userTypeName'] = "NO USER TYPE RECORDED";
          }
          if ($institution != null) {
            $x['institutionName'] = $institution->institutionName;
          } else {
            $x['institutionName'] = "NO INSTITUTION RECORDED";
          }
        }
  
        return response()->json($user);
    }

    public function show(User $user) {
        $usertypes = DB::table('usertypes_ref')->where('userTypeID', $user->userTypeID)->first();
        $institution = DB::table('institutions')->where('institutionID', $user->institutionID)->first();
        $user = $user->toArray();
        if ($usertypes != null) {
            $user['userTypeName'] = $usertypes->userTypeName;
        } else {
          $user['userTypeName'] = "NO USER TYPE RECORDED";
        }
        if ($institution != null) {
          $user['institutionName'] = $institution->institutionName;
        } else {
          $user['institutionName'] = "NO INSTITUTION RECORDED";
        }

        return response()->json($user);

    }

    public function store(Request $request) {

    }

    public function update(Request $request) {
      $data = $request->all();
      $originalUser = User::find($data['originalUser']);

      $this->validate($request, [
        'accountName' => [
          'required',
        ],
        'username' => [
          'required',
          Rule::unique('users')->ignore($originalUser->id, 'id')
        ],
        'email' => [
          'required',
        ],
        'password' => [
          'required',
        ]
        ], [
          'accountName.required' => 'The \'Update Account Name\' field is required.', 
          'username.required' => 'The \'Update Username\' field is required.', 
          'username.unique' => 'This Username has already been taken.', 
          'email.required' => 'The \'Update Email\' field is required.', 
          'password.required' => 'The \'Update Password\' field is required.', 
        ]);


      if (isset($data['accountName'])) {
        $originalUser->accountName = $data['accountName'];
      }
      if (isset($data['username']))
        $originalUser->username = $data['username'];
      if (isset($data['email']))
        $originalUser->email = $data['email'];
      if (isset($data['password']))
        $originalUser->password = bcrypt($data['password']);

      $originalUser->save();

      return response()->json($originalUser);
    }

    public function delete(User $user) {

    }
}
