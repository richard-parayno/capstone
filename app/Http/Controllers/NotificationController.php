<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class NotificationController extends Controller
{
    //
    public function index(Request $request) {
        $data = $request->all();
        $currentUser = $data['currentUser'];
        
        $allNotifications = DB::table('notifications')->where('toUserID', $data['currentUser'])->get();

        foreach($allNotifications as $x) {
            $fromUser = DB::table('users')->where('id', $x->fromUserID)->first();
            $action = DB::table('action_ref')->where('actionID', $x->actionID)->first();

            if (isset($fromUser)) {
                $x->fromUser = $fromUser->accountName;
            }
            if (isset($action)) {
                $x->actionName = $action->actionName;
            }
        }


        return response()->json($allNotifications);
    }

    public function update() {

    }
}
