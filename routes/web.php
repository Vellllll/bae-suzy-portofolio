<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\Home\AboutController;
use App\Http\Controllers\Home\HomeSliderController;
use App\Http\Controllers\Home\PortfolioController;
use App\Http\Controllers\Home\BlogCategoryController;
use App\Http\Controllers\Home\BlogController;
use App\Http\Controllers\Home\FooterController;
use App\Http\Controllers\Home\ContactController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('frontend.index');
})->name('index');

// Admin All Route
Route::middleware(['auth'])->group(function(){

    Route::controller(AdminController::class)->group(function() {
        Route::get('/admin/logout', 'destroy')->name('admin.logout');
        Route::get('/admin/profile', 'profile')->name('admin.profile');
        Route::get('/admin/profile/edit', 'editprofile')->name('edit.profile');
        Route::post('/admin/profile/store', 'storeprofile')->name('store.profile');
        Route::get('/admin/profile/changepassword', 'changepassword')->name('change.password');
        Route::post('/admin/profile/updatepassword', 'updatepassword')->name('update.password');
    });

});


// Home Slider Route
Route::controller(HomeSliderController::class)->group(function(){
    Route::get('/homeslide', 'homeslider')->name('home.slide');
    Route::post('/updateslider', 'updateslider')->name('update.slider');
});

// About Page Route
Route::controller(AboutController::class)->group(function(){
    Route::get('/aboutpage', 'aboutpage')->name('about.page');
    Route::post('/updateabout', 'updateabout')->name('update.about');
    Route::get('/about', 'about')->name('about');
    Route::get('/multiimagepage', 'multiimagepage')->name('multi.image');
    Route::post('/multiimagepage/store', 'storemultiimage')->name('store.multi.image');
    Route::get('/allmultiimage', 'allmultiimage')->name('all.multi.image');
    Route::get('/editmultiimage/{id}', 'editmultiimage')->name('edit.multi.image');
    Route::post('/editmultiimage/update', 'updatemultiimage')->name('update.multi.image');
    Route::get('/editmultiimage/{id}/delete', 'deletemultiimage')->name('delete.multi.image');
});

// Portfolio Route
Route::controller(PortfolioController::class)->group(function(){
    Route::get('/portfolio/all', 'allportfoliopage')->name('all.portfolio.page');
    Route::get('/portfolio/add', 'addportfoliopage')->name('add.portfolio.page');
    Route::post('portfolio/addportfolio', 'storeportfolio')->name('store.portfolio');
    Route::get('/portfolio/edit/{id}', 'editportfoliopage')->name('edit.portfolio.page');
    Route::post('/portfolio/update', 'updateportfolio')->name('update.portfolio');
    Route::get('/portfolio/delete/{id}', 'deleteportfolio')->name('delete.portfolio');
    Route::get('/portfolio/details/{id}', 'portfoliodetails')->name('portfolio.details');
    Route::get('/portfolios', 'portfoliospage')->name('portfolios.page');
});

// Blog Category Route
Route::controller(BlogCategoryController::class)->group(function(){
    Route::get('/blogcategory/all', 'allblogcategorypage')->name('all.blog.category.page');
    Route::get('/blogcategory/add', 'addblogcategorypage')->name('add.blog.category.page');
    Route::post('/blogcategory/storeblogcategory', 'storeblogcategory')->name('store.blog.category');
    Route::get('/blogcategory/edit/{id}', 'editblogcategorypage')->name('edit.blog.category.page');
    Route::post('blogcategory/update/{id}', 'updateblogcategory')->name('update.blog.category');
    Route::get('/blogcategory/delete/{id}', 'deleteblogcategory')->name('delete.blog.category');
});

// Blog Route
Route::controller(BlogController::class)->group(function(){
    Route::get('/blog/all', 'allblogpage')->name('all.blog.page');
    Route::get('/blog/add', 'addblogpage')->name('add.blog.page');
    Route::post('/blog/storeblog','storeblog')->name('store.blog');
    Route::get('/blog/edit/{id}', 'editblogpage')->name('edit.blog.page');
    Route::post('/blog/update/{id}', 'updateblog')->name('update.blog');
    Route::get('/blog/delete/{id}', 'deleteblog')->name('delete.blog');
    Route::get('/blog/details/{id}', 'blogdetails')->name('blog.details');
    Route::get('/category/{id}', 'categorypage')->name('category.page');
    Route::get('/blog', 'blog')->name('blog');
});

// Footer Route
Route::controller(FooterController::class)->group(function(){
    Route::get('/footer/setup', 'footersetuppage')->name('footer.setup.page');
    Route::post('/footer/setupupdate/{id}', 'updatefooter')->name('footer.setup.update');
});

//Contact Route
Route::controller(ContactController::class)->group(function(){
    Route::get('/contact', 'contactpage')->name('contact.page');
    Route::post('/contact/post', 'contactpost')->name('contact.post');
    Route::get('/contact/all', 'allcontactpage')->name('all.contact.page');
    Route::get('contact/delete/{id}', 'contactdelete')->name('contact.delete');
});

Route::get('/dashboard', function () {
    return view('admin.index');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
