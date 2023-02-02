<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;

use App\Models\Blog;
use App\Models\BlogCategory;

use Illuminate\Support\Carbon;

class BlogController extends Controller
{
    public function allblogpage(){
        $blogs = Blog::latest()->get();
        return view('admin.blog.all_blog')->with([
            'blogs' => $blogs
        ]);
    }

    public function addblogpage(){
        $blogcategories = BlogCategory::OrderBy('blog_category', 'ASC')->get();
        return view('admin.blog.add_blog')->with([
            'blogcategories' => $blogcategories
        ]);
    }

    public function storeblog(Request $request){
        $request->validate([
            'blog_category_id' => 'required',
            'blog_title' => 'required',
            'blog_tags' => 'required',
            'blog_image' => 'required'
        ],[
            'blog_category_id.required' => 'Blog Category is Required',
            'blog_title.required' => 'Blog Title is Required',
            'blog_tags.required' => 'Blog Tags is Required'
        ]);

        $image = $request->file('blog_image');
        $name_generate = hexdec(uniqid()).'.'.$image->getClientOriginalExtension();

        Image::make($image)->resize(430, 327)->save('upload/blogs/'.$name_generate);
        $save_url = 'upload/blogs/'.$name_generate;

        Blog::insert([
            'blog_category_id' => $request->blog_category_id,
            'blog_title' => $request->blog_title,
            'blog_tags' => $request->blog_tags,
            'blog_description' => $request->blog_description,
            'blog_image' => $save_url,
            'created_at' => Carbon::now()
        ]);

        $notification = array(
            'message' => 'Blog Added!',
            'alert-type' => 'success'
        );

        return redirect()->route('all.blog.page')->with($notification);
    }

    public function editblogpage($id){
        $blog = Blog::find($id);
        $blogcategories = BlogCategory::OrderBy('blog_category', 'ASC')->get();
        return view('admin.blog.edit_blog')->with([
            'blog' => $blog,
            'blogcategories' => $blogcategories
        ]);
    }

    public function updateblog(Request $request, $id){
        if($request->file('blog_image')){
            $image = $request->file('blog_image');
            $name_generate = hexdec(uniqid()).'.'.$image->getClientOriginalExtension();

            Image::make($image)->resize(430, 327)->save('upload/blogs/'.$name_generate);
            $save_url = 'upload/blogs/'.$name_generate;

            Blog::findOrFail($id)->update([
                'blog_category_id' => $request->blog_category_id,
                'blog_title' => $request->blog_title,
                'blog_tags' => $request->blog_tags,
                'blog_description' => $request->blog_description,
                'blog_image' => $save_url,
                'updated_at' => Carbon::now()
            ]);

            $notification = array(
                'message' => 'Blog Updated with Image!',
                'alert-type' => 'success'
            );

            return redirect()->route('all.blog.page')->with($notification);
        } else {
            Blog::findOrFail($id)->update([
                'blog_category_id' => $request->blog_category_id,
                'blog_title' => $request->blog_title,
                'blog_tags' => $request->blog_tags,
                'blog_description' => $request->blog_description,
                'updated_at' => Carbon::now()
            ]);

            $notification = array(
                'message' => 'Blog Updated without Image!',
                'alert-type' => 'success'
            );

            return redirect()->route('all.blog.page')->with($notification);
        }
    }

    public function deleteblog($id){
        $blog = Blog::findOrFail($id);
        $blog_image = $blog->blog_image;
        unlink($blog_image);

        $blog->delete();

        $notification = array(
           'message' => 'Blog Deleted!',
           'alert-type' =>'success'
        );

        return redirect()->back()->with($notification);
    }

    public function blogdetails($id){
        $all_blogs = Blog::latest()->limit(5)->get();
        $blogcategories = BlogCategory::OrderBy('blog_category', 'ASC')->get();

        $blog = Blog::findOrFail($id);
        return view('frontend.blog_details')->with([
            'all_blogs' => $all_blogs,
            'blogcategories' => $blogcategories,
            'blog' => $blog
        ]);
    }

    public function categorypage($id){
        $all_blogs = Blog::latest()->limit(5)->get();
        $blogcategories = BlogCategory::OrderBy('blog_category', 'ASC')->get();
        $category = BlogCategory::findOrFail($id);

        $blogs = Blog::where('blog_category_id', $id)->OrderBy('id', 'DESC')->get();
        return view('frontend.category_page')->with([
            'all_blogs' => $all_blogs,
            'blogcategories' => $blogcategories,
            'category' => $category,
            'blogs' => $blogs
        ]);
    }

    public function blog(){
        $all_blogs = Blog::latest()->paginate(3);
        $blog_categories = BlogCategory::OrderBy('blog_category', 'ASC')->get();

        return view('frontend.blogs')->with([
            'all_blogs' => $all_blogs,
            'blog_categories' => $blog_categories,
        ]);
    }
}
