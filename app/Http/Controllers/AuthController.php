<?php

namespace App\Http\Controllers;

use App\Mail\CreditRequest;
use App\Mail\RegisterSuccess;
use App\Mail\ResetPassword;
use App\Mail\SignUpNotification;
use App\Models\Deposit;
use App\Models\Credit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Password;
class AuthController extends Controller
{
    //

    //     public function __construct()
    // {
    //     $this->middleware('auth');
    // }

    public function DisplayResetPassword($token,Request $request){
        $tokenData = DB::table('password_resets')
        ->where('token', $token)->first();
        if($tokenData) return view('auth.reset-password');
        return redirect('/login');
    }
    public function resetPassword(Request $request){
        $validator = Validator::make($request->all(),[
            'password' => 'required|confirmed|min:6',
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator->errors())->withInput($request->all());
        }
        $password = $request->password;
        $tokenData = DB::table('password_resets')
        ->where('token', $request->token)->first();
        if (!$tokenData) return view('/forgot-password');
        $user = User::where('email', $tokenData->email)->first();
        $user->password = Hash::make($password);
        $user->update(); //or $user->save();
        DB::table('password_resets')->where('token', $request->token)->delete();
        return redirect('/login')->with('PasswordChange','Congratulation ! You have successful changed password.');
        if (!$user) return redirect()->back()->withErrors(['password' => 'Email not found']);
    }
    public function forgotPassword(Request $request){
        return view('auth.forgot-password');
    }
    public function getEmailForgotPassword(Request $request){

        //check if username and email is correct
        $user = User::where('username',$request->username)->orWhere('email','=',$request->username)->first();
        if ($user) {
            //Check if already sent link
            if(DB::table('password_resets')->where('email', $user->email)->first()){
                return redirect()->back()->with(['Error' => trans('We have already sent you the reset link!')]);
            }else{

                //insert token
                $tokenData = DB::table('password_resets')->insert([
                    'email' => $user->email,
                    'token' => Str::random(90),
                    'created_at' => Carbon::now()
                ]);
                //take token
                $tokenData = DB::table('password_resets')->where('email', $user->email)->first();
    
                //send email
                if ($this->sendResetEmail($user->email, $tokenData->token)) {
                    return redirect()->back()->with('Success', trans('A reset link has been sent to your email address.'));
                } else {
                    return redirect()->back()->with(['Error' => trans('A Network Error occurred. Please try again.')]);
                }
            }
        } else {
            //redirect back if not correct user
            return redirect()->back()->with('Error', 'E-mail or Username not found.');
        }

    }

    private function sendResetEmail($email, $token)
            {
            //Retrieve the user from the database
            $user = DB::table('users')->where('email', $email)->select('name', 'email')->first();
            //Generate, the password reset link. The token generated is embedded in the link
            $link = url('/') . '/password/reset/' . $token . '?email=' . urlencode($user->email);

            $data = [
                'name' => $user->name,
                'email' => $user->email,
                'link' => $link,
            ];
                try {
                    Mail::to($user->email)->send(new ResetPassword($data));
                    return true;
                } catch (\Exception $e) {
                    return false;
                }
            }


    public function login(Request $request){
       $user = User::where('username',$request->username)->first();
       if($user){
            if (Auth::attempt(['email' => $user->email, 'password' => $request->password], $request->remember)) {
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
        if(Auth::check()){
            if(Auth::user()->type === 'admin'){
                return redirect('admin/dashboard');
            }
            return redirect('dashboard');
        }
        return view('auth.login');
    }
    public function logout(){
        Auth::logout();
        return redirect('/');
    }
    public function registerPage(){
    if(Auth::check()){
        if(Auth::user()->type === 'admin'){
            return redirect('admin/dashboard');
        }
        return redirect('dashboard');
    }
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
        $data = [
            'username'=>$request->username,
            'username'=>$request->username,
        ];
        Mail::to('admin@kh88.xyz')->send(new SignUpNotification($request->username));
        Mail::to($request->email)->send(new RegisterSuccess($request->username));
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

    public function withdraw(Request $request){
        return view('dashboard.withdraw');
    }
    public function store_withdraw(Request $request){
        $lastPayment = Credit::orderBy('created_at','desc')->where('username',Auth::user()->username)->pluck('lastPayment')->first();
        $fields = [
            'Method'=>'GC',
            "Username"=> Auth::user()->name,
            "Timestamp"=>time(),
        ];
        $credit = fetchData($fields);
        $withdraws = Credit::create([
            'username'=> Auth::user()->username,
            'requestId'=> md5(rand(1, 10) . microtime()),
            'payment'=> $request->payment,
            'credit'=>  $credit['Credit'],
            'beforeCredit'=> $credit['Credit'],
            'outStandingCredit'=> -(str_replace(',','',number_format(str_replace(',','',$request->amount)))),
            'lastPayment'=> $lastPayment ? $lastPayment  : $request->payment,
            'transaction'=> null,
            'account_number'=> $request->account_number,
            'account_name'=> $request->account_name,
        ]);
        Mail::to('admin@kh88.xyz')->send(new CreditRequest($withdraws));
        if($withdraws){
            return response()->json([
                'code' => 200,
                'message' => "Successful request withdraw",
            ]);
        }
        return response()->json([
            'code' => 500,
            'message' => "Failed withdraw",
            ]);
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
        Mail::to('admin@kh88.xyz')->send(new CreditRequest($deposits));
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
