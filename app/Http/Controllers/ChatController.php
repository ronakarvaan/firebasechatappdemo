<?php

namespace App\Http\Controllers;

use App\Models\Chat;
use Illuminate\Foundation\Auth\User;
use Illuminate\Http\Request;
use LaravelFCM\Facades\FCM;
use LaravelFCM\Message\OptionsBuilder;
use LaravelFCM\Message\PayloadDataBuilder;
use LaravelFCM\Message\PayloadNotificationBuilder;

class ChatController extends Controller
{
    public function index(Request $req)
    {
        $input = $req->all();
        $fcm_token = $input['fcm_token'];
        $user_id = $input['user_id'];

        $user = User::findOrFail($user_id);

        $user->fcm_token = $fcm_token;
        $user->save();
        return response()->json([
            'success' => true,
            'message' => 'User token updated successfully.',
        ]);
    }
    public function createChat(Request $request)
    {
        $input = $request->all();
        $message = $input['message'];
        $chat = new Chat([
            'sender_id' => auth()->user()->id,
            'sender_name' => auth()->user()->name,
            'message' => $message,
        ]);

        $this->broadcastMessage(auth()->user()->name, $message);
        $chat->save();
        return redirect()->back();
    }

    private function broadcastMessage($senderName, $message)
    {
        $optionBuilder = new OptionsBuilder();
        $optionBuilder->setTimeToLive(60 * 20);

        $notificationBuilder = new PayloadNotificationBuilder('New message from : ' . $senderName);
        $notificationBuilder->setBody($message)
            ->setSound('default')
            ->setClickAction(route('dashboard'));

        $dataBuilder = new PayloadDataBuilder();
        $dataBuilder->addData([
            'sender_name' => $senderName,
            'mesage' => $message,
        ]);

        $option = $optionBuilder->build();
        $notification = $notificationBuilder->build();
        $data = $dataBuilder->build();

        ($tokens = User::all()->pluck('fcm_token')->toArray());

        $downstreamResponse = FCM::sendTo($tokens, $option, $notification, $data);

        return $downstreamResponse->numberSuccess();
    }
}
