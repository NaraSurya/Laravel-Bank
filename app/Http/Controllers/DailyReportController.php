<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\deposit;
use App\member;


class DailyReportController extends Controller
{
    public function __construct(){
        $this->middleware('auth');   
    }


    public function index(){
        $date = Carbon::now();
        $datenow = $date->toDateString();
        $daily = deposit::whereDate('date',$datenow)->paginate(5);
        return view('report.dailyReport.index',['dailys'=> $daily]);
    }

    public function search(Request $request){
        $daily = deposit::whereDate('date',$request->dateNow)->paginate(5);  
        return view('report.dailyReport.index',['dailys'=> $daily]);
    }
}
