<?php

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


Route::get('/',[\App\Http\Controllers\FrontendController::class,'index'])->name("index");

Route::get('/about',[\App\Http\Controllers\FrontendController::class,'about'])->name("about");



Route::get('/contact',[\App\Http\Controllers\FrontendController::class,'contact'])->name("contact");




Route::get('/author',[\App\Http\Controllers\FrontendController::class,'author'])->name("author");


Route::get('/error',[\App\Http\Controllers\FrontendController::class,'error'])->name("error");



Route::get('/features',[\App\Http\Controllers\Api\PostController::class,'features'])->name("features");
Route::get('/all',[\App\Http\Controllers\Api\PostController::class,'index'])->name("all");



Route::post('/message',[\App\Http\Controllers\FrontendController::class,'storeMessage'])->name("message");




Route::get('/blog',[\App\Http\Controllers\BlogController::class,'index'])->name("blog");
Route::get('/blog/{id?}',[\App\Http\Controllers\BlogController::class,'show'])->name("blog");



Route::post('/login',[\App\Http\Controllers\Api\UsersController::class,'login']);
Route::get('/logout',[\App\Http\Controllers\Api\UsersController::class,'logout'])->name("logout");
Route::post('/register',[\App\Http\Controllers\Api\UsersController::class,'register']);
Route::get('/userEdit',[\App\Http\Controllers\Api\UsersController::class,'editProfile']);
Route::put('/updateUser',[\App\Http\Controllers\Api\UsersController::class,'update']);


Route::get('/comments/{id}',[\App\Http\Controllers\Api\Comments::class,'comments']);
Route::post('/comments',[\App\Http\Controllers\Api\Comments::class,'insert']);
Route::delete('/comments/{id}',[\App\Http\Controllers\Api\Comments::class,'delete']);
Route::get('/comments/{id}/edit',[\App\Http\Controllers\Api\Comments::class,'edit']);
Route::put('/comments',[\App\Http\Controllers\Api\Comments::class,'update']);



Route::get('/likes/{id}',[\App\Http\Controllers\Api\Likes::class,'likes'])->name("likes");
Route::post('/likes',[\App\Http\Controllers\Api\Likes::class,'likePost'])->name("likes");
Route::delete('/likes/{id}',[\App\Http\Controllers\Api\Likes::class,'deleteLike'])->name("likes");


Route::middleware(["myuser"])->group(function () {



    Route::get('/addPost',[\App\Http\Controllers\FrontendController::class,'newPost'])->name("addPost");


    Route::get('/post/{id}/edit',[\App\Http\Controllers\FrontendController::class,'editPost'])->name("post.edit");


    Route::put('/post/{id}',[\App\Http\Controllers\FrontendController::class,'updatePost'])->name("post.update");


    Route::resource('/userPost',\App\Http\Controllers\Api\AdminPosts::class);

});

Route::middleware(['allUsers'])->group(function (){

    Route::get('/editProfile',[\App\Http\Controllers\FrontendController::class,'editProfile'])->name("editProfile");
});

Route::middleware(['mymiddleware'])->group(function () {

    Route::get('/admin',[\App\Http\Controllers\FrontendController::class,'admin'])->name("admin");



    Route::get('/activity',[\App\Http\Controllers\FrontendController::class,'logFile']);

/////products admin
    Route::resource('/allAdmin',\App\Http\Controllers\Api\AdminPosts::class);

////sponsors admin
    Route::resource('/allSponsors',\App\Http\Controllers\Api\Sponsors::class);

////networks admin
    Route::resource('/allNetworks',\App\Http\Controllers\Api\Networks::class);

////hashtags admin
    Route::resource('/allHashtags',\App\Http\Controllers\Api\Hashtags::class);

////users admin
    Route::resource('/allUsers',\App\Http\Controllers\Api\Users::class);


////messages admin
    Route::resource('/allMessages',\App\Http\Controllers\Api\Messages::class);


////comments admin
    Route::resource('/allComments',\App\Http\Controllers\Api\CommentsAdmin::class);


////image post
    Route::delete('/image/{id}',[\App\Http\Controllers\Api\ImageController::class,"deleteImage"]);
});


//Route::get('/menu',[\App\Http\Controllers\Api\MenuController::class,'index'])->name("/menu");
//Route::get('/',[\App\Http\Controllers\Api\PostController::class,'index'])->name("index");
