<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;

use App\Models\HomeSlide;

class HomeSliderController extends Controller
{
    public function homeslider(){
        $homeSlide = HomeSlide::find(1);
        return view('admin.home_slide.home_slide_all')->with([
            'homeSlide' => $homeSlide
        ]);
    }

    public function updateslider(Request $request){
        $slide_id = $request->id;

        if($request->file('slide_image')){
            $image = $request->file('slide_image');
            $name_generate = hexdec(uniqid()).'.'.$image->getClientOriginalExtension(); //35246135.jpg

            Image::make($image)->resize(636, 852)->save('upload/home_slide/'.$name_generate);
            $save_url = 'upload/home_slide/'.$name_generate;

            HomeSlide::findOrFail($slide_id)->update([
                'title' => $request->title,
                'title_description' => $request->title_description,
                'video_url' => $request->video_url,
                'slide_image' => $save_url
            ]);

            $notification = array(
                'message' => 'Home Slide Updated with Image!',
                'alert-type' => 'success'
            );

            return redirect()->back()->with($notification);
        } else {
            HomeSlide::findOrFail($slide_id)->update([
                'title' => $request->title,
                'title_description' => $request->title_description,
                'video_url' => $request->video_url
            ]);

            $notification = array(
                'message' => 'Home Slide Updated without Image!',
                'alert-type' => 'success'
            );

            return redirect()->back()->with($notification);
        }

    }
}
