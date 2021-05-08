<?php
use Illuminate\Auth\Middleware\Authenticate;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Models\Games;
use App\Models\Credit;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;
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
    return md5(rand(1, 10) . microtime());
    $fields = [
        "Method"=> "TC",
        "Username"=> 'testing', 
        "Timestamp"=> time(), 
        "RequestID"=> 'ZxcOH5AcO2', 
        "Amount"=> 100,
    ];
    return fetchData($fields);
});

Route::get('/login', [AuthController::class,'loginPage'])->name('login');
Route::post('/login', [AuthController::class,'login']);
Route::post('/logout', [AuthController::class,'logout']);
Route::get('/register', [AuthController::class,'registerPage']);
Route::post('/register', [AuthController::class,'register']);

Route::post('/play',[AuthController::class,'play'])->middleware('auth');
Route::get('/credit',[AuthController::class,'credit'])->middleware('auth');

// Route::get('/register-api',function(){
//     return Redirect::to('http://heera.it');
// });
Route::get('/get-games', function (Request $request) {
    $games = Games::with('Jackpots')->paginate(5);
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
Route::get('/', function () {
    $games = Games::paginate('10');
    $gameType = Games::distinct('GameType')->pluck('GameType');
    return view('welcome',compact('games','gameType'));
});




Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard.dashboard');
    });
    Route::get('/deposit', [AuthController::class,'deposit']);
    Route::post('/deposit', [AuthController::class,'store_deposit']);
    Route::get('/transactions', [AuthController::class,'transactions']);
    Route::get('/dashboard-admin', function () {
        return view('dashboard.dashboard-admin');
    });
});




Route::prefix('/admin')->group(function () {

        Route::middleware(['auth', 'auth.admin'])->group(function () {

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


