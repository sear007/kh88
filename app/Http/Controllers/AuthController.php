<?php

namespace App\Http\Controllers;

use App\Models\Deposit;
use App\Models\Credit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;
class AuthController extends Controller
{
    //

    //     public function __construct()
    // {
    //     $this->middleware('auth');
    // }
    public function login(Request $request){
       $user = User::where('username',$request->username)->first();
       if($user){
            if (Auth::attempt(['email' => $user->email, 'password' => $request->password])) {
                $request->session()->regenerate();
                $user->status = true;
                //Fetch Token Here
                $user->token = Str::random(20);
                $user->save();
                return response()->json([
                    'code'=>200,
                    'message'=>"You have successful logged in.",
                ]);
            }
       }
        return response()->json([
            'code'=>500,
            'message'=>"The provided credentials do not match our records.",
        ]);
    }

    public function loginPage(){
        return "Login";
    }
    public function logout(){
        Auth::logout();
        return redirect('/');
    }
    public function registerPage(){
        return view('auth.register');
    }
    public function register(Request $request){
        $validator = Validator::make($request->all(),[
            'email' => 'required|unique:users,email',
            'username' => 'required|unique:users,username|min:5',
            'password' => 'required|confirmed|min:6',
            'terms' => 'required',
        ],$messages = [
            'terms.required' => 'Accept the terms condition.',
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator->errors())->withInput($request->all());
        }
        $fields = [
            "Method"=> "CU", 
            "Username"=> $request->username, 
            "Timestamp"=> time()
        ];
        $store_user_api = fetchData($fields);
        $user = User::create([
            'name'  => $request->username,
            'email' => $request->email,
            'username' => $request->username,
            'password' => $request->password,
            'status' => true,
            'token' =>  null,
            'type'=> 'user',
        ]);
        if (Auth::attempt(['email' => $user->email, 'password' => $request->password],true)) {
            $request->session()->regenerate();
            return redirect('/deposit');
        }
    }

    public function play(Request $request){
        $fields = [
            'Method'=>'PLAY',
            "Username"=> Auth::user()->username,
            "Timestamp"=>time(),
        ];
        $user = fetchData($fields);
        $token = $user['Token'];
        $gameCode = $request->GameCode;
        $redirect = "http://kh88.test";
        $mobile = true;
        $lang = "en";
        return Redirect::to('http://www.gwc688.net?token='.$user['Token'].'&game='.$gameCode.'&redirectUrl='.$redirect.'&mobile='.$mobile.'&lang='.$lang);
    }
    public function credit(Request $request){
        $fields = [
            'Method'=>'GC',
            "Username"=> Auth::user()->name,
            "Timestamp"=>time(),
        ];
        $credit = fetchData($fields);
        return $credit;
    }
    public function deposit(Request $request){
        return view('dashboard.deposit');
    }
    public function store_deposit(Request $request){
        $lastPayment = Credit::orderBy('created_at','desc')->where('username',Auth::user()->username)->pluck('lastPayment')->first();
        $fields = [
            'Method'=>'GC',
            "Username"=> Auth::user()->name,
            "Timestamp"=>time(),
        ];
        $credit = fetchData($fields);
        $deposits = Credit::create([
            'username'=> Auth::user()->username,
            'requestId'=> md5(rand(1, 10) . microtime()),
            'payment'=> $request->payment,
            'credit'=>  $credit['Credit'],
            'beforeCredit'=> $credit['Credit'],
            'outStandingCredit'=> str_replace(',','',number_format(str_replace(',','',$request->amount))),
            'lastPayment'=> $lastPayment ? $lastPayment  : $request->payment,
            'transaction'=> $request->transaction,
        ]);
        if($deposits){
            return response()->json([
                'code' => 200,
                'message' => "Successful deposit",
            ]);
        }
        return response()->json([
            'code' => 500,
            'message' => "Failed deposit",
        ]);
    }
    public function transactions(){
        $credits = Credit::where('username',Auth::user()->username)->get();
        return view("dashboard.transactions",compact('credits'));
    }

    

}
