<?php

use App\Models\Games;
use App\Models\Jackpots;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;


Route::get('/play-game',function(){
    $fields = [
        "Method" => "PLAY", 
        "Username" => "sear007", 
        "Timestamp" => time()
    ];
    $data = fetchData($fields);
    return $data;
});
Route::get('/tc',function(){
    $fields = [
        "Method"=> "TC",
        "Username"=> "sear007", 
        "Timestamp"=> time(), 
        "RequestID"=>Str::random(20), 
        "Amount"=>"-10000",
    ];
    $data = fetchData($fields);
    return $data;
});

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
