<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Footer;

class FooterController extends Controller
{
    public function footersetuppage(){
        $footer = Footer::find(1);
        return view('admin.footer.footer_setup')->with([
            'footer' => $footer
        ]);
    }

    public function updatefooter(Request $request, $id){
        Footer::findOrFail($id)->update([
            'number' => $request->number,
            'short_description' => $request->short_description,
            'address' => $request->address,
            'email' => $request->email,
            'facebook' => $request->facebook,
            'twitter' => $request->twitter,
            'copyright' => $request->copyright
        ]);

        $notification = array(
            'message' => 'Footer Updated!',
            'alert-type' => 'success'
        );

        return redirect()->back()->with($notification);
    }
}
