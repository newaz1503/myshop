<?php

namespace App\Http\Controllers\Frontend;

use App\Models\Subscriber;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Mail\SubscriberMail;
use Illuminate\Support\Facades\Mail;

class SubscriberController extends Controller
{
    public function subscriber_store(Request $request){
        $this->validate($request,[
            'email'=>'required|email|unique:subscribers',
        ]);
        $subscriber = new Subscriber();
        $subscriber->email = $request->email;
        $subscriber->save();
        return response()->json([
            'message' => 'Subscription successfully'
        ], 200);
    }
    public function subscriber_send(){
        $subscribers = Subscriber::all();
        foreach ($subscribers as $key => $subscriber) {
            Mail::to($subscriber->email)->send(new SubscriberMail($subscriber));
        }
        return response()->json(['success'=>'Send email to subscriber successfully.']);
    }

}
