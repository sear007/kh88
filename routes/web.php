<?php

use App\Events\DepositNotificationEvent;
use Illuminate\Auth\Middleware\Authenticate;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Mail\ResetPassword;
use App\Models\Games;
use App\Models\Credit;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

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


Route::get('testing', function () {
    $link = config('base_url') . 'password/reset/' . Str::random(90) . '?email=' . urlencode('koungbuntha@gmail.com');
    $data = [
        'name' => 'Koung Buntha',
        'email' => 'koungbuntha@gmail.com',
        'link' => $link,
    ];
    Mail::to('koungbuntha@gmail.com')->send(new ResetPassword($data));
    // $fields = [
    //     "Method"=> "CU", 
    //     "Username"=> 'demo88', 
    //     "Timestamp"=> time()
    // ];
    // return $user = fetchData($fields);
});

Route::get('/', function () {
    return view('welcome');
});
Route::get('/games', function () {
    $gameType = Games::distinct('GameType')->pluck('GameType');
    return view('games',compact('gameType'));
});

Route::get('/login', [AuthController::class,'loginPage'])->name('login');
Route::post('/login', [AuthController::class,'login']);
Route::post('/logout', [AuthController::class,'logout']);
Route::get('/register', [AuthController::class,'registerPage']);
Route::post('/register', [AuthController::class,'register']);

Route::get('/forgot-password', [AuthController::class,'forgotPassword']);
Route::post('/forgot-password', [AuthController::class,'getEmailForgotPassword']);
Route::post('/password/reset/{token}', [AuthController::class,'resetPassword']);
Route::get('/password/reset/{token}', [AuthController::class,'DisplayResetPassword']);



Route::post('/play',[AuthController::class,'play'])->middleware('auth');
Route::get('/credit',[AuthController::class,'credit'])->middleware('auth');
// Route::get('/register-api',function(){
//     return Redirect::to('http://heera.it');
// });
Route::get('/get-games', function (Request $request) {
    $games = Games::with('Jackpots')->paginate(10);
    if($request->type){
        $games = Games::where('GameType',$request->type)->with('Jackpots')->paginate(10);
    }
    $gameType = Games::distinct('GameType')->pluck('GameType');
    return response()->json([
        'code' => '200',
        'message' => 'Successful',
        'data' => [
            "games" => $games,
            "type" => $gameType,
        ],
    ]);
});

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard.dashboard');
    });
    Route::get('/deposit', [AuthController::class,'deposit']);
    Route::post('/deposit', [AuthController::class,'store_deposit']);
    Route::get('/withdraw', [AuthController::class,'withdraw']);
    Route::post('/withdraw', [AuthController::class,'store_withdraw']);
    Route::get('/transactions', [AuthController::class,'transactions']);
});




Route::prefix('/admin')->group(function () {

        Route::middleware(['auth', 'auth.admin'])->group(function () {

            Route::get('/dataJson',[AdminController::class,'dataJson']);
            Route::get('/notifications',[AdminController::class,'notifications']);

            Route::get('/dashboard',[AdminController::class,'index']);
            Route::get('/deposits',[AdminController::class,'deposits']);
            Route::get('/depositsJson',[AdminController::class,'depositsJson'])->name('depositJson');
            Route::post('deposit/approve',[AdminController::class,'deposit_approve'])->name('approve_deposit');
            Route::post('/deposit/destroy',[AdminController::class,'deposit_destroy'])->name('destroy_deposit');
            Route::get('withdraws',[AdminController::class,'withdraws']);
            Route::get('withdrawsJson',[AdminController::class,'withdrawsJson'])->name('withdrawsJson');
            Route::post('withdraw/approve',[AdminController::class,'withdraw_approve'])->name('approve_withdraw');
            Route::post('withdraw/destroy',[AdminController::class,'withdraw_destroy'])->name('destroy_withdraw');
           
     });
});
