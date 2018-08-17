<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Carbon\Carbon;

class NotificationController extends Controller
{
    //
    public function index(Request $request) {
        $data = $request->all();
        $currentUser = $data['currentUser'];
        
        $allNotifications = DB::table('notifications')->where('toUserID', $data['currentUser'])->where('read', 0)->orderBy('notifID', 'desc')->get();
        //$allNotifications = Notifications::where('toUserID', $data['currentUser'])->where('read', 0)->orderBy('notifID', 'desc')->get();

        foreach($allNotifications as $x) {
            $now = Carbon::now();
            $nowAdjusted = $now->addHours(8);
            $notificationDate = Carbon::parse($x->insertedOn);

            $fromUser = DB::table('institutions')->where('institutionID', $x->fromUserID)->first();
            $action = DB::table('action_ref')->where('actionID', $x->actionID)->first();

            if (isset($fromUser)) {
                $x->fromUser = $fromUser->institutionName;
            }
            if (isset($action)) {
                $x->actionName = $action->actionName;
            }
            
            if (isset($now)) {
                $x->nowDate = $nowAdjusted->toDateTimeString();
            }

            if (isset($notificationDate)) {
                $x->readableDate = $notificationDate->diffForHumans($nowAdjusted);
            }
        }


        return response()->json($allNotifications);
    }
    
    public function all(Request $request) {
        $data = $request->all();
        $currentUser = $data['currentUser'];
        $read = $data['read'];
        
        $allNotifications = DB::table('notifications')->where('toUserID', $data['currentUser'])->where('read', $read)->orderBy('notifID', 'desc')->get();
        //$allNotifications = Notifications::where('toUserID', $data['currentUser'])->where('read', 0)->orderBy('notifID', 'desc')->get();

        foreach($allNotifications as $x) {
            $now = Carbon::now();
            $nowAdjusted = $now->addHours(8);
            $notificationDate = Carbon::parse($x->insertedOn);

            $fromUser = DB::table('institutions')->where('institutionID', $x->fromUserID)->first();
            $action = DB::table('action_ref')->where('actionID', $x->actionID)->first();

            if (isset($fromUser)) {
                $x->fromUser = $fromUser->institutionName;
            }
            if (isset($action)) {
                $x->actionName = $action->actionName;
            }
            
            if (isset($now)) {
                $x->nowDate = $nowAdjusted->toDateTimeString();
            }

            if (isset($notificationDate)) {
                $x->readableDate = $notificationDate->diffForHumans($nowAdjusted);
            }
        }


        return response()->json($allNotifications);
    }

    public function update(Request $request) {
        $data = $request->all();
        $currentNotif = $data['notifID'];

        $selectedNotification = DB::table('notifications')->where('notifID', $currentNotif)->first();

        switch ($selectedNotification->read) {
            case 1:
                $updateNotif = DB::table('notifications')->where('notifID', $currentNotif)->update(['read'=> 0]);
                break;
            
            case 0:
                $updateNotif = DB::table('notifications')->where('notifID', $currentNotif)->update(['read'=> 1]);
                break;
        }

        $selectedNotification = DB::table('notifications')->where('notifID', $currentNotif)->first();


        return response()->json($selectedNotification);
    }
}
