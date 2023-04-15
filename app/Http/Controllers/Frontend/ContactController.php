<?php

namespace App\Http\Controllers\Frontend;

use App\Mail\ContactMail;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    public function contact_store(Request $request){

        $this->validate($request,[
            'first_name'=>'required|string',
            'last_name'=>'required|string',
            'email'=>'required|email',
            'phone'=>'required|string',
            'subject'=>'required|string',
            'comment'=>'required|string',

        ]);
        $contact =array();
        $contact['first_name'] = $request->first_name;
        $contact['last_name'] = $request->first_name;
        $contact['email'] = $request->email;
        $contact['phone'] = $request->phone;
        $contact['subject'] = $request->subject;
        $contact['comment'] = $request->comment;
        $email = "saikotkhan44@gmail.com";
        Mail::to($email)->send(new ContactMail($contact));
        return response()->json([
            'message' => 'Your mail sent successfully. We will contact you soon'
        ], 200);

    }
}
