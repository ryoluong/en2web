<?php

use Illuminate\Http\Request;
use App\Facades\Slack;

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

// Route::middleware('auth:api')->post('/', function (Request $request) {
//     return $request->user();
// });
Route::post('/webhook/line', function(Request $request) {
    $json_string = file_get_contents('php://input');
    $json_object = json_decode($json_string);
    Log::info(var_dump($json_object));
    Slack::notice(var_dump($json_object));
    Log::info('LINE API works!');
});