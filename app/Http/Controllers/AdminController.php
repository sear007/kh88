<?php

namespace App\Http\Controllers;

use App\Models\Credit;
use App\Models\Deposit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
class AdminController extends Controller
{

    public function index(){
        return view('dashboard.admin.pages.index');
    }

    public function credits(){
        return view('dashboard.admin.pages.credits');
    }
    public function creditsJson(Request $request){
    $draw = $request->get('draw');
    $start = $request->get("start");
    $rowperpage = $request->get("length");
    $columnIndex_arr = $request->get('order');
    $columnName_arr = $request->get('columns');
    $order_arr = $request->get('order');
    $search_arr = $request->get('search');
    $columnIndex = $columnIndex_arr[0]['column'];
    $columnName  =  $columnName_arr[$columnIndex]['data'];
    $columnSortOrder = $order_arr[0]['dir'];
    $searchValue = $search_arr['value'];
     $totalRecords = Credit::select('count(*) as allcount')->where('outStandingCredit','>',0)->count();
     $totalRecordswithFilter = Credit::select('count(*) as allcount')->where('outStandingCredit','>',0)->where('username', 'like', '%' .$searchValue . '%')->count();
     $records = Credit::orderBy($columnName,$columnSortOrder)
       ->where(function($query) use ($searchValue){
            $query->where('credits.username', 'LIKE', '%'.$searchValue.'%');
        })
       ->select('credits.*')
       ->skip($start)
       ->take($rowperpage)
       ->get();
     $response = array(
        "columnSortOrder" => $request->get('order'),
        "draw" => intval($draw),
        "iTotalRecords" => $totalRecords,
        "iTotalDisplayRecords" => $totalRecordswithFilter,
        "aaData" => $records
     );
     echo json_encode($response);
     exit;
    }





    public function deposits(){
        return view('dashboard.admin.pages.deposits');
    }
    public function depositsJson(Request $request){
        $draw = $request->get('draw');
        $start = $request->get("start");
        $rowperpage = $request->get("length");
        $columnIndex_arr = $request->get('order');
        $columnName_arr = $request->get('columns');
        $order_arr = $request->get('order');
        $search_arr = $request->get('search');
        $columnIndex = $columnIndex_arr[0]['column'];
        $columnName  =  $columnName_arr[$columnIndex]['data'];
        $columnSortOrder = $order_arr[0]['dir'];
        $searchValue = $search_arr['value'];
        $totalRecords = Credit::select('count(*) as allcount')->where('outStandingCredit','>',0)->count();
        $totalRecordswithFilter = Credit::select('count(*) as allcount')->where('outStandingCredit','>',0)->where('username', 'like', '%' .$searchValue . '%')->count();
        $records = Credit::orderBy($columnName,$columnSortOrder)
        ->where('outStandingCredit','>',0)
        ->where(function($query) use ($searchValue){
                $query->where('credits.username', 'LIKE', '%'.$searchValue.'%');
                $query->orWhere('credits.payment', 'LIKE', '%'.$searchValue.'%');
                $query->orWhere('credits.transaction', 'LIKE', '%'.$searchValue.'%');
        })
        ->select('credits.*')
        ->skip($start)
        ->take($rowperpage)
        ->get();
        $response = array(
            "columnSortOrder" => $request->get('order'),
            "draw" => intval($draw),
            "iTotalRecords" => $totalRecords,
            "iTotalDisplayRecords" => $totalRecordswithFilter,
            "aaData" => $records
        );
        echo json_encode($response);
        exit;
    }
    public function deposit_approve(Request $request){
        $credit = Credit::find($request->id);
        $credit->status = true;
        $credit->save();
        $fields = [
            "Method"=> "TC",
            "Username"=> $credit->username, 
            "Timestamp"=> time(), 
            "RequestID"=> $credit->requestId, 
            "Amount"=> $credit->outStandingCredit,
        ];
        fetchData($fields);
        return "Successful Approved!";
    }
    public function deposit_destroy(Request $request){
        $credit = Credit::find($request->id);
        $credit->delete();
        return "Successful Removed!";
    }


    public function withdraws(){
        return view('dashboard.admin.pages.withdraws');
    }
    public function withdrawsJson(Request $request){
        $draw = $request->get('draw');
        $start = $request->get("start");
        $rowperpage = $request->get("length");
        $columnIndex_arr = $request->get('order');
        $columnName_arr = $request->get('columns');
        $order_arr = $request->get('order');
        $search_arr = $request->get('search');
        $columnIndex = $columnIndex_arr[0]['column'];
        $columnName  =  $columnName_arr[$columnIndex]['data'];
        $columnSortOrder = $order_arr[0]['dir'];
        $searchValue = $search_arr['value'];
        $totalRecords = Credit::select('count(*) as allcount')->where('outStandingCredit','<',0)->count();
        $totalRecordswithFilter = Credit::select('count(*) as allcount')->where('outStandingCredit','<',0)->where('username', 'like', '%' .$searchValue . '%')->count();
        $records = Credit::orderBy($columnName,$columnSortOrder)
        ->where(function($query) use ($searchValue){
                $query->where('credits.username', 'LIKE', '%'.$searchValue.'%');
                $query->orWhere('credits.payment', 'LIKE', '%'.$searchValue.'%');
                $query->orWhere('credits.transaction', 'LIKE', '%'.$searchValue.'%');
        })
        ->where('outStandingCredit','<',0)
        ->select('credits.*')
        ->skip($start)
        ->take($rowperpage)
        ->get();
        $response = array(
            "columnSortOrder" => $request->get('order'),
            "draw" => intval($draw),
            "iTotalRecords" => $totalRecords,
            "iTotalDisplayRecords" => $totalRecordswithFilter,
            "aaData" => $records
        );
        echo json_encode($response);
        exit;
    }
    public function withdraw_approve(Request $request){
        $credit = Credit::find($request->id);
        $credit->status = true;
        $credit->save();
        return "Successful Approved!";
    }
    public function withdraw_destroy(Request $request){
        $credit = Credit::find($request->id);
        $credit->delete();
        return "Successful Removed!";
    }



}
