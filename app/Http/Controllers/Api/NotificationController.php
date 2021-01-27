<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\SuccessResponse;
use App\Message;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    //

    public function list($token){
        $messages = Message::join("hosts", "hosts.id", "=", "messages.host_id")
            ->select("messages.*")
            ->where("hosts.token", $token)
            ->where("unread", true)
            ->get();

        return new SuccessResponse($messages);
    }

    public function read($id){
        $message = Message::find($id);

        if($message){
            $message->unread = false;
            $message->save();
        }
        return new SuccessResponse($message);
    }
}
