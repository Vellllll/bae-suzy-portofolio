<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;

use App\Models\About;
use App\Models\MultiImage;

use Illuminate\Support\Carbon;

class AboutController extends Controller
{
    public function aboutpage(){
        $about = About::find(1);
        return view('admin.about_page.about_page_all')->with([
            'about' => $about
        ]);
    }

    public function updateabout(Request $request){
        $about_id = $request->id;

        if($request->file('about_image')){
            $image = $request->file('about_image');
            $name_generate = hexdec(uniqid()).'.'.$image->getClientOriginalExtension();

            Image::make($image)->resize(523, 605)->save('upload/about_page/'.$name_generate);
            $save_url = 'upload/about_page/'.$name_generate;

            About::findOrFail($about_id)->update([
                'title' => $request->title,
                'short_title' => $request->short_title,
                'short_description' => $request->short_description,
                'long_description' => $request->long_description,
                'about_image' => $save_url
            ]);

            $notification = array(
                'message' => 'About Page Updated with Image!',
                'alert-type' => 'success'
            );

            return redirect()->back()->with($notification);
        } else {
            About::findOrFail($about_id)->update([
                'title' => $request->title,
                'short_title' => $request->short_title,
                'short_description' => $request->short_description,
                'long_description' => $request->long_description
            ]);

            $notification = array(
                'message' => 'About Page Updated without Image!',
                'alert-type' => 'success'
            );

            return redirect()->back()->with($notification);
        }
    }

    public function about(){
        $about = About::find(1);
        return view('frontend.about')->with([
            'about' => $about
        ]);
    }

    public function multiimagepage(){
        $multiimage = MultiImage::find(1);
        return view('admin.about_page.multi_image')->with([
            'multiimage' => $multiimage
        ]);
    }

    public function storemultiimage(Request $request){
        $multiimages = $request->file('multi_image');

        foreach ($multiimages as $image) {
            $name_generate = hexdec(uniqid()).'.'.$image->getClientOriginalExtension();

            Image::make($image)->resize(220, 220)->save('upload/multi_image/'.$name_generate);
            $save_url = 'upload/multi_image/'.$name_generate;

            MultiImage::insert([
                'multi_images' => $save_url,
                'created_at' => Carbon::now()
            ]);
        }

        $notification = array(
            'message' => 'Multiple Images Inserted!',
            'alert-type' => 'success'
        );

        return redirect()->back()->with($notification);

    }

    public function allmultiimage(){
        $multiimages = MultiImage::all();
        return view('admin.about_page.all_multi_image')->with([
            'multiimages' => $multiimages
        ]);
    }

    public function editmultiimage($id){
        $multiimage = MultiImage::findOrFail($id);
        return view('admin.about_page.edit_multi_image')->with([
            'multiimage' => $multiimage
        ]);
    }

    public function updatemultiimage(Request $request){
        $image_id = $request->id;

        $image = $request->file('multi_image');
        $name_generate = hexdec(uniqid()).'.'.$image->getClientOriginalExtension();

        Image::make($image)->resize(220, 220)->save('upload/multi_image/'.$name_generate);
        $save_url = 'upload/multi_image/'.$name_generate;

        MultiImage::findOrFail($image_id)->update([
            'multi_images' => $save_url
        ]);

        $notification = array(
            'message' => 'Multi Image Updated!',
            'alert-type' => 'success'
        );

        return redirect()->route('all.multi.image')->with($notification);
    }

    public function deletemultiimage($id){
        $multiimage = MultiImage::findOrFail($id);
        $image = $multiimage->multi_images;
        unlink($image);

        MultiImage::findOrFail($id)->delete();

        $notification = array(
            'message' => 'Multi Image Deleted!',
            'alert-type' => 'success'
        );

        return redirect()->back()->with($notification);

    }
}
