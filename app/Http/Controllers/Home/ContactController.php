<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

use App\Models\Contact;

class ContactController extends Controller
{
    public function contactpage(){
        return view('frontend.contact_page');
    }

    public function contactpost(Request $request){
        Contact::insert([
            'name' => $request->name,
            'email' => $request->email,
            'subject' => $request->subject,
            'phone' => $request->phone,
            'message' => $request->message,
            'created_at' => Carbon::now()
        ]);

        $notification = array(
            'message' => 'Message Sent!',
            'alert-type' => 'success'
        );

        return redirect()->back()->with($notification);
    }

    public function allcontactpage(){
        $contact_messages = Contact::latest()->get();

        return view('admin.contact.all_contact_messages')->with([
            'contact_messages' => $contact_messages
        ]);
    }

    public function contactdelete($id){
        $contact_message = Contact::findOrFail($id);
        $contact_message->delete();

        $notification = array(
            'message' => 'Contact Deleted!',
            'alert-type' => 'success'
        );

        return redirect()->back()->with($notification);
    }
}
