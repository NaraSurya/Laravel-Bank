<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\deposit;
use Session;


class MemberReportController extends Controller
{
    public function __construct(){
        $this->middleware('auth');   
    }


    public function index(){
        $monthNow = Carbon::now();  
        $monthly = deposit::whereMonth('date',$monthNow->month)
                          ->whereYear('date',$monthNow->year)->get();
        return view('report.memberReport.index',['monthlys'=>$monthly]);
    }

    public function sort(Request $request){
        Session::put('sortBy',$request->sortBy);
            if ($request->sortBy == 'Hari') {
                $day = Carbon::now();
                $daily = deposit::whereDate('date',$day->toDateString())->get();
                return view('report.memberReport.index',['monthlys'=>$daily]);
            } else if ($request->sortBy == 'Bulan') {
                return redirect (route('memberReport.index'));
            }
            else{
                $yearNow= Carbon::now();  
                $yearly = deposit::whereYear('date',$yearNow->year)->get();
                return view('report.memberReport.index',['monthlys'=>$yearly]);
            }
    }
}
