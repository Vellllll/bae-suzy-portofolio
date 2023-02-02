<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;

use App\Models\Portfolio;

use Illuminate\Support\Carbon;

class PortfolioController extends Controller
{
    public function allportfoliopage(){
        $portfolios = Portfolio::latest()->get();
        return view('admin.portfolio_page.all_portfolio_page')->with([
            'portfolios' => $portfolios
        ]);
    }

    public function addportfoliopage(){
        return view('admin.portfolio_page.add_portfolio_page');
    }

    public function storeportfolio(Request $request){
        $request->validate([
            'portfolio_name' => 'required',
            'portfolio_title' => 'required',
            'portfolio_image' => 'required'
        ],[
            'portfolio_name.required' => 'Portfolio Name is Required',
            'portfolio_title.required' => 'Portfolio Title is Required'
        ]);

        $image = $request->file('portfolio_image');
        $name_generate = hexdec(uniqid()).'.'.$image->getClientOriginalExtension();

        Image::make($image)->resize(1020, 519)->save('upload/portfolios/'.$name_generate);
        $save_url = 'upload/portfolios/'.$name_generate;

        Portfolio::insert([
            'portfolio_name' => $request->portfolio_name,
            'portfolio_title' => $request->portfolio_title,
            'portfolio_description' => $request->portfolio_description,
            'portfolio_image' => $save_url,
            'created_at' => Carbon::now()
        ]);

        $notification = array(
            'message' => 'Portfolio Added!',
            'alert-type' => 'success'
        );

        return redirect()->route('all.portfolio.page')->with($notification);
    }

    public function editportfoliopage($id){
        $portfolio = Portfolio::findOrFail($id);
        return view('admin.portfolio_page.edit_portfolio_page')->with([
            'portfolio' => $portfolio
        ]);
    }

    public function updateportfolio(Request $request){
        $portfolio_id = $request->id;

        if($request->file('portfolio_image')){
            $image = $request->file('portfolio_image');
            $name_generate = hexdec(uniqid()).'.'.$image->getClientOriginalExtension();

            Image::make($image)->resize(1020, 519)->save('upload/portfolios/'.$name_generate);
            $save_url = 'upload/portfolios/'.$name_generate;

            Portfolio::findOrFail($portfolio_id)->update([
                'portfolio_name' => $request->portfolio_name,
                'portfolio_title' => $request->portfolio_title,
                'portfolio_description' => $request->portfolio_description,
                'portfolio_image' => $save_url
            ]);

            $notification = array(
                'message' => 'Portfolio Updated with Image!',
                'alert-type' => 'success'
            );

            return redirect()->route('all.portfolio.page')->with($notification);
        } else {
            Portfolio::findOrFail($portfolio_id)->update([
                'portfolio_name' => $request->portfolio_name,
                'portfolio_title' => $request->portfolio_title,
                'portfolio_description' => $request->portfolio_description
            ]);

            $notification = array(
                'message' => 'Portfolio Updated without Image!',
                'alert-type' => 'success'
            );

            return redirect()->route('all.portfolio.page')->with($notification);
        }
    }

    public function deleteportfolio($id){
        $portfolio = Portfolio::findOrFail($id);
        $image = $portfolio->portfolio_image;
        unlink($image);

        $portfolio->delete();

        $notification = array(
            'message' => 'Portfolio Deleted!',
            'alert-type' => 'success'
        );

        return redirect()->back()->with($notification);
    }

    public function portfoliodetails($id){
        $portfolio = Portfolio::findOrFail($id);
        return view('frontend.home_all.portfolio_details')->with([
            'portfolio' => $portfolio
        ]);
    }

    public function portfoliospage(){
        $portfolios = Portfolio::latest()->limit(5)->get();
        return view('frontend.portfolio.all_portfolios')->with([
            'portfolios' => $portfolios
        ]);
    }
}
