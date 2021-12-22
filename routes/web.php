<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\PostsController;
use App\Http\Controllers\SingleController;
use Illuminate\Support\Facades\Auth;
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

// Route::get('/', function () {
//     return view('home.index', []);
// })->name('home.index');

// Route::get('/contact', function () {
//     return view('home.contact');
// })->name('home.contact');

// Route::view('/','home.index',[])->name('home.index');
// Route::view('/contact','home.contact')->name('home.contact');


Route::get('/', [HomeController::class, 'home'])
    ->name('home.index');

Route::get('/contact', [HomeController::class, 'contact'])
    ->name('home.contact');

Route::get('secret', [HomeController::class, 'secret'])
    ->name('secret')
    ->middleware('can:home.secret');


// Route::prefix('/fun')->name('fun.')->group(function() use($posts){
//     Route::get('/responses', function() use($posts) {
//         return response($posts,201)
//             ->header('Content-Type','application/json')
//             ->cookie('MY_COOKIE','Hamza Tasci',3600);
//     })->name('responses');

//     Route::get('/json',function() use($posts){
//         return response()->json($posts);
//     })->name('json');

//     Route::get('/download', function(){
//         return response()->download(public_path('/hamza.jpg'), 'face.jpg');
//     })->name('download');
// });

Route::resource('/posts', PostsController::class);

// Route::get('/posts', function(Request $request) use($posts) {

//     return view('posts.index',['posts'=>$posts]);
// });
// Route::get('/post/{id?}', function($id = 1) use ($posts){

//     abort_if(!isset($posts[$id]),404);

//     return view('posts.show', ['post'=>$posts[$id]]);
// })->name("post.index");

Route::get('/recent_post/{id?}', function ($postId = 20) {
    return "Post $postId";
})->name("post.recent.index");

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Auth::routes();