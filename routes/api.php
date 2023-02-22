<?php

use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/', function () {
    User::updateOrCreate(["email" => "thomnx@kozo-japan.com"], [
        "name" => "Thom NX",
        "password" => "123456"
    ]);
    return response()->json(['message' => 'success']);
});

Route::get('/user/{id}', function ($id) {
    $post = User::with('posts')->find($id);
    return response()->json(['data' => $post]);
});
Route::get('/post', function () {
    $post = Post::all();
    return response()->json(['data' => $post]);
});

Route::post('/post', function (Request $request) {
    try {
        $param = $request->only('title', 'content', 'user_id');
        $create = Post::create($param);

        return response()->json(['message' => 'Create success']);

    } catch (\Throwable $th) {
        Log::error($th);
        return response()->json(['message' => 'Create failed']);
    }    
});
