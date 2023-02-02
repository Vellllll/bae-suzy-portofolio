<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\BlogCategory;

use Illuminate\Support\Carbon;

class BlogCategoryController extends Controller
{
    public function allblogcategorypage(){
        $blogcategories = BlogCategory::latest()->get();
        return view('admin.blog_category.all_blog_category')->with([
            'blogcategories' => $blogcategories
        ]);
    }

    public function addblogcategorypage(){
        return view('admin.blog_category.add_blog_category');
    }

    public function storeblogcategory(Request $request){
        // $request->validate([
        //     'blog_category' => 'required'
        // ],[
        //     'blog_category.required' => 'Blog Category is Required'
        // ]);

        BlogCategory::insert([
            'blog_category' => $request->blog_category,
            'created_at' => Carbon::now()
        ]);

        $notification = array(
            'message' => 'Blog Category Added!',
            'alert-type' => 'success'
        );

        return redirect()->route('all.blog.category.page')->with($notification);
    }

    public function editblogcategorypage($id){
        $blogcategory = BlogCategory::find($id);
        return view('admin.blog_category.edit_blog_category')->with([
            'blogcategory' => $blogcategory
        ]);
    }

    public function updateblogcategory(Request $request, $id){
        BlogCategory::findOrFail($id)->update([
            'blog_category' => $request->blog_category
        ]);

        $notification = array(
            'message' => 'Blog Category Updated!',
            'alert-type' => 'success'
        );

        return redirect()->route('all.blog.category.page')->with($notification);

    }

    public function deleteblogcategory($id){
        $blogcategory = BlogCategory::find($id);
        $blogcategory->delete();

        $notification = array(
           'message' => 'Blog Category Deleted!',
            'alert-type' =>'success'
        );

        return redirect()->back()->with($notification);
    }
}
