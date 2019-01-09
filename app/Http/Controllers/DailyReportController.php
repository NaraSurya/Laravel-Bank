<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\deposit;
use App\member;
use Session;


class DailyReportController extends Controller
{
    public function __construct(){
        $this->middleware('auth');   
    }


    public function index(){
        
        $date = Carbon::now();
        $dailyDate = $date->toDateString();

        if(Session::has('dailyDate')) {
            $dailyDate = Session::get('dailyDate');
        } 

        $daily = deposit::whereDate('date',$dailyDate)->paginate(10);  
        // Session::forget('dailyDate');
        return view('report.dailyReport.index',['dailys'=> $daily]);
        
        }
    

    public function search(Request $request){
        $dailyDate = Carbon::parse($request->dateNow);
        $dailyString = $dailyDate->toDateString();
        Session::put('dailyDate', $dailyString);
        return redirect(route('dailyReport.index'));
    }
}
