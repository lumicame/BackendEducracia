<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
Use App\Models\Project;
Use App\Models\Department;
Use App\Models\Type;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\VoteController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\HistoryController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\RatingController;



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
Route::post('users/life', [UserController::class,'life']);
Route::post('users/service', [UserController::class,'services']);
Route::post('users', [UserController::class,'create']);
Route::post('users/show', [UserController::class,'show']);
Route::post('users/project', [UserController::class,'projects']);
Route::post('users/profile', [UserController::class,'photoProfile']);
Route::post('users/search', [UserController::class,'search']);
Route::post('users/count', [UserController::class,'count']);
Route::post('users/notification/view', [UserController::class,'notificationView']);
Route::post('users/follow', [UserController::class,'getFollow']);
Route::post('users/follow/save', [UserController::class,'saveFollow']);
Route::post('users/active', [UserController::class,'Active']);

Route::post('vote/save', [VoteController::class,'save']);
Route::post('vote/count', [VoteController::class,'count']);
Route::post('vote/get', [VoteController::class,'get']);

Route::post('comment/save', [CommentController::class,'save']);
Route::get('comment/get', [CommentController::class,'get']);
Route::get('comment/sub/get', [CommentController::class,'getSub']);
Route::post('comment/delete', [CommentController::class,'delete']);


Route::post('message/save', [MessageController::class,'save']);
Route::post('message/get', [MessageController::class,'get']);
Route::post('message/get/id', [MessageController::class,'getMessage']);

Route::post('chat/get', [ChatController::class,'get']);


Route::post('notification/get', [NotificationController::class,'get']);
Route::post('notification/message', [MessageController::class,'message']);
Route::get('notification/send', [NotificationController::class,'notification']);

Route::post('login', [UserController::class,'login']);
Route::post('huella', [UserController::class,'huella']);
Route::post('token', [UserController::class,'Token']);

Route::get('projects',[ProjectController::class,'Projects']);
Route::post('project/get',[ProjectController::class,'show']);
Route::post('saveProject', [ProjectController::class,'saveProject']);
Route::post('project/edit', [ProjectController::class,'edit']);
Route::post('project/delete', [ProjectController::class,'delete']);

Route::post('saveHistory', [HistoryController::class,'saveHistory']);
Route::post('getHistory', [HistoryController::class,'getHistory']);
Route::post('showHistory', [HistoryController::class,'showHistory']);

Route::post('/transaction/get', [TransactionController::class,'get']);
Route::post('/transaction/ammount', [TransactionController::class,'ammount_total']);
Route::post('/transaction/account/pay', [TransactionController::class,'accountPay']);

////RATING////////
Route::post('/rating/get', [RatingController::class,'get']);
Route::post('/rating/save', [RatingController::class,'save']);
Route::post('/rating/count', [RatingController::class,'count']);



Route::get('departments', function() {return Department::all();});
Route::get('types', function() {return Type::all();});





/*Route::post('/send', function (Request $request) {
    $ch = curl_init('http://192.168.1.11/educracia/public/send');
 
//especificamos el POST (tambien podemos hacer peticiones enviando datos por GET
curl_setopt ($ch, CURLOPT_POST, 1);
 
//le decimos qué paramáetros enviamos (pares nombre/valor, también acepta un array)
curl_setopt ($ch, CURLOPT_POSTFIELDS, "message=".$request->message);
 
//le decimos que queremos recoger una respuesta (si no esperas respuesta, ponlo a false)
curl_setopt($ch,CURLOPT_RETURNTRANSFER,true)
 
//recogemos la respuesta
$respuesta = curl_exec ($ch);
 
//o el error, por si falla
$error = curl_error($ch);
 
//y finalmente cerramos curl
curl_close ($ch);
});*/
