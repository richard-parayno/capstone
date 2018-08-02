<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use DB;

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

      if (isset($data['first-name']) && isset($data['last-name'])) {
        $originalUser->accountName = $data['first-name']." ".$data['last-name'];
      } else if (isset($data['first-name'])) {
        $originalUser->accountName = $data['first-name'];
      } else if (isset($data['last-name'])) {
        $originalUser->accountName = $data['last-name'];
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
